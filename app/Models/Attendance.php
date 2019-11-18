<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'request_content',
        'absent_flg',
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
        $this->belongsTo(User::class);
    }
}
