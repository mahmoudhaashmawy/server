@extends($activeTemplate.'layouts.master')
@section('content')
<div class="pt-50 pb-50">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <div class="col-xl-5 col-sm-6">
              <div class="trip-card">
                <div class="trip-card__content pt-2">
                    <h3 class="text-center my-2">@lang('Payment Preview')</h3>
                    <img src="{{$data->img}}" alt="@lang('Image')">
                  <ul class="caption-list mt-4">
                    <li>
                      <span class="caption">@lang('PLEASE SEND EXACTLY')</span>
                      <span class="value text-end text--base">{{ $data->amount }} {{__($data->currency)}}</span>
                    </li>
                    <li>
                      <span class="caption">@lang('To')</span>
                      <span class="value text-end text--base">{{ $data->sendto }}</span>
                    </li>                          
                  </ul>

                  <h4 class="text--base bold my-4 text-center">@lang('SCAN TO SEND')</h4>
                </div>
              </div><!-- trip-card end -->    
            </div>
          </div><!-- row end -->
    </div>
  </div>
@endsection