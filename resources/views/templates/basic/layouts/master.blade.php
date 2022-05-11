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

<header class="header">
    <div class="header__bottom">
        <div class="container">
            <nav class="navbar navbar-expand-xl p-0 align-items-center">
                <a class="site-logo site-title" href="{{ route('home') }}"><img
                        src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="logo"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="menu-toggle"></span>
                </button>
                <div class="collapse navbar-collapse mt-lg-0 mt-3" id="navbarSupportedContent">
                    <ul class="navbar-nav main-menu ms-auto">
                        @auth
                            <li><a href="{{ route('user.home') }}">@lang('Dashboard')</a></li>
                            <li class="menu_has_children"><a href="javascript:void(0)">@lang('Tour Plan')</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('plans') }}">@lang('Plans')</a></li>
                                    <li><a href="{{ route('user.tour.log') }}">@lang('Tour Log')</a></li>
                                </ul>
                            </li>
                            <li class="menu_has_children"><a href="javascript:void(0)">@lang('Seminar')</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('seminars') }}">@lang('Plans')</a></li>
                                    <li><a href="{{ route('user.seminar.log') }}">@lang('Seminar Log')</a></li>
                                </ul>
                            </li>
                            <li class="menu_has_children"><a href="javascript:void(0)">@lang('Support')</a>
                                <ul class="sub-menu">
                                    <li><a href="{{route('ticket.open')}}">@lang('Create New')</a></li>
                                    <li><a href="{{route('ticket')}}">@lang('My Tickets')</a></li>
                                </ul>
                            </li>
                            <li class="menu_has_children"><a href="javascript:void(0)">@lang('Account')</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('user.deposit.history') }}">@lang('Payment History')</a></li>
                                    <li><a href="{{ route('user.change.password') }}">@lang('Change Password')</a></li>
                                    <li><a href="{{ route('user.profile.setting') }}">@lang('Profile Setting')</a></li>
                                    <li><a href="{{ route('user.twofactor') }}">@lang('2FA Security')</a></li>
                                    <li><a href="{{ route('user.logout') }}">@lang('Logout')</a></li>
                                </ul>
                            </li>
                        @endauth
                    </ul>
                    <div class="nav-right">
                        <select class="langSel language-select me-3">
                            @foreach($language as $item)
                                <option value="{{$item->code}}"
                                        @if(session('lang') == $item->code) selected @endif>{{ __($item->name) }}</option>
                            @endforeach
                        </select>
                        @auth
                            <a href="{{ route('user.logout') }}" class="btn btn-md btn--base d-flex align-items-center"><i
                                    class="las la-sign-out-alt fs--18px me-2"></i> @lang('Logout')</a>
                        @endauth
                    </div>
                </div>
            </nav>
        </div>
    </div><!-- header__bottom end -->
</header>


<div class="main-wrapper">

    @include($activeTemplate.'partials.breadcrumb')

    @yield('content')
    
</div>

<!-- footer section start -->
@include($activeTemplate.'partials.footer')
<!-- footer section end -->


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

<script src="{{asset($activeTemplateTrue.'js/bootstrap-fileinput.js')}}"></script>
<script src="{{ asset($activeTemplateTrue.'js/jquery.validate.js') }}"></script>

@stack('script-lib')

@include('partials.notify')

@include('partials.plugins')

@stack('script')

<script>

    (function ($) {
        "use strict";
        $(".langSel").on("change", function() {
            window.location.href = "{{route('home')}}/change/"+$(this).val() ;
        });
        
    })(jQuery);
    
</script>

<script>
    (function($){
        "use strict";

        $("form").validate();
        $('form').on('submit',function () {
          if ($(this).valid()) {
            $(':submit', this).attr('disabled', 'disabled');
          }
        });

    })(jQuery);
</script>

</body>
</html>
