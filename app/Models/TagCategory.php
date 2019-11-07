<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagCategory extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];
    protected $table = 'tag_categories';
    protected $dates = ['deleted_at'];

    
    public function question()
    {
        return $this->hasMany(Question::class, 'category_id');
    }
}

