<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Football') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- jquery dataTables -->
    {!!Html::style('storage/css/datatables.min.css')!!}
    <!-- parsley form validation -->
    {!!Html::style('storage/css/parsley.css')!!}
    <!-- Font Awesome -->
    {!!Html::style('storage/css/font-awesome.min.css')!!}
</head>
<body>
    @include('inc.navbar')
    <div class="container">
        @include('inc.messages')
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Laravel-Ckeditor -->
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'article-ckeditor' );
    </script>
    <!-- jquery dataTables -->
    {!!Html::script('storage/js/jquery.dataTables.min.js')!!}
    {!!Html::script('storage/js/dataTables.bootstrap.min.js')!!}
    <script>
        $('.table').dataTable();
    </script>
    <!-- parsley form validation -->
    {!!Html::script('storage/js/parsley.min.js')!!}
</body>
</html>
