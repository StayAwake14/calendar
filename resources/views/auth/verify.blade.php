@extends('layouts.base')

@section('verify')
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
    <div class="mx-auto text-center mb-5 mt-5">
        <h1 class="text-3xl mb-5">Absence Verification</h1>
        @if(!is_null($verifyArray))
        @foreach($verifyArray as $absences)
                @foreach($absences as $absence)
                <div>
                    <p class="block">
                        [ {{ $absence->user->team->team_name }} ]
                        [ {{ $absence->user->fname }} {{ $absence->user->lname }} ] </br>
                        [ {{ $absence->reason->reason_name}} ] 
                        {{ $absence->datefrom }} - {{ $absence->dateto }} </br>
                        Comment: {{ $absence->description }}
                    </p>
                    <form class="inline-block mt-5" action="{{ route('verify.accept', [$absence->id]) }}" method="POST">
                    @method('PUT')
                    @csrf
                        <input type="hidden" name="email" value="{{ $absence->user->email }}">
                        <button class="mb-5 py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none" type="submit">Accept</button>
                    </form>
                    <form class="inline" action="{{ route('verify.decline', [$absence->id]) }}" method="POST">
                    @method('POST')
                    @csrf
                        <button class="mb-5 py-2 px-4 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 focus:outline-none" type="submit">Decline</button>
                    </form>
                </div>
                @endforeach
        @endforeach
        @else
            <p class="font-italic underline p-5">There are no verifications to check.</p>
        @endif
        <a href="profile" class="mt-5 py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none">Back </a>
    </div>
@endsection