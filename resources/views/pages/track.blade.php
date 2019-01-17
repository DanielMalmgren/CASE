@extends('layouts.app')

@section('content')

    <H1>{{$track->translateOrDefault(App::getLocale())->name}}</H1>

    @if(count($track->lessons->where('active', true)) > 0)
        <ul class="list-group mb-3 lessons">
            @foreach($track->lessons->where('active', true) as $lesson)
                <li class="list-group-item d-flex justify-content-between lh-condensed nopadding">
                    <a href="/lesson/{{$lesson->id}}">
                        <h6 class="my-0">{{$lesson->translateOrDefault(App::getLocale())->name}}</h6>
                        @if($lesson->lesson_results->where('user_id', Auth::user()->id)->first())
                            {{--<small class="text-muted">{{$lesson->lesson_results->where('user_id', Auth::user()->id)->first()->personal_best_percent}}</small>--}}
                            @php
                                $percent = $lesson->lesson_results->where('user_id', Auth::user()->id)->first()->personal_best_percent;
                            @endphp
                            @if($percent>49)
                                <img src="/images/Star_happy_small.png">
                            @else
                                <img src="/images/Star_unhappy_small.png">
                            @endif
                            @if($percent>74)
                                <img src="/images/Star_happy_small.png">
                            @else
                                <img src="/images/Star_unhappy_small.png">
                            @endif
                            @if($percent==100)
                                <img src="/images/Star_happy_small.png">
                            @else
                                <img src="/images/Star_unhappy_small.png">
                            @endif
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

@endsection
