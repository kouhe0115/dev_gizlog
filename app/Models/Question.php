<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Comment;

class Question extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function comment()
    {
        return $this->hasMany(Comment::class, 'question_id');
    }
    
    public function category()
    {
        return $this->belongsTo(Question::class);
    }
    
}

