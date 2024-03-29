@extends('layouts.pdfapp')

@section('title', $lesson->translation()->name)

@section('content')

    <style>
        @page { margin: 0px 0px; }
        body {
            background-image:url({{env('APP_URL').'/images/cert_background.png'}});
            background-repeat:no-repeat;
            width:100%;
            height:100vh;
            background-size: cover;
            text-align: center;
            color: #36a9e1;
            font-size: 45px;
            font-family: Arial Bold;
        }
        .content {
            margin-top: 450px;
            line-height: 150%;
        }
    </style>

    <div class="content">
        @lang('Detta diplom intygar att')<br>

        {{$name}}<br>

        @lang('framgångsrikt har genomfört')<br>

        {{$lesson->track->translation()->name}}
    </div>

@endsection
