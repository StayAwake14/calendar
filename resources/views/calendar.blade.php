@extends('layouts.base')

@section('calendar')

    <div class="flex text-white h-screen justify-center items-center mx-auto bg-gradient-to-r from-purple-600 via-pink-600 to-red-400">
        <div>
    <div class="text-center">
            <h1 class="text-5xl neon-white">Calendar Absence</h1>
            @if(Session::get('UserLogged'))
            <div class="results">
                <div class="alert alert-success mt-7">
                    <a class="p-5 py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none" href="{{ route('profile') }}">Profile</a>
                    <a class="p-5 py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none" href="{{ route('logout') }}">Logout</a>
                </div>
            </div>  
            @else
            <div class="block mt-5">
                <a class="py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-400 focus:outline-none" href="{{ route('login')}}">Login</a>
                <a class="py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-400 focus:outline-none" href="{{ route('register')}}">Register</a>
            </div>
            @endif
            <h1 class="text-5xl mt-5 pt-5 drop-shadow-lg neon-white"> {{ $year }} </h1>
            <h1 class="text-3xl w-1/6 p-10 mx-auto neon-white"> {{ $monthName }} </h1>
        </div>
        
        <div class="calendar text-gray-600">
            <table class="table-auto mx-auto text-center border shadow-2xl p-5 bg-white">
                <thead>
                    <tr>
                        <th></th>
                    @foreach($base as $monthDay)
                        @if(isset($monthDay['day']['event']))
                            <div class="group relative">
                                <th class="bg-{{ $monthDay['day']['color'] }}-600 text-{{ $monthDay['day']['color'] }}-200 has-tooltip rounded-full animate__animated animate__backInDown animate__delay-1s"> 
                                    {{ $monthDay['day']['name'] }}
                                    <span class="tooltip bg-{{ $monthDay['day']['color'] }}-300 text-black text-center p-2 rounded-full py-3 px-6 rounded-full"> {{ $monthDay['day']['event'] }}</span>
                                </th>
                            </div>
                        @elseif(isset($monthDay['day']['weekend']))
                            <div class="group relative ">
                                <th class="bg-{{ $monthDay['day']['color'] }}-600 text-{{ $monthDay['day']['color'] }}-200 has-tooltip rounded-full animate__animated animate__backInDown animate__faster"> 
                                    {{ $monthDay['day']['name'] }}
                                    <span class="tooltip bg-{{ $monthDay['day']['color'] }}-300  text-black text-center p-2  rounded-full py-3 px-6"> {{ $monthDay['day']['weekend'] }}</span>
                                </th>
                            </div>
                        @else
                            <th class="bg-{{ $monthDay['day']['color'] }}-300 text-{{ $monthDay['day']['color'] }}-200 rounded-full animate__animated animate__backInDown animate__faster"> 
                                {{ $monthDay['day']['name'] }}
                            </th>
                        @endif
                    @endforeach
                    </tr>
                    <tr>
                        <th></th>
                    @foreach($base as $monthDay)
                        @if(isset($monthDay['day']['event']))
                            <div class="group relative">
                                <th class="bg-{{ $monthDay['day']['color'] }}-600 has-tooltip text-{{ $monthDay['day']['color'] }}-200 rounded-full animate__animated animate__backInDown animate__delay-1s"> 
                                    {{ $monthDay['day']['number'] }}
                                    <span class="tooltip bg-{{ $monthDay['day']['color'] }}-300 text-black rounded-full p-4 rounded-full text-center"> {{ $monthDay['day']['event'] }}</span>
                                </th>
                            </div>
                        @elseif(isset($monthDay['day']['weekend']))
                            <div class="group relative ">
                                <th class="bg-{{ $monthDay['day']['color'] }}-600 has-tooltip text-{{ $monthDay['day']['color'] }}-200 rounded-full animate__animated animate__backInDown animate__faster"> 
                                    {{ $monthDay['day']['number'] }}
                                    <span class="tooltip bg-{{ $monthDay['day']['color'] }}-300 text-black rounded-full p-4 text-center"> {{ $monthDay['day']['weekend'] }}</span>
                                </th>
                            </div>
                        @else
                            <th class="bg-{{ $monthDay['day']['color'] }}-300 rounded-full animate__animated animate__flipInX animate__delay-1s"> 
                                {{ $monthDay['day']['number'] }}
                            </th>
                        @endif
                    @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($calendar as $user)
                    <tr>
                        <div class="group relative">
                            <td class="font-bold bg-green-200 rounded-full p-2 has-tooltip-image animate__animated animate__zoomInLeft animate__delay-1s"> {{$user['details']['fname'] }} {{$user['details']['lname'] }} 
                                <img src="{{ asset('/images/avatars/'.$user['details']['id'].'.PNG') }}" class="tooltip-image p-2 p-5 font-bold text-center" alt="no image uploaded">
                            </td>
                        </div>
                        @foreach($user['calendar'] as $userDay)
                            @if(isset($userDay['reason']))
                                @if($userDay['reason'] === "Weekend")
                                <div class="group relative">
                                    <td class="bg-{{ $userDay['bgcolor'] }}-600 has-tooltip rounded-full animate__animated animate__backInUp animate__faster">
                                        <span class="tooltip bg-{{ $userDay['bgcolor'] }}-300 p-2 rounded-full p-5 font-bold text-center">{{  $userDay['reason'] }}</span>
                                    </td>
                                </div>
                                @elseif($userDay['reason'] === "Event")
                                <div class="group relative">
                                    <td class="bg-{{ $userDay['bgcolor'] }}-600 has-tooltip rounded-full animate__animated animate__backInUp animate__delay-1s">
                                        <span class="tooltip bg-{{ $userDay['bgcolor'] }}-300 p-2 rounded-full p-5 font-bold text-center">{{  $userDay['event'] }}</span>
                                    </td>
                                </div>
                                @else
                                <div class="group relative">
                                    <td class="bg-{{ $userDay['bgcolor'] }}-600 has-tooltip rounded-full animate__animated animate__backInUp animate__fast">
                                        @if($userDay['confirmed'])
                                        <span class="text-{{ $userDay['bgcolor'] }}-100 font-bold">A</span>
                                        @endif
                                        <span class="tooltip bg-{{ $userDay['bgcolor'] }}-300 p-2 rounded-full p-5 text-center"><b> Reason: </b>{{  $userDay['reason'] }} </br> <b>Comment: </b> {{  $userDay['comment'] }} </span>
                                    </td>
                                </div>
                                @endif
                            @else
                                <div class="group relative">
                                    <td class="bg-{{ $userDay['bgcolor'] }}-600 rounded-full animate__animated animate__backInUp animate__delay-1s backdrop-filter shadow-1xl">
                                    x
                                    </td>
                                </div>
                            @endif
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>
            <div class="block text-center my-20">
                <a class="py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-400 focus:outline-none" href="{{ route('calendar.switch', [$subMonth, $subYear] )}}">Previous</a>
                <a class="py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-400 focus:outline-none" href="{{ route('calendar.switch', [$nextMonth, $nextYear] )}}">Next</a>
            </div>
        </div>
        </div>
    </div>
@endsection