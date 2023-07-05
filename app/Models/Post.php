<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['total_visits', 'this_week_visits', 'this_month_visits'];

    protected $fillable = ['title', 'text', 'user_id', 'image_id'];
    public function getTotalVisitsAttribute()
    {
        return visits($this)->count();
    }

    public function getThisWeekVisitsAttribute()
    {
        return visits($this)->period('week')->count();
    }

    public function getThisMonthVisitsAttribute()
    {
        return visits($this)->period('month')->count();
    }


    public function author(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function image(){
        return $this->belongsTo(Image::class, 'image_id', 'id');
    }
    public function tags(){
        return $this->belongsToMany(Tag::class, 'post_tags');
    }
    public function categories(){
            return $this->belongsToMany(Category::class, 'post_categories');
    }
    public function ratings(){
        return $this->hasMany(PostRating::class,);
    }

    /**
     * Get the instance of the user visits
     *
     * @return \Awssat\Visits\Visits
     */
    public function visitsCounter()
    {
        return visits($this);
    }

    /**
     * Get the visits relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function visits()
    {
        return visits($this)->relation();
    }
}
