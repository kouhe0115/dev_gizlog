<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyReport extends Model
{
    use SoftDeletes;
    
    protected  $dates = ['reporting_time', 'deleted_at'];
    
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'reporting_time',
    ];
    
    public function scopeWhereMonth($query, $searchMonth)
    {
        return $searchMonth ? $query->where('reporting_time', 'LIKE', $searchMonth.'%') : $query ;
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
