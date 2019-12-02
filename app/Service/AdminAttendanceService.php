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
     * ユーザー情報の取得
     *
     * @return User[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function fetchUserInfo()
    {
        return $this->user->with('attendance')->get();
    }
    
    public function fetchAttendance($userId, $date)
    {
        return $this->attendance->where('user_id', $userId)
            ->where('date', $date)
            ->first();
    }
    
    /**
     * 個別勤怠の登録
     *
     * @param $attributes
     * @return int
     */
    public function registerAttendance($attributes)
    {
        if ($this->attendance->where('user_id', $attributes['user_id'])->where('date', $attributes['date'])->first()) {
            return 0;
        }
        
        $attributes['start_time'] = $this->convertTime($attributes['start_time']);
        $attributes['end_time'] = $this->convertTime($attributes['end_time']);
        $this->attendance->create($attributes);
    }
    
    
    /**
     * 出勤退勤時間の更新
     *
     * @param $id
     * @param $attribute
     */
    public function attendanceUpdateByUserId($id, $attribute)
    {
        $date = $attribute['date'];
        $attribute['start_time'] = $this->convertTime($date. ' ' .$attribute['start_time']);
        $attribute['end_time'] = $this->convertTime($date. ' ' .$attribute['end_time']);
        $attribute['is_request'] = false;
        $this->attendance->find($id)->update($attribute);
    }
    
    /**
     * 文字列を日付にキャスト
     *
     * @param $attribute
     * @return Carbon
     */
    public function convertTime($attribute)
    {
        if (!empty($attribute)) {
            return new Carbon($attribute);
        }
        return $attribute;
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
            
            if (!empty($attendance) && $attendance->is_absent) {
                $absentCount++;
            }
        }
        return [
            'lateCount' => $lateCount,
            'absentCount' => $absentCount
        ];
    }
    
    /**
     * 個別勤怠の欠席の登録
     *
     * @param $id
     */
    public function attendanceUpdateIsDelete($id)
    {
        $this->attendance->find($id)->update([
            'is_absent' => true,
        ]);
    }
}
