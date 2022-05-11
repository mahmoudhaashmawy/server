@extends($activeTemplate.'layouts.master')
@section('content')
<div class="pt-50 pb-50">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <div class="col-xl-5 col-sm-6">
              <div class="trip-card">
                <div class="trip-card__content pt-2">
                    <img src="{{ $data->gatewayCurrency()->methodImage() }}" alt="@lang('Image')">
                  <ul class="caption-list mt-5">
                    <li>
                      <span class="caption">@lang('Amount')</span>
                      <span class="value text-end text--base">{{showAmount($data->amount)}} {{__($general->cur_text)}}</span>
                    </li>
                    <li>
                      <span class="caption">@lang('Charge')</span>
                      <span class="value text-end text--base">{{showAmount($data->charge)}}{{__($general->cur_text)}}</span>
                    </li>
                    <li>
                      <span class="caption">@lang('Payable')</span>
                      <span class="value text-end text--base"> {{showAmount($data->amount + $data->charge)}}{{__($general->cur_text)}}</span>
                    </li>
                    <li>
                      <span class="caption">@lang('Conversion Rate')</span>
                      <span class="value text-end text--base">1 {{__($general->cur_text)}} = {{showAmount($data->rate)}}  {{__($data->baseCurrency())}}</span>
                    </li>
                    <li>
                      <span class="caption">@lang('In') {{$data->baseCurrency()}}</span>
                      <span class="value text-end text--base">{{showAmount($data->final_amo)}}</span>
                    </li>
                    @if($data->gateway->crypto==1)
                    <li>
                        <span class="caption">@lang('Conversion with')</span>
                        <span class="value text-end text--base">{{ __($data->method_currency) }} @lang('and final value will Show on next step')</span>
                      </li>
                    @endif                
                  </ul>

                  @if( 1000 >$data->method_code)
                        <a href="{{route('user.deposit.confirm')}}" class="btn btn--base w-100 mt-4">@lang('Pay Now')</a>
                    @else
                        <a href="{{route('user.deposit.manual.confirm')}}" class="btn btn--base w-100 mt-4">@lang('Pay Now')</a>
                    @endif
                </div>
              </div><!-- trip-card end -->    
            </div>
          </div><!-- row end -->
    </div>
  </div>
@endsection