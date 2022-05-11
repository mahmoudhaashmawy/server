@php
    $about_content = getContent('about.content', true);
    $about_elements = getContent('about.element', false, null, true);
    $counter_elements = getContent('counter.element', false, null, true);
@endphp
<!-- about section start -->
<section class="pt-100 pb-100">
    <div class="container">
        <div class="row gy-5">
            <div class="col-xl-6">
                <div class="about-thumb  wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">
                    <img src="{{ getImage('assets/images/frontend/about/' . @$about_content->data_values->image, '992x923') }}" alt="image">
                </div>
            </div>
            <div class="col-xl-6 ps-lg-5">
                <h2 class="section-title mb-3">{{ __(@$about_content->data_values->heaidng) }}</h2>
                <p>{{ __(@$about_content->data_values->sub_heading) }}</p>
                <div class="row gy-4 mt-5">

                    @forelse($about_elements as $item)
                        <div class="col-sm-6">
                            <div class="about-item wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">
                                <div class="about-item__icon">
                                    @php echo @$item->data_values->icon @endphp
                                </div>
                                <div class="about-item__content">
                                    <h5 class="mb-2">{{ __(@$item->data_values->title) }}</h5>
                                    <p>{{ __(@$item->data_values->content) }}</p>
                                </div>
                            </div><!-- about-item end -->
                        </div>
                    @empty
                    @endforelse

                </div>
            </div>
        </div><!-- row end -->
    </div>
    <div class="line-area">
        <img src="{{asset($activeTemplateTrue.'images/elements/line.png')}}" alt="image">
        <div class="container">
            <div class="row">

                @forelse($counter_elements as $item)
                    <div class="col-sm-3 col-6 overview-single">
                        <div class="overview-item">
                            <h4 class="overview-item__number">{{ __(@$item->data_values->number) }}</h4>
                            <p class="overview-item__caption mt-3">{{ __(@$item->data_values->title) }}</p>
                        </div>
                    </div>
                @empty
                @endforelse

            </div>
        </div>
    </div>
</section>
<!-- about section end -->
