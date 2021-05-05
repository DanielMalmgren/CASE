<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PollQuestion extends Model
{
    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['text', 'alternatives'];

    public function poll(): BelongsTo
    {
        return $this->belongsTo('App\Poll');
    }

    public function poll_responses(): hasMany
    {
        return $this->hasMany('App\PollResponse');
    }

    public function translation()
    {
        $translation = $this->translate(\App::getLocale());
        if(isset($translation)) {
            return $translation;
        } else {
            return $this->translate($this->poll->default_locale->id);
        }
    }

    public function next_question()
    {
        return $this->poll->next_question($this);
    }

    public function first_on_previous_page()
    {
        if($this->order == 1) {
            return null;
        }
        $previous_page_break = $this->poll->poll_questions->where('type', 'pagebreak')->where('order', '<', $this->order-1)->sortBy('order')->last();
        if(isset($previous_page_break)) {
            return $this->poll->poll_questions->where('order', $previous_page_break->order+1)->first();
        } else {
            return $this->poll->poll_questions->where('order', 1)->first();
        }
    }

    public function getAlternativesArrayAttribute()
    {
        return explode(';', $this->translation()->alternatives);
    }

    public function setAlternativesArrayAttribute($value)
    {
        if(!isset($value)) {
            return;
        }
        $imploded = implode(';', $value);
        if(isset($imploded)) {
            $this->translateOrNew(\App::getLocale())->alternatives = $imploded;
        }
    }
}

class PollQuestionTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['text', 'alternatives'];
}
