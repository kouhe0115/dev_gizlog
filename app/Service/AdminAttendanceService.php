<?php

namespace App\Service;

use App\Models\Attendance;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;

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
    
    /**
     * ユーザー情報の取得
     *
     * @return User[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function fetchUserInfo()
    {
        return $this->user->with('attendance')->get();
    }
    
    /**
     * 出勤退勤時間の登録
     *
     * @param $id
     * @param $strTime
     * @return mixed
     */
    public function attendanceUpdateByUserId($id, $strTime)
    {
        $attribute['start_time'] = $this->convertTime($strTime['start_time']);
        $attribute['end_time'] = $this->convertTime($strTime['end_time']);
        $this->attendance->find($id)->update($attribute);
    }
    
    /**
     * 文字列を日付にキャスト
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
    
    public function attendanceUpdateIsDelete($id)
    {
         $this->attendance->find($id)->update([
            'is_absent' => true
        ]);
    }
}
