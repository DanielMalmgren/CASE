@extends('layouts.app')

@section('title', $lesson->translateOrDefault(App::getLocale())->name)

@section('content')

    <H1>{{$lesson->translateOrDefault(App::getLocale())->name}}</H1>

    <div class="card">
        <div class="card-body">

            @if(count($lesson->contents) > 0)
                @foreach($lesson->contents->sortBy('order') as $content)
                @switch($content->type)
                    @case('vimeo')
                        <div style="max-width:250px">
                            <div class="vimeo-container">
                                <iframe src="https://player.vimeo.com/video/{{$content->content}}" width="0" height="0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                            </div>
                        </div>
                        @break

                    @case('html')
                        {!!$content->translateOrDefault(App::getLocale())->text!!}
                        <br><br>
                        @break

                    @case('audio')
                        <audio controls controlsList="nodownload">
                            <source src="/storage/pods/{{$content->content}}" type="audio/mpeg">
                        </audio>
                        @break

                    @case('office')
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://view.officeapps.live.com/op/embed.aspx?src={{env('APP_URL')}}/storage/office/{{$content->content}}"></iframe>
                        </div>
                        <br>
                        @break

                    @case('file')
                        <a target="_blank" href="/storage/files/{{$content->content}}">{{$content->content}}</a>
                        <br>
                        @break

                    @default
                        Unexpected content type!
                @endswitch

                @endforeach
            @endif

        </div>
    </div>

    <br>

    {{--@if ($question)
        <a href="/test/{{$lesson->id}}" class="btn btn-primary">@lang('Fortsätt till testet')</a>
    @else
        <a href="/test/{{$lesson->id}}" class="btn btn-primary disabled">@lang('Fortsätt till testet')</a>
    @endif--}}

    <a href="/lessons/{{$lesson->id}}/finish" class="btn btn-primary">@lang('Färdig med denna lektion')</a>

    @can ('manage lessons')
        <a href="/lessons/{{$lesson->id}}/edit" class="btn btn-primary">@lang('Redigera lektionen')</a>
        {{--<a href="/lessons/{{$lesson->id}}/editquestions" class="btn btn-primary">@lang('Redigera frågor för lektion')</a>--}}
    @endcan

@endsection
