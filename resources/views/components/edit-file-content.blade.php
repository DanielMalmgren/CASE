<div id="file[{{$content->id}}]" data-id="{{$content->id}}" class="card">
    <div class="card-body">
        <span class="handle"><i class="fas fa-arrows-alt-v"></i></span>
        <label class="handle" for="file[{{$content->id}}]">
            @lang('Övrig fil')
            @if(!$content->hasTranslation(\App::getLocale()))
                (@lang('Översatt innehåll saknas - visar innehåll från standardspråk'))
            @endif
        </label>
        @if($content->lesson->track->current_locale_is_track_default())
            <a href="#" class="close remove_field" data-dismiss="alert" data-translations="{{$content->translations()->count()}}" aria-label="close">&times;</a>
        @endif
        <input readonly name="file[{{$content->id}}]" class="form-control original-content" value="{{$content->filename()}}">
        <input name="replace_file[{{$content->id}}]" class="form-control" type="file" value="{{$content->filename()}}">
    </div>
</div>