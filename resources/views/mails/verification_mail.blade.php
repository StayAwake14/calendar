@extends('layouts.base')

@section('verification_mail')

<div class="container">
    <h1 class="text-center font-bold text-5xl">MCCORP - Calendar Absence Verification</h1>
    <div class="text-center text-3xl">
        @if($absence->confirmed)
            <p> Your absence has been approved by team leader [ {{ $leader->team->team_name}} ] {{ $leader->user->fname }} {{ $leader->user->lname }}</p>
            <p> {{ $absence->reason->reason_name }} <=> {{ $absence->datefrom }} - {{ $absence->dateto }} </p>
        @else
            <p> Your absence has been declined by team leader</p>
        @endif
    </div>
</div>

@endsection