@php
    $seminars_content = getContent('seminars.content', true);
    $seminars = \App\Models\Seminar::active()->with('ratings')->latest()->take(10)->get();
@endphp
<!-- location section start -->
<section class="pt-50 pb-100 bg_img location-section white--overlay" style="background-image: url({{ getImage('assets/images/frontend/seminars/' . @$seminars_content->data_values->background_image, '1920x1282') }});">
    <div class="container-fluid">
        <div class="row justify-content-xl-end justify-content-center">
            <div class="col-xl-3 col-lg-6 col-md-8 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">
                <div class="section-header text-xl-start text-center">
                    <h2 class="section-title">{{ __(@$seminars_content->data_values->heading) }}</h2>
                    <p class="mt-3">{{ __(@$seminars_content->data_values->sub_heading) }}</p>
                    <a href="{{ route('seminars') }}" class="btn btn--base mt-4">@lang('Discover All')</a>
                </div>
            </div>
            <div class="col-xxl-7 col-xl-9 ps-5">
                <div class="location-slider">

                    @forelse ($seminars as $seminar)
                    <div class="single-slide">
                        <div class="location-card has--link rounded-3">
                            <a href="{{ route('seminar.details', [$seminar->id, slug($seminar->name)]) }}" class="item--link"></a>
                            <img src="{{ getImage(imagePath()['seminars']['path'].'/'.@$seminar->images[0], imagePath()['seminars']['size']) }}" alt="image">
                            <div class="overlay-content">
                                <div class="d-flex flex-wrap align-items-end">
                                    <div class="col-6">
                                        <h4 class="location-name text-white">{{ __($seminar->name) }}</h4>
                                        <div class="ratings fs--14px mt-2">
                                            @php
                                                $rating = $seminar->ratings()->avg('rating') + 0;
                                            @endphp

                                                @foreach(range(1,5) as $i)
                                                    <span class="fa-stack" style="width:1em">
                                                        <i class="far fa-star fa-stack-1x"></i>

                                                        @if($rating >0)
                                                            @if($rating >0.5)
                                                                <i class="fas fa-star fa-stack-1x"></i>
                                                            @else
                                                                <i class="fas fa-star-half fa-stack-1x"></i>
                                                            @endif
                                                        @endif
                                                        @php $rating--; @endphp
                                                    </span>
                                                @endforeach
                                            <span class="text-white">({{ $seminar->ratings()->count() }} @lang('reviews'))</span>
                                        </div>
                                    </div>
                                    <div class="col-6 text-end">
                                        <div class="location-card__price text-white">{{ $general->cur_sym }}{{ showAmount($seminar->price) }}</div>
                                        <span class="text-white fs--14px"><i class="las la-clock fs--18px"></i> {{ __($seminar->duration) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- location-card end -->
                    </div><!-- single-slide end -->
                    @empty                        
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</section>
<!-- location section end -->
