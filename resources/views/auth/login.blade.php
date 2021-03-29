
<div class="mx-auto text-center mt-5 mb-5">
@if(Session::get('UserLogged'))
<div class="results">
    
            <div class="alert alert-success">
                <a class="p-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none" href="profile">Profile</a>
                <a class="p-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none" href="logout">Logout</a>
            </div>
    </div>
@else
<h1 class="text-3xl">Login Form</h1>
    <form action="{{ route('auth.check') }}" method="post">
    @csrf
        <div class="form-group">
            <label>Login</label>
            <input class="form-input px-4 py-3 rounded-full" type="text" name="login" placeholder="Enter login" value="{{ old('login') }}">
            <span class="bg-600-red">@error('login') {{ $login }} @enderror</span>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-input px-4 py-3 rounded-full"  type="password" name="password" placeholder="Enter password">
            <span class="bg-600-red">@error('password') {{ $message }} @enderror</span>
        </div>
        <div class="form-group">
            <button class="py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none" type="submit">Login</button>
        </div>
    </form>
    <a href="register">Don't have an account? Create now!</a>

    @endif
</div>


@yield('login')