<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
