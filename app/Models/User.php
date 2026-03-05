<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Important
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    protected $fillable = [
        'email',
        'password',
        // other fields
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    function news()
    {
        return $this->hasMany(News::class);
    }
}
