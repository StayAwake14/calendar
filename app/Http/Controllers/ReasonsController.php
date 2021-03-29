<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\reasons;

class ReasonsController extends Controller
{
    public function reasons(){

        return view('auth.reason');
    }

    public function add(Request $request){
        $reasons = new reasons;
        $reasons->reason_name = $request->reason;
        
        if($reasons->save())
        {
            return back()->with('success', 'Reason has been successfully added!');
        }
        else
        {
            return back()->with('fail', 'Reason could not be added!');
        }
    }
}
