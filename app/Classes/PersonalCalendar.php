<?php

namespace  App\Classes;

use Illuminate\Support\Facades\DB;

use Cmixin\BusinessDay;
Use \Carbon\Carbon;

use App\Models\absences;
use App\Models\users;
use App\Models\reasons;



class PersonalCalendar extends Calendar{

    public $userLoggedId; // User's details
    public $subMonth, $subDate, $subDay, $subLastDay, $weekArr, $subYear, $nextMonth, $nextYear; // Config

    public function setPersonalCalendar($userLoggedId){
        // Personal Calendar Config
        BusinessDay::enable('Carbon\Carbon');
        Carbon::setHolidaysRegion($this->region);
        $holidays = Carbon::getHolidays();
        $this->userLoggedId = $userLoggedId;
        $this->date = $date = Carbon::now();
        $this->monthName = $this->getMonthName($date, "F");
        $this->currentYear = $date->year;
        $this->currentMonth = $date->month;
        $this->monthLength = $date->daysInMonth;
        $this->firstMonthDay = $this->getFirstMonthDay($date, "j");
        $this->lastMonthDay = $this->getLastMonthDay($date, "j");
        $this->subDate = $subDate = new Carbon('last sunday of last month');

        $this->subDay = $subDay = $subDate->day;
        $this->subLastDay= $subLastDay = $subDate->lastOfMonth()->day;
        //Getting year and substract one month
        $this->subMonth = $date->subMonth()->month;
        $this->subYear = $date->year;
      
        // Geting year and add plus 2 months because of previous substraction so needs reset;
        $this->nextMonth = $date->addMonth(2)->month;
        $this->nextYear = $date->year;

        // Set date to current
        $date->subMonth(1);
        $this->date = $date->firstOfMonth();
    }

    public function refresh2($uid){
        $this->userLoggedId = $uid;
        $this->date =  $this->getCurrentDate();
        $this->monthName = $this->getMonthName($this->date, "F");
        $this->currentYear = $this->date->year;
        $this->currentMonth = $this->date->month;
        $this->monthLength = $this->date->daysInMonth;
        $this->firstMonthDay = $this->getFirstMonthDay($this->date, "j");
        $this->lastMonthDay = $this->getLastMonthDay($this->date, "j");
        //Reset calendar
        $this->date->firstOfMonth();
        if($this->currentMonth == 1)
        {
            $this->subYear = $this->date->subYear()->year;
        }
        else
        {
            $this->subYear = $this->date->year;
        }
        
        $this->subDate = $subDate = new Carbon("last sunday of ".$this->subYear." ".$this->date->subMonth()->format("F"));
        $this->subDay = $subDay = $subDate->day;

        $this->subLastDay = $subDate->lastOfMonth()->day;
    //    dd($this->subDate);

        $this->subMonth = $this->subDate->month;
    
        $this->subDate->firstOfMonth();
        //Getting year and substract one month

        // Geting year and add plus 2 months because of previous substraction so needs reset;
        $this->nextMonth = $this->date->addMonth(2)->month;
        $this->nextYear = $this->date->year;
      
        // Set date to current
        $this->date->subMonth(1);
        $this->date = $this->date->firstOfMonth();
        
    }

    private function createPersonalCalendar($date, $fday, $lday, $monthHolidays){
        $weekBreak = 0;
        $week = 0;
        $weekArr = array();
        $calendar = array();

        

        for($day = $this->subDay; $day < $this->subLastDay+1; $day++){
           // $calendar[$week][$day]['day']['number'] = $day;
            $calendar = $this->setDay($calendar, $week, $day);
        
            $calendar = $this->setDayColor($calendar, $week, $day, "gray");
            $weekBreak++;
         //   echo $weekBreak;
        }

        for($day = $fday; $day < $lday+1; $day++)
        {
            $date2 = Carbon::parse($this->currentYear.'-'.$this->currentMonth.'-'.$day);
           
            if($weekBreak%7 == 0)
            {
                $week++;
            }
   
            $calendar = $this->setDay($calendar, $week, $day);
            
            $weekArr[$day] = array();
 
            $weekArr[$day] = [
                'week' => $week,
                'day' => $day
            ];

        
            if($date2->isWeekend())
            {
              // echo  $day;
                $calendar = $this->setDayWeekend($calendar, $week, $day, "Weekend");
                $calendar = $this->setDayColor($calendar, $week, $day, 'purple');
            }
            else 
            {
                $calendar = $this->setDayColor($calendar, $week, $day, 'white');
            }

            if(!empty($monthHolidays[$day]))
            {
                $calendar = $this->setDayWeekend($calendar, $week, $day, $monthHolidays[$day]['event']);
                $calendar = $this->setDayEvent($calendar, $week, $day, $monthHolidays[$day]['event']);
                $calendar = $this->setDayColor($calendar, $week, $day, 'pink');
            }
            $date->addDay();
            $weekBreak++;
        }
  
        $this->weekArr = $weekArr;
        return $this->calendarFillWithUserAbsence($calendar, $this->currentYear, $this->currentMonth);
    }

    private function calendarFillWithUserAbsence($calendar, $year, $month){
        $absences = absences::with('reason')
            ->where('user_id', $this->userLoggedId)
            ->whereYear('datefrom', $this->currentYear)
            ->whereMonth('datefrom', $this->currentMonth)
            ->get();

        foreach($absences as $absence)
        {
            $since = Carbon::parse($absence->datefrom)->day;
            $to = Carbon::parse($absence->dateto)->day;

            for($day = $since; $day < $to+1; $day++)
            {
                $week = $this->weekArr[$day]['week'];

                if(empty($calendar[$week][$day]['day']['weekend']) && empty($calendar[$week][$day]['day']['event']))
                switch($absence->reason['reason_name'])
                {
                    case "Vacation":
                        $calendar = $this->setDayComment($calendar, $week, $day, $absence->description);
                        $calendar = $this->setDayReason($calendar, $week, $day, $absence->reason['reason_name']);
                        $calendar = $this->setDayColor($calendar, $week, $day, "red");
                    break;
                    case "Business Trip":
                        $calendar = $this->setDayComment($calendar, $week, $day, $absence->description);
                        $calendar = $this->setDayReason($calendar, $week, $day, $absence->reason['reason_name']);
                        $calendar = $this->setDayColor($calendar, $week, $day, "blue");
                    break;
                }
   
                $calendar = $this->setDayConfirm($calendar, $week, $day, $absence->confirmed);
            }
            
        }

        $this->calendar = $calendar;
        return $calendar;
    }

    public function buildCalendar(){
        $monthHolidays = $this->holidaysArray(Carbon::getYearHolidays($this->currentYear), $this->currentMonth);
        $this->calendar = $this->createPersonalCalendar($this->date, $this->firstMonthDay, $this->lastMonthDay, $monthHolidays);
    }

    private function setDay($array, $week, $day){
        $array[$week][$day]['day']['number'] = $day;
        return $array;
    }

    private function setDayEvent($array, $week, $day, $event){
        $array[$week][$day]['day']['event'] = $event;
        return $array;
    }

    private function setDayWeekend($array, $week, $day, $weekend){
        $array[$week][$day]['day']['weekend'] = $weekend;
        return $array;
    }
    
    private function setDayColor($array, $week, $day, $color){
        $array[$week][$day]['day']['color'] = $color;
        return $array;
    }

    private function setDayComment($array, $week, $day, $comment){
        $array[$week][$day]['day']['comment'] = $comment;
        return $array;
    }

    private function setDayReason($array, $week, $day, $reason){
        $array[$week][$day]['day']['reason'] = $reason;
        return $array;
    }

    private function setDayConfirm($array, $week, $day, $confirm){
        $array[$week][$day]['day']['confirmed'] = $confirm;
        return $array;
    }

}





?>