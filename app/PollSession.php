<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PollSession extends Model
{
    public function poll_response(): hasMany
    {
        return $this->hasMany('App\PollResponse');
    }

    public function poll(): BelongsTo
    {
        return $this->belongsTo('App\Poll');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }
}