@extends('layouts.app')

@section('title', __('Redigera lektion'))

@section('content')

<script src="/trumbowyg/trumbowyg.min.js"></script>
<script type="text/javascript" src="/trumbowyg/langs/sv.min.js"></script>
<script type="text/javascript" language="javascript" src="{{asset('vendor/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

@if($lesson->track->current_locale_is_track_default())
   <x-add-content/>
@endif

<script type="text/javascript">
    function addtwe() {
        $('.twe').trumbowyg({
            btns: [
                ['formatting'],
                ['strong', 'em', 'del'],
                ['link'],
                ['justifyLeft', 'justifyCenter'],
                ['unorderedList', 'orderedList'],
                ['horizontalRule'],
                ['fullscreen']
            ],
            lang: 'sv',
            removeformatPasted: true,
            minimalLinks: true
        });
    }

    function update_content_order() {
        var order = $("#contents_wrap").sortable("toArray");
        $('#content_order').val(order.join(","));
    }

    function deletelesson() {
        if(confirm('Vill du verkligen radera denna lektion?')) {
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: '/lessons/{{$lesson->id}}',
                data : {_token:token},
                type: 'DELETE',
                success: function(result) {
                    console.log(result)
                }
            })
            .always(function() {
                window.location='/tracks/{{$lesson->track_id}}';
            });
        }
    }

    $(function() {

        $('#limited_by_title').on('change', function() {
            var val = this.checked;
            $("#titles").toggle(this.checked);
        });

        addtwe();

        $("#contents_wrap").sortable({
            update: function (e, u) {
                update_content_order();
            },
            handle: '.handle',
            axis: 'y'
        });

        update_content_order();

    });
</script>

    <H1>@lang('Redigera lektion')</H1>

    <form method="post" name="lesson" action="{{action('LessonController@update', $lesson->id)}}" accept-charset="UTF-8" enctype="multipart/form-data">
        @method('put')
        @csrf

        <input type="hidden" id="content_order" name="content_order" value="" />

        <div class="mb-3">
            <label for="name">@lang('Namn')</label>
            <input name="name" class="form-control" id="name" value="{{$lesson->translation()->name}}">
        </div>

        <div class="mb-3">
            <label for="track">@lang('Spår')</label>
            <select class="custom-select d-block w-100" id="track" name="track" required="">
                @foreach($tracks as $track)
                    @if($lesson->track_id == $track->id)
                        <option selected value="{{$track->id}}">{{$track->translation()->name}}</option>
                    @else
                        <option value="{{$track->id}}">{{$track->translation()->name}}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <input type="hidden" name="active" value="0">
            <label><input type="checkbox" name="active" value="1" {{$lesson->active?"checked":""}}>@lang('Aktiv')</label>
        </div>

        <h2>@lang('Innehåll')</h2>
        <div id="contents_wrap">
            @if(count($lesson->contents) > 0)
                @foreach($lesson->contents->sortBy('order') as $content)
                    <x-edit-content :content="$content"/>
                @endforeach
            @endif
        </div>

        <br>

        @if($lesson->track->current_locale_is_track_default())
            <div class="row">
                <div class="col-lg-4">
                    <label for="content_to_add">@lang('Typ av innehåll att lägga till')</label>
                    <select class="custom-select d-block w-100" name="content_to_add" id="content_to_add">
                        <option selected disabled value="select">@lang('Välj typ av innehåll')</option>>
                        <option value="vimeo">@lang('Vimeo-film')</option>
                        <option value="youtube">@lang('Youtube-film')</option>
                        <option value="html">@lang('Text')</option>
                        <option value="audio">@lang('Pod (ljudfil)')</option>
                        <option value="office">@lang('Office-fil (Word, Excel, Powerpoint)')</option>
                        <option value="image">@lang('Bild')</option>
                        <option value="file">@lang('Övrig fil')</option>
                        <option value="pagebreak">@lang('Sidrubrik')</option>
                    </select>
                </div>
            </div>
        @endif

        <br><br>

        <button class="btn btn-primary btn-lg btn-primary" type="submit">@lang('Spara')</button>
        <button type="button" class="btn btn-lg btn-danger" onclick="deletelesson()">@lang('Radera lektion')</button>

    </form>

@endsection
