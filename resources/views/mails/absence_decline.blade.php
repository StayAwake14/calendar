@extends('layouts.base')

@section('absence_decline')

<div class="container">
    <h1 class="text-center font-bold text-5xl">MCCORP - Calendar Absence Status</h1>
    <div class="text-center text-3xl">
        <h2>Information</h2>
        <p> Your leader from <b>team [ {{ $leader->team->team_name }} ]</b> {{ $leader->fname }} {{ $leader->lname }} has declined your absence.</p>
        <h3>Absence Details</h3>
        <p class="font-italic"> [ {{ $absence->reason->reason_name }} ] {{ $absence->datefrom }} - {{ $absence->dateto }} </p>
    </div>
</div>

@endsection