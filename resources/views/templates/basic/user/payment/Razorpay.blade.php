@extends($activeTemplate.'layouts.master')
@section('content')
<div class="pt-50 pb-50">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <div class="col-xl-5 col-sm-6">
              <div class="trip-card">
                <div class="trip-card__content pt-2">
                    <img src="{{$deposit->gatewayCurrency()->methodImage()}}" alt="@lang('Image')">
                  <ul class="caption-list mt-4">
                    <li>
                      <span class="caption">@lang('Please Pay')</span>
                      <span class="value text-end text--base">{{showAmount($deposit->final_amo)}} {{$deposit->method_currency}}</span>
                    </li>
                    <li>
                      <span class="caption">@lang('To Get')</span>
                      <span class="value text-end text--base">{{showAmount($deposit->amount)}}  {{__($general->cur_text)}}</span>
                    </li>                          
                  </ul>

                  <form action="{{$data->url}}" method="{{$data->method}}">
                    <input type="hidden" custom="{{$data->custom}}" name="hidden">
                    <script src="{{$data->checkout_js}}"
                            @foreach($data->val as $key=>$value)
                            data-{{$key}}="{{$value}}"
                        @endforeach >
                    </script>
                </form>
                </div>
              </div><!-- trip-card end -->    
            </div>
          </div><!-- row end -->
    </div>
  </div>
@endsection


@push('script')
    <script>
        (function ($) {
            "use strict";
            $('input[type="submit"]').addClass("btn btn--base w-100 mt-4 btn-custom2");
        })(jQuery);
    </script>
@endpush
