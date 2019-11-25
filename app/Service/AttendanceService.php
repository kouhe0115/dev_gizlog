<?php

namespace App\Service;

use App\Models\Attendance;
use Carbon\Carbon;

const MINUTES_TO_HOURS = 60;
const DAILY_FORMAT = 'Y-m-d';

/**
 * 勤怠に関するメソッド
 *
 * Class AttendanceService
 * @package App\Service
 */
class AttendanceService
{
    /**
     * Attendanceインスタンス
     *
     * @var Attendance
     */
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
     * ログイン中のユーザーの今日の勤怠管理を取得
     *
     * @param $userId
     * @return mixed
     */
    public function getTodayAttendance($userId)
    {
        $d = Carbon::now()->format(DAILY_FORMAT);
        return $this->attendance->where('date', $d)->where('user_id', $userId)->first();
    }
    
    /**
     * ログイン中のユーザーの今日の勤怠の状態を取得
     *
     * @param $attendance
     * @return string
     */
    public function attendanceStatus($attendance)
    {
        if (isset($attendance->absent_flg) && $attendance->absent_flg === 1) {
            return $status = 'absent';
        }
        
        if (empty($attendance->start_time) && empty($attendance->end_time)) {
            return $status = 'setStartTime';
        }
        
        if (!empty($attendance->start_time) && !empty($attendance->end_time)) {
            return $status = 'leaving';
        }
        
        if (!empty($attendance->start_time) && empty($attendance->end_time)) {
            return $status = 'setEndTime';
        }
    }

    /**
     * ログイン中のユーザーの勤怠管理の取得
     *
     * @param $userId
     * @return mixed
     */
    public function fetchByUserId($userId)
    {
        return $this->attendance->where('user_id', $userId)
                                ->orderBy('date','desc')
                                ->get();
    }

    /**
     * 出勤時間の登録
     *
     * @param $attributes
     */
    public function registerStartTime($attributes)
    {
        $attributes['date'] = Carbon::now()->format(DAILY_FORMAT);
        $this->attendance->create(
            [
                'start_time' => $attributes['start_time'],
                'date' => $attributes['date'],
                'user_id' => $attributes['user_id'],
            ]
        );
    }

    /**
     * 退勤時間の登録
     *
     * @param $attributes
     * @param $id
     */
    public function registerEndTime($attributes, $id)
    {
        $this->attendance->find($id)->update(
            [
                'end_time' => $attributes['end_time'],
            ]
        );
    }

    /**
     * 欠席、理由の登録
     *
     * @param $attributes
     */
    public function registerAbsence($attributes)
    {
        $this->attendance->updateOrCreate(
            [
                'user_id' => $attributes['user_id'],
                'date' => Carbon::now()->format(DAILY_FORMAT)
            ], $attributes
        );
    }
    
    /**
     * 修正申請を登録
     *
     * @param $attributes
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function registerRequest($attributes)
    {
         $this->attendance->where('user_id', $attributes['user_id'])
                          ->where('date', $attributes['searchDate'])
                          ->firstOrFail()
                          ->first()
                          ->update(
                         [
                             'request_content' => $attributes['request_content']
                         ]);
    }
    
    /**
     * 学習時間の合計を取得
     *
     * @param $attendances
     * @return float
     */
    public function fetchTotalLearningTime($attendances)
    {
        $attendancesTime = $attendances->filter(
            function ($v) {
                return ($v['start_time'] !== NULL && $v['end_time'] !== NULL);
            }
        );

        $totalLearningTime = 0;
        foreach ($attendancesTime as $attendance) {
            $diffTime = $attendance->start_time->diffInMinutes($attendance->end_time);
            $totalLearningTime += $diffTime;
        };
        return $totalLearningTime = round($totalLearningTime / MINUTES_TO_HOURS);
    }
    
    /**
     * 出勤日数の取得
     *
     * @param $attendances
     * @return mixed
     */
    public function fetchAttendancesCount($attendances)
    {
        return $attendances->where('absent_flg', 0)
                            ->count();
    }
}
