<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Football Hub') }}</title>

    <!-- Styles -->
    <link href="{{URL::asset('assets/css/parsley.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{URL::asset('assets/css/bootstrap-tagsinput.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ url('assets/css/style.css') }}" />
        <link rel="stylesheet" href="{{ url('assets/css/ionicons.min.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/css/font-awesome.min.css') }}" />
    
    <!--Google Font-->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700,700i" rel="stylesheet">
    

    <!--Favicon-->
    <link rel="shortcut icon" type="image/png" href="{{ url('assets/images/fav.png') }}"/>
    <script type="text/javascript">
        function setPopup(msg, bkcolor, duration) {
            $('#err_Desc').html(msg).css({ 'background-color': bkcolor, 'padding': '10px' }).fadeIn(400).delay(duration).fadeOut(400);
        }
    </script>
</head>
<body>
        @yield('content')

    <!-- Scripts -->
    <script src="{{URL::asset('assets/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/respond.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.validate.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.validate.unobtrusive.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/parsley.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/modernizr-2.6.2.js')}}"></script>
    <script src="{{URL::asset('assets/js/typeahead.bundle.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/footable.min.js')}}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <!--
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'article-ckeditor' );
    </script>
    -->
 <script src="{{ url('assets/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.appear.min.js') }}"></script>
        <script src="{{ url('assets/js/jquery.incremental-counter.js') }}"></script>
    <script src="{{ url('assets/js/script.js') }}"></script>

    @yield('scripts')

    <div class="mainDiv400 msg_css" id="err_Desc"></div>
    
    @yield('footer')
</body>
</html>