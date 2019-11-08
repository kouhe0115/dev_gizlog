<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
      'user_id',
      'tag_category_id',
      'title',
      'content',
    ];
    
    protected $dates = [
        'deleted_at',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function tagCategory()
    {
        return $this->belongsTo(TagCategory::class);
    }
    
    public function scopeWhereUserId($query, $inputs)
    {
        return isset($inputs['user_id']) ?
            $query->where('user_id', $inputs['user_id']) : $query;
    }
    
    public function scopeWhereCategory($query, $inputs)
    {
        return !empty($inputs['tag_category_id']) ?
            $query->where('tag_category_id', $inputs['tag_category_id']) : $query;
    }
    
    public function scopeWhereSearchWord($query, $inputs)
    {
        return isset($inputs['search_word']) ?
            $query->where('title', 'LIKE', "%{$inputs['search_word']}%") : $query;
    }
    
    public function getQuestion($inputs)
    {
        return $this->whereCategory($inputs)
                    ->whereSearchWord($inputs)
                    ->whereUserId($inputs)
                    ->with(['user', 'tagCategory', 'comment'])
                    ->orderBy('created_at','desc')
                    ->paginate(20);
    }
}

