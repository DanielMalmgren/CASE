@extends('layouts.pdfapp')

@section('title', $lesson->translateOrDefault(App::getLocale())->name)

@section('content')

    <style>
        @page { margin: 100px 25px; }
        header { position: fixed; top: -60px; left: 0px; right: 0px; height: 50px; }
        footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; }
        .completedlist { margin-left: 100px; }
    </style>

    <center><H1>DIPLOMA</H1>

    <H2>Awarded to {{$name}}
    For active participation and approved implementation
    of Care Skills Escalator sequence
    {{$lesson->translateOrDefault(App::getLocale())->name}}</H2>
    </center>

    <footer>
    I know. This is crap ugly. Function first, esthetics come later :-) /Daniel
    </footer>

@endsection
