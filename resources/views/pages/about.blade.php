@extends('layouts.app')

@section('content')

<H1>@lang('Om')</H1>

<div class="card">
    <div class="card-body">
        @lang('messages.infotext')
        <br><br>
        @lang('messages.infotext_long')
    </div>
</div>

<br><br>

<div class="card">
    <div class="card-body">
        @lang('Om du vill kontakta projektteamet, klicka nedan')
        <br><br>
        <a href="/feedback" class="btn btn-primary">@lang('Feedback')</a>
    </div>
</div>

@endsection
