<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\PollQuestion;

class Poll extends Model
{
    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['name', 'infotext'];

    public function poll_sessions(): HasMany
    {
        return $this->hasMany('App\PollSession');
    }

    public function poll_questions(): HasMany
    {
        return $this->hasMany('App\PollQuestion');
    }

    public function workplaces(): BelongsToMany
    {
        return $this->belongsToMany('App\Workplace', 'poll_workplace');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany('App\Lesson');
    }

    public function default_locale(): BelongsTo
    {
        return $this->belongsTo('App\Locale', 'default_locale_id');
    }

    public function current_locale_is_poll_default(): bool
    {
        return \App::isLocale($this->default_locale->id);
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

    //Return the first question in this poll
    public function first_question(): PollQuestion
    {
        return $this->poll_questions->sortBy('order')->first();
    }

    //Return the next question after a given question
    public function next_question(PollQuestion $question)
    {
        return $this->poll_questions->where('order', '>', $question->order)->sortBy('order')->first();
    }
}

class PollTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'infotext', 'infotext2'];
}
