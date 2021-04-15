
@extends('layouts.app')

@section('title', __('Enkät'))

@section('content')

    <script src="/trumbowyg/trumbowyg.min.js"></script>
    <script type="text/javascript" src="/trumbowyg/langs/sv.min.js"></script>

    <form method="post" action="{{action('PollController@update', $poll->id)}}" accept-charset="UTF-8" enctype="multipart/form-data">
        @method('put')
        @csrf

        <div class="mb-3">
            <label for="name">@lang('Namn')</label>
            <input name="name" class="form-control" id="name" value="{{$poll->translation()->name}}">
        </div>

        <div class="mb-3">
            <label for="infotext">@lang('Informationstext före')</label>
            <textarea rows="4" name="infotext" class="form-control twe">{!!$poll->translation()->infotext!!}</textarea>
        </div>

        <div class="mb-3">
            <label for="infotext2">@lang('Informationstext efter')</label>
            <textarea rows="4" name="infotext2" class="form-control twe">{!!$poll->translation()->infotext2!!}</textarea>
        </div>

        <div class="mb-3">
            <label for="locale">@lang('Standardspråk')</label>
            <select class="custom-select d-block w-100" disabled>
                <option selected>{{$poll->default_locale->name}}</option>
            </select>
        </div>

        <br>

        <button class="btn btn-primary btn-lg btn-primary" type="submit">@lang('Spara')</button>

    </form>

    <br><br>

    <h1>@lang('Enkätens frågor')</h1>

    <div class="list-group mb-4" id="pollquestionslist">
        @foreach($poll->poll_questions->sortBy('order') as $question)
            <a href="/pollquestion/{{$question->id}}/edit" class="list-group-item list-group-item-action" id="id-{{$question->id}}">
                <div class="row">
                    @if($question->type == 'pagebreak')
                        <hr style="width:95%">
                    @else
                        {{$question->translation()->text}} -
                        {{$question->compulsory?__("Obligatorisk"):__("Frivillig")}}
                        @if($question->type == 'freetext')
                            @lang('fritextfråga')
                        @elseif($question->max_alternatives == 1)
                            @lang('envalsfråga med :alternatives alternativ', ['alternatives' => count($question->alternatives_array)])
                        @else
                            @lang('flervalsfråga med :alternatives alternativ', ['alternatives' => count($question->alternatives_array)])
                        @endif
                        {{$question->display_criteria!=''?'(__("har visningskriterium"))':''}}
                    @endif
                </div>
            </a>
        @endforeach
    </div>

    @if($poll->current_locale_is_poll_default())
        <a href="/pollquestion/create/{{$poll->id}}" class="btn btn-primary">@lang('Lägg till fråga')</a>
    @endif

    <br><br>

    <a href="/poll/{{$poll->id}}/exportresponses" class="btn btn-primary">@lang('Exportera enkätsvar')</a>

    <script type="text/javascript" language="javascript" src="{{asset('vendor/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
    <script type="text/javascript">
        $(function() {
            $("#pollquestionslist").sortable({
            update: function (e, u) {
                var token = "{{ csrf_token() }}";
                var data = $(this).sortable('serialize');
                $.ajax({
                    url: '/pollquestion/reorder',
                    data : {_token:token,data:data},
                    type: 'POST'
                });
            }
            });
        });

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
    </script>


    <link href="/tree-multiselect/jquery.tree-multiselect.min.css" rel="stylesheet">
    <script src="/tree-multiselect/jquery.tree-multiselect.min.js"></script>
    <script type="text/javascript">
    	$("select#workplaces").treeMultiselect({
            startCollapsed: true,
            hideSidePanel: true
        });
    </script>

@endsection
