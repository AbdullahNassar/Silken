<!DOCTYPE html>
<html>
    <head>
        <!-- Meta Tags
        ========================== -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Site Title
        ========================== -->
        <title>{{$settings->site_name}} | @yield('title')</title>

        <!-- Favicon
        ===========================-->
        <link rel="shortcut icon" href="{{asset('assets/site/images/fav.png')}}">

        <!-- Base & Vendors
        ========================== -->

        @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="{{asset('assets/site/vendor/bootstrap/css/bootstrap-ar.css')}}">
        @else
        <link rel="stylesheet" href="{{asset('assets/site/vendor/bootstrap/css/bootstrap.css')}}">
        @endif
        <link rel="stylesheet" href="{{asset('assets/site/vendor/font-awesome/css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/site/vendor/rs-plugin/css/settings.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/site/vendor/owl-carousel/css/owl.carousel.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/site/vendor/owl-carousel/css/owl.theme.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/site/vendor/Magnific-Popup-master/dist/magnific-popup.css')}}">
        <link rel="stylesheet" href="{{asset('assets/site/vendor/WOW/animate.css')}}">
        <link rel="stylesheet" href="{{asset('assets/site/vendor/pace/pace-theme-loading-bar.css')}}">
        <link rel="stylesheet" href="{{asset('assets/site/vendor/rating-plugin/rateit.css')}}">

        <!-- Site Style
        ==========================-->
        <link rel="stylesheet" href="{{asset('assets/site/css/style.css')}}">
        @if(app()->getLocale() == 'en')
        <link rel="stylesheet" href="{{asset('assets/site/css/style-en.css')}}">
        @endif

        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <div class="preloader"></div>
        <div id="wrapper">
            <!-- BEGIN HEADER -->
            @include('site.layouts.header')
            <!-- END HEADER -->
            <div class="main">
                <div class="fullwidthbanner-container">
                    @if(Request::route()->getName() == 'site.home')
                    @include('site.layouts.slider')
                    @endif
                    <!-- END fullwidthbanner-container -->
                    <div class="page-content">
                        @yield('content')
                    </div>
                    <!-- BEGIN FOOTER -->
                    @include('site.layouts.footer')
                    <!-- END FOOTER -->
                </div>    
            </div>
        </div>

        <!-- JS Base & Vendors ========================== -->
        <script src="{{asset('assets/site/vendor/jquery/jquery.js')}}"></script>
        <script src="{{asset('assets/site/vendor/bootstrap/js/bootstrap.js')}}"></script>
        <script src="{{asset('assets/site/vendor/jquery-ui/jquery-ui.min.js')}}"></script>
        <script src="{{asset('assets/site/vendor/rating-plugin/jquery.rateit.min.js')}}"></script>


        
        <script src="{{asset('assets/site/noty/js/noty/packaged/jquery.noty.packaged.min.js')}}"></script>

        <script src="{{asset('assets/site/vendor/nicescroll/jquery.nicescroll.min.js')}}"></script>
        <script src="{{asset('assets/site/vendor/rs-plugin/js/jquery.themepunch.tools.min.js')}}"></script>
        <script src="{{asset('assets/site/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js')}}"></script>
        <script src="{{asset('assets/site/vendor/owl-carousel/js/owl.carousel.min.js')}}"></script>
        <script src="{{asset('assets/site/vendor/loadingoverlay/loadingoverlay.min.js')}}"></script>
        <script src="{{asset('assets/site/vendor/Magnific-Popup-master/dist/jquery.magnific-popup.js')}}"></script>
        <script src="{{asset('assets/site/vendor/WOW/wow.min.js')}}"></script>
        <script src="{{asset('assets/site/vendor/pace/pace.min.js')}}"></script>
        @if(Request::route()->getName() == 'site.contact')
        <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDKLRPtMlxtvFH6ktPPslJZA2efs7ViJ0A"></script>
        <script src="{{asset('assets/site/js/google.js')}}"></script>
        @endif
        <script src="{{asset('assets/admin/jquery.validate.js')}}"></script>
        <script src="{{asset('assets/site/vendor/jcarousellite.js')}}"></script>
        
        <script src="{{asset('assets/site/js/site.js')}}"></script>

        <!-- Site JS
        ========================== -->
        <script src="{{asset('assets/site/js/main.js')}}"></script>

    </body>
</html>