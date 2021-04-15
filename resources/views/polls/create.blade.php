
@extends('layouts.app')

@section('title', __('Enkät'))

@section('content')

    <script src="/trumbowyg/trumbowyg.min.js"></script>
    <script type="text/javascript" src="/trumbowyg/langs/sv.min.js"></script>

    <form method="post" action="{{action('PollController@store')}}" accept-charset="UTF-8" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name">@lang('Namn')</label>
            <input name="name" class="form-control" id="name">
        </div>

        <div class="mb-3">
            <label for="infotext">@lang('Informationstext före')</label>
            <textarea rows="4" name="infotext" class="form-control twe"></textarea>
        </div>

        <div class="mb-3">
            <label for="infotext2">@lang('Informationstext efter')</label>
            <textarea rows="4" name="infotext2" class="form-control twe"></textarea>
        </div>

        <br>

        <button class="btn btn-primary btn-lg btn-primary" type="submit">@lang('Spara')</button>

    </form>

    <script type="text/javascript">
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
