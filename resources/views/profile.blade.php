@extends('layouts.base')

@section('profile')
    @if(Session::get('UserLogged'))
        <div class="alert alert-success">
            <p class="p-3">Imię: {{ $LoggedUserInfo->fname }} </p>
            <p class="p-3">Nazwisko: {{ $LoggedUserInfo->lname }} </p>
            <p class="p-3 mb-5">Adres Email: {{ $LoggedUserInfo->email }} </p>
            <a class="p-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="calendar">Calendar</a>
            <a class="p-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="reason">Add Reason</a>
            <a class="p-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="absence">Add Absence</a>
            <a class="p-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="logout">Logout</a>
        </div>
    @endif
@endsection