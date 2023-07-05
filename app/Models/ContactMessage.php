<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'email', 'name'];

    public function reply(){
        return $this->hasOne(ContactMessageReply::class, 'contact_message_id', 'id');
    }
}
