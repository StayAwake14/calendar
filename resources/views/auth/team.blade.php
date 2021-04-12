@extends('layouts.form')
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
    @section('team_form')
    <h1 class="text-3xl">Team Add Form</h1>
        <form action=" {{ route('team.add') }}" method="post">
        @csrf
            <div class="flex flex-col mb-4">
                <label for="team_name"  class="uppercase px-4 py-3 font-bold text-lg text-grey-darkest">Team name</label>
                <input type="text" class="form-input mb-5 mt-5 px-4 py-3 rounded-full border w-3/4 mx-auto"  name="team_name">
            </div>
            <div class="flex flex-col mb-4">
                <label for="reason"  class="uppercase px-4 py-3 font-bold text-lg text-grey-darkest">Leader: </label>
                <select class="form-input mt-5 px-4 py-3 rounded-full border w-2/4 mx-auto" type="text" name="user_id">
                @foreach($users as $user)
                    <option value="{{ $user['id'] }}"> {{ $user["fname"] }} {{ $user["lname"] }} </option>
                @endforeach
                </select>
            </div>
            <button class="mb-5 py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none" type="submit">Add</button>
            <a href="profile" class="mt-5 py-2 px-4 bg-pink-500 text-white font-semibold rounded-lg shadow-md hover:bg-pink-700 focus:outline-none">Back </a>
        </form>
    @endsection
@endsection