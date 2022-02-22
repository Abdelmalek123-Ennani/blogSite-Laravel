<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
       "user_id" , "post_id" , "description" , "parent_id"
    ];


    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function replies() {
        return $this->hasMany('App\Models\Comment' , 'parent_id');
    }
}
