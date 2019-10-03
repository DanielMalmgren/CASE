@extends('layouts.app')

@section('title', __('Feedback'))

@section('content')

    <H1>@lang('Skicka feedback')</H1>

    <form method="post" action="{{action('FeedbackController@post')}}" accept-charset="UTF-8">
        @csrf

        <div class="mb-3">
            <label for="lesson">@lang('Min feedback gäller lektion')</label>
            <select class="custom-select d-block w-100" name="lesson" id="lesson">
                <option selected value="null">@lang('Ingen specifik lektion')</option>
                @foreach($lessons as $lesson)
                    <option value="{{$lesson->name}}">{{$lesson->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="content">@lang('Meddelande')</label>
            <textarea rows=5 name="content" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label><input type="checkbox" name="anonymous">@lang('Jag vill vara anonym')</label>
        </div>

        <br>

        <button class="btn btn-primary btn-lg btn-block" type="submit">@lang('Skicka')</button>
    </form>

@endsection
