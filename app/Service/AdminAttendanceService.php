<?php

namespace App\Service;

use App\Models\Attendance;
use Carbon\Carbon;
use Auth;

/**
 * 勤怠に関するメソッド
 *
 * Class AttendanceService
 * @package App\Service
 */
class AdminAttendanceService
{
   private $attendance;
   
   public function __construct(Attendance $attendance)
   {
       $this->attendance = $attendance;
   }
   
   public function getAttendanceByToday()
   {
       return $attendances = $this->attendance->where('date', Carbon::today())->get();
   }
}
