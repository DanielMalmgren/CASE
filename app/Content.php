<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Config;
use App\ContentSetting;

class Content extends Model
{
    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['text'];

    function __construct($type=null, $lesson_id=null, $content=null, $text=null) {
        parent::__construct();
        if($type != null) {
            $currentLocale = \App::getLocale();
            $this->type = $type;
            $this->lesson_id = $lesson_id;
            $this->content = $content;
            if($text != null) {
                $this->translateOrNew($currentLocale)->text = $this->add_target_to_links($text);
            }
            $this->save();
        }
    }

    public static function boot () {
        parent::boot();

        self::deleting(function ($content) {
            Storage::deleteDirectory("public/files/".$content->id);
        });
    }

    public function lesson()
    {
        return $this->belongsTo('App\Lesson');
    }

    public function color()
    {
        return $this->belongsTo('App\Color')->withDefault([
            'hex' => '#ffffff',
        ]);
    }

    public function content_settings()
    {
        return $this->hasMany('App\ContentSetting');
    }

    public function getMaxWidthAttribute()
    {
        $valueobj = $this->content_settings->where('key', 'max_width')->first();
        if(isset($valueobj)) {
            return $valueobj->value;
        } else {
            return '250';
        }
    }

    public function getMaxHeightAttribute()
    {
        $valueobj = $this->content_settings->where('key', 'max_height')->first();
        if(isset($valueobj)) {
            return $valueobj->value;
        } else {
            return '250';
        }
    }


    public function getAdjustmentAttribute()
    {
        $valueobj = $this->content_settings->where('key', 'adjustment')->first();
        if(isset($valueobj)) {
            return $valueobj->value;
        } else {
            return 'left';
        }
    }

    public function setColor(String $hex) {
        $color = Color::where('hex', $hex)->first();
        if(isset($color)) {
            $this->color_id = $color->id;
        }
    }

    public function textPart($part) {
        $translation = $this->translation();
        if(isset($translation)) {
            return explode(';', $translation->text)[$part];
        } else {
            return '';
        }
    }

    public function translatedFileExists() {
        return Storage::exists("public/files/".$this->id."/".\App::getLocale().'/'.$this->filename());
    }

    public function filename() {
        $translation = $this->translation();
        if(isset($translation)) {
            return $translation->text;
        } else {
            return 'broken.png';
        }
    }

    public function urlpath() {
        if($this->translatedFileExists()) {
            return "/storage/files/".$this->id."/".\App::getLocale().'/';
        } else {
            return "/storage/files/".$this->id."/".$this->lesson->track->default_locale->id.'/';
        }
    }

    public function url() {
        if($this->translatedFileExists()) {
            return "/storage/files/".$this->id."/".\App::getLocale().'/'.$this->filename();
        } else {
            return "/storage/files/".$this->id."/".$this->lesson->track->default_locale->id.'/'.$this->filename();
        }
    }

    public function getTextIfExists() {
        if($this->translateOrDefault(\App::getLocale()) !== null) {
            return $this->translateOrDefault(\App::getLocale())->text;
        } else {
            return null;
        }
    }

    public function filepath($ignoreMissing=false) {
        if($ignoreMissing || $this->translatedFileExists()) {
            return "public/files/".$this->id."/".\App::getLocale().'/';
        } else {
            return "public/files/".$this->id."/".$this->lesson->track->default_locale->id.'/';
        }
    }

    public static function add_target_to_links($text) {
        return str_replace('<a href=', '<a target="_blank" href=', $text);
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

    public function getTextAttribute()
    {
        $translation = $this->translation();
        if(isset($translation)) {
            return $translation->text;
        } else {
            return '';
        }
    }
}

class ContentTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['text'];
}
