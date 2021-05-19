@extends('layouts.app')

@section('content')

<H1>@lang('Om')</H1>

<div class="card">
    <div class="card-body">
        @lang('messages.infotext')
        <br><br>
        @lang('messages.infotext_long', [
                                            'contact_sweden' => Html::mailto(env('CONTACT_SWEDEN')),
                                            'contact_scotland' => Html::mailto(env('CONTACT_SCOTLAND')),
                                            'contact_latvia' => Html::mailto(env('CONTACT_LATVIA')),
                                            'contact_romania' => Html::mailto(env('CONTACT_ROMANIA')),
                                            'contact_spain' => Html::mailto(env('CONTACT_SPAIN')),
                                        ])
    </div>
</div>

@endsection
