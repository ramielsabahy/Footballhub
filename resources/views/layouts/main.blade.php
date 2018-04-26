<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('incs.styles')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Football Hub') }}</title>

    <!-- Styles -->
    <link href="{{URL::asset('assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/multiselect/css/multi-select.css')}}"  rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::asset('assets/plugins/select2/dist/css/select2-bootstrap.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::asset('assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/switchery/switchery.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/css/parsley.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{URL::asset('assets/css/bootstrap-tagsinput.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatables/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/plugins/datatables/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/plugins/datatables/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/plugins/datatables/responsive.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/plugins/datatables/scroller.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/css/core.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/css/components.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/css/pages.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/css/menu.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/css/responsive.css')}}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css"

    @yield('css')

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="{{URL::asset('assets/js/modernizr.min.js')}}"></script>

    <script type="text/javascript">
        function setPopup(msg, bkcolor, duration) {
            $('#err_Desc').html(msg).css({ 'background-color': bkcolor, 'padding': '10px' }).fadeIn(400).delay(duration).fadeOut(400);
        }
    </script>
</head>
<body>
    @include('incs.navbar')
    <div id="app" class="container">
        @include('incs.messages')
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="{{URL::asset('assets/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/respond.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.validate.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.validate.unobtrusive.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/modernizr-2.6.2.js')}}"></script>
    <script src="{{URL::asset('assets/js/typeahead.bundle.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/footable.min.js')}}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{URL::asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/parsley.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/detect.js')}}"></script>
    <script src="{{URL::asset('assets/js/fastclick.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.slimscroll.js')}}')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.blockUI.js')}}"></script>
    <script src="{{URL::asset('assets/js/waves.js')}}"></script>
    <script src="{{URL::asset('assets/js/wow.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.nicescroll.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.scrollTo.min.js')}}"></script>


    <!-- App js -->
    <script src="{{URL::asset('assets/js/jquery.core.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.app.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <!--
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'article-ckeditor' );
    </script>
    -->

    @yield('scripts')

    <div class="mainDiv400 msg_css" id="err_Desc"></div>
    
    @yield('footer')
</body>
</html>
