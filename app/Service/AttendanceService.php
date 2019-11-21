<?php
namespace App\Service;

use App\Models\Attendance;
use Carbon\Carbon;

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
    public function setStartTime($attributes)
    {
        $attributes['date'] = $this->getNowDate();
        $this->attendance->fill($attributes)->save();
    }

    /**
     * 退勤時間の登録
     *
     * @param $attributes
     * @param $id
     */
    public function setEndTime($attributes, $id)
    {
        $this->attendance->find($id)->fill($attributes)->save();
    }

    /**
     * 欠席、理由の登録
     *
     * @param $attributes
     */
    public function setAbsence($attributes)
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
    public function setRequest($attributes)
    {
        $this->attendance->where('user_id', $attributes['user_id'])
                         ->where('date', $attributes['searchDate'])
                         ->first()->fill($attributes)->save();
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
