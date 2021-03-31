<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\Models\users;
use App\Models\absences;
use App\Models\reasons;


use Cmixin\BusinessDay;
Use \Carbon\Carbon;

class UserAuthController extends Controller
{
    function login(){
        return view('calendar');
    }

    function register(){
        return view('auth.register');
    }

    function create(Request $request){
        $request->validate([
            'login'=>'required|unique:users',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:8',
            'rpassword'=>'required|min:8',
            'fname'=>'required',
            'lname'=>'required'
        ]);


        $user = new users;
        $user->login = $request->login;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->fname = $request->fname;
        $user->lname = $request->lname;

        if($user->save()){
            return back()->with('success', 'You have been successfully registered!');
        } else{
            return back()->with('fail', 'Something went wrong!');
        }


    }

    function check(Request $request){

        $request->validate([
            'login'=>'required',
            'password'=>'required|min:8'
        ]);

        $user = users::where('login', '=', $request->login)->first();
        if($user)
        {
            if(Hash::check($request->password, $user->password)){
                $request->session()->put('UserLogged', $user->id);
                return redirect('profile');
            } else {
                return back()->with('fail', 'Invaild password!');
            }
        } 
        else
        {
            return back()->with('fail', 'No account found for this login!');
        }

    }

    function profile(){
        BusinessDay::enable('Carbon\Carbon');
        Carbon::setHolidaysRegion('pl');
        $users = users::all()->toArray();
        $date = Carbon::now();
        $date = $date::parse();
        $holidays = Carbon::getHolidays('pl');
        $year = $date->year;
        $month= $date->month;
        $fday = $date->firstOfMonth()->format("j");
        $lday = $date->lastOfMonth()->format("j");
        $fmd = $date->lastOfMonth()->format("D");
        $monthLength = $date->daysInMonth;
        $monthName = $date->format("F");
    //    $usersCount = $users->count();
        $matrix = array();
        $calendar = array();
        $monthHolidays = array();
        $subMonthArray = array();

        $subDate = new Carbon('last sunday of last month');
        $subMonth = $subDate->month;
        $subDay = $subDate->day;
      //  echo "Last Sunday: ".$subDay."<br>";
        $subLastDay = $subDate->lastOfMonth()->day;
    //    echo "Last day: ".$subLastDay;
        $yearWeek = $subDate->weekOfYear;

        //CREATE HOLIDAYS ARR
        foreach (Carbon::getYearHolidays($year) as $id => $holiday) {
            
            if($holiday->month == $month)
            {
                $holidayDay = $holiday->format('j');
                $monthHolidays[$holidayDay] = 
                [
                    'month'=> $month,
                    'day'=> $holidayDay,
                    'event'=> $holiday->getHolidayName()
                ];
            }
        }
        $weekBreak = 0;
        $week = 0;
        $weekArr = array();
        for($day = $subDay; $day < $subLastDay+1; $day++){
           
            $date3 = Carbon::parse($year.'-'.$subMonth.'-'.$day);
            $calendar[$week][$day]['day']['number'] = $day;
            $calendar[$week][$day]['day']['event'] = !empty($monthHolidays[$day]) ? $monthHolidays[$day]['event'] : "";
            $calendar[$week][$day]['day']['weekend'] = "";
            $calendar[$week][$day]['day']['color'] = 'gray';
            $calendar[$week][$day]['day']['month'] = 'previous';
            $calendar[$week][$day]['day']['reason'] = '';

            array_push($weekArr, [
                'week' => $week,
                'day' => $day
            ]);
            $weekBreak++;
        }

        for($day = $fday; $day < $lday+1; $day++)
        {
            $date2 = Carbon::parse($year.'-'.$month.'-'.$day);
            $dayOfTheWeek = $date2->dayOfWeek;
            $monthWeekNumber = $date2->weekOfMonth;
            array_push($weekArr, [
                'week' => $week,
                'day' => $day
            ]);

            if($weekBreak%7 == 0)
            {
                $week++;
            }
         //   echo $monthWeekNumber;
            $calendar[$week][$day]['day']['number'] = $day;
            $calendar[$week][$day]['day']['event'] = !empty($monthHolidays[$day]) ? $monthHolidays[$day]['event'] : "";
            $calendar[$week][$day]['day']['weekend'] = "";
            $calendar[$week][$day]['day']['month'] = "";
            $calendar[$week][$day]['day']['reason'] = "";
            
            if($date2->isWeekend())
            {
                $calendar[$week][$day]['day']['color']= 'purple';
                $calendar[$week][$day]['day']['weekend'] = "Weekend";
            }
            elseif(!empty($monthHolidays[$day]))
            {
                $calendar[$week][$day]['day']['color'] = 'pink';
            }
            else 
            {
                $calendar[$week][$day]['day']['color'] = 'white';
            }
            $weekBreak++;
        }

        $absences = absences::all()->where('user_id', '=', session('UserLogged'))->toArray();

       // print_r($user);

        foreach($absences as $absence)
        {
            $since = Carbon::parse($absence['datefrom'])->day;
            $to = Carbon::parse($absence['dateto'])->day;

            $reasons = reasons::all()
                ->where('id', $absence['reason_id'])
                ->toArray();

            foreach($reasons as $reason){

                foreach($calendar as $key => $week)
                {
                    foreach($week as $key2 => $day)
                    {
                        if($day['day']['number'] >= $since && $day['day']['number'] <= $to && empty($day['day']['weekend']) && empty($day['day']['month']))
                        {
                            switch($reason['reason_name'])
                            {
                                case "Vacation":
                                    $calendar[$key][$key2]['day']['reason']="Vacation";
                                    $calendar[$key][$key2]['day']['color']="red";
                                break;
                                case "Business Trip":
                                    $calendar[$key][$key2]['day']['reason']="Business Trip";
                                    $calendar[$key][$key2]['day']['color']="blue";
                                break;
                            }
                            
                        }
                        
                    }
                        
                }
            }
        }

        if(session()->has('UserLogged')){
            $user = users::where('id', '=', session('UserLogged'))->first();
            $LoggedUserInfo = $user;

        }
        else
        {
            return redirect('calendar');
        }

        return view('profile', compact('LoggedUserInfo', 'calendar', 'subMonthArray'));
    }

    function logout(){
        if(session()->has('UserLogged')){
            session()->pull('UserLogged');
            return redirect('calendar');
        }
    }

}
