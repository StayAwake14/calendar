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
        <h1 class="text-3xl">Absence Verification</h1>
        @foreach($verifyArray as $absences)
                @foreach($absences as $user)
                <p class="mt-5 mb-5">
                    {{ $user->user->fname }} {{ $user->user->lname }}
                 </p>
                 @endforeach
                @foreach($absences as $absence)
                <div>
                    <p class="inline">
                    [ {{ $absence->reason->reason_name}} ]
                        {{ $absence->datefrom }} - {{ $absence->dateto }}
                    </p>
                    <form class="inline" action="{{ route('verify.accept', [$absence->id]) }}" method="POST">
                    @method('PUT')
                    @csrf
                        <button class="mb-5 py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none" type="submit">Accept</button>
                    </form>
                </div>
                @endforeach
        @endforeach
        <a href="profile" class="mt-5 py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none">Back </a>
    </div>
@endsection