<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['text', 'post_id', 'user_id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function ratings(){
        return $this->hasMany(CommentRating::class, 'comment_id', 'id');
    }
}
