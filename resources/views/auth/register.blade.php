@extends('layouts.base')

@section('register')
<div class="flex h-screen justify-center items-center text-center mx-auto bg-gradient-to-r from-green-400 to-blue-500 text-gray-600">
    <div class="mx-auto w-1/4 shadow-2xl rounded p-5 bg-white animate__animated animate__zoomInDown">
        <h1 class="text-3xl">Register your account</h1>
        <form action="{{ route('auth.create') }}" method="post">
        @csrf
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
            <div class="flex flex-col mb-4">
                <label class="uppercase px-4 py-3 font-bold text-lg text-grey-darkest" for="login">Login</label>
                <input class="form-input px-4 py-3 rounded-full border h-10 focus:outline-none focus:ring focus:border-blue-300" type="text" name="login" placeholder="Enter login" value="{{ old('login') }}">
                <span class="bg-600-red">@error('login') {{ $message }} @enderror</span>
            </div>
            <div class="flex flex-col mb-4">
                <label class="uppercase px-4 py-3 font-bold text-lg text-grey-darkest" for="password">Password</label>
                <input class="form-input px-4 py-3 rounded-full border h-10 focus:outline-none focus:ring focus:border-blue-300" type="password" name="password" placeholder="Enter password">
                <span class="bg-600-red">@error('password') {{ $message }} @enderror</span>
            </div>
            <div class="flex flex-col mb-4">
                <label class="uppercase px-4 py-3 font-bold text-lg text-grey-darkest" for="password">Repeat Password</label>
                <input class="form-input px-4 py-3 rounded-full border h-10 focus:outline-none focus:ring focus:border-blue-300" type="password" name="rpassword" placeholder="Repeat password">
                <span class="bg-600-red">@error('rpassword') {{ $message }} @enderror</span>
            </div>
            <div class="flex flex-col mb-4">
                <label class="uppercase px-4 py-3 font-bold text-lg text-grey-darkest" for="email">Email</label>
                <input class="form-input px-4 py-3 rounded-full border h-10 h-10 focus:outline-none focus:ring focus:border-blue-300" type="email" name="email" placeholder="Enter Email" value="{{ old('email') }}">
                <span class="bg-600-red">@error('email') {{ $message }} @enderror</span>
            </div>
            <div class="flex flex-col mb-4">
                <label class="uppercase px-4 py-3 font-bold text-lg text-grey-darkest" for="fname">First Name</label>
                <input class="form-input px-4 py-3 rounded-full border h-10 focus:outline-none focus:ring focus:border-blue-300" type="text" name="fname" placeholder="Enter First Name" value="{{ old('fname') }}">
                <span class="bg-600-red">@error('fname') {{ $message }} @enderror</span>
            </div>
            <div class="flex flex-col mb-4">
                <label class="uppercase px-4 py-3 font-bold text-lg text-grey-darkest" for="lname">Last Name</label>
                <input class="form-input px-4 py-3 rounded-full border h-10 focus:outline-none focus:ring focus:border-blue-300" type="text" name="lname" placeholder="Enter Last Name" value="{{ old('lname') }}">
                <span class="bg-600-red">@error('lname') {{ $message }} @enderror</span>
            </div>
            <div class="flex flex-col mb-4 w-24 mx-auto">
                <button class="py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-400 focus:outline-none" type="submit">Register</button>
            </div>
        </form>
        <a href="calendar" class="py-2 px-3 underline">I already have account!</a>
        </div>
    </div>
@endsection