@extends($activeTemplate.'layouts.frontend')
@section('content')
    @php
        $banner_content = getContent('banner.content', true);
        $plan_locations = App\Models\Plan::orderBy('location')->get('location');
        $seminar_locations = App\Models\Seminar::orderBy('location')->get('location');
    @endphp

    <!-- hero section start -->
    <section class="hero bg_img" style="background-image: url({{ getImage('assets/images/frontend/banner/' . @$banner_content->data_values->background_image, '1920x1281') }});">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10 text-center">
                    <h2 class="hero__title text-white wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">
                        {{ __(@$banner_content->data_values->heading) }}</h2>
                    <p class="text-white mt-3 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">{{ __(@$banner_content->data_values->sub_heading) }}</p>
                </div>
            </div><!-- row end -->
        </div>
    </section>
    <!-- hero section end -->

    <!-- search area start -->
    <div class="search-area pb-50 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.7s">
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-lg-12">
                    <ul class="nav nav-tabs find-tabs with-indicator" id="findTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link mw--120 active" id="tour-tab" data-bs-toggle="tab" data-bs-target="#tour"
                                    type="button" role="tab" aria-controls="tour" aria-selected="true">
                                <i class="las la-globe-africa"></i>
                                <p>@lang('Tour Package')</p>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link mw--120" id="flight-tab" data-bs-toggle="tab" data-bs-target="#flight"
                                    type="button" role="tab" aria-controls="flight" aria-selected="false">
                                <i class="las la-calendar"></i>
                                <p>@lang('Seminar Package')</p>
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="findTabContent">
                        <div class="tab-pane fade show active" id="tour" role="tabpanel" aria-labelledby="tour-tab">
                            <form class="find-form" action="{{ route('plans.search') }}" method="GET">
                                <div class="find-form__destination">
                                    <div class="left">
                                        <label class="mb-0">@lang('Location')</label>
                                        <select class="select2-basic" name="location1">
                                            <option value="">@lang('Select location')</option>
                                            @forelse ($plan_locations as $location)
                                            <option value="{{ $location->location }}">{{ $location->location }}</option>
                                            @empty                                                
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="find-form__duration">
                                    <div class="left">
                                        <label class="mb-0">@lang('From Date')</label>
                                        <input type="text" name="from_date" autocomplete="off" placeholder="Select date"
                                               class="form--control datepicker-here">
                                    </div>
                                    <div class="icon">
                                        <img src="{{asset($activeTemplateTrue.'images/icon/returning.svg')}}" alt="image">
                                    </div>
                                    <div class="right">
                                        <label class="mb-0">@lang('To Date')</label>
                                        <input type="text" name="to_date" autocomplete="off" placeholder="Select date"
                                               class="form--control datepicker-here">
                                    </div>
                                </div>
                                <div class="find-form__btn">
                                    <button type="submit" class="btn btn--base w-100"><i class="las la-search fs--18px"></i> @lang('Find Now')
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="flight" role="tabpanel" aria-labelledby="flight-tab">
                            <form class="find-form" action="{{ route('seminars.search') }}" method="GET">
                                <div class="find-form__destination">
                                    <div class="left">
                                        <label class="mb-0">@lang('Location 1')</label>
                                        <select class="select2-basic" name="location1">
                                            <option value="">@lang('Select location')</option>
                                            @forelse ($seminar_locations as $location)
                                            <option value="{{ $location->location }}">{{ $location->location }}</option>
                                            @empty                                                
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="icon">
                                        <img src="{{asset($activeTemplateTrue.'images/icon/two-arrows.svg')}}" alt="image">
                                    </div>
                                    <div class="right">
                                        <label class="mb-0">@lang('Location 1')</label>
                                        <select class="select2-basic" name="location2">
                                            <option value="">@lang('Select location')</option>
                                            @forelse ($seminar_locations as $location)
                                            <option value="{{ $location->location }}">{{ $location->location }}</option>
                                            @empty                                                
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="find-form__duration">
                                    <div class="left">
                                        <label class="mb-0">@lang('From Date')</label>
                                        <input type="text" name="from_date" autocomplete="off" placeholder="Select date"
                                               class="form--control datepicker-here">
                                    </div>
                                    <div class="icon">
                                        <img src="{{asset($activeTemplateTrue.'images/icon/returning.svg')}}" alt="image">
                                    </div>
                                    <div class="right">
                                        <label class="mb-0">@lang('To Date')</label>
                                        <input type="text" name="to_date" autocomplete="off" placeholder="Select date"
                                               class="form--control datepicker-here">
                                    </div>
                                </div>
                                <div class="find-form__btn">
                                    <button type="submit" class="btn btn--base w-100"><i class="las la-search fs--18px"></i> @lang('Find Now')
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- search area end -->

    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection
