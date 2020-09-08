@extends('layouts.app')

@section('title', __('Lista användare'))

@section('content')

    <H1>Användare</H1>

    @can('Manage all users')
        <div class="card">
            <div class="card-body">
                <label for="edit_user">@lang('Sök efter användare')</label>
                <select class="edit_user" name="edit_user[]"></select>
            </div>
        </div>
    @endcan

    <br>

    @can('Manage all users')
        <a href="/users/create" class="btn btn-primary">@lang('Skapa användare')</a>
    @endcan

    <link href="/select2/select2.min.css" rel="stylesheet" />
    <link href="/select2/select2-bootstrap4.min.css" rel="stylesheet" />
    <script src="/select2/select2.min.js"></script>
    <script src="/select2/i18n/sv.js"></script>

    <script type="text/javascript">
        $('.edit_user').select2({
            width: '100%',
            ajax: {
                url: '/select2users',
                dataType: 'json'
            },
            language: "sv",
            minimumInputLength: 3,
            theme: "bootstrap4"
        });

        $('.edit_user').on('select2:select', function (e) {
            var userid = e.params.data.id;
            window.location='/users/' + userid + '/edit';
        });
    </script>

@endsection
