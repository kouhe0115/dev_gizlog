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
//      $thisはtodoインスタンスを指す
//      todoインスタンスに対して、whereで各レコードのuser_idと引数のログイン中のユーザーのIDとの検索をかけ、一致してものを取得
//      戻り値はコレクションオブジェクト、コレクションオブジェクトの中のitemsのオブジェクトの中の連想配列に各レコードの情報が格納されている
        return $this->where('user_id', $id)->orderBy('reporting_time', 'desc')->get();
    }
}
