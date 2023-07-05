<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuParty extends Model
{
    use HasFactory;

    public function category(){
        return $this->hasOne(Category::class);
    }
    public function menuItem(){
        return $this->hasOne(MenuItem::class);
    }
}
