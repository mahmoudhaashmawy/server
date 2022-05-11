@extends($activeTemplate.'layouts.master')
@section('content')
<div class="pt-50 pb-50">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <div class="col-xl-5 col-sm-6">
              <div class="trip-card">
                <div class="trip-card__content pt-2">
                    <img src="{{$deposit->gatewayCurrency()->methodImage()}}" alt="@lang('Image')">
                  <form action="{{ route('ipn.'.$deposit->gateway->alias) }}" method="POST">
                    @csrf

                    <ul class="caption-list mt-4">
                        <li>
                          <span class="caption">@lang('Please Pay')</span>
                          <span class="value text-end text--base">{{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</span>
                        </li>
                        <li>
                          <span class="caption">@lang('To Get')</span>
                          <span class="value text-end text--base">{{showAmount($deposit->amount)}}  {{__($general->cur_text)}}</span>
                        </li>                          
                      </ul>
    
                      <button type="button" class="btn mt-4 btn--base w-100 custom-success" id="btn-confirm">@lang('Pay Now')</button>
                            <script
                                src="//js.paystack.co/v1/inline.js"
                                data-key="{{ $data->key }}"
                                data-email="{{ $data->email }}"
                                data-amount="{{$data->amount}}"
                                data-currency="{{$data->currency}}"
                                data-ref="{{ $data->ref }}"
                                data-custom-button="btn-confirm"
                            >
                            </script>
                  </form>
                </div>
              </div><!-- trip-card end -->    
            </div>
          </div><!-- row end -->
    </div>
  </div>
@endsection
