@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate.'partials.breadcrumb')

@php
    $contact_content = getContent('contact.content', true);
@endphp

<!-- contact section start -->
<section class="pt-100 pb-100">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-7">
          <div class="contact-thumb">
            <img src="{{ getImage('assets/images/frontend/contact/' . @$contact_content->data_values->image, '641x757') }}" alt="image">
          </div>
        </div>
        <div class="col-lg-5 ps-lg-5">
          <h2 class="section-title">{{ __(@$contact_content->data_values->title) }}</h2>
          <p class="mt-3">{{ __(@$contact_content->data_values->content) }}</p>
          <form class="contact-form mt-5" action="" method="POST">
              @csrf

            <div class="form-group">
              <label>@lang('Name')</label>
              <input name="name" type="text" placeholder="@lang('Your Name')" class="form--control" value="{{ auth()->check() ? auth()->user()->fullname : old('name') }}" @if(auth()->user()) readonly @endif required>
            </div>
            <div class="form-group">
              <label>@lang('Email')</label>
              <input name="email" type="text" placeholder="@lang('Enter E-Mail Address')" class="form--control" value="{{ auth()->check() ? auth()->user()->email : old('email') }}" @if(auth()->user()) readonly @endif required>
            </div>
            <div class="form-group">
              <label>@lang('Subject')</label>
              <input name="subject" type="text" placeholder="@lang('Write your subject')" class="form--control" value="{{old('subject')}}" required>
            </div>
            <div class="form-group">
              <label>@lang('Messages')</label>
              <textarea name="message" wrap="off" placeholder="@lang('Write your message')" class="form--control">{{old('message')}}</textarea>
            </div>
            <button type="submit" class="btn btn--base">@lang('Submit Now')</button>
          </form>
        </div>
      </div><!-- row end -->
      <div class="row g-4 mt-4 justify-content-center">
        <div class="col-sm-10 col-md-6 col-xl-4">
          <div class="contact-item">
            <div class="icon">
              <i class="las la-map-marked-alt"></i>
            </div>
            <div class="cont">
              <h6 class="mb-2">@lang('Address')</h6>
              <p>@php echo @$contact_content->data_values->address @endphp</p>
            </div>
          </div><!-- contact-item end -->
        </div>
        <div class="col-sm-10 col-md-6 col-xl-4">
          <div class="contact-item">
            <div class="icon">
            <i class="las la-phone"></i>
          </div>
            <div class="cont">
              <h6 class="mb-2">@lang('Phone')</h6>
              <p>@php echo @$contact_content->data_values->phone @endphp</p>
            </div>
          </div><!-- contact-item end -->
        </div>
        <div class="col-sm-10 col-md-6 col-xl-4">
          <div class="contact-item">
            <div class="icon">
            <i class="las la-envelope"></i>
          </div>
            <div class="cont">
              <h6 class="mb-2">@lang('Email Address')</h6>
              <p>@php echo @$contact_content->data_values->email @endphp</p>
            </div>
          </div><!-- contact-item end -->
        </div>
      </div>
    </div>
  </section>
  <!-- contact section end -->  

  <!-- map area start -->
  <div class="map-area">
    <iframe src = "https://maps.google.com/maps?q={{ @$contact_content->data_values->map_latitude }},{{ @$contact_content->data_values->map_longitude }}&hl=es;z=14&amp;output=embed"></iframe>
  </div>
  <!-- map area end -->
@endsection
