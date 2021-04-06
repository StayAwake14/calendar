<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\users;
use App\Models\leaders;
use App\Models\teams;

class LeadersController extends Controller
{
    public function leaders(){

        $users = users::all()->toArray();
        $teams = teams::all()->toArray();

        return view('auth.leader', compact('users', 'teams'));
    }

    public function add(Request $request){
        $leader = new leaders;
        $leader->user_id = $request->user_id;
        $leader->team_id = $request->team_id;

        if($leader->save()){
            return back()->with('success', 'Leader has been successfully assigned!');
        } else{
            return back()->with('fail', 'Something went wrong!');
        }
    }
}
