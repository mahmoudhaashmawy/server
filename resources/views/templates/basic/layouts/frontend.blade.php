<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

@stack('fbComment')

<!-- preloader css start -->
<div class="preloader">
    <div class="preloader__inner text-center">
        <div class="rounded-circle"></div>
        <div class="icon"><i class="las la-globe-africa"></i></div>
    </div>
</div>
<!-- preloader css end -->

<!-- header-section start  -->
@include($activeTemplate.'partials.header')
<!-- header-section end  -->

<div class="main-wrapper">

    @yield('content')

</div>

<!-- footer section start -->
@include($activeTemplate.'partials.footer')
<!-- footer section end -->


{{--Cookie--}}
@php
    $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
@endphp
@if(@$cookie->data_values->status && !session('cookie_accepted'))
    <div class="cookie__wrapper">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <p class="txt my-2">

                    @php echo @$cookie->data_values->description @endphp

                    <a href="{{ @$cookie->data_values->link }}" target="_blank" class="text--base">@lang('Read Policy')</a>
                </p>
                <button class="btn btn--base btn-md my-2 acceptPolicy">@lang('Accept')</button>
            </div>
        </div>
    </div>
@endif


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


<script>
    (function ($) {
        "use strict";
        $(".langSel").on("change", function () {
            window.location.href = "{{route('home')}}/change/" + $(this).val();
        });

        //Cookie
        $(document).on('click', '.acceptPolicy', function () {
            $.ajax({
                url: "{{ route('cookie.accept') }}",
                method:'GET',
                success:function(data){
                    if (data.success){
                        $('.cookie__wrapper').addClass('d-none');
                        notify('success', data.success)
                    }
                },
            });
        });
    })(jQuery);
</script>

</body>
</html>
