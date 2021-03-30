@extends('layouts.base')

@section('register')
    <div class="mx-auto text-center mt-5 mb-5">
        <h1 class="text-3xl">Register Form</h1>
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
            <div class="form-group">
                <label for="login">Login</label>
                <input class="form-input px-4 py-3 rounded-full" type="text" name="login" placeholder="Enter login" value="{{ old('login') }}">
                <span class="bg-600-red">@error('login') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-input px-4 py-3 rounded-full"  type="password" name="password" placeholder="Enter password">
                <span class="bg-600-red">@error('password') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="password">Repeat Password</label>
                <input class="form-input px-4 py-3 rounded-full"  type="password" name="rpassword" placeholder="Repeat password">
                <span class="bg-600-red">@error('rpassword') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-input px-4 py-3 rounded-full" type="email" name="email" placeholder="Enter Email" value="{{ old('email') }}">
                <span class="bg-600-red">@error('email') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="fname">First Name</label>
                <input class="form-input px-4 py-3 rounded-full" type="text" name="fname" placeholder="Enter First Name" value="{{ old('fname') }}">
                <span class="bg-600-red">@error('fname') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="lname">Last Name</label>
                <input class="form-input px-4 py-3 rounded-full" type="text" name="lname" placeholder="Enter Last Name" value="{{ old('lname') }}">
                <span class="bg-600-red">@error('lname') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <button class="py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none" type="submit">Register</button>
            </div>
        </form>
        <a href="calendar">I already have account!</a>
    </div>
@endsection