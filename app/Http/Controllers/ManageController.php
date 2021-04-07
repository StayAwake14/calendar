<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;
use App\Models\teams;
use App\Models\leaders;

class ManageController extends Controller
{
    public function manage(){
        $leaders = leaders::with(['user','team'])
        ->where('user_id', '=', session('UserLogged'))
        ->first();

        // Check if user is able to manage any team
        if(!is_null($leaders))
        {

            $users = users::with('team')
            ->where('team_id', '=', $leaders->team_id)
            ->get();
            
            $teams = teams::all()
            ->toArray();
            
        }
        else
        {
            $users = null;
            $teams = null;
        }

        return view('auth.manage', compact('users', 'teams'));
    }

    public function edit($id, Request $request){

        $users = users::where('id', '=', $id)->first();
        $users->team_id = $request->team;

        if($users->save())
        {
            return back()->with('success', 'User has been successfully modified!');
        }
        else
        {
            return back()->with('fail', 'User could not be added!');
        }
    }
}
