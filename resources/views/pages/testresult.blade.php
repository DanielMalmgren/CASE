@extends('layouts.app')

@section('title', __('Testresultat'))

@section('content')

    <H1>@lang('Testresultat')</H1>

    <div class="card">
        <div class="card-body">

            @for ($i = 10; $i <= 100; $i=$i+10)
                @if($percent>=$i)
                    <img class="resultstar" src="/images/Star_happy.png">
                @else
                    <img class="resultstar" src="/images/Star_unhappy.png">
                @endif
            @endfor

            <br><br>

            @if(isset($lesson->poll))
                <a href="/poll/{{$lesson->poll_id}}/{{$lesson->id}}">@lang('Vi vill gärna veta vad du tyckte om lektionen. Klicka här för att lämna din åsikt!')</a>
            @endif

            <br><br>

            @if($percent<100)
                @lang('Inte riktigt alla rätt rakt igenom. Klicka på knappen nedan för att gå tilbaka till lektionen och repetera.')
                <br><br>
                <a href="/lessons/{{$lesson->id}}" class="btn btn-primary">@lang('Tillbaka till lektionen')</a>
            @else
                @lang('Bra, alla rätt på första försöket!')<br><br>

                @if($lesson->next() === null)

                    @lang('Du är nu färdig med detta spår och kan välja mellan att skriva ut ett diplom eller skicka ett mail direkt ifrån plattformen som intygar detta.')<br><br>

                    <form method="post" name="pdfdiploma" action="{{action('TestResultController@pdfdiploma', $test_session->id)}}" accept-charset="UTF-8">
                        @csrf
                        <div class="mb-3">
                            <label for="name">@lang('Ditt namn')</label>
                            <input name="name" class="form-control" id="name" required>
                        </div>

                        <button class="btn btn-primary btn-lg btn-primary" type="submit">@lang('Skriv ut diplom')</button>

                    </form>

                    <br>

                    <form method="post" name="resultmail" id="resultmail" action="{{action('TestResultController@resultmail', $test_session->id)}}" accept-charset="UTF-8">
                        @csrf
                        <div class="mb-3">
                            <label for="name">@lang('Ditt namn')</label>
                            <input name="name" class="form-control" id="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="email">@lang('Mailadress att skicka intyg till')</label>
                            <input type="email" name="email" class="form-control" id="email" required>
                        </div>

                        <x-honey recaptcha/>
                        <button class="btn btn-primary btn-lg btn-primary" type="submit">@lang('Skicka mail med intyg')</button>

                    </form>
                @else
                    <a href="/lessons/{{$lesson->next()->id}}" class="btn btn-primary">@lang('Nästa lektion')</a>
                @endif

            @endif

            <br><br>
        </div>
    </div>

@endsection
