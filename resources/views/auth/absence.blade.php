@extends('layouts.base')

@section('absence')
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
    <h1 class="text-3xl">Absence Add Form</h1>
        <form action=" {{ route('absence.add') }}" method="post">
        @csrf
            <label for="reason">Reason</label>
            <select class="form-input px-4 py-3 rounded-full border" type="text" name="reason">
            @foreach($reasons as $reason)
                <option value="{{ $reason['id'] }}"> {{ $reason["reason_name"] }} </option>
            @endforeach
            </select>
            </br>
            <span class="bg-600-red">@error('reason') {{ $message }} @enderror</span>
            <label for="datefrom">Since: </label>
            <input type="date" class="form-input px-4 py-3 rounded-full border"  name="datefrom">
            </br>
            <label for="datefrom">To: </label>
            <input type="date" class="form-input px-4 py-3 rounded-full border"  name="dateto">
            </br>
            <label for="description">Description</label>
            <textarea class="form-input px-4 py-3 rounded-full border"  name="description"></textarea>
            </br>
            <button class="mb-5 py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none" type="submit">Add</button>
            <a href="profile" class="mt-5 py-2 px-4 bg-pink-500 text-white font-semibold rounded-lg shadow-md hover:bg-pink-700 focus:outline-none">Back </a>
        </form>
    </div>
@endsection