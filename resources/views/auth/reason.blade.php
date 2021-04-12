@extends('layouts.form')
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
        @section('reason_form')
            <h1 class="text-3xl">Reason Add Form</h1>
            <form action=" {{ route('reason.add') }}" method="post">
            @csrf
                <div class="flex flex-col mb-3 mt-3">
                    <label for="reason" class="uppercase px-4 py-3 font-bold text-lg text-grey-darkest" >Reason</label>
                    <input class="mb-5 form-input px-4 py-3 rounded-full border" type="text" name="reason">
                </div>
                <div class="flex flex-col mb-3">
                    <label for="color" class="uppercase px-4 py-3 font-bold text-lg text-grey-darkest" >Color</label>
                    <input class="mb-5 form-input px-4 py-3 rounded-full border" type="text" name="color">
                    <span class="bg-600-red">@error('reason') {{ $message }} @enderror</span>
                </div>
                <button class="mb-5 py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none" type="submit">Add</button>
                <a href="profile" class="py-2 px-4 bg-pink-500 text-white font-semibold rounded-lg shadow-md hover:bg-pink-700 focus:outline-none">Back </a>
            </form>
        @endsection
@endsection