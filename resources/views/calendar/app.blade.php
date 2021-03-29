

    <div class="h-screen justify-center items-center">
    <div class="text-center">
        <h1 class="text-4xl">Calendar Absence</h1>
        <h1 class="text-2xl mb-5 mt-5"> {{ $monthName }} </h1>
    </div>
    <div>
        <table class="table-auto border-separate border border-black-800 mx-auto text-center">
            <thead >
                <tr>
                    <th class="border border-black">User</th>
                @foreach($calendar as $monthDay)
                    @if($monthDay['day']['event'] !== "")
                        <div class="group relative">
                            <th class="border border-black bg-{{ $monthDay['day']['color'] }}-300 has-tooltip"> 
                                {{ $monthDay['day']['number'] }}
                                <span class="tooltip bg-{{ $monthDay['day']['color'] }}-600 text-left p-2 rounded-full py-3 px-6"> {{ $monthDay['day']['event'] }}</span>
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
                            @if($userDay['reason'] !== "Weekend")
                            <div class="group relative">
                                <td class="border border-black bg-{{ $userDay['bgcolor'] }}-600 has-tooltip">
                                    <span class="tooltip bg-{{ $userDay['bgcolor'] }}-300 text-left p-2 rounded-full py-3 px-6"><b>Reason:</b> {{  $userDay['reason'] }} <br> <b>Comment:</b> {{ $userDay['comment'] }}</span>
                                </td>
                            </div>
                            @else
                            <div class="group relative">
                                <td class="border border-black bg-{{ $userDay['bgcolor'] }}-600 has-tooltip">
                                    <span class="tooltip bg-{{ $userDay['bgcolor'] }}-300 text-left p-2 rounded-full py-3 px-6"><b>{{  $userDay['reason'] }}</b></span>
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


@yield('content')