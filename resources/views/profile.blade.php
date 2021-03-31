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
                        <a class="p-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="calendar">Calendar</a>
                        <a class="p-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="reason">Add Reason</a>
                        <a class="p-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="absence">Add Absence</a>
                        <a class="p-5 py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none" href="logout">Logout</a>
                    </div>
                </div>
       
                <div class="flex justify-center items-center">
                    <div class="flex-col">
                        <h1 class="text-lg text-grey-darkest text-5xl p-5"> Your personal calendar </h1>
                        <h1 class="text-lg text-grey-darkest uppercase text-4xl p-5"> March </h1>
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
                                                <span class="tooltip bg-{{ $day['day']['color'] }}-300 text-left p-2 rounded-full py-3 px-6"><b>Reason: </b>{{$day['day']['reason']}}</span>                                        
                                            </td>
                                        @endempty
                                    @else
                                    <td class="p-4 has-tooltip">
                                        <span class="text-center mt-5 pl-4 pt-2.5 pb-2.5 pr-4 bg-{{$day['day']['color']}}-300 rounded-full mb-4">{{$day['day']['number']}}</span>                                        
                                        <span class="tooltip bg-{{ $day['day']['color'] }}-300 text-left p-2 rounded-full py-3 px-6">{{$day['day']['weekend']}}</span>     
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