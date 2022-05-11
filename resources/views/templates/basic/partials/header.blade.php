@php
    $contact_content = getContent('contact.content', true);
    $socials = getContent('social_icon.element',false,null,true);
@endphp
<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="header-top-bar-area">
                <ul class="phone-number">
                    <li>
                        <a href="#0"><i class="las la-phone"></i> {{ $contact_content->data_values->phone }}</a>
                    </li>
                    <li>
                        <a href="#0"><i class="las la-envelope"></i> {{ $contact_content->data_values->email }}</a>
                    </li>
                </ul>
                <ul class="social-icons">
                    @foreach($socials as $social)
                    <li>
                        <a href="{{ $social->data_values->url }}">@php echo $social->data_values->social_icon @endphp</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
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
                        <li><a href="{{ route('home') }}">@lang('Home')</a></li>
                        @foreach($pages as $k => $data)
                            <li><a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a></li>
                        @endforeach
                        <li><a href="{{ route('plans') }}">@lang('Tour Package')</a></li>
                        <li><a href="{{ route('seminars') }}">@lang('Seminar Package')</a></li>
                        <li><a href="{{ route('blogs') }}">@lang('Blog')</a></li>
                        <li><a href="{{ route('contact') }}">@lang('Contact')</a></li>
                    </ul>
                    <div class="nav-right">
                        <select class="langSel language-select me-3">
                            @foreach($language as $item)
                                <option value="{{$item->code}}"
                                        @if(session('lang') == $item->code) selected @endif>{{ __($item->name) }}</option>
                            @endforeach
                        </select>
                        @auth
                            <a href="{{ route('user.home') }}" class="btn btn-md btn--base d-flex align-items-center"><i
                                    class="las la-tachometer-alt fs--18px me-2"></i> @lang('Dashboard')</a>
                        @else
                            <a href="{{ route('user.login') }}" class="btn btn-md btn--base d-flex align-items-center"><i
                                    class="las la-user fs--18px me-2"></i> @lang('Login')</a>
                        @endauth
                    </div>
                </div>
            </nav>
        </div>
    </div><!-- header__bottom end -->
</header>
