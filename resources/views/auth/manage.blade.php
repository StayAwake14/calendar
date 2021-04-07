@extends('layouts.base')

@section('manage')
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
        <h1 class="text-3xl">User Management</h1>
        @if(!is_null($users))
            @foreach($users as $user)
                <p class="inline">{{ $user->fname}} {{ $user->lname }}</p>
                <form class="block" action="{{ route('manage.edit', [$user['id']] ) }}" method="POST">
                @method('PUT')
                @csrf
                    <select class="mt-5 mb-5 form-input px-4 py-3 rounded-full border block mx-auto" name="team">
                    @foreach($teams as $team)
                        <option value="{{ $team['id'] }}">{{ $team['team_name'] }}</option>
                    @endforeach
                    </select>
                    <button class="mb-5 py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none" type="submit">Add</button>
                   
                </form>
            @endforeach
        @endif
        <a href="profile" class="mt-5 py-2 px-4 bg-pink-500 text-white font-semibold rounded-lg shadow-md hover:bg-pink-700 focus:outline-none">Back </a>
    </div>
@endsection