@extends($activeTemplate.'layouts.frontend')
@section('content')
<!-- single package section start -->
<section class="pb-100">
    <div class="single-package-header bg_img" style="background-image: url('{{ getImage('assets/images/frontend/seminar_breadcrumb/' . @$seminar_breadcrumb->data_values->background_image, '1920x1131') }}');">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="single-package-content">
              <h2 class="title text-white">@lang($pageTitle)</h2>
              <div class="ratings mt-2">
                @php
                    $rating = $seminar->ratings_avg_rating + 0;
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
                <span class="text-white">({{ $seminar->ratings_count }})</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-8 pe-lg-5">
          <ul class="nav nav-tabs custom--nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">@lang('Seminar Details')</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="plan-tab" data-bs-toggle="tab" data-bs-target="#plan" type="button" role="tab" aria-controls="plan" aria-selected="false">@lang('Seminar Plan')</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery" type="button" role="tab" aria-controls="gallery" aria-selected="true">@lang('Seminar Gallery')</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab" aria-controls="review" aria-selected="false">@lang('Review')</button>
            </li>
          </ul>
          <div class="tab-content mt-5 package-tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
              <img src="{{ getImage(imagePath()['seminars']['path'].'/'.@$seminar->images[0], imagePath()['seminars']['size']) }}" class="w-100 mb-4 tour-plan-img"  alt="image">
              <h3 class="mb-3">@lang('Seminar Details')</h3>
              <p>
                  @php
                      echo $seminar->details
                  @endphp
              </p>
              <h6 class="mb-3 mt-5">@lang('Included')</h6>
              <ul class="cmn-list">

                @forelse ($seminar->included as $incld)
                    <li>@lang($incld)</li>
                @empty                    
                @endforelse
                
              </ul>
              <h6 class="mb-3 mt-5">@lang('Excluded')</h6>
              <ul class="cmn-list">

                @forelse ($seminar->excluded as $excld)
                    <li>@lang($excld)</li>
                @empty            
                @endforelse
                
              </ul>
              <h6 class="mt-5 mb-3">@lang('Seminar Map')</h6>
              <div class="tour-map-wrapper">
                <iframe id="tour-map" src ="https://maps.google.com/maps?q={{ $seminar->map_latitude }},{{ $seminar->map_longitude }}&hl=es;z=14&amp;output=embed"></iframe>
              </div>
            </div>
            <div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
              <div class="row gy-4">

                @forelse ($seminar->images as $image)
                <div class="col-lg-4">
                    <div class="gallery-card">
                      <img src="{{ getImage(imagePath()['seminars']['path'].'/'.$image, imagePath()['seminars']['size']) }}" alt="image">
                      <a href="{{ getImage(imagePath()['seminars']['path'].'/'.$image, imagePath()['seminars']['size']) }}" data-rel="lightcase:myCollection:slideshow" class="view-thumb"><i class="las la-plus"></i></a>
                    </div>
                  </div>
                @empty                    
                @endforelse
            
              </div>
            </div>
            <div class="tab-pane fade" id="plan" role="tabpanel" aria-labelledby="plan-tab">

                @forelse ($seminar->seminar_plan as $item)
                    <div class="tour-plan-block">
                        <div class="tour-plan-block__header">
                        <h3 class="title mb-3"><span>@lang($item[0])</span> @lang($item[1])</h3>
                        </div>
                        <div class="tour-plan-block__content">
                        <p>
                            @php
                                echo $item[2]
                            @endphp
                        </p>
                        </div>
                    </div><!-- tour-plan-block end -->
                @empty                  
                @endforelse
                
            </div>
            <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
              <div class="course-details-review mb-5">
                <div class="rating-area d-flex flex-wrap align-items-center justify-content-between mb-4">
                  <div class="rating">{{ @$seminar->ratings_avg_rating + 0 }}</div>
                  <div class="content">
                    <div class="ratings d-flex align-items-center justify-content-end fs--18px">
                      
                      @php
                          $rating = $seminar->ratings_avg_rating + 0;
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

                    </div>
                    <span class="mt-1 text-muted fs--14px">@lang('Based on') {{ @$seminar->ratings_count }} @lang('ratings')</span>
                  </div>
                </div>
                <div class="single-review">
                  <p class="star"><i class="las la-star text--base"></i> 5</p>
                  <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{ @(($seminar->ratings()->where('rating', 5)->count())/$seminar->ratings_count*100) }}%" aria-valuenow="{{ @(($seminar->ratings()->where('rating', 5)->count())/$seminar->ratings_count*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span class="percentage">{{ @getAmount(($seminar->ratings()->where('rating', 5)->count())/$seminar->ratings_count*100) }}%</span>
                </div><!-- single-review end -->
                <div class="single-review">
                  <p class="star"><i class="las la-star text--base"></i> 4</p>
                  <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{ @(($seminar->ratings()->where('rating', 4)->count())/$seminar->ratings_count*100) }}%" aria-valuenow="{{ @(($seminar->ratings()->where('rating', 4)->count())/$seminar->ratings_count*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span class="percentage">{{ @getAmount(($seminar->ratings()->where('rating', 4)->count())/$seminar->ratings_count*100) }}%</span>
                </div><!-- single-review end -->
                <div class="single-review">
                  <p class="star"><i class="las la-star text--base"></i> 3</p>
                  <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{ @(($seminar->ratings()->where('rating', 3)->count())/$seminar->ratings_count*100) }}%" aria-valuenow="{{ @(($seminar->ratings()->where('rating', 3)->count())/$seminar->ratings_count*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span class="percentage">{{ @getAmount(($seminar->ratings()->where('rating', 3)->count())/$seminar->ratings_count*100) }}%</span>
                </div><!-- single-review end -->
                <div class="single-review">
                  <p class="star"><i class="las la-star text--base"></i> 2</p>
                  <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{ @(($seminar->ratings()->where('rating', 2)->count())/$seminar->ratings_count*100) }}%" aria-valuenow="{{ @(($seminar->ratings()->where('rating', 2)->count())/$seminar->ratings_count*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span class="percentage">{{ @getAmount(($seminar->ratings()->where('rating', 2)->count())/$seminar->ratings_count*100) }}%</span>
                </div><!-- single-review end -->
                <div class="single-review">
                  <p class="star"><i class="las la-star text--base"></i> 1</p>
                  <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{ @(($seminar->ratings()->where('rating', 1)->count())/$seminar->ratings_count*100) }}%" aria-valuenow="{{ @(($seminar->ratings()->where('rating', 1)->count())/$seminar->ratings_count*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span class="percentage">{{ @getAmount(($seminar->ratings()->where('rating', 1)->count())/$seminar->ratings_count*100) }}%</span>
                </div><!-- single-review end -->
              </div>

              @auth
              <div class="course-details-review mb-5">                
                <form action="{{ route('user.rating', $seminar->id) }}" method="POST">
                  @csrf

                  <input type="hidden" name="type" value="seminar">
                  <input type="hidden" name="rating" id="rating">

                  <div class='rating-stars text-center mb-3'>
                    <ul id='stars'>
                      <li class='star' title='Poor' data-value='1'>
                        <i class='fa fa-star fa-fw'></i>
                      </li>
                      <li class='star' title='Fair' data-value='2'>
                        <i class='fa fa-star fa-fw'></i>
                      </li>
                      <li class='star' title='Good' data-value='3'>
                        <i class='fa fa-star fa-fw'></i>
                      </li>
                      <li class='star' title='Excellent' data-value='4'>
                        <i class='fa fa-star fa-fw'></i>
                      </li>
                      <li class='star' title='WOW!!!' data-value='5'>
                        <i class='fa fa-star fa-fw'></i>
                      </li>
                    </ul>
                  </div>
                  <div class="form-group">
                    <textarea name="comment" id="" cols="30" rows="10" class="form--control" placeholder="@lang('Write your comment')"></textarea>
                  </div>

                  <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn--base">@lang('Submit')</button>
                  </div>
                </form>                  
              </div>
              @else
              <div class="course-details-review mb-5 text-center">
                <h4 class="text--base">@lang('Please login to add rating!')</h4>                 
              </div>
              @endauth
              
              @forelse ($seminar->ratings as $item)
              <div class="single-rating">
                <div class="single-rating__thumb">
                  <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. $item->user->image, '75x75') }}" alt="image">
                </div>
                <div class="single-rating__content">
                  <h5 class="name">{{ $item->user->fullname }}</h5>
                  <div class="d-flex align-items-center mt-1">
                    <div class="ratings d-flex align-items-center justify-content-end fs--18px">
                      @for ($i = 1; $i <= 5; $i++)
                          @if ($item->rating >= $i)
                          <i class="las la-star"></i>
                          @else
                          <i class="lar la-star"></i>
                          @endif
                      @endfor
                    </div>
                    <span class="text-muted ms-2">{{ $item->created_at->diffForHumans() }}</span>
                  </div>
                  <p class="mt-2">{{ @$item->comment }}</p>
                </div>
              </div><!-- single-rating end -->
              @empty                  
              @endforelse

            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="package-sidebar-widget">
            <div class="thumb">
              <img src="{{ getImage(imagePath()['seminars']['path'].'/'.@$seminar->images[0], imagePath()['seminars']['size']) }}" alt="image">
              <div class="price"><span class="fs--14px">{{ $general->cur_sym }}</span> {{ showAmount($seminar->price) }}</div>
            </div>
            <div class="content mt-5">
              <ul class="package-sidebar-list">
                <li>
                  <i class="las la-clock"></i>
                  <span>{{ $seminar->duration }}</span>
                </li>
                <li>
                  <i class="las la-calendar-alt"></i>
                  <span>{{ showDateTime($seminar->start_time, 'd, F, Y') }}</span>
                </li>
                <li>
                  <i class="las la-user"></i>
                  <span>{{ $seminar->capacity - $seminar->sold }} @lang('Availability')</span>
                </li>
              </ul>
              <ul class="caption-list mt-5">
                <li>
                  <span class="caption text-white">@lang('Start Time')</span>
                  <span class="value text-end text--base">{{ showDateTime($seminar->start_time) }}</span>
                </li>
                <li>
                  <span class="caption text-white">@lang('Return')</span>
                  <span class="value text-end text--base">{{ showDateTime($seminar->end_time) }}</span>
                </li>
                <li>
                  <span class="caption text-white">@lang('Total Capacity')</span>
                  <span class="value text-end text--base">{{ $seminar->capacity }} @lang('Persons')</span>
                </li>
              </ul>
              
              @if ($seminar->start_time < now())
                <a href="javascript:void(0)" class="btn btn--base w-100 mt-5">@lang('Completed')</a>
              @else
                @if ($seminar->sold == $seminar->capacity)
                  <a href="javascript:void(0)" class="btn btn--base w-100 mt-5">@lang('Seat Not Available')</a>
                @else
                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn--base w-100 mt-5" data-bs-toggle="modal" data-bs-target="#bookingModal">
                    @lang('Book Now')
                  </button>
                @endif
              @endif
            </div>
              <div class="blog-details-footer mt-4">
                <span class="share-caption text-white">@lang('Share Seminar')</span>
                <ul class="share-post-links">
                  <li><a href="http://twitter.com/share?url={{ route('seminar.details', [$seminar->id, slug($seminar->name)]) }}" target="_blank" class="twitter"><i class="lab la-twitter m-0"></i> </a></li>
                  <li><a href="http://www.facebook.com/sharer.php?u={{ route('seminar.details', [$seminar->id, slug($seminar->name)]) }}" target="_blank" class="facebook"><i class="lab la-facebook-f m-0"></i></a></li>
                </ul>
              </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- single package section end -->

  <!-- Modal -->
@if (auth()->check())
@if ($seminar->start_time > now() && $seminar->sold != $seminar->capacity)
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">@lang('Booking')</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('user.booking') }}" method="POST">
        @csrf

        <div class="modal-body">          

            <input type="hidden" name="plan_id" value="{{ $seminar->id }}">
            <input type="hidden" name="type" value="seminar">

            <div class="form-group">
              <label for="seat">@lang('Number of Seat')</label>
              <div class="input-group">
                <input type="number" min="1" max="{{ $seminar->capacity - $seminar->sold }}" class="form--control" name="seat" id="seat" placeholder="@lang('Enter Number of Seat')">
                <span class="input-group-text"><i class="las la-user"></i></span>
              </div>
              <span class="text--danger total"></span>
            </div>          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn--secondary btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
          <button type="submit" class="btn btn--base btn-sm">@lang('Book')</button>
        </div>
    </form>
    </div>
  </div>
</div>
@endif
@else
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">@lang('Booking')</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <h5>@lang('Please login to book!')</h5>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn--secondary btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
      <a href="{{ route('user.login') }}" class="btn btn--base btn-sm">@lang('Login')</a>
    </div>
  </div>
</div>
</div>
@endif
@endsection

@push('style')
    <style>
/* Rating Star Widgets Style */
.rating-stars ul {
  list-style-type:none;
  padding:0;
  
  -moz-user-select:none;
  -webkit-user-select:none;
}
.rating-stars ul > li.star {
  display:inline-block;
  
}

/* Idle State of the stars */
.rating-stars ul > li.star > i.fa {
  font-size:2.5em; /* Change the size of the stars */
  color:#ccc; /* Color on idle state */
}

/* Hover state of the stars */
.rating-stars ul > li.star.hover > i.fa {
  color:#FFCC36;
}

/* Selected state of the stars */
.rating-stars ul > li.star.selected > i.fa {
  color:#FF912C;
}

    </style>
@endpush

@push('script')
<script>
  (function ($) {
      "use strict";

      $(document).on('keypress, keyup', '#seat', function () {
        var seat = $(this).val();
        var price = parseFloat('{{ getAmount($seminar->price)}}');
        if (seat) {
          $('.total').text('Total price: {{$general->cur_sym}}' + seat*price);
        } else {
          $('.total').text('');
        }
      });
  
  //Rating
  /* 1. Visualizing things on Hover - See next part for action on click */
  $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  
  /* 2. Action to perform on click */
  $('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (var i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (var i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
    if (ratingValue >= 1) {
      $('#rating').val(ratingValue);
    }
    
  });

  })(jQuery);
</script>
@endpush