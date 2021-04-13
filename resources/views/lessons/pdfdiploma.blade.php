@extends('layouts.pdfapp')

@section('title', $lesson->translateOrDefault(App::getLocale())->name)

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
            font-size: 50px;
        }
        .name {
            margin-top: 535px;
        }
        .unit {
            margin-top: 80px;
        }
    </style>

    <div class="name">
        {{$name}}
    </div>

    <div class="unit">
        {{$lesson->track->translateOrDefault(App::getLocale())->name}}
    </div>

@endsection
