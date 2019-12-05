<?php

namespace App\Service;

use App\Models\Attendance;
use Carbon\Carbon;

/**
 * 勤怠に関するメソッド
 *
 * Class AttendanceService
 * @package App\Service
 */
class AttendanceService
{
    
    /**
     * 分を時間に変換
     */
    const MINUTES_TO_HOURS = 60;
    
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
     * Attendanceインスタンス
     *
     * @var Attendance
     */
    private $attendance;
    
    /**
     * ログイン中のユーザーの今日の勤怠管理を取得
     *
     * @param $userId
     * @return mixed
     */
    public function getTodayAttendance($userId)
    {
        $d = Carbon::now()->format(config('const.DAILY_FORMAT'));
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
        if (!empty($attendance->is_absent)) {
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
            ->orderBy('date', 'desc')
            ->get();
    }
    
    /**
     * 出勤時間の登録
     *
     * @param $attributes
     */
    public function registerStartTime($attributes)
    {
        $attributes['date'] = Carbon::now()->format(config('const.DAILY_FORMAT'));
        $this->attendance->create($attributes);
    }
    
    /**
     * 退勤時間の登録
     *
     * @param $attributes
     * @param $id
     */
    public function registerEndTime($attributes, $id)
    {
        $this->attendance->find($id)->update($attributes);
    }
    
    /**
     * 欠席、理由の登録
     *
     * @param $attributes
     */
    public function registerAbsence($attributes)
    {
        $this->attendance->updateOrCreate([
                'user_id' => $attributes['user_id'],
                'date' => Carbon::now()->format(config('const.DAILY_FORMAT'))
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
            ->update($attributes);
    }
    
    /**
     * 学習時間の合計を取得
     *
     * @param $attendances
     * @return float
     */
    public function attendanceTotalLearningTime($attendances)
    {
        $totalLearningTime = 0;
        /** @var Attendance $attendance */
        foreach ($attendances as $attendance) {
            $totalLearningTime += $attendance->calcLearningTime();
        };
        return $totalLearningTime = round($totalLearningTime / self::MINUTES_TO_HOURS);
    }
    
    /**
     * 出勤日数の取得
     *
     * @param $attendances
     * @return mixed
     */
    public function attendancesCount($attendances)
    {
        return $attendances->where('is_absent', false)
            ->count();
    }
}
