<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\absences;
use App\Models\reasons;
use App\Models\teams;
use App\Models\leaders;
use App\Models\users;
use App\Mail\VerificationMail;
use App\Mail\AbsenceAdd;
use App\Mail\Absence;
use App\Mail\AbsenceDecline;

class AbsencesController extends Controller
{
    public function absences(){
        
        $reasons = reasons::all()->toArray();

        return view('auth.absence')->with('reasons', $reasons);
    }

    public function toVerify(){
        // Getting all teams assigned to specified user
        $verifyArray = null;
        
        //Getting specified leader sites that can manage
        $leaders = leaders::with(['user','team'])
        ->where('user_id', '=', session('UserLogged'))
        ->get();
        
        // Getting all absences from users whose belong to team leader's team
        foreach($leaders as $leader){

            //Getting users that belong to same site as leader
            $users = users::with(['team', 'absence'])
            ->where('team_id', '=', $leader->team->id)
            ->get();
         
            foreach($users as $user){
            
                $absences = absences::with(['user.team', 'reason'])
                ->where('confirmed', '=', 0)
                ->where('user_id', '=', $user->id)
                ->get();
                
                $verifyArray[$user->id] = $absences;
            }
        }

        return view('auth.verify', compact('verifyArray'));
    }

    public function accept($id, Request $request){

        $absences = absences::with(['user','reason'])->where('id', '=', $id)->first();
        $absences->confirmed = 1;

        $leader = leaders::with(['user', 'team'])
        ->where('user_id', '=', session('UserLogged'))
        ->where('team_id', '=', $absences->user->team_id)
        ->first();
        
        if($absences->save())
        {
            Mail::to($request->email)->send(new VerificationMail($absences, $leader));
            return back()->with('success', 'Absence has been accepted!');
        }
        else
        {
            return back()->with('fail', 'Absence could not be accepted!');
        }
    }

    public function decline($id){

        $absences = absences::with('reason')
        ->where('id', '=', $id)
        ->first();

        // Get user info
        $user = users::where('id', '=', $absences->user_id)->first();

        // Get leader info
        $leader = users::with('team')
        ->where('team_id', '=', $user->team_id)
        ->where('id', '=', session('UserLogged'))
        ->first();

        if($absences->delete())
        {
            Mail::to($user->email)->send(new AbsenceDecline($absences, $user, $leader));
            return back()->with('success', 'Absence has been declined!');
        }
        else
        {
            return back()->with('fail', 'Absence could not be declined!');
        }
    }

    public function add(Request $request){
        
        $absences = new absences;
        $absences->user_id = session('UserLogged');
        $absences->reason_id = $request->reason;
        $absences->datefrom = $request->datefrom;
        $absences->dateto = $request->dateto;
        $absences->description = $request->description ? : "";
        $absences->confirmed = false;

        //Taking user team_id
        $user = users::with('team')->
        where('id', '=', session('UserLogged'))
        ->first();

        $leaders = leaders::with(['team', 'user'])
        ->where('team_id', '=', $user->team_id)
        ->get();

        $reason = reasons::where('id', '=', $request->reason)->first();

        if($absences->save())
        {
            foreach($leaders as $leader)
            {
                Mail::to($leader->user->email)->send(new AbsenceAdd($absences, $user, $reason));
            }
            
            return back()->with('success', 'Absence has been successfully added!');
        }
        else
        {
            return back()->with('fail', 'Reason could not be added!');
        }
    }

    
}
