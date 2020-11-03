@extends('layouts.app')

@section('content')

<div class="col-md-6">

    <H1>@lang('Redigera spår')</H1>

    <form method="post" action="{{action('TrackController@update', $track->id)}}" accept-charset="UTF-8" enctype="multipart/form-data">
        @method('put')
        @csrf

        <div class="mb-3">
            <label for="name">@lang('Namn')</label>
            <input name="name" class="form-control" id="name" value="{{$track->translation()->name}}">
        </div>

        <div class="mb-3">
            <label for="subtitle">@lang('Undertitel')</label>
            <input name="subtitle" class="form-control" id="subtitle" value="{{$track->translation()->subtitle}}">
        </div>

        <div class="mb-3">
            <label for="locale">@lang('Standardspråk')</label>
            <select class="custom-select d-block w-100" name="locale" disabled>
                @foreach($locales as $locale)
                    @if($track->default_locale_id == $locale->id)
                        <option value="{{$locale->id}}" selected>{{$locale->name}}</option>
                    @else
                        <option value="{{$locale->id}}">{{$locale->name}}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="color">@lang('Färg')</label>
            <input name="color" type="color" list="presetColors" value="{{$track->color->hex}}">
            <datalist id="presetColors">
                @foreach($colors as $color)
                    <option>{{$color->hex}}</option>
                @endforeach
            </datalist>
        </div>

        <div class="mb-3">
            <label for="icon">@lang('Ikon: ') </label>
            <img class="lessonimage" src="/storage/icons/{{$track->icon}}" style="max-width:50px">
            <input name="icon" class="form-control" type="file" accept="image/jpeg,image/png,image/gif">
        </div>

        <div class="mb-3">
            <input type="hidden" name="active" value="0">
            <label><input type="checkbox" name="active" value="1" {{$track->active?"checked":""}}>@lang('Aktiv')</label>
        </div>

        <br>

        <button class="btn btn-primary btn-lg btn-block" type="submit">@lang('Spara')</button>
    </form>
</div>

@endsection
