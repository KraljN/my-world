<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessageReply extends Model
{
    use HasFactory;
    protected $fillable = ['text', 'contact_message_id', 'user_id'];

    public function user(){
       return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
