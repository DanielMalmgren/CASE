<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Lesson;

class Track extends Model
{
    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    public $incrementing = false;

    public function workplaces(): BelongsToMany
    {
        return $this->belongsToMany('App\Workplace');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany('App\Lesson');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany('App\User');
    }

    public function countries()
    {
        return $this->belongsToMany('App\Country');
    }

    public function default_locale(): BelongsTo
    {
        return $this->belongsTo('App\Locale', 'default_locale_id');
    }

    public function current_locale_is_track_default(): bool
    {
        return \App::isLocale($this->default_locale->id);
    }

    public function color()
    {
        return $this->belongsTo('App\Color')->withDefault([
            'hex' => '#ffffff',
        ]);
    }

    public function first_lesson(): ?Lesson
    {
        return $this->lessons()->orderBy('order')->where('active', true)->first();
    }

    public function next_lesson(Lesson $last_lesson): ?Lesson
    {
        return $this->lessons()->orderBy('order')->where('active', true)->where('order', '>', $last_lesson->order)->first();
    }

    public function translation()
    {
        $translation = $this->translate(\App::getLocale());
        if(isset($translation)) {
            return $translation;
        } else {
            return $this->translate($this->default_locale->id);
        }
    }
}

class TrackTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
}
