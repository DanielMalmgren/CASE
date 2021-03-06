<div id="pagebreak[{{$content->id}}]" data-id="{{$content->id}}" class="card">
    <div class="card-body">
        <span class="handle"><i class="fas fa-arrows-alt-v"></i></span>
        <label class="handle" for="pagebreak[{{$content->id}}]">@lang('Sidrubrik')</label>
        @if($content->lesson->track->current_locale_is_track_default())
            <a href="#" class="close remove_field" data-dismiss="alert" data-translations="{{$content->translations()->count()}}" aria-label="close">&times;</a>
        @endif
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <input name="pagebreak[{{$content->id}}]" class="form-control original-content" value="{{$content->getTextIfExists()}}">
                </div>
                <div class="col-lg-2">
                    <label for="content_colors[{{$content->id}}]">@lang('Färg')</label>
                    <input name="content_colors[{{$content->id}}]" type="color" list="presetColors" value="{{$content->color->hex}}">
                    <datalist id="presetColors">
                        @foreach($colors as $color)
                            <option>{{$color->hex}}</option>
                        @endforeach
                    </datalist>
                </div>
            </div>
        </div>
    </div>
</div>