@extends('layouts.base')

@section('reason')
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
    <h1 class="text-3xl">Reason Add Form</h1>
        <form action=" {{ route('reason.add') }}" method="post">
        @csrf
            <div class="form-group">
                <label for="reason">Reason</label>
                <input class="mb-5 form-input px-4 py-3 rounded-full border" type="text" name="reason">
                <span class="bg-600-red">@error('reason') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <button class="mb-5 py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none" type="submit">Add</button>
            </div>
        </form>
        <a href="profile" class="py-2 px-4 bg-pink-500 text-white font-semibold rounded-lg shadow-md hover:bg-pink-700 focus:outline-none">Profile </a>
    </div>
@endsection