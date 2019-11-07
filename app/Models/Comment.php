<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}

