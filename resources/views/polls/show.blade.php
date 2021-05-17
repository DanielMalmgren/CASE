
@extends('layouts.app')

@section('title', __('Enkät'))

@section('content')

    <H1>{{$poll->translation()->name}}</H1>

    <div class="card">
            <div class="card-body">
                {!!$poll->translation()->infotext!!}
            </div>
    </div>

    <br>

    @if(isset($first_question_id))
        <a href="/pollquestion/{{$first_question_id}}" class="btn btn-primary">@lang('Påbörja enkäten')</a>
    @else
        @lang('Denna enkät innehåller inga frågor!')
    @endif

@endsection
