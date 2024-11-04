<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ClientResetPasswordNotification;

class Applicant_info extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table='applicant_info';

    protected $fillable = [
        'names',
        'email',
        'password',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
  
    /**
    	* Send the password reset notification.
    	*
         * @param  string  $token
         * @return void
    */

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
  
    public function sendPasswordResetNotification($token)
    {
      $this->notify(new ClientResetPasswordNotification($token));
    }
}
