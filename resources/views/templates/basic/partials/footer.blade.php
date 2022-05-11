@php
    $footer_content = getContent('footer.content', true);
    $policy_pages = getContent('policy_pages.element');
@endphp

<footer class="footer bg_img dark--overlay-two" style="background-image: url({{ getImage('assets/images/frontend/footer/' . @$footer_content->data_values->background_image, '1920x960') }});">
    <div class="footer__overview">
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-8 wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="0.3s">
                    <h2 class="text-white text-md-start text-center">{{ __(@$footer_content->data_values->heading) }}</h2>
                </div>
                <div class="col-md-4 text-md-end text-center wow fadeInRight" data-wow-duration="0.5s" data-wow-delay="0.5s">
                    <a href="{{ @$footer_content->data_values->button_link }}" class="btn btn--base">{{ __(@$footer_content->data_values->button) }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center text-center wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.7s">
                    <a href="{{ route('home') }}" class="footer-logo"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="image"></a>
                    <p class="mt-4 text-white">{{ __(@$footer_content->data_values->footer_content) }}</p>
                    <ul class="inlne-menu d-flex flex-wrap align-items-center justify-content-center mt-4">
                        <li><a href="{{ route('plans') }}">@lang('Tour Plan')</a></li>
                        <li><a href="{{ route('seminars') }}">@lang('Seminar')</a></li>
                        @forelse($policy_pages as $item)
                            <li><a href="{{ route('link', [$item->id, slug($item->data_values->title)]) }}">{{ __(@$item->data_values->title) }}</a></li>
                        @empty
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__bottom">
        <div class="container">
            <div class="row gy-2">
                <div class="col-md-6">
                    <p class="text-white text-md-start text-center">{{ __(@$footer_content->data_values->copyright) }}</p>
                </div>
                <div class="col-md-6 text-md-end text-center">
                    <img src="{{ getImage('assets/images/frontend/footer/' . @$footer_content->data_values->payment_image, '385x51') }}" alt="image" class="footer-card">
                </div>
            </div>
        </div>
    </div>
</footer>
