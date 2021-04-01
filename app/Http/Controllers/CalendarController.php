<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
Use \Carbon\Carbon;

use App\Models\absences;
use App\Models\users;
use App\Models\reasons;

use Cmixin\BusinessDay;


class CalendarController extends Controller
{
    public function index(Request $request)
    {
       
        BusinessDay::enable('Carbon\Carbon');
        Carbon::setHolidaysRegion('pl');
        $holidays = Carbon::getHolidays('pl');
        $users = users::all()->toArray();

        $date = Carbon::now();
        $dateNext = Carbon::now();
        $monthName = $date->format("F");
        $year = $date->year;
        $month= $date->month;
        $monthLength = $date->daysInMonth;
        $fday = $date->firstOfMonth()->format("j");
        $lday = $date->lastOfMonth()->format("j");
        $subMonth = $date->subMonth()->month;
        $nextMonth = $dateNext->addMonth()->month;
    

     /*   if($request->month)
        {
            $date = Carbon::parse("2021-".$request->month."-01");
            $dateNext = Carbon::parse("2021-".$request->month."-01");
            $monthName = $date->format("F");
            $year = $date->year;
            $month = $request->month;
            $monthLength = $date->daysInMonth;
            $fday = $date->firstOfMonth()->format("j");
            $lday = $date->lastOfMonth()->format("j");
            $subMonth = $request->month-1;
            if($subMonth == 0)
            {
                $subMonth = 12;
            }
            $nextMonth = $dateNext->addMonth()->month;
        }
        else
        {}*/


      /*  echo "Length: ".$monthLength."<br>";
        echo "Previous month: ".$subMonth."<br>";
        echo "Current month: ".$month."<br>";
        echo "Next Month: ".$nextMonth."<br>"; */

    //    $usersCount = $users->count();
        $matrix = array();
        $calendar = array();
        $monthHolidays = array();

        $weekMap = [
            0 => 'SU',
            1 => 'MO',
            2 => 'TU',
            3 => 'WE',
            4 => 'TH',
            5 => 'FR',
            6 => 'SA',
        ];

        //CREATE HOLIDAYS ARR
        foreach (Carbon::getYearHolidays($year) as $id => $holiday) {
            if($holiday->month == $month)
            {
                $holidayDay = $holiday->format('j');
                $monthHolidays[$holidayDay] = 
                [
                    'month'=> $month,
                    'day'=> $holidayDay,
                    'event'=> $holiday->getHolidayName()
                ];
            }
        }

        for($day = $fday; $day < $lday+1; $day++)
        {
            $date2 = Carbon::parse($year.'-'.$month.'-'.$day);
            $dayOfTheWeek = $date2->dayOfWeek;
            $calendar[$day]['day']['number'] = $day;
            $calendar[$day]['day']['event'] = !empty($monthHolidays[$day]) ? $monthHolidays[$day]['event'] : "";
            $calendar[$day]['day']['weekend'] = "";
            
            if($date2->isWeekend())
            {
                $calendar[$day]['day']['color']= 'purple';
                $calendar[$day]['day']['weekend'] = "Weekend";
            }
            else 
            {
                $calendar[$day]['day']['color'] = 'white';
            }

            if(!empty($monthHolidays[$day]))
            {
                $calendar[$day]['day']['color'] = 'pink';
            }
        }
       
      // print_r($calendar);
       
        // CREATE MATRIX FOR EVERY USER
        foreach($users as $user){

            for($day = 1; $day < $monthLength+1; $day++)
            {
                $matrix[$user['id']]['calendar'][$day]['comment'] = "";
                $matrix[$user['id']]['calendar'][$day]['reason'] = "";

                if($calendar[$day]['day']['weekend'] === "")
                {
                    $matrix[$user['id']]['calendar'][$day]['bgcolor'] = "white";
                }
                else
                {
                    $matrix[$user['id']]['calendar'][$day]['reason'] = "Weekend";
                    $matrix[$user['id']]['calendar'][$day]['bgcolor'] = 'purple';
                }
                
                if( $calendar[$day]['day']['event'] !== "")
                {
                    $matrix[$user['id']]['calendar'][$day]['event'] = $calendar[$day]['day']['event'];
                    $matrix[$user['id']]['calendar'][$day]['reason'] = "Event";
                    $matrix[$user['id']]['calendar'][$day]['bgcolor'] = 'pink';
                }
            }
            
        }

        //FILL MATRIX WITH ABSENCES
        foreach($users as $user)
        {
            $absences = DB::table('absences')
            ->where('user_id', $user['id'])
            ->where('datefrom', 'like', "2021-0$month%")
            ->get();

         //   echo "2021-0$month%";

            $matrix[$user['id']]['details']['fname'] = $user['fname'];
            $matrix[$user['id']]['details']['lname'] = $user['lname'];

            foreach($absences as $absence)
            {
                $reasons = reasons::all()
                ->where('id', $absence->reason_id)
                ->toArray();

                $dayFrom = Carbon::parse($absence->datefrom)->format('j');
                $dayTo = Carbon::parse($absence->dateto)->format('j');
        
                for($day = $dayFrom; $day < $dayTo+1; $day++)
                {
                   
                    foreach($reasons as $reason)
                    {
                        if(empty($matrix[$user['id']]['calendar'][$day]['reason']))
                        switch($reason['reason_name'])
                        {
                            case "Vacation":
                                $matrix[$user['id']]['calendar'][$day]['reason'] = $reason['reason_name'];
                                $matrix[$user['id']]['calendar'][$day]['bgcolor'] = 'red';
                                break;
                             case "Business Trip":
                                $matrix[$user['id']]['calendar'][$day]['reason'] = $reason['reason_name'];
                                $matrix[$user['id']]['calendar'][$day]['bgcolor'] = 'blue';
                                break;
                            default:
                                $matrix[$user['id']]['calendar'][$day]['reason'] = $reason['reason_name'];
                        }
                        
                    }

                    $matrix[$user['id']]['calendar'][$day]['comment'] = $absence->description;
                }
               
            }
        }

        return view('calendar', [
            'calendar' => $calendar,
            'month_days' => $monthLength,
            'monthName' => $monthName,
            'subMonth' => $subMonth,
            'nextMonth' => $nextMonth,
            'matrix' => $matrix
        ]);
    }

    public function show($curr_month)
    {
       
        BusinessDay::enable('Carbon\Carbon');
        Carbon::setHolidaysRegion('pl');
        $holidays = Carbon::getHolidays('pl');
        $users = users::all()->toArray();

        if($curr_month)
        {
            $date = Carbon::parse("2021-".$curr_month."-01");
            $dateNext = Carbon::parse("2021-".$curr_month."-01");
            $monthName = $date->format("F");
            $year = $date->year;
            $month = $curr_month;
            $monthLength = $date->daysInMonth;
            $fday = $date->firstOfMonth()->format("j");
            $lday = $date->lastOfMonth()->format("j");
            $subMonth = $curr_month-1;
            if($subMonth == 0)
            {
                $subMonth = 12;
            }
            $nextMonth = $dateNext->addMonth()->month;
        }
        else
        {
            $date = Carbon::now();
            $dateNext = Carbon::now();
            $monthName = $date->format("F");
            $year = $date->year;
            $month= $date->month;
            $monthLength = $date->daysInMonth;
            $fday = $date->firstOfMonth()->format("j");
            $lday = $date->lastOfMonth()->format("j");
            $subMonth = $date->subMonth()->month;
            $nextMonth = $dateNext->addMonth()->month;
        }

    /*    echo "Length: ".$monthLength."<br>";
        echo "Previous month: ".$subMonth."<br>";
        echo "Current month: ".$month."<br>";
        echo "Next Month: ".$nextMonth."<br>"; */

    //    $usersCount = $users->count();
        $matrix = array();
        $calendar = array();
        $monthHolidays = array();

        $weekMap = [
            0 => 'SU',
            1 => 'MO',
            2 => 'TU',
            3 => 'WE',
            4 => 'TH',
            5 => 'FR',
            6 => 'SA',
        ];

        //CREATE HOLIDAYS ARR
        foreach (Carbon::getYearHolidays($year) as $id => $holiday) {
            
            if($holiday->month == $month)
            {
                $holidayDay = $holiday->format('j');
                $monthHolidays[$holidayDay] = 
                [
                    'month'=> $month,
                    'day'=> $holidayDay,
                    'event'=> $holiday->getHolidayName()
                ];
            }
        }

        for($day = $fday; $day < $lday+1; $day++)
        {
            $date2 = Carbon::parse($year.'-'.$month.'-'.$day);
            $dayOfTheWeek = $date2->dayOfWeek;
            $calendar[$day]['day']['number'] = $day;
            $calendar[$day]['day']['event'] = !empty($monthHolidays[$day]) ? $monthHolidays[$day]['event'] : "";
            $calendar[$day]['day']['weekend'] = "";
            
            if($date2->isWeekend())
            {
                $calendar[$day]['day']['color']= 'purple';
                $calendar[$day]['day']['weekend'] = "Weekend";
            }
            else 
            {
                $calendar[$day]['day']['color'] = 'white';
            }

            if(!empty($monthHolidays[$day]))
            {
                $calendar[$day]['day']['color'] = 'pink';
            }
        }
       
      // print_r($calendar);
       
        // CREATE MATRIX FOR EVERY USER
        foreach($users as $user){

            for($day = 1; $day < $monthLength+1; $day++)
            {
                $matrix[$user['id']]['calendar'][$day]['comment'] = "";
                $matrix[$user['id']]['calendar'][$day]['reason'] = "";

                if($calendar[$day]['day']['weekend'] === "")
                {
                    $matrix[$user['id']]['calendar'][$day]['bgcolor'] = "white";
                }
                else
                {
                    $matrix[$user['id']]['calendar'][$day]['reason'] = "Weekend";
                    $matrix[$user['id']]['calendar'][$day]['bgcolor'] = 'purple';
                }
                
                if( $calendar[$day]['day']['event'] !== "")
                {
                    $matrix[$user['id']]['calendar'][$day]['event'] = $calendar[$day]['day']['event'];
                    $matrix[$user['id']]['calendar'][$day]['reason'] = "Event";
                    $matrix[$user['id']]['calendar'][$day]['bgcolor'] = 'pink';
                }
            }
            
        }

        //FILL MATRIX WITH ABSENCES
        foreach($users as $user)
        {
            $absences = DB::table('absences')
            ->where('user_id', $user['id'])
            ->where('datefrom', 'like', "2021-0$curr_month%")
            ->get();

           // echo "2021-0$curr_month%";

            $matrix[$user['id']]['details']['fname'] = $user['fname'];
            $matrix[$user['id']]['details']['lname'] = $user['lname'];

            foreach($absences as $absence)
            {
                $reasons = reasons::all()
                ->where('id', $absence->reason_id)
                ->toArray();

                $dayFrom = Carbon::parse($absence->datefrom)->format('j');
                $dayTo = Carbon::parse($absence->dateto)->format('j');
        
                for($day = $dayFrom; $day < $dayTo+1; $day++)
                {
                   
                    foreach($reasons as $reason)
                    {
                        if(empty($matrix[$user['id']]['calendar'][$day]['reason']))
                        switch($reason['reason_name'])
                        {
                            case "Vacation":
                                $matrix[$user['id']]['calendar'][$day]['reason'] = $reason['reason_name'];
                                $matrix[$user['id']]['calendar'][$day]['bgcolor'] = 'red';
                                break;
                             case "Business Trip":
                                $matrix[$user['id']]['calendar'][$day]['reason'] = $reason['reason_name'];
                                $matrix[$user['id']]['calendar'][$day]['bgcolor'] = 'blue';
                                break;
                            default:
                                $matrix[$user['id']]['calendar'][$day]['reason'] = $reason['reason_name'];
                        }
                        
                    }

                    $matrix[$user['id']]['calendar'][$day]['comment'] = $absence->description;
                }
               
            }
        }
        
        return view('calendar', [
            'calendar' => $calendar,
            'month_days' => $monthLength,
            'monthName' => $monthName,
            'subMonth' => $subMonth,
            'nextMonth' => $nextMonth,
            'matrix' => $matrix
        ]);
    }
} 