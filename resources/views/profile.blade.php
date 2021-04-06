@extends('layouts.base')

@section('profile')
    @if(Session::get('UserLogged'))
        <div class="calendar text-center mx-auto">
            <div class="flex justify-between h-screen">
                <div class="flex justify-center items-center mx-auto">
                    <div class="flex-col">
                        <p class="p-3 ">First Name: {{ $LoggedUserInfo->user->fname }} </p>
                        <p class="p-3">Last Name: {{ $LoggedUserInfo->user->lname }} </p>
                        <p class="p-3 mb-5">Email: {{ $LoggedUserInfo->user->email }} </p>
                        <p class="p-3 ">Team: {{ $LoggedUserInfo->team_name }} </p>
                        <div class="buttons mt-5">
                            <div class="inline-block">
                                <a class="p-5 mt-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{ route('calendar') }}">Calendar</a>
                                <a class="p-5 mt-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{ route('reason') }}">Add Reason</a>
                                <a class="p-5 mt-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{ route('absence') }}">Add Absence</a>
                                <a class="p-5 mt-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{ route('leader') }}">Add Leader</a>
                            </div>
                            <div class="mt-5 inline-block">
                                <a class="p-5 mt-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{ route('team') }}">Add Team</a>
                                <a class="p-5 mt-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{ route('verify') }}">Verify Absences</a>
                                <a class="p-5 mt-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{ route('manage') }}">Manage Users</a>
                                <a class="p-5 mt-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{ route('logout') }}">Logout</a>
                            </div>
                        </div>
                    </div>
                   
                </div>
                <div class="flex justify-between h-screen mx-auto">
                    <div class="flex justify-center items-center">
                        <div class="flex flex-col">
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{URL::route('profile.show2', [1, $year] )}}">January</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{URL::route('profile.show2', [2, $year] )}}">February</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{URL::route('profile.show2', [3, $year] )}}">March</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{URL::route('profile.show2', [4, $year] )}}">April</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{URL::route('profile.show2', [5, $year] )}}">May</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{URL::route('profile.show2', [6, $year] )}}">June</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{URL::route('profile.show2', [7, $year] )}}">July</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{URL::route('profile.show2', [8, $year] )}}">August</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{URL::route('profile.show2', [9, $year] )}}">September</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{URL::route('profile.show2', [10, $year] )}}">Octoboer</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{URL::route('profile.show2', [11, $year] )}}">November</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{URL::route('profile.show2', [12, $year] )}}">December</a>
                        </div>
                    </div>
                </div>
       
                <div class="flex justify-center items-center mx-auto">
                    <div class="flex-col">
                        <h1 class="text-lg text-grey-darkest text-5xl p-5"> Your personal calendar </h1>
                        <h1 class="text-lg text-grey-darkest uppercase text-4xl p-5"> {{$year}} </h1>
                            @foreach($accountYears as $year)
                                <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{URL::route('profile.show2', [$month, $year] )}}"> {{ $year }}</a>
                            @endforeach
                        <h1 class="text-lg text-grey-darkest uppercase text-4xl mt-5 p-5"> {{$monthName}} </h1>
                        <table class="table-fixed mx-auto" cellspacing="10">
                            <thead>
                                <tr>
                                    <th class="p-5">Sun</th>
                                    <th class="p-5">Mon</th>
                                    <th class="p-5">Tue</th>
                                    <th class="p-5">Wed</th>
                                    <th class="p-5">Thu</th>
                                    <th class="p-5">Fri</th>
                                    <th class="p-5">Sat</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($calendar as $week)
                                <tr>
                                @foreach($week as $day)
                                    @empty($day['day']['weekend'])
                                        @empty($day['day']['reason'])
                                            <td class="p-4 has-tooltip">
                                                <span class="text-center mt-5 pl-4 pt-2.5 pb-2.5 pr-4 bg-{{$day['day']['color']}}-300 rounded-full mb-4">{{$day['day']['number']}}</span>
                                            </td>
                                        @else
                                        <td class="p-4 has-tooltip">
                                                @if($day['day']['confirmed'])
                                                    <span class="text-center mt-5 pl-4 pt-2.5 pb-2.5 pr-4 bg-{{$day['day']['color']}}-300 rounded-full mb-4 font-bold border-2 border-{{$day['day']['color']}}-600">{{$day['day']['number']}}</span>
                                                @else
                                                    <span class="text-center mt-5 pl-4 pt-2.5 pb-2.5 pr-4 bg-{{$day['day']['color']}}-300 rounded-full mb-4">{{$day['day']['number']}}</span>
                                                @endif
                                                <span class="tooltip bg-{{ $day['day']['color'] }}-300 text-left p-2 rounded-full py-3 px-6"><b>Reason: </b>{{$day['day']['reason']}}</br> <b>Comment: </b> {{$day['day']['comment']}}</span>                                        
                                            </td>
                                        @endempty
                                    @else
                                    <td class="p-4 has-tooltip">
                                        <span class="text-center mt-5 pl-4 pt-2.5 pb-2.5 pr-4 bg-{{$day['day']['color']}}-300 rounded-full mb-4">{{$day['day']['number']}}</span>                                        
                                        <span class="tooltip bg-{{ $day['day']['color'] }}-300 text-left p-2 rounded-full py-3 px-6 font-bold">{{$day['day']['weekend']}}</span>     
                                    </td>
                                    @endempty
                                @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
           </div>
        </div>
    @endif
@endsection