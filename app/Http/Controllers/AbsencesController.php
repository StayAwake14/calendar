<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\absences;
use App\Models\reasons;

class AbsencesController extends Controller
{
    public function absences(){
        
        $reasons = reasons::all()->toArray();

        return view('auth.absence')->with('reasons', $reasons);
    }

    public function add(Request $request){
        
        $absences = new absences;
        $absences->user_id = session('UserLogged');
        $absences->reason_id = $request->reason;
        $absences->datefrom = $request->datefrom;
        $absences->dateto = $request->dateto;
        $absences->description = $request->description;
        
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
