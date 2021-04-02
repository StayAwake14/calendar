<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            $weekBreak++;
        }

        for($day = $fday; $day < $lday+1; $day++)
        {
            $date2 = Carbon::parse($year.'-'.$month.'-'.$day);
            $dayOfTheWeek = $date2->dayOfWeek;
            $monthWeekNumber = $date2->weekOfMonth;
            $weekArr[$day] = array();


            if($weekBreak%7 == 0)
            {
                $week++;
            }

            $weekArr[$day] = [
                'week' => $week,
                'day' => $day
            ];
         
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
            else 
            {
                $calendar[$week][$day]['day']['color'] = 'white';
            }

            if(!empty($monthHolidays[$day]))
            {
                $calendar[$week][$day]['day']['weekend'] = $calendar[$week][$day]['day']['event'];
                $calendar[$week][$day]['day']['color'] = 'pink';
            }
            $weekBreak++;
        }

        $absences = DB::table('absences')
            ->where('user_id', session('UserLogged'))
            ->where('datefrom', 'like', "2021-04%")
            ->get();

        foreach($absences as $absence)
        {
            $since = Carbon::parse($absence->datefrom)->day;
            $to = Carbon::parse($absence->dateto)->day;

            $reasons = reasons::all()
                ->where('id', $absence->reason_id)
                ->toArray();

            for($day = $since; $day < $to+1; $day++)
            {
                $key = $weekArr[$day]['week'];
            
                foreach($reasons as $reason){
                    if(empty($calendar[$key][$day]['day']['weekend']))
                    switch($reason['reason_name'])
                    {
                        case "Vacation":
                            $calendar[$key][$day]['day']['comment'] = $absence->description;
                            $calendar[$key][$day]['day']['reason']="Vacation";
                            $calendar[$key][$day]['day']['color']="red";
                        break;
                        case "Business Trip":
                            $calendar[$key][$day]['day']['comment'] = $absence->description;
                            $calendar[$key][$day]['day']['reason']="Business Trip";
                            $calendar[$key][$day]['day']['color']="blue";
                        break;
                    }
                }

            }

            // OLD CONCEPTION WORSE
              /*  foreach($calendar as $key => $week)
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

                        
                }*/
           
        }

        if(session()->has('UserLogged')){
            $user = users::where('id', '=', session('UserLogged'))->first();
            $LoggedUserInfo = $user;
            $created = $LoggedUserInfo->created_at->year;
            $updated = $LoggedUserInfo->updated_at->year;
            $accountYears = range($created, $updated);

        }
        else
        {
            return redirect('calendar');
        }

        return view('profile', compact('LoggedUserInfo', 'calendar', 'monthName', 'year', 'month', 'accountYears'));
    }

    function logout(){
        if(session()->has('UserLogged')){
            session()->pull('UserLogged');
            return redirect('calendar');
        }
    }

    function show($curr_month, $year)
    {
            BusinessDay::enable('Carbon\Carbon');
            Carbon::setHolidaysRegion('pl');
            $holidays = Carbon::getHolidays('pl');
            $users = users::all()->toArray();
            $date = Carbon::parse("$year-".$curr_month."-01");
            
            $year = $date->year;
            $month= $date->month;
           
            $fday = $date->firstOfMonth()->format("j");
            
            $lday = $date->lastOfMonth()->format("j");
            
            $fmd = $date->lastOfMonth()->format("D");
            
            $monthLength = $date->daysInMonth;
            $monthName = $date->format("F");
           
            $subMonth = $curr_month-1;

            if($curr_month == 1){
                $subMonth = 12;
                $subYear=$year-1;
                $dateNext = Carbon::parse("$subYear-".$subMonth."-01");

                $knownDate = Carbon::create($subYear, $month, 1);   
                Carbon::setTestNow($knownDate);  
                $subDate = new Carbon("last sunday of ".$dateNext->format("F"));
                Carbon::setTestNow();   
            }
            else
            {
                $dateNext = Carbon::parse("$year-".$subMonth."-01");

                $knownDate = Carbon::create($year, $month, 1);   
                Carbon::setTestNow($knownDate);  
                $subDate = new Carbon("last sunday of ".$dateNext->format("F"));
                Carbon::setTestNow();   
            }


         
           // $subMonth = $subDate->month;

         //  echo "Sub Days: ".
         $subDay = $subDate->day;


        //  echo "Last Sunday: ".$subDay."<br>";
            $subLastDay = $subDate->lastOfMonth()->day;
        //    echo "Last day: ".$subLastDay;
            $yearWeek = $subDate->weekOfYear;

            //echo $subLastDay;

            $calendar = array();
            $monthHolidays = array();
            $subMonthArray = array();
    
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
                $weekBreak++;
            }
    
            for($day = $fday; $day < $lday+1; $day++)
            {
                $date2 = Carbon::parse($year.'-'.$month.'-'.$day);
                $dayOfTheWeek = $date2->dayOfWeek;
                $monthWeekNumber = $date2->weekOfMonth;
                $weekArr[$day] = array();
    
    
                if($weekBreak%7 == 0)
                {
                    $week++;
                }
    
                $weekArr[$day] = [
                    'week' => $week,
                    'day' => $day
                ];
             
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
                else 
                {
                    $calendar[$week][$day]['day']['color'] = 'white';
                }
    
                if(!empty($monthHolidays[$day]))
                {
                    $calendar[$week][$day]['day']['weekend'] = $calendar[$week][$day]['day']['event'];
                    $calendar[$week][$day]['day']['color'] = 'pink';
                }
                $weekBreak++;
            }
    
            $absences = DB::table('absences')
                ->where('user_id', session('UserLogged'))
                ->where('datefrom', 'like', "$year-0$month%")
                ->get();
    
            foreach($absences as $absence)
            {
                $since = Carbon::parse($absence->datefrom)->day;
                $to = Carbon::parse($absence->dateto)->day;
    
                $reasons = reasons::all()
                    ->where('id', $absence->reason_id)
                    ->toArray();
    
                for($day = $since; $day < $to+1; $day++)
                {
                    $key = $weekArr[$day]['week'];
                
                    foreach($reasons as $reason){
                        if(empty($calendar[$key][$day]['day']['weekend']))
                        switch($reason['reason_name'])
                        {
                            case "Vacation":
                                $calendar[$key][$day]['day']['comment'] = $absence->description;
                                $calendar[$key][$day]['day']['reason']="Vacation";
                                $calendar[$key][$day]['day']['color']="red";
                            break;
                            case "Business Trip":
                                $calendar[$key][$day]['day']['comment'] = $absence->description;
                                $calendar[$key][$day]['day']['reason']="Business Trip";
                                $calendar[$key][$day]['day']['color']="blue";
                            break;
                        }
                    }
    
                }
            }

            if(session()->has('UserLogged')){
                $user = users::where('id', '=', session('UserLogged'))->first();
                $LoggedUserInfo = $user;
                $created = $LoggedUserInfo->created_at->year;
                $updated = $LoggedUserInfo->updated_at->year;
                $accountYears = range($created, $updated);
  
            }
            else
            {
                return redirect('calendar');
            }

            return view('profile', compact('LoggedUserInfo', 'calendar', 'monthName', 'year', 'month', 'accountYears'));
    }
    

}
