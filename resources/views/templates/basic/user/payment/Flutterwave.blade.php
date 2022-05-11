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
                      <span class="value text-end text--base">{{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</span>
                    </li>
                    <li>
                      <span class="caption">@lang('To Get')</span>
                      <span class="value text-end text--base">{{showAmount($deposit->amount)}}  {{__($general->cur_text)}}</span>
                    </li>                          
                  </ul>

                  <button type="button" class="btn btn--base w-100 mt-4 btn-custom2 " id="btn-confirm" onClick="payWithRave()">@lang('Pay Now')</button>
                </div>
              </div><!-- trip-card end -->    
            </div>
          </div><!-- row end -->
    </div>
  </div>
@endsection

@push('script')
    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
    <script>
        "use strict"
        var btn = document.querySelector("#btn-confirm");
        btn.setAttribute("type", "button");
        const API_publicKey = "{{$data->API_publicKey}}";

        function payWithRave() {
            var x = getpaidSetup({
                PBFPubKey: API_publicKey,
                customer_email: "{{$data->customer_email}}",
                amount: "{{$data->amount }}",
                customer_phone: "{{$data->customer_phone}}",
                currency: "{{$data->currency}}",
                txref: "{{$data->txref}}",
                onclose: function () {
                },
                callback: function (response) {
                    var txref = response.tx.txRef;
                    var status = response.tx.status;
                    var chargeResponse = response.tx.chargeResponseCode;
                    if (chargeResponse == "00" || chargeResponse == "0") {
                        window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                    } else {
                        window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                    }
                        // x.close(); // use this to close the modal immediately after payment.
                    }
                });
        }
    </script>
@endpush