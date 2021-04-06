<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\absences;
use App\Models\reasons;
use App\Models\teams;
use App\Models\leaders;
use App\Models\users;

class AbsencesController extends Controller
{
    public function absences(){
        
        $reasons = reasons::all()->toArray();

        return view('auth.absence')->with('reasons', $reasons);
    }

    public function toVerify(){
        // Getting all teams assigned to specified user

        
        $leaders = leaders::with(['user','team'])
        ->where('user_id', '=', session()->has('UserLogged'))
        ->get();
        // Getting all absences from users whose belong to team leader's team
        foreach($leaders as $leader){

            //Getting users that belong to same site as leader
            $users = users::with(['absence'])
            ->where('team_id', '=', $leader->team->id)
            ->get();
         
            foreach($users as $user){
            
                $absences = absences::with(['user', 'reason'])
                ->where('confirmed', '=', 0)
                ->where('user_id', '=', $user->id)
                ->get();
                
        
                $verifyArray[$user->id] = $absences;
            }
        }

        return view('auth.verify', compact('verifyArray'));
    }

    public function accept($id){

        $absences = absences::where('id', '=', $id)->first();
        $absences->confirmed = 1;

        if($absences->save())
        {
            return back()->with('success', 'Absence has been accepted!');
        }
        else
        {
            return back()->with('fail', 'Absence could not be accepted!');
        }
    }

    public function add(Request $request){
        
        $absences = new absences;
        $absences->user_id = session('UserLogged');
        $absences->reason_id = $request->reason;
        $absences->datefrom = $request->datefrom;
        $absences->dateto = $request->dateto;
        $absences->description = $request->description;
        $absences->confirmed = false;
        
        if($absences->save())
        {
            return back()->with('success', 'Absence has been successfully added!');
        }
        else
        {
            return back()->with('fail', 'Reason could not be added!');
        }
    }

    
}
