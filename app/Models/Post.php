<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use HasFactory , Sluggable;

    protected $fillable = ['title', 'slug', 'description', 'img_path', 'user_id'];

    public function user() {
       return  $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->hasMany('App\Models\Comment')->whereNull('parent_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
            ];
    }

}