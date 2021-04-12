<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\users;
use App\Models\absences;
use App\Models\reasons;
use App\Models\teams;

use Cmixin\BusinessDay;
Use \Carbon\Carbon;

use App\Classes\Calendar;
use App\Classes\PersonalCalendar;

class UserAuthController extends Controller
{
    function login(){
        return view('auth.login');
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
        $user->team_id = 0;
        $user->job_title = "";

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
        $setPersonalCalendar = new PersonalCalendar('pl');
        
        $setPersonalCalendar->setPersonalCalendar(session('UserLogged'));
        $setPersonalCalendar->buildCalendar();

        $calendar = $setPersonalCalendar->getFullCalendar();
        $monthName = $setPersonalCalendar->getCurrentMonthName();
        $month = $setPersonalCalendar->getCurrentMonthNumber();
        $year = $setPersonalCalendar->getCurrentYear();

        if(session()->has('UserLogged')){
            $user = users::with('team')->where('id', '=', session('UserLogged'))->first();

            $curr_date = date('Y-m-d');
            $absences = absences::with('reason')
            ->where('user_id', '=', session('UserLogged'))
            ->where('datefrom', '>=', $curr_date)
            ->limit(4)
            ->get();

            $teams = teams::with('user')
            ->where('id', '=', $user->team_id)
            ->first();
            
            $LoggedUserInfo = $user;

            $created = $LoggedUserInfo->created_at->year;
            $updated = $LoggedUserInfo->updated_at->year;
            $accountYears = range($created, $updated);

        }
        else
        {
            return redirect('calendar');
        }

        return view('profile', compact('LoggedUserInfo', 'calendar', 'monthName', 'year', 'month', 'accountYears', 'absences'));
    }

    function logout(){
        if(session()->has('UserLogged')){
            session()->pull('UserLogged');
            return redirect('calendar');
        }
    }

    function show($month, $year)
    {
            $setPersonalCalendar = new PersonalCalendar('pl');
            //$setPersonalCalendar->date = $setPersonalCalendar->date::create($year,$month, 1);
            $setPersonalCalendar->setDate($setPersonalCalendar->date, $year, $month);
            $setPersonalCalendar->refresh2(session('UserLogged'));
            $setPersonalCalendar->buildCalendar();
          
            
            $monthName = $setPersonalCalendar->getCurrentMonthName();
            $month = $setPersonalCalendar->getCurrentMonthNumber();
            $year = $setPersonalCalendar->getCurrentYear();
            $calendar = $setPersonalCalendar->getFullCalendar();

            if(session()->has('UserLogged')){
                $user = users::with('team')->where('id', '=', session('UserLogged'))->first();

                $curr_date = date('Y-m-d');
                $absences = absences::with('reason')
                ->where('user_id', '=', session('UserLogged'))
                ->where('datefrom', '>=', $curr_date)
                ->limit(4)
                ->get();

                $teams = teams::with('user')
                ->where('id', '=', $user->team_id)
                ->first();
                
                $LoggedUserInfo = $user;
    
                $created = $LoggedUserInfo->created_at->year;
                $updated = $LoggedUserInfo->updated_at->year;
                $accountYears = range($created, $updated);
            }
            else
            {
                return redirect('calendar');
            }

            return view('profile', compact('LoggedUserInfo', 'calendar', 'monthName', 'year', 'month', 'accountYears', 'absences'));
    }
    

}
