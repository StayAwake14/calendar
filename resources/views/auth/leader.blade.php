@extends('layouts.base')

@section('absence')
    <div class="results">
            @if(Session::get('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif

            @if(Session::get('fail'))
                <div class="alert alert-success">
                    {{ Session::get('fail') }}
                </div>
            @endif
        </div>
    <div class="mx-auto text-center mb-5">
    <h1 class="text-3xl">Leader Add Form</h1>
        <form action=" {{ route('leader.add') }}" method="post">
        @csrf
            <label for="reason">Leader: </label>
            <select class="form-input mt-5 px-4 py-3 rounded-full border" type="text" name="user_id">
            @foreach($users as $user)
                <option value="{{ $user['id'] }}"> {{ $user["fname"] }} {{ $user["lname"] }} </option>
            @endforeach
            </select>
            </br>
            <label for="reason">Team: </label>
            <select class="form-input mt-5 mb-5 px-4 py-3 rounded-full border" type="text" name="team_id">
            @foreach($teams as $team)
                <option value="{{ $team['id'] }}"> {{ $team["team_name"] }} </option>
            @endforeach
            </select>
            </br>
            <button class="mb-5 py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none" type="submit">Add</button>
            <a href="profile" class="mt-5 py-2 px-4 bg-pink-500 text-white font-semibold rounded-lg shadow-md hover:bg-pink-700 focus:outline-none">Back </a>
        </form>
    </div>
@endsection