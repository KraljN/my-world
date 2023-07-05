<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $timestamps = false;
    protected $fillable = ['src', 'alt'];

    public function users(){
        return $this->hasMany(User::class, 'image_id', 'id');
    }

    public function posts(){
        return $this->hasMany(Post::class, 'image_id', 'id');
    }
}
