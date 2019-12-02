<?php

namespace App\Service;

use App\Models\Attendance;
use App\Models\User;
use Auth;
use Carbon\Carbon;

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
    
    /**
     * AdminAttendanceService constructor.
     * @param Attendance $attendance
     * @param User $user
     */
    public function __construct(Attendance $attendance, User $user)
    {
        $this->user = $user;
        $this->attendance = $attendance;
    }
    
    /**
     * 個別ユーザーの取得
     *
     * @param $userId
     * @return mixed
     */
    public function fetchUserInfo($userId)
    {
        return $this->user->find($userId);
    }
    
    /**
     * ユーザー情報の取得
     *
     * @return User[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function fetchAllUsersInfo()
    {
        return $this->user->with('attendance')->get();
    }
    
    /**
     * 個別勤怠の取得
     *
     * @param $userId
     * @param $date
     * @return mixed
     */
    public function fetchUserAttendanceByDate($userId, $date)
    {
        return $this->attendance->where('user_id', $userId)
            ->where('date', $date)
            ->first();
    }
    
    /**
     * 個別勤怠の登録
     *
     * @param $strTime
     * @param $userId
     * @return int
     */
    public function registerAttendance($attributes, $userId)
    {
        if ($this->attendance->where('user_id', $userId)->where('date', $attributes['date'])->first()) {
            return 0;
        }
        
        $attributes['user_id'] = $userId;
        $attributes['start_time'] = $this->convertTime($attributes['date'] . ' ' . $attributes['start_time']);
        $attributes['end_time'] = $this->convertTime($attributes['date'] . ' ' . $attributes['end_time']);
        $this->attendance->create($attributes);
    }
    
    
    /**
     * 個別勤怠時間の更新
     *
     * @param $id
     * @param $strTime
     */
    public function updateAttendance($id, $strTime)
    {
        $attributes['start_time'] = $this->convertTime($strTime['date'] . ' ' . $strTime['start_time']);
        $attributes['end_time'] = $this->convertTime($strTime['date'] . ' ' . $strTime['end_time']);
        $this->attendance->find($id)->update([
            'start_time' => $attributes['start_time'],
            'end_time' => $attributes['end_time'],
            'is_request' => false,
        ]);
    }
    
    /**
     * 個別勤怠の欠席の登録
     *
     * @param $id
     */
    public function registerAbsent($id)
    {
        $this->attendance->find($id)->update([
            'is_absent' => true,
        ]);
    }
    
    /**
     * 文字列を日付型にキャスト
     *
     * @param $strTime
     * @return Carbon
     */
    public function convertTime($strTime)
    {
        if (!empty($strTime)) {
            return new Carbon($strTime);
        }
        return $strTime;
    }
    
    /**
     * 遅刻と欠席のカウント
     *
     * @param $userInfos
     * @return array
     */
    public function countAbsentLate($userInfos)
    {
        $absentCount = 0;
        $lateCount = 0;
        
        foreach ($userInfos->allattendance as $attendance) {
            if (!empty($attendance) && $attendance->start_time->format('H:i') > START_TIME) {
                $lateCount++;
            }
            
            if (!empty($attendance) && $attendance->is_absent) {
                $absentCount++;
            }
        }
        return [
            'lateCount' => $lateCount,
            'absentCount' => $absentCount
        ];
    }
}
