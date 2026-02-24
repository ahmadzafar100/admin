<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Important
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'email',
        'password',
        // other fields
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
