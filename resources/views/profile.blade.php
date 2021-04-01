@extends('layouts.base')

@section('profile')
    @if(Session::get('UserLogged'))
        <div class="container calendar text-center mx-auto">
            <div class="flex justify-between h-screen">
                <div class="flex justify-center items-center">
                    <div class="flex-col">
                        <p class="p-3 ">Imię: {{ $LoggedUserInfo->fname }} </p>
                        <p class="p-3">Nazwisko: {{ $LoggedUserInfo->lname }} </p>
                        <p class="p-3 mb-5">Adres Email: {{ $LoggedUserInfo->email }} </p>
                        <a class="p-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{ route('calendar') }}">Calendar</a>
                        <a class="p-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{ route('reason') }}">Add Reason</a>
                        <a class="p-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{ route('absence') }}">Add Absence</a>
                        <a class="p-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="{{ route('logout') }}">Logout</a>
                    </div>
                   
                </div>
                <div class="flex justify-between h-screen">
                    <div class="flex justify-center items-center">
                        <div class="flex flex-col">
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="/profile/month/1">January</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="/profile/month/2">February</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="/profile/month/3">March</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="/profile/month/4">April</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="/profile/month/5">May</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="/profile/month/6">June</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="/profile/month/7">July</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="/profile/month/8">August</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="/profile/month/9">September</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="/profile/month/10">Octoboer</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="/profile/month/11">November</a>
                            <a class="p-5 my-2 py-2 px-4 bg-indigo-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none" href="/profile/month/12">December</a>
                        </div>
                    </div>
                </div>
       
                <div class="flex justify-center items-center">
                    <div class="flex-col">
                        <h1 class="text-lg text-grey-darkest text-5xl p-5"> Your personal calendar </h1>
                        <h1 class="text-lg text-grey-darkest uppercase text-4xl p-5"> {{$monthName}} </h1>
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
                                                <span class="text-center mt-5 pl-4 pt-2.5 pb-2.5 pr-4 bg-{{$day['day']['color']}}-300 rounded-full mb-4">{{$day['day']['number']}}</span>
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