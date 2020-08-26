@extends('layouts.app')

@section('title', __('Inställningar'))

@section('content')

<div class="col-md-5 mb-3">

    <H1>@lang('Inställningar')</H1>

    <form method="post" name="settings" action="{{action('SettingsController@store', $user->id)}}" accept-charset="UTF-8">
        @csrf

        <div class="mb-3">
            <label for="locale">@lang('Språk')</label>
            <select class="custom-select d-block w-100" name="locale" id="locale" required="">
                @foreach($locales as $locale)
                    @if($user->locale_id == $locale->id || (!$user->locale_id && $locale->default)) {{-- Om antingen denna locale matchar med användarens eller om användaren inte har någon och detta är default locale --}}
                        <option value="{{$locale->id}}" selected>{{$locale->name}}</option>
                    @else
                        <option value="{{$locale->id}}">{{$locale->name}}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <div class="row container">
                <div>
                    <label for="firstname">@lang('Förnamn')</label>
                    <input type="text" name="firstname" class="form-control" disabled value="{{$user->firstname}}">
                </div>
                <div>
                    <label for="lastname">@lang('Efternamn')</label>
                    <input type="text" name="lastname" class="form-control" disabled value="{{$user->lastname}}">
                </div>
            </div>
        </div>

        {{--
        <div class="mb-3">
            <label for="municipality">@lang('Kommun')</label>
            <select class="custom-select d-block w-100" id="municipality" name="municipality" required="">
                @if(!$user->workplace && !old('municipality'))
                    <option disabled selected value>@lang('Välj...')</option>
                @endif
                @foreach($municipalities as $municipality)
                    @if($user->workplace && $user->workplace->municipality->id == $municipality->id || !$user->workplace && old('municipality') == $municipality->id)
                        <option selected value="{{$municipality->id}}">{{$municipality->name}}</option>
                    @else
                        <option value="{{$municipality->id}}">{{$municipality->name}}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="workplace">@lang('Arbetsplats')</label>
            @if($user->workplace || old('workplace'))
                <select class="custom-select d-block w-100" id="workplace" name="workplace" required="">
                    @foreach($workplaces as $workplace)
                        @if($user->workplace && $user->workplace->id == $workplace->id || !$user->workplace && old('workplace') == $workplace->id)
                            <option selected data-municipality="{{$workplace->municipality_id}}" data-workplace-type="{{$workplace->workplace_type_id}}" value="{{$workplace->id}}">{{$workplace->name}}</option>
                        @else
                            <option data-municipality="{{$workplace->municipality_id}}" data-workplace-type="{{$workplace->workplace_type_id}}" value="{{$workplace->id}}">{{$workplace->name}}</option>
                        @endif
                    @endforeach
                </select>
            @else
                <select class="custom-select d-block w-100" id="workplace" name="workplace" required="" disabled>
                    <option disabled data-municipality="-1">@lang('Välj kommun först')</option>
                    @foreach($workplaces as $workplace)
                        <option data-municipality="{{$workplace->municipality_id}}" data-workplace-type="{{$workplace->workplace_type_id}}" value="{{$workplace->id}}">{{$workplace->name}}</option>
                    @endforeach
                </select>
            @endif
        </div>
        --}}

        <div class="mb-3">
            <label for="email">@lang('E-postadress')</label>
            <input type="email" name="email" class="form-control" id="email" value="{{old('email', $user->email)}}" placeholder="fornamn.efternamn@kommun.se">
        </div>

        <br>

        <button class="btn btn-primary btn-lg btn-block" name="submit" type="submit">@lang('Spara')</button>
    </form>
</div>

@endsection
