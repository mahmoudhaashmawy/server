<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ $general->sitename(__($pageTitle)) }}</title>
@include('partials.seo')

<!-- bootstrap 5  -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/lib/bootstrap.min.css')}}">
    <!-- fontawesome 5  -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/all.min.css')}}">
    <!-- lineawesome font -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/line-awesome.min.css')}}">
    <!--  -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/lightcase.css')}}">
    <!-- slick slider css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/lib/slick.css')}}">
    <!-- select 2 plugin css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/lib/select2.min.css')}}">
    <!-- dateoicker css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/lib/datepicker.min.css')}}">
    <!-- main css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/main.css')}}">

    <!-- Custom Color -->
    <link rel="stylesheet"
          href="{{asset($activeTemplateTrue.'css/color.php?color='.$general->base_color.'&secondColor='.$general->secondary_color)}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap-fileinput.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">
    @stack('style-lib')

    @stack('style')
</head>
<body>
<!-- preloader css start -->
<div class="preloader">
    <div class="preloader__inner text-center">
        <div class="rounded-circle"></div>
        <div class="icon"><i class="las la-globe-africa"></i></div>
    </div>
</div>
<!-- preloader css end -->

@yield('content')


<!-- jQuery library -->
<script src="{{asset($activeTemplateTrue.'js/lib/jquery-3.5.1.min.js')}}"></script>
<!-- bootstrap js -->
<script src="{{asset($activeTemplateTrue.'js/lib/bootstrap.bundle.min.js')}}"></script>
<!-- slick slider js -->
<script src="{{asset($activeTemplateTrue.'js/lib/slick.min.js')}}"></script>
<!-- scroll animation -->
<script src="{{asset($activeTemplateTrue.'js/lib/wow.min.js')}}"></script>
<!-- lightcase js -->
<script src="{{asset($activeTemplateTrue.'js/lib/lightcase.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/lib/select2.min.js')}}"></script>

<script src="{{asset($activeTemplateTrue.'js/lib/datepicker.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/lib/datepicker.en.js')}}"></script>
<!-- main js -->
<script src="{{asset($activeTemplateTrue.'js/app.js')}}"></script>

@stack('script-lib')

@stack('script')

@include('partials.plugins')

@include('partials.notify')

</body>
</html>
