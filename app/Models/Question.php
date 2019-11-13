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
    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function tagCategory()
    {
        return $this->belongsTo(TagCategory::class);
    }
    
    public function scopeWhereUserId($query, $attributes)
    {
        return isset($attributes['user_id']) ?
            $query->where('user_id', $attributes['user_id']) : $query;
    }

    public function scopeWhereCategory($query, $attributes)
    {
        return !empty($attributes['tag_category_id']) ?
            $query->where('tag_category_id', $attributes['tag_category_id']) : $query;
    }

    public function scopeWhereSearchWord($query, $attributes)
    {
        return isset($attributes['search_word']) ?
            $query->where('title', 'LIKE', "%{$attributes['search_word']}%") : $query;
    }

    public function getQuestion($attributes)
    {
        return $this->whereCategory($attributes)
                    ->whereSearchWord($attributes)
                    ->whereUserId($attributes)
                    ->with(['user', 'tagCategory', 'comments'])
                    ->orderBy('created_at','desc')
                    ->paginate(20);
    }
}
