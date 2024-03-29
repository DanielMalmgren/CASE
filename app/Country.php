<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Country extends Model
{
    use HasFactory;

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany('App\Lesson');
    }

    public function tracks(): BelongsToMany
    {
        return $this->belongsToMany('App\Track');
    }

}
