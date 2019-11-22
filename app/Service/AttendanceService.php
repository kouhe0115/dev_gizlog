<?php

namespace App\Service;

use App\Models\Attendance;
use Carbon\Carbon;

const HOURS_TO_MINUTES = 60;

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
     * @param $userId
     * @return mixed
     */
    public function getTodayAttendance($userId)
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
     * 出勤時間の登録
     *
     * @param $attributes
     */
    public function registerStartTime($attributes)
    {
        $attributes['date'] = $this->getNowDate();
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
        $attributes['date'] = $this->getNowDate();
        $this->attendance->updateOrCreate(
            ['user_id' => $attributes['user_id'], 'date' => $attributes['date']], $attributes
        );
    }

    /**
     * 修正申請を登録
     *
     * @param $attributes
     */
    public function registerRequest($attributes)
    {
        $this->attendance->where('user_id', $attributes['user_id'])
                         ->where('date', $attributes['searchDate'])
                         ->first()->update(
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
    public function getTotalLearningTime($attendances)
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
        return $totalLearningTime = round($totalLearningTime / HOURS_TO_MINUTES);
    }
    
    /**
     * 出勤日数の取得
     *
     * @param $attendances
     * @return mixed
     */
    public function getAttendancesCount($attendances)
    {
        return $attendances->where('absent_flg', 0)
                            ->count();
    }
}
