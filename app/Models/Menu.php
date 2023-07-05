<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['order', 'route', 'menu_party_id'];

    public function parties(){
        return $this->hasOne(MenuParty::class, 'id', 'menu_party_id');
    }
}
