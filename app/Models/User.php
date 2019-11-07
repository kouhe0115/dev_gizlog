<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Attendance;
use App\Models\DailyReport;
use App\Models\Question;
use DB;
use Carbon;
use PhpParser\Comment;

class User extends Authenticatable
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slack_user_id',
        'email',
        'avatar',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = [
        'remember_token',
    ];
    
    public function dailyReport()
    {
        return $this->hasMany(DailyReport::class, 'user_id');
    }
    
    public function question()
    {
        return $this->hasMany(Question::class);
    }
    
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function attendance()
    {
        return $this->hasOne(Attendance::class, 'user_id')->where('date', Carbon::today()->format('Y-m-d'));
    }

    public function allAttendance()
    {
        return $this->hasMany(Attendance::class, 'user_id')->orderBy('date', 'desc');
    }

    public function createUserInstance($slackId)
    {
        return $this->withTrashed()->whereNotNull('id')->firstOrNew(['slack_user_id' => $slackId]);
    }

    public function getSlackUsers($userInfoId)
    {
        return $this->firstOrNew(['user_info_id' => $userInfoId]);
    }

    public function saveUserInfos($users, $slackUserInfos)
    {
        $users->fill([
            'name'          => $slackUserInfos->name,
            'slack_user_id' => $slackUserInfos->id,
            'email'         => $slackUserInfos->email,
            'avatar'        => $slackUserInfos->avatar,
        ])->save();
    }

    public function restoreDeletedUser($userInfoId)
    {
        DB::transaction(function() use($userInfoId) {
            $this->withTrashed()->where('user_info_id', $userInfoId)->update(['deleted_at' => null]);
        });
    }
}

