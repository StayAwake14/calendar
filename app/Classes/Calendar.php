<?php

namespace  App\Classes;

use Illuminate\Support\Facades\DB;

use Cmixin\BusinessDay;
Use \Carbon\Carbon;

use App\Models\absences;
use App\Models\users;
use App\Models\reasons;

class Calendar{

    public $region; // settings
    public $date, $monthName, $currentYear, $currentMonth, $monthLength, $firstMonthDay, $lastMonthDay, $subMonth, $nextMonth, $subYear, $nextYear; // details
    public $base, $calendar; // details arrays

    public function __construct($region){

        //All default config
        BusinessDay::enable('Carbon\Carbon');
        Carbon::setHolidaysRegion($region);
        $holidays = Carbon::getHolidays();
        $this->region = $region;
        $this->date = $date = Carbon::now();
        $this->region = $region;
        $this->monthName = $this->getMonthName($date, "F");
        $this->currentYear = $date->year;
        $this->currentMonth = $date->month;
        $this->monthLength = $date->daysInMonth;
        $this->firstMonthDay = $this->getFirstMonthDay($date, "j");
        $this->lastMonthDay = $this->getLastMonthDay($date, "j");

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

    public function buildCalendar(){
        $monthHolidays = $this->holidaysArray(Carbon::getYearHolidays($this->currentYear), $this->currentMonth);
        $this->base = $this->baseCalendarArray($this->date, $this->firstMonthDay, $this->lastMonthDay, $monthHolidays);
        $this->calendar = $matrix = $this->createUsersCalendar($this->base, $this->currentYear, $this->currentMonth, $this->monthLength);
    }

    public function refresh(){
        $this->date = $this->getCurrentDate();
        $this->monthName = $this->getMonthName($this->date, "F");
        
        $this->currentYear = $this->date->year;
        $this->currentMonth = $this->date->month;
      
        $this->monthLength = $this->date->daysInMonth;
        $this->firstMonthDay = $this->getFirstMonthDay($this->date, "j");
        $this->lastMonthDay = $this->getLastMonthDay($this->date, "j");

        // Reset to first month cause of substraction issue
        $this->date->firstOfMonth();
        //Getting year and substract one month
        $this->subMonth = $this->date->subMonth(1)->month;
        $this->subYear = $this->date->year;
       
        // Geting year and add plus 2 months because of previous substraction so needs reset;
        $this->nextMonth = $this->date->addMonth(2)->month;
        $this->nextYear = $this->date->year;
                
        // Set date to current
        $this->date->subMonth(1);
        $this->date->firstOfMonth();
    }

    // Assign all primary holidays in current month's year to array
    // Carbon::getYearHolidays($year)
    protected function holidaysArray($holidaysYearArray, $month){
        $monthHolidays = array();
        foreach ($holidaysYearArray as $holiday) {
            if($holiday->month == $month)
            {
                $holidayDay = $holiday->day;
                $monthHolidays[$holidayDay] = 
                [
                    'month'=> $month,
                    'day'=> $holidayDay,
                    'event'=> $holiday->getHolidayName()
                ];
            }
        }

        return $monthHolidays;
    }

    // Assign all informations to array for specified month that will be displaying
    private function baseCalendarArray($date, $fday, $lday, $monthHolidays){
        $calendar = array();
        for($day = $fday; $day < $lday+1; $day++)
        {

            $calendar = $this->setDay($calendar, $day);
            $calendar = $this->setDayName($calendar, $day, $this->date, "D");

            if(!empty($event[$day]))
                $calendar = $this->setDayEvent($calendar, $day, $event[$day]);
            

            if($date->isWeekend())
            {
                $calendar = $this->setDayWeekend($calendar, $day, "Weekend");
                $calendar = $this->setDayColor($calendar, $day, 'purple');
            }
            else 
            {
                $calendar = $this->setDayColor($calendar, $day, 'white');
            }

            if(!empty($monthHolidays[$day]))
            {
                $calendar = $this->setDayEvent($calendar, $day, $monthHolidays[$day]['event']);
                $calendar = $this->setDayColor($calendar, $day, 'pink');
            }
            
            $date->addDay();
        }

        return $calendar;
    }

    private function createUsersCalendar($baseCalendar, $year, $month, $monthLength){
        $calendar = array();
        $users = users::all()->toArray();

        foreach($users as $user){
            $uid = $user['id'];
            for($day = 1; $day < $monthLength+1; $day++)
            {
                $calendar = $this->setUserDayBackgroundColor($calendar, $uid, $day, "white");
                
                if(array_key_exists('weekend', $baseCalendar[$day]['day']))
                {
                    $calendar = $this->setUserDayReason($calendar, $uid, $day, "Weekend");
                    $calendar = $this->setUserDayBackgroundColor($calendar, $uid, $day, "purple");
                }
               
                if(array_key_exists('event', $baseCalendar[$day]['day']))
                {
                    $calendar = $this->setUserDayEvent($calendar, $uid, $day, $baseCalendar[$day]['day']['event']);
                    $calendar = $this->setUserDayReason($calendar, $uid, $day, 'Event');
                    $calendar = $this->setUserDayBackgroundColor($calendar, $uid, $day, 'pink');
                }
            }
            
        }

        return $this->calendarFillWithUsersAbsence($calendar, $year, $month, $users);
    }

    private function calendarFillWithUsersAbsence($calendar, $year, $month, $users){
        foreach($users as $user)
        {
            $uid = $user['id'];
            $absences = DB::table('absences')
            ->where('user_id', $user['id'])
            ->where('datefrom', 'like', "$year-0$month%")
            ->get();

            $calendar = $this->setUserId($calendar, $uid);
            $calendar = $this->setUserFirstName($calendar, $uid, $user['fname']);
            $calendar = $this->setUserLastName($calendar, $uid, $user['lname']);

            foreach($absences as $absence)
            {
                $reasons = reasons::all()
                ->where('id', $absence->reason_id)
                ->toArray();

                $dayFrom = Carbon::parse($absence->datefrom)->day;
                $dayTo = Carbon::parse($absence->dateto)->day;
        
                for($day = $dayFrom; $day < $dayTo+1; $day++)
                {
                   
                    foreach($reasons as $reason)
                    {
                        if(empty($calendar[$uid]['calendar'][$day]['reason']))
                        switch($reason['reason_name'])
                        {
                            case "Vacation":
                                $calendar = $this->setUserDayReason($calendar, $uid, $day, $reason['reason_name']);
                                $calendar = $this->setUserDayBackgroundColor($calendar, $uid, $day, 'red');
                                break;
                             case "Business Trip":
                                $calendar = $this->setUserDayReason($calendar, $uid, $day, $reason['reason_name']);
                                $calendar = $this->setUserDayBackgroundColor($calendar, $uid, $day, 'blue');                                break;
                            default:
                                $calendar = $this->setUserDayReason($calendar, $uid, $day, $reason['reason_name']);
                        }
                        
                    }
                    
                    $calendar = $this->setUserDayComment($calendar, $uid, $day, $absence->description);
                    $calendar = $this->setUserDayConfirmed($calendar, $uid, $day, $absence->confirmed);
                }
               
            }
        }

        return $calendar;
    }

    private function setDayName($array, $day, $date, $format){
        $array[$day]['day']['name'] = $date->format($format);
        return $array;
    }


    private function setDay($array, $day){
        $array[$day]['day']['number'] = $day;
        return $array;
    }

    private function setDayEvent($array, $day, $event){
        $array[$day]['day']['event'] = $event;
        return $array;
    }

    private function setDayWeekend($array, $day, $weekend){
        $array[$day]['day']['weekend'] = $weekend;
        return $array;
    }
    
    private function setDayColor($array, $day, $color){
        $array[$day]['day']['color'] = $color;
        return $array;
    }

    private function setUserDayComment($array, $uid, $day, $comment){
        $array[$uid]['calendar'][$day]['comment'] = $comment;
        return $array;
    }

    private function setUserDayEvent($array, $uid, $day, $event){
        $array[$uid]['calendar'][$day]['event'] = $event;
        return $array;
    }

    private function setUserDayReason($array, $uid, $day, $reason){
        $array[$uid]['calendar'][$day]['reason'] = $reason;
        return $array;
    }

    private function setUserDayBackgroundColor($array, $uid, $day, $bgcolor){
        $array[$uid]['calendar'][$day]['bgcolor'] = $bgcolor;
        return $array;
    }

    private function setUserDayConfirmed($array, $uid, $day, $confirm){
        $array[$uid]['calendar'][$day]['confirmed'] = $confirm;
        return $array;
    }

    private function setUserId($array, $uid){
        $array[$uid]['details']['id'] = $uid;
        return $array;
    }

    private function setUserFirstName($array, $uid, $name){
        $array[$uid]['details']['fname'] = $name;
        return $array;
    }

    private function setUserLastName($array, $uid, $name){
        $array[$uid]['details']['lname'] = $name;
        return $array;
    }

    public function getMonthName($date, $format){
        return $date->format($format);
    }

    public function getFirstMonthDay($date, $format){
        return $date->firstOfMonth()->format($format);
    }

    public function getLastMonthDay($date, $format){
        return $date->lastOfMonth()->format($format);
    }

    public function getCurrentMonthLength(){
        return $this->monthLength;
    }

    public function getCurrentMonthName(){
        return $this->monthName;
    }

    public function getCurrentMonthNumber(){
        return $this->currentMonth;
    }

    public function getCurrentYear(){
        return $this->currentYear;
    }

    public function getCurrentSubMonth(){
        return $this->subMonth;
    }

    public function getCurrentNextMonth(){
        return $this->nextMonth;
    }

    public function getCurrentSubYear(){
        return $this->subYear;
    }

    public function getCurrentNextYear(){
        return $this->nextYear;
    }

    public function getBaseCalendar(){
        return $this->base;
    }

    public function getFullCalendar(){
        return $this->calendar;
    }

    public function getCurrentDate(){
        return $this->date;
    }

    public function setDate($date, $year, $month){
        $this->date = $date::parse($year.'-'.$month);
    }
}
?>