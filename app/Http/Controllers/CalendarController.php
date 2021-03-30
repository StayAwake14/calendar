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
    public function index()
    {
        BusinessDay::enable('Carbon\Carbon');
        Carbon::setHolidaysRegion('pl');
        $users = users::all()->toArray();
        $date = Carbon::now();
        $holidays = Carbon::getHolidays('pl');
        $year = $date->year;
        $month= $date->month;
        $fday = $date->firstOfMonth()->format("j");
        $lday = $date->lastOfMonth()->format("j");

        $monthLength = $date->daysInMonth;
        $monthName = $date->format("F");
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
            elseif(!empty($monthHolidays[$day]))
            {
                $calendar[$day]['day']['color'] = 'pink';
            }
            else 
            {
                $calendar[$day]['day']['color'] = 'white';
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
            }
            
        }

        //FILL MATRIX WITH ABSENCES
        foreach($users as $user)
        {
            $absences = absences::all()
            ->where('user_id', $user['id'])
            ->toArray();

            $matrix[$user['id']]['details']['fname'] = $user['fname'];
            $matrix[$user['id']]['details']['lname'] = $user['lname'];

            foreach($absences as $absence)
            {
            
                $reasons = reasons::all()
                ->where('id', $absence['reason_id'])
                ->toArray();

                $dayFrom = Carbon::parse($absence['datefrom'])->format('j');
                $dayTo = Carbon::parse($absence['dateto'])->format('j');
        
                for($day = $dayFrom; $day < $dayTo+1; $day++)
                {
                   
                    foreach($reasons as $reason)
                    {
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

                    $matrix[$user['id']]['calendar'][$day]['comment'] = $absence['description'];
                }
               
            }
        }

        return view('calendar', [
            'calendar' => $calendar,
            'month_days' => $monthLength,
            'monthName' => $monthName,
            'matrix' => $matrix
        ]);
    }
} 