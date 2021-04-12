@extends('layouts.base')

@section('login')
<div class="flex h-screen justify-center items-center text-center mx-auto bg-gradient-to-r from-green-400 to-blue-500 text-gray-600">
    <div class="mx-auto w-1/4 shadow-2xl rounded p-5 bg-white animate__animated animate__zoomInDown">
        <h1 class="text-3xl mt-5 mb-5">Login to your account</h1>
        <form action="{{ route('auth.check') }}" method="post">
        @csrf
            <div class="flex flex-col mb-4">
                <label class="uppercase px-4 py-3 font-bold text-lg text-grey-darkest" for="login">Login</label>
                <input class="form-input px-4 py-3 rounded-full border focus:outline-none focus:ring focus:border-blue-300 h-10" type="text" name="login" placeholder="Enter login" value="{{ old('login') }}">
                <span class="bg-600-red">@error('login') {{ $login }} @enderror</span>
            </div>
            <div class="flex flex-col mb-4">
                <label class="uppercase px-4 py-3 font-bold text-lg text-grey-darkest" for="password">Password</label>
                <input class="form-input px-4 py-3 rounded-full border focus:outline-none focus:ring focus:border-blue-300 h-10" type="password" name="password" placeholder="Enter password">
                <span class="bg-600-red">@error('password') {{ $message }} @enderror</span>
            </div>
            <div class="flex flex-col mb-4 w-24 mx-auto">
                <button class="py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-400 focus:outline-none" type="submit">Login</button>
            </div>
        </form>
        <a href="calendar" class="py-2 px-3 underline">I already have account</a>
    </div>
    </div>
@endsection