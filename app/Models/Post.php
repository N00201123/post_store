<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'author', 'date', 'likes', 'platform_id'];

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public function tags() 
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
}


