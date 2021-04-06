<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\teams;
use App\Models\users;


class TeamsController extends Controller
{
    public function teams(){
        $users = users::all()->toArray();
        return view('auth.team')->with('users', $users);
    }

    public function add(Request $request){
        $team = new teams;
        $team->team_name = $request->team_name;
    
        if($team->save()){
            return back()->with('success', 'Team has been created!');
        } else{
            return back()->with('fail', 'Something went wrong!');
        }
    }


}
