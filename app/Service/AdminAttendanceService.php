<?php

namespace App\Service;

use App\Models\Attendance;
use App\Models\User;
use Auth;

const START_TIME = '10:00';
/**
 * 勤怠に関するメソッド
 *
 * Class AttendanceService
 * @package App\Service
 */
class AdminAttendanceService
{
    /**
     * @var Attendance
     */
    private $attendance;
    
    /**
     * @var User
     */
    private $user;
    
    public function __construct(Attendance $attendance, User $user)
    {
        $this->user = $user;
        $this->attendance = $attendance;
    }
    
    public function fetchUserInfo()
    {
        return $this->user->with('attendance')->get();
    }
    
    
    /**
     * 遅刻と欠席のカウント
     *
     * @param $userInfos
     * @return array
     */
    public function countLate($userInfos)
    {
        $absentCount = 0;
        $lateCount = 0;
        foreach ($userInfos->allattendance as $attendance) {
            if (!empty($attendance) && $attendance->start_time->format('H:i') > START_TIME) {
                $lateCount++;
            }
            
            if (!empty($attendance) && $attendance->absent_flg) {
                $absentCount++;
            }
        }
        return [
            'lateCount' => $lateCount,
            'absentCount' => $absentCount
        ];
    }
}
