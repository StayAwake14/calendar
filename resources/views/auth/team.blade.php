@extends('layouts.base')

@section('team')
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
    <h1 class="text-3xl">Team Add Form</h1>
        <form action=" {{ route('team.add') }}" method="post">
        @csrf
            <label for="team_name">Team name</label>
            <input type="text" class="form-input mb-5 mt-5 px-4 py-3 rounded-full border"  name="team_name">
            </br>
            <label for="reason">Leader: </label>
            <select class="form-input mt-5 px-4 py-3 rounded-full border" type="text" name="user_id">
            @foreach($users as $user)
                <option value="{{ $user['id'] }}"> {{ $user["fname"] }} </option>
            @endforeach
            </select>
            <button class="mb-5 py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none" type="submit">Add</button>
            <a href="profile" class="mt-5 py-2 px-4 bg-pink-500 text-white font-semibold rounded-lg shadow-md hover:bg-pink-700 focus:outline-none">Back </a>
        </form>
    </div>
@endsection