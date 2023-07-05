<?php

namespace App\Models;

 use App\Mail\EmailChanged;
 use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Mail\AccountConfirmation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, softDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image_id',
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'activated'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasVerifiedEmail()
    {
        return $this->activated;
    }

    public function image(){
        return $this->belongsTo(Image::class, 'image_id', 'id');
    }

    public function posts(){
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function getKey(){
        return $this->id;
    }
    public function getEmailForVerification(){
        return 'email_hash';
    }

    public function markEmailAsVerified(){
        $this->activated = config("constants.user.activated");
        $this->save();
    }

    public function changeEmail($email){
        $this->email = $email;
        $this->save();
    }

    public function sendEmailChangeNotification($newEmail){
        Mail::to($newEmail)->send(new EmailChanged($this->first_name, $this->id, $newEmail));
    }

    public function sendEmailVerificationNotification(){
        Mail::to($this->email)->send(new AccountConfirmation($this->first_name, $this->id));
    }
}
