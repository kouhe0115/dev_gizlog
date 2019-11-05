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
        return $this->where('user_id', $id)
                    ->orderBy('reporting_time', 'desc');
    }
    
    public function getReportByMonth($searchMonth, $id)
    {
        if (is_null($searchMonth)) {
            return $this->getByUserId($id)->get();
        } else {
            return $this->getByUserId($id)
                        ->where('reporting_time', 'LIKE', $searchMonth.'%')
                        ->get();
        }
    }
}
