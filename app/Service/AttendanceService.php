<?php
namespace App\Service;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    private $attendance;
    
    /**
     * コンストラクター
     *
     * Attendance $attendance
     * @param Attendance $attendance
     */
    public function __construct(Attendance $attendance)
    {
        $this->attendance = $attendance;
    }
    
    /**
     * 現在時間の取得
     *
     * @return string
     */
    public function getNowDate()
    {
        return Carbon::now()->format('Y-m-d');
    }
    
    /**
     * ログイン中のユーザーの今日の勤怠管理を取得
     *
     * @param $d
     * @param $userId
     * @return mixed
     */
    public function getByTodayAttendance($userId)
    {
        $d = $this->getNowDate();
        return $this->attendance->where('date', $d)->where('user_id', $userId)->first();
    }
    
    /**
     * ログイン中のユーザーの勤怠管理の取得
     *
     * @param $userId
     * @return mixed
     */
    public function getByUserId($userId)
    {
        return $this->attendance->where('user_id', $userId)
                                ->orderBy('date','desc')
                                ->get();
    }
    
    /**
     * 日時を指定しての勤怠管理の取得
     *
     * @param $attributes
     * @return mixed
     */
    public function getAttendanceBySearchDate($attributes)
    {
        return $this->attendance->where('user_id', Auth::id())
                                ->where('date', $attributes['searchDate'])
                                ->first();
    }
    
    /**
     *学習時間の合計を取得
     *
     * @param $userId
     * @return float
     */
    public function getTotalLearningTime($userId)
    {
        $attendancesTime = $this->attendance
                                ->where('user_id', $userId)
                                ->whereNotNull('start_time')
                                ->whereNotNull('end_time')
                                ->get();
        $totalLearningTime = 0;
        foreach ($attendancesTime as $attendance) {
            $diffTime = $attendance->start_time->diffInMinutes($attendance->end_time);
            $totalLearningTime += $diffTime;
        };
        return $totalLearningTime = round($totalLearningTime / 60);
    }
    
    /**
     * 出勤日数の取得
     *
     * @param $userId
     * @return mixed
     */
    public function getAttendancesCount($userId)
    {
        return $this->attendance
                    ->where('user_id', $userId)
                    ->where('absent_flg', 0)
                    ->get()
                    ->count();
    }
}
