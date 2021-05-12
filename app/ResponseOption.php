<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResponseOption extends Model
{
    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['text'];

    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    public function translation()
    {
        $translation = $this->translate(\App::getLocale());
        if(isset($translation)) {
            return $translation;
        } else {
            return $this->translate($this->question->lesson->track->default_locale->id);
        }
    }
}

class ResponseOptionTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['text'];
}
