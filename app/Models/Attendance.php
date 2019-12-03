<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    const START_TIME = '10:00';
    
    public $timestamps = false;
    
    /**
     * boolean 型へ変換
     *
     * @var array
     */
    protected $casts = [
        'is_absent' => 'boolean',
        'is_request' => 'boolean',
    ];

    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'request_content',
        'is_absent',
        'absent_reason',
        'date',
        'is_request',
    ];
    
    protected $dates = [
        'start_time',
        'end_time',
        'date',
        'deleted_at',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * ガード節
     * 勤怠を個別で時間の差分の取得
     *
     * @return int
     */
    public function calcLearningTime()
    {
        if (is_null($this->start_time)) {
            return 0;
        }
        if (is_null($this->end_time)) {
            return 0;
        }
         //  計算
        return $this->start_time->diffInMinutes($this->end_time);
    }
    
    /**
     * 遅刻の判定
     *
     * @return bool
     */
    public function isLate()
    {
        if (is_null($this->start_time)) {
            return false;
        }
        
        return $this->start_time->format('H:i') > self::START_TIME;
    }
    
    /**
     * 欠席の判定
     *
     * @return mixed
     */
    public function isAbsent()
    {
        return $this->is_absent;
    }
}
