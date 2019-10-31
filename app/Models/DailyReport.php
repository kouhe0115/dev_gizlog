<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyReport extends Model
{
    use SoftDeletes;
    
    protected  $dates = ['deleted_at', 'reporting_time'];
    
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'reporting_time',
    ];
    
    public function getByUserId($id)
    {
        return $this->where('user_id', $id)->orderBy('reporting_time', 'desc')->get();
    }
    
    public function getByMonthReports($searchMonth, $id)
    {
        return $this->where('user_id', $id)->where('reporting_time', 'like', '%' . $searchMonth. '%')->orderBy('reporting_time', 'desc')->get();
    }
}
