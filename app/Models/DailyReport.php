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
    
    public function scopeWhereMonth($query, $searchMonth)
    {
        return $query->where('reporting_time', 'LIKE', $searchMonth.'%');
    }
    
    public function getAllReport($searchMonth, $id)
    {
        return $this->where('user_id', $id)
                    ->whereMonth($searchMonth)
                    ->orderBy('reporting_time', 'desc')
                    ->get();
    }
    
//    public function getAllReport($searchMonth, $id)
//    {
//        return $this->where('user_id', $id)
//                    ->when($searchMonth, function ($query, $searchMonth) {
//                        return $query->where('reporting_time', 'LIKE', $searchMonth. '%');
//                    })
//                    ->orderBy('reporting_time', 'desc')
//                    ->get();
//    }
}
