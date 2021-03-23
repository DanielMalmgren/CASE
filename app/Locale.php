<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function tracks()
    {
        return $this->hasMany('App\Track', 'default_locale_id');
    }

    public function polls()
    {
        return $this->hasMany('App\Poll', 'default_locale_id');
    }

    public $incrementing = false;

    protected $keyType = 'string';
}
