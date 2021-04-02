@extends('layouts.base')

@section('calendar')

    <div class="fixed menu w-1/5 text-center bg-blue-300 h-full p-5">
            @if(Session::get('UserLogged'))
                <div class="results">
                    <div class="alert alert-success">
                        <a class="p-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none" href="{{ route('profile') }}">Profile</a>
                        <a class="p-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none" href="{{ route('logout') }}">Logout</a>
                    </div>
                </div>
            @else
                <h1 class="text-3xl">Login to your account</h1>
                <form action="{{ route('auth.check') }}" method="post">
                @csrf
                    <div class="flex flex-col mb-4">
                        <label class="uppercase px-4 py-3 font-bold text-lg text-grey-darkest" for="login">Login</label>
                        <input class="form-input px-4 py-3 rounded-full border focus:outline-none focus:ring focus:border-blue-300" type="text" name="login" placeholder="Enter login" value="{{ old('login') }}">
                        <span class="bg-600-red">@error('login') {{ $login }} @enderror</span>
                    </div>
                    <div class="flex flex-col mb-4">
                        <label class="uppercase px-4 py-3 font-bold text-lg text-grey-darkest" for="password">Password</label>
                        <input class="form-input px-4 py-3 rounded-full border focus:outline-none focus:ring focus:border-blue-300" type="password" name="password" placeholder="Enter password">
                        <span class="bg-600-red">@error('password') {{ $message }} @enderror</span>
                    </div>
                    <div class="flex flex-col mb-4 w-24 mx-auto">
                        <button class="py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none" type="submit">Login</button>
                    </div>
                </form>
                <a href="register" class="mt-5 p-3 underline">Don't have an account? Create now!</a>
            @endif
    </div>
    <div class="h-screen justify-center w-4/5 items-center float-right">
        <div class="text-center mt-5">
            <h1 class="text-4xl">Calendar Absence</h1>
            <h1 class="text-2xl mb-5 mt-5"> {{ $year }} </h1>
            <h1 class="text-2xl mb-5 mt-5"> {{ $monthName }} </h1>
            <div class="inline-block">
                <a class="py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{URL::route('calendar.show', [$subMonth, $subYear] )}}">Previous</a>
                <a class="py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{URL::route('calendar.show', [$nextMonth, $nextYear] )}}">Next</a>
            </div>
        </div>
        <div class="mt-5">
            <table class="table-auto border-separate border border-black-800 mx-auto text-center">
                <thead >
                    <tr>
                        <th class="border border-black">User</th>
                    @foreach($calendar as $monthDay)
                        @if($monthDay['day']['event'] !== "")
                            <div class="group relative">
                                <th class="border border-black bg-{{ $monthDay['day']['color'] }}-600 has-tooltip"> 
                                    {{ $monthDay['day']['number'] }}
                                    <span class="tooltip bg-{{ $monthDay['day']['color'] }}-300 text-left p-2 rounded-full py-3 px-6"> {{ $monthDay['day']['event'] }}</span>
                                </th>
                            </div>
                        @elseif($monthDay['day']['weekend'] !== "")
                            <div class="group relative">
                                <th class="border border-black bg-{{ $monthDay['day']['color'] }}-600 has-tooltip"> 
                                    {{ $monthDay['day']['number'] }}
                                    <span class="tooltip bg-{{ $monthDay['day']['color'] }}-300 text-left p-2 ml-5 rounded-full py-3 px-6"> {{ $monthDay['day']['weekend'] }}</span>
                                </th>
                            </div>
                        @else
                            <th class="border border-black bg-{{ $monthDay['day']['color'] }}-300"> 
                                {{ $monthDay['day']['number'] }}
                            </th>
                        @endif
                    @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($matrix as $user)
                    <tr>
                        <td class="border border-black font-bold p-2"> {{$user['details']['fname'] }} {{$user['details']['lname'] }} </td>
                        @foreach($user['calendar'] as $userDay)
                            @if($userDay['reason'] !== "")
                                @if($userDay['reason'] === "Weekend")
                                <div class="group relative">
                                    <td class="border border-black bg-{{ $userDay['bgcolor'] }}-600 has-tooltip">
                                        <span class="tooltip bg-{{ $userDay['bgcolor'] }}-300 text-left p-2 rounded-full py-3 px-6 font-bold">{{  $userDay['reason'] }}</span>
                                    </td>
                                </div>
                                @elseif($userDay['reason'] === "Event")
                                <div class="group relative">
                                    <td class="border border-black bg-{{ $userDay['bgcolor'] }}-600 has-tooltip">
                                        <span class="tooltip bg-{{ $userDay['bgcolor'] }}-300 text-left p-2 rounded-full py-3 px-6 font-bold">{{  $userDay['event'] }}</span>
                                    </td>
                                </div>
                                @else
                                <div class="group relative">
                                    <td class="border border-black bg-{{ $userDay['bgcolor'] }}-600 has-tooltip">
                                        <span class="tooltip bg-{{ $userDay['bgcolor'] }}-300 text-left p-2 rounded-full py-3 px-6"><b> Reason: </b>{{  $userDay['reason'] }} </br> <b>Comment: </b> {{  $userDay['comment'] }} </span>
                                    </td>
                                </div>
                                @endif
                            @else
                                <div class="group relative">
                                    <td class="border border-black bg-{{ $userDay['bgcolor'] }}-600">
                                    </td>
                                </div>
                            @endif
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection