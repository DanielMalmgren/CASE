@extends('layouts.app')

@section('title', __('Spår'))

@section('content')

    <H1>@lang('Spår')</H1>

    @if(count($tracks) > 0)
        <ul class="list-group mb-3 tracks" id="tracks">
            @foreach($tracks as $track)
                <li class="list-group-item d-flex justify-content-between lh-condensed nopadding" id="id-{{$track->id}}">
                    <a href="/tracks/{{$track->id}}">
                        <h6 class="my-0">{{$track->translateOrDefault(App::getLocale())->name}}
                            @if($track->active == 0)
                                - inaktiv
                            @endif
                        </h6>
                        <small class="text-muted">{{$track->translateOrDefault(App::getLocale())->subtitle}}</small>
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <br>
        @lang('Det finns inga spår!')
    @endif

    @can('manage lessons')
        <script type="text/javascript" language="javascript" src="{{asset('vendor/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
        <script type="text/javascript">
            $(function() {
                $("#tracks").sortable({
                update: function (e, u) {
                    var token = "{{ csrf_token() }}";
                    var data = $(this).sortable('serialize');
                    $.ajax({
                        url: '/tracks/reorder',
                        data : {_token:token,data:data},
                        type: 'POST'
                    });
                }
                });
            });
        </script>

        <a href="/tracks/create" class="btn btn-primary">@lang('Lägg till spår')</a>
    @endcan

@endsection
