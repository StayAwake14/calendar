@extends('layouts.base')

@section('profile')
    @if(Session::get('UserLogged'))
    
        <div class="calendar text-center bg-gradient-to-r from-purple-400 via-pink-400 to-purple-400 justify-center items-center h-screen flex text-white">
            <div class="fixed top-10 animate__animated animate__backInDown">
                <a class="p-5 mt-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{ route('calendar') }}">Calendar</a>
                <a class="p-5 mt-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{ route('reason') }}">Add Reason</a>
                <a class="p-5 mt-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{ route('absence') }}">Add Absence</a>
                <a class="p-5 mt-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{ route('leader') }}">Add Leader</a>
                <a class="p-5 mt-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{ route('team') }}">Add Team</a>
                <a class="p-5 mt-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{ route('verify') }}">Verify Absences</a>
                <a class="p-5 mt-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{ route('manage') }}">Manage Users</a>
                <a class="p-5 mt-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{ route('logout') }}">Logout</a>
            </div>
            <div class="flex w-3/4 mt-5">
                <div class="flex-col justify-center items-center mx-auto w-3/4">
                    <h1 class="text-lg text-grey-darkest text-4xl p-5 text-white neon-white animate__animated animate__flash"> Account details </h1>
                    <div class="flex-col text-gray-600 text-left bg-white rounded-3xl w-4/4 p-5 animate__animated animate__fadeIn">
                        <p class="p-3 text-2xl"><b>First Name:</b> {{ $LoggedUserInfo->fname }} </p>
                        <p class="p-3 text-2xl"><b>Last Name:</b> {{ $LoggedUserInfo->lname }} </p>
                        <p class="p-3 text-2xl"><b>Email:</b> {{ $LoggedUserInfo->email }} </p>
                        <p class="p-3 text-2xl"><b>Team:</b> {{ $LoggedUserInfo->team->team_name }} </p>
                    </div>
                    <h1 class="text-lg text-grey-darkest text-4xl p-5 text-white neon-white animate__animated animate__flash"> Incoming absences </h1>
                    <div class="flex-col text-gray-600 text-left rounded-3xl w-4/4 bg-white p-5 animate__animated animate__fadeIn">
                    @isset($absences)
                        @foreach($absences as $key => $absence)
                            <p class="p-3 text-2xl"><b> {{ $key+1 }}. </b> [ {{ $absence->reason->reason_name }}] {{ $absence->datefrom }} - {{ $absence->dateto }}</p>
                        @endforeach
                    @endisset
                    </div>
                </div>
                <div class="flex justify-center items-center mx-auto p-10 w-1/4">
                    <div class="flex justify-center items-center">
                        <div class="flex flex-col animate__animated animate__fadeInDown">
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{ route('profile.show2', [1, $year] )}}">January</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{ route('profile.show2', [2, $year] )}}">February</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{ route('profile.show2', [3, $year] )}}">March</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{ route('profile.show2', [4, $year] )}}">April</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{ route('profile.show2', [5, $year] )}}">May</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{ route('profile.show2', [6, $year] )}}">June</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{ route('profile.show2', [7, $year] )}}">July</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{ route('profile.show2', [8, $year] )}}">August</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{ route('profile.show2', [9, $year] )}}">September</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{ route('profile.show2', [10, $year] )}}">Octoboer</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{ route('profile.show2', [11, $year] )}}">November</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{ route('profile.show2', [12, $year] )}}">December</a>
                        </div>
                    </div>
                </div>
       
                <div class="flex text-gray-600">
                    <div class="flex-col">
                        <div class="animate__animated animate__flash">
                            <h1 class="text-lg text-grey-darkest text-5xl p-5 text-white neon-white"> Your personal calendar </h1>
                            <h1 class="text-lg text-grey-darkest uppercase text-4xl p-5 text-white neon-white"> {{$year}} </h1>
                                @foreach($accountYears as $year)
                                    <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="{{URL::route('profile.show2', [$month, $year] )}}"> {{ $year }}</a>
                                @endforeach
                            <h1 class="text-lg text-grey-darkest uppercase text-4xl mt-5 p-5 text-white neon-white"> {{$monthName}} </h1>
                        </div>
                        <table class="table-fixed mx-auto bg-white rounded-3xl animate__animated animate__flipInX" cellspacing="10">
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
                                                
                                                @if(!empty($day['day']['event']))
                                                    <span class="tooltip bg-{{ $day['day']['color'] }}-300 text-left p-2 rounded-full py-3 px-6 font-bold">{{$day['day']['event']}}</span>        
                                                @else
                                                    <span class="tooltip bg-{{ $day['day']['color'] }}-300 text-left p-2 rounded-full py-3 px-6"><b>Reason: </b>{{$day['day']['reason']}}</br> <b>Comment: </b> {{$day['day']['comment']}}</span>        
                                                @endif  
                              
                                            </td>
                                        @endempty
                                    @elseif(isset($day['day']['weekend']))
                                    <td class="p-4 has-tooltip">
                                        <span class="text-center mt-5 pl-4 pt-2.5 pb-2.5 pr-4 bg-{{$day['day']['color']}}-300 rounded-full mb-4">{{$day['day']['number']}}</span>                                        
                                        <span class="tooltip bg-{{ $day['day']['color'] }}-300 text-left p-2 rounded-full py-3 px-6 font-bold">{{$day['day']['weekend']}}</span>     
                                    </td>
                                    @else
                                    <td class="p-4 has-tooltip">
                                        <span class="text-center mt-5 pl-4 pt-2.5 pb-2.5 pr-4 bg-{{$day['day']['color']}}-300 rounded-full mb-4">{{$day['day']['number']}}</span>                                        
                                        <span class="tooltip bg-{{ $day['day']['color'] }}-300 text-left p-2 rounded-full py-3 px-6 font-bold">{{$day['day']['event']}}</span>     
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