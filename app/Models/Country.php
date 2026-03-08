<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    function states()
    {
        return $this->hasMany(State::class);
    }

    function cities()
    {
        return $this->hasMany(City::class);
    }
}
