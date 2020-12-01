<div id="toc[{{$content->id}}]" data-id="{{$content->id}}" class="card">
    <div class="card-body">
        <span class="handle"><i class="fas fa-arrows-alt-v"></i></span>
        <label class="handle" for="toc[{{$content->id}}]">@lang('Innehållsförteckning')</label>
        @if($content->lesson->track->current_locale_is_track_default())
            <a href="#" class="close remove_field" data-dismiss="alert" data-translations="{{$content->translations()->count()}}" aria-label="close">&times;</a>
        @endif
        <input hidden name="toc[{{$content->id}}]" class="form-control original-content" value="whatever">
    </div>
</div>