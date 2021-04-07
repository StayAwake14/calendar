@extends('layouts.base')

@section('absence_add')

<div class="container">
    <h1 class="text-center font-bold text-5xl">MCCORP - Calendar Absence Status</h1>
    <div class="text-center text-3xl">
        <h2>Information</h2>
        <p> Your employee from <b>team [ {{ $user->team->team_name }} ]</b> {{ $user->fname }} {{ $user->lname }} has assigned an absence that awaits for your verification</p>
        <h3>Absence Details</h3>
        <p class="font-italic"> [ {{ $reason->reason_name }} ] {{ $absences->datefrom }} - {{ $absences->dateto }} [Comment] {{ $absences->description }} </p>
    </div>
</div>

@endsection