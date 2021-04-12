<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
Use \Carbon\Carbon;

use App\Models\absences;
use App\Models\users;
use App\Models\reasons;

use Cmixin\BusinessDay;

use App\Classes\Calendar;


class CalendarController extends Controller
{

    public function index(){

        $setCalendar = new Calendar('pl');
        $monthLength = $setCalendar->getCurrentMonthLength();
        $monthName = $setCalendar->getCurrentMonthName();
        $month = $setCalendar->getCurrentMonthNumber();
        $year = $setCalendar->getCurrentYear();
        $subMonth = $setCalendar->getCurrentSubMonth();
        $nextMonth = $setCalendar->getCurrentNextMonth();
        $subYear = $setCalendar->getCurrentSubYear();
        $nextYear = $setCalendar->getCurrentNextYear();
        $setCalendar->buildCalendar();
        $base = $setCalendar->getBaseCalendar();
        $calendar = $setCalendar->getFullCalendar();
 
        return view('calendar', [
            'base' => $base,
            'calendar' => $calendar,
            'monthName' => $monthName,
            'month' => $month,
            'year' => $year,
            'subMonth' => $subMonth,
            'nextMonth' => $nextMonth,
            'subYear' => $subYear,
            'nextYear' => $nextYear
        ]);
    }

    public function switch($month, $year, Request $request){
        $setCalendar = new Calendar('pl');
        $setCalendar->setDate($setCalendar->date, $year, $month);
        $setCalendar->refresh();
        $monthLength = $setCalendar->getCurrentMonthLength();
        $monthName = $setCalendar->getCurrentMonthName();
        $month = $setCalendar->getCurrentMonthNumber();
        $year = $setCalendar->getCurrentYear();
        $subMonth = $setCalendar->getCurrentSubMonth();
        $nextMonth = $setCalendar->getCurrentNextMonth();
        $subYear = $setCalendar->getCurrentSubYear();
        $nextYear = $setCalendar->getCurrentNextYear();
        $setCalendar->buildCalendar();
        $base = $setCalendar->getBaseCalendar();
        $calendar = $setCalendar->getFullCalendar();

        return view('calendar', [
            'base' => $base,
            'calendar' => $calendar,
            'monthName' => $monthName,
            'month' => $month,
            'year' => $year,
            'subMonth' => $subMonth,
            'nextMonth' => $nextMonth,
            'subYear' => $subYear,
            'nextYear' => $nextYear
        ]);
    }
} 