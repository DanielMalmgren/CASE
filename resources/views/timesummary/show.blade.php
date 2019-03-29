@extends('layouts.app')

@section('title', __('Sammanställning till ESF'))

@section('content')

    <script type="text/javascript">
        $(function() {
            $('#rel_month').change(function(){
                var rel_month = $('#rel_month').val();
                $("#monthsummary").load("/timesummaryajax/" + rel_month);
            }).change();
        });
    </script>

    <div class="col-md-5 mb-3">

        <H1>@lang('Sammanställning till ESF')</H1>
        <form method="get" name="settings" action="{{action('TimeSummaryController@export')}}" accept-charset="UTF-8">
            @csrf

            <div class="mb-3">
                <label for="rel_month">@lang('Månad')</label>
                <select class="custom-select d-block w-100" id="rel_month" name="rel_month" required="">
                    @for ($i = -6; $i <= 0; $i++)
                        <option value="{{$i}}" {{$i==-1?'selected':''}}>{{strftime('%B %Y',strtotime($i." month"))}}</option>
                    @endfor
                </select>
            </div>

            <div id="monthsummary"></div>

            <button class="btn btn-primary btn-lg btn-block" name="submit" type="submit">@lang('Hämta sammanställningen')</button>
        </form>
    </div>
@endsection
