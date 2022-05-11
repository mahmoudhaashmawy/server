@php
    $plans_content = getContent('plans.content', true);
    $plans = \App\Models\Plan::active()->latest()->take(12)->get();
@endphp
<!-- best trip section start -->
<section class="pt-100 pb-100 bg_img white--overlay" style="background-image: url({{ getImage('assets/images/frontend/plans/' . @$plans_content->data_values->background_image, '1920x1280') }});">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-10">
                <div class="section-header text-center wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">
                    <h2 class="section-title">{{ __(@$plans_content->data_values->heading) }}</h2>
                    <p class="mt-3">{{ __(@$plans_content->data_values->sub_heading) }}</p>
                </div>
            </div>
        </div><!-- row end -->

        <div class="row g-4 justify-content-center">

            @foreach ($plans as $plan)
            <div class="col-sm-6 col-lg-4 col-xl-3">
                <div class="trip-card">
                    <div class="trip-card__thumb">
                        <a href="{{ route('plan.details', [$plan->id, slug($plan->name)]) }}" class="w-100 h-100">
                            <img src="{{ getImage(imagePath()['plans']['path'].'/'.@$plan->images[0], imagePath()['plans']['size']) }}" alt="image">
                        </a>
                        <div class="trip-card__price"><span class="fs--14px">{{ $general->cur_sym }}</span> {{ showAmount($plan->price) }}</div>
                    </div>
                    <div class="trip-card__content">
                        <h5 class="trip-card__title"><a href="{{ route('plan.details', [$plan->id, slug($plan->name)]) }}">@lang($plan->name)</a></h5>
                        <ul class="trip-card__meta mt-2">
                            <li>
                                <i class="las la-map-marked-alt"></i>
                                <p>@lang($plan->location)</p>
                            </li>
                            <li>
                                <i class="las la-clock"></i>
                                <p>{{ showDateTime($plan->departure_time) }}</p>
                            </li>
                            <li>
                                <i class="las la-user"></i>
                                <p>{{ $plan->capacity }} @lang('persons')</p>
                            </li>
                        </ul>
                    </div>
                </div><!-- trip-card end -->
            </div><!-- single-slide end -->
                
            @endforeach

        </div>
    </div>
</section>
<!-- best trip section end -->
