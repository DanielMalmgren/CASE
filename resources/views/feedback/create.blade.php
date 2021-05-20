@extends('layouts.app')

@section('title', __('Feedback'))

@section('content')

    <H1>@lang('Skicka feedback')</H1>

    <form method="post" action="{{action('FeedbackController@post')}}" accept-charset="UTF-8">
        @csrf

        <div class="mb-3">
            <label for="name">@lang('Namn')</label>
            <input type="text" name="name" class="form-control">
        </div>

        <div class="mb-3">
            <label for="email">@lang('E-postadress')</label>
            <input type="email" name="email" class="form-control" id="email">
        </div>

        <div class="mb-3">
            <label for="country">@lang('Jag vill att min feedback ska nå ansvarig i')</label>
            <select class="custom-select d-block w-100" name="country">
                <option value="general">@lang('Allmänhet')</option>
                @foreach($countries as $country)
                    <option {{$users_country->id==$country->id?'selected':''}} value="{{$country->id}}">{{$country->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="lesson">@lang('Min feedback gäller lektion')</label>
            <select class="custom-select d-block w-100" name="lesson" id="lesson">
                <option selected value="null">@lang('Ingen specifik lektion')</option>
                @foreach($lessons as $lesson)
                    @if(isset($activelesson) && $lesson->id == $activelesson)
                        <option selected value="{{$lesson->name}}">{{$lesson->name}}</option>
                    @else
                        <option value="{{$lesson->name}}">{{$lesson->name}}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="content">@lang('Meddelande')</label>
            <textarea rows=5 name="content" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label><input type="checkbox" id="contacted" name="contacted" onclick="toggleDisableAnonymous()">@lang('Jag vill bli kontaktad')</label>
        </div>

        <br>

        <x-honey recaptcha/>

        <button class="btn btn-primary btn-lg btn-block" type="submit">@lang('Skicka')</button>
    </form>

@endsection
