@extends('layouts.app')

@section('title', __('Redigera användare'))

@section('content')

<div class="col-md-5 mb-3">

    <H1>@lang('Redigera användare')</H1>

    <form method="post" name="settings" action="{{action('UsersController@update', $user->id)}}" accept-charset="UTF-8">
        @method('put')
        @csrf

        <div class="mb-3">
            <div class="row container">
                <div>
                    <label for="firstname">@lang('Förnamn')</label>
                    <input required type="text" name="firstname" class="form-control"  value="{{$user->firstname}}">
                </div>
                <div>
                    <label for="lastname">@lang('Efternamn')</label>
                    <input required type="text" name="lastname" class="form-control"  value="{{$user->lastname}}">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="email">@lang('E-postadress')</label>
            <input required type="email" name="email" class="form-control" id="email" placeholder="fornamn.efternamn@kommun.se"  value="{{$user->email}}">
        </div>

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
            <input type="hidden" name="lesson_editor" value="0">
            <label><input type="checkbox" name="lesson_editor" value="1" {{$user->hasRole('lesson_editor')?"checked":""}}>@lang('Lektionsredaktör')</label>
        </div>

        <br>

        <button class="btn btn-primary btn-lg btn-block" name="submit" type="submit">@lang('Spara')</button>
    </form>
</div>

@endsection
