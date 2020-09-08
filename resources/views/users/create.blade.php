@extends('layouts.app')

@section('title', __('Skapa användare'))

@section('content')

<div class="col-md-5 mb-3">

    <H1>@lang('Skapa användare')</H1>

    <form method="post" name="settings" action="{{action('UsersController@store')}}" accept-charset="UTF-8">
        @csrf

        <div class="mb-3">
            <div class="row container">
                <div>
                    <label for="firstname">@lang('Förnamn')</label>
                    <input required type="text" name="firstname" class="form-control"  value="{{old('firstname')}}">
                </div>
                <div>
                    <label for="lastname">@lang('Efternamn')</label>
                    <input required type="text" name="lastname" class="form-control"  value="{{old('lastname')}}">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="email">@lang('E-postadress')</label>
            <input required type="email" name="email" class="form-control" id="email" placeholder="fornamn.efternamn@kommun.se"  value="{{old('email')}}">
        </div>

        <div class="mb-3">
            <label for="locale">@lang('Språk')</label>
            <select class="custom-select d-block w-100" name="locale" id="locale" required="">
                @foreach($locales as $locale)
                    <option value="{{$locale->id}}">{{$locale->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <input type="hidden" name="lesson_editor" value="0">
            <label><input type="checkbox" name="lesson_editor" value="1">@lang('Lektionsredaktör')</label>
        </div>

        <div class="mb-3">
            <label for="pwd_cleartext">@lang('Lösenord')</label>
            <input type="text" class="form-control" disabled value="{{old('pwd_cleartext')?old('pwd_cleartext'):$password}}">
            <input type="hidden" name="pwd_cleartext" class="form-control" id="pwd_cleartext" value="{{old('pwd_cleartext')?old('pwd_cleartext'):$password}}">
        </div>

        <br>

        <button class="btn btn-primary btn-lg btn-block" name="submit" type="submit">@lang('Skapa')</button>
    </form>
</div>

@endsection
