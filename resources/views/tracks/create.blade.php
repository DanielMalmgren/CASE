@extends('layouts.app')

@section('content')

<div class="col-md-6">

<script type="text/javascript">
    $(function() {
        $('#limited_by_country').on('change', function() {
            var val = this.checked;
            $("#countries").toggle(this.checked);
        });

    });
</script>

    <H1>@lang('Skapa spår')</H1>

    <form method="post" action="{{action('TrackController@store')}}" accept-charset="UTF-8" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name">@lang('Namn')</label>
            <input name="name" class="form-control" id="name">
        </div>

        <div class="mb-3">
            <label for="subtitle">@lang('Undertitel')</label>
            <input name="subtitle" class="form-control" id="subtitle">
        </div>

        <div class="mb-3">
            <label for="locale">@lang('Standardspråk')</label>
            <select class="custom-select d-block w-100" name="locale">
                @foreach($locales as $locale)
                    <option value="{{$locale->id}}">{{$locale->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="color">@lang('Färg')</label>
            <input name="color" type="color" list="presetColors">
            <datalist id="presetColors">
                @foreach($colors as $color)
                    <option>{{$color->hex}}</option>
                @endforeach
            </datalist>
        </div>

        <div class="mb-3">
            <label for="icon">@lang('Ikon: ') </label>
            <input name="icon" class="form-control" type="file" accept="image/jpeg,image/png,image/gif">
        </div>

        <div class="mb-3">
            <input type="hidden" name="active" value="0">
            <label><input type="checkbox" name="active" value="1">@lang('Aktiv')</label>
        </div>

        <div class="mb-3">
            <input type="hidden" name="limited_by_country" value="0">
            <label><input type="checkbox" name="limited_by_country" id="limited_by_country" value="1">@lang('Begränsad enbart till vissa länder')</label>
        </div>

        <div id="countries" class="ml-5" style="display: none;">
            @foreach($countries as $country)
                <label><input type="checkbox" name="countries[]" value="{{$country->id}}">{{$country->name}}</label><br>
            @endforeach
        </div>

        <br>

        <button class="btn btn-primary btn-lg btn-block" type="submit">@lang('Skapa')</button>
    </form>
</div>

@endsection
