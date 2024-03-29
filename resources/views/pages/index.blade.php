@extends('layouts.app')

@section('title', __('Startsida'))

@section('content')

<H1>@lang('Välkommen till lärplattformen för Case!')</H1>

<div class="card">
    <div class="card-body">
        @lang('messages.infotext')
    </div>
</div>

<br>

<H1>@lang('Nyheter')</H1>

@if(count($announcements) > 0)
    <div class="list-group mb-4">
        @foreach($announcements as $announcement)
            <a href="/announcements/{{$announcement->id}}" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{$announcement->heading}}</h5>
                    <small>{{\Carbon\Carbon::parse($announcement->created_at)->format('Y-m-d')}}</small>
                </div>
                <p class="mb-1">{{$announcement->preamble}}</p>
            </a>
        @endforeach
      </div>
@endif

@can('manage announcements')
    <a href="/announcements/create" class="btn btn-primary">@lang('Skapa nytt meddelande')</a>
@endcan

@endsection
