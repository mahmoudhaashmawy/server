@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate.'partials.breadcrumb')

    <div class="pt-50 pb-50">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-3 pe-5">
                    <button class="action-sidebar-open"><i class="las la-sliders-h"></i> @lang('Filter')</button>
                    <div class="action-sidebar">
                        <button class="action-sidebar-close"><i class="las la-times"></i></button>
                        <form action="{{ route('seminars.search') }}" method="GET">
                            <div class="action-widget widget--shadow">
                                <h4 class="action-widget__title no-icon">@lang('Search')</h4>
                                <div class="action-widget__body">
                                    <input type="text" name="name" autocomplete="off" class="form--control form-control-sm" placeholder="@lang('Search here')">
                                </div>
                                <h6 class="action-widget__title mt-4 no-icon">@lang('Filter by price')</h6>
                                <div class="action-widget__body">
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" name="min_price" autocomplete="off" placeholder="@lang('min')" class="form--control form-control-sm">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" name="max_price" autocomplete="off" placeholder="@lang('max')" class="form--control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                                <h4 class="action-widget__title mt-4 no-icon">@lang('Category')</h4>
                                <div class="action-widget__body">

                                    @forelse ($categories as $category)
                                        <div class="form-check d-flex justify-content-between">
                                            <div class="left">
                                                <input class="form-check-input" name="category[]" type="checkbox" value="{{ $category->id }}" id="chekbox-{{ $category->id }}">
                                                <label class="form-check-label" for="chekbox-{{ $category->id }}">
                                                    {{ __($category->name) }}
                                                </label>
                                            </div>
                                            <label class="fs--14px mt-1" for="chekbox-{{ $category->id }}">({{ $category->seminars()->count() }})</label>
                                        </div><!-- form-check end -->
                                    @empty                                    
                                    @endforelse
                                        <div class="col-12 mt-3">
                                            <button type="submit" class="btn btn-sm btn--base w-100">@lang('Filter')</button>
                                        </div>

                                </div>
                            </div><!-- action-widget end -->
                        </form>
                        <div class="action-widget">
                            <a href="{{ @$ad_images->data_values->ad_image_1_link }}" class="d-block">
                                <img src="{{ getImage('assets/images/frontend/ad_image/' . @$ad_images->data_values->ad_image_1, '270x385') }}" alt="image">
                            </a>
                        </div><!-- action-widget css end -->
                        <div class="action-widget">
                            <a href="{{ @$ad_images->data_values->ad_image_2_link }}" class="d-block">
                                <img src="{{ getImage('assets/images/frontend/ad_image/' . @$ad_images->data_values->ad_image_2, '270x385') }}" alt="image">
                            </a>
                        </div><!-- action-widget css end -->
                    </div><!-- action-sidebar end -->
                </div>

                <div class="col-lg-9">
                    <div class="row gy-4">

                        @forelse($seminars as $seminar)
                            <div class="col-xl-4 col-sm-6">
                                <div class="trip-card">
                                    <div class="trip-card__thumb">
                                        <a href="{{ route('seminar.details', [$seminar->id, slug($seminar->name)]) }}" class="w-100 h-100">
                                            <img src="{{ getImage(imagePath()['seminars']['path'].'/'.@$seminar->images[0], imagePath()['seminars']['size']) }}" alt="image">
                                        </a>
                                        <div class="trip-card__price"><span class="fs--14px">{{ $general->cur_sym }}</span> {{ showAmount($seminar->price) }}</div>
                                    </div>
                                    <div class="trip-card__content">
                                        <h5 class="trip-card__title"><a href="{{ route('seminar.details', [$seminar->id, slug($seminar->name)]) }}">@lang($seminar->name)</a></h5>
                                        <ul class="trip-card__meta mt-2">
                                            <li>
                                                <i class="las la-map-marked-alt"></i>
                                                <p>@lang($seminar->location)</p>
                                            </li>
                                            <li>
                                                <i class="las la-clock"></i>
                                                <p>{{ showDateTime($seminar->departure_time) }}</p>
                                            </li>
                                            <li>
                                                <i class="las la-user"></i>
                                                <p>{{ $seminar->capacity }} @lang('persons')</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div><!-- trip-card end -->
                            </div>
                        @empty
                        @endforelse

                    </div><!-- row end -->

                    <div class="text-end mt-5 pagination-md">
                        {{ $seminars->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
