<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['text'];

    public function lesson()
    {
        return $this->belongsTo('App\Lesson');
    }

    public function testresponses()
    {
        return $this->hasMany('App\TestResponse');
    }

    public function response_options()
    {
        return $this->hasMany('App\ResponseOption');
    }

    public function translation()
    {
        $translation = $this->translate(\App::getLocale());
        if(isset($translation)) {
            return $translation;
        } else {
            return $this->translate($this->lesson->track->default_locale->id);
        }
    }
}

class QuestionTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['text'];
}
