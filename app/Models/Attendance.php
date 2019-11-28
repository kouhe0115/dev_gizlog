<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    public $timestamps = false;
    
    /**
     * boolean 型へ変換
     *
     * @var array
     */
    protected $casts = [
        'is_absent' => 'boolean',
    ];

    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'request_content',
        'is_absent',
        'absent_reason',
        'date',
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
}
