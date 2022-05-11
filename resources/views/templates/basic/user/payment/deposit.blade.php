@extends($activeTemplate.'layouts.master')

@section('content')
<div class="pt-50 pb-50">
    <div class="container">
          <div class="row gy-4">

            @foreach ($gatewayCurrency as $data)
            <div class="col-xl-3 col-md-4 col-sm-6">
                <div class="trip-card h-100 border-radius-0">
                <h6 class="text-center mb-1 ">{{__($data->name)}}</h6>
                  <div class="trip-card__thumb h-auto mx-3">                    
                    <a href="javascript:void(0)" class="w-100">
                      <img src="{{$data->methodImage()}}" class="card-img-top" alt="{{__($data->name)}}" alt="image">
                    </a>
                  </div>
                  <div class="trip-card__content pt-2">
                    <a href="javascript:void(0)" data-id="{{$data->id}}"
                        data-name="{{$data->name}}"
                        data-currency="{{$data->currency}}"
                        data-method_code="{{$data->method_code}}"
                        data-min_amount="{{showAmount($data->min_amount)}}"
                        data-max_amount="{{showAmount($data->max_amount)}}"
                        data-base_symbol="{{$data->baseSymbol()}}"
                        data-fix_charge="{{showAmount($data->fixed_charge)}}"
                        data-percent_charge="{{showAmount($data->percent_charge)}}" class="btn btn--base w-100  custom-success deposit mt-2" data-bs-toggle="modal" data-bs-target="#depositModal">
                         @lang('Pay Now')</a>
                  </div>
                </div><!-- trip-card end -->    
              </div>
            @endforeach
            
          </div><!-- row end -->
    </div>
  </div>


    <div class="modal fade" id="depositModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="modal-title method-name" id="depositModalLabel"></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('user.deposit.insert')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <p>@lang('Are you sure to pay '){{ showAmount($log->price) }} {{ $general->cur_text }}</p>
                        <div class="form-group">
                            <input type="hidden" name="currency" class="edit-currency">
                            <input type="hidden" name="method_code" class="edit-method-code">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary btn-sm" data-dismiss="modal">@lang('Close')</button>
                        <div class="prevent-double-click">
                            <button type="submit" class="btn btn--base btn-sm confirm-btn">@lang('Confirm')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.deposit').on('click', function () {
                var name = $(this).data('name');
                var currency = $(this).data('currency');
                var method_code = $(this).data('method_code');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var baseSymbol = "{{$general->cur_text}}";
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');

                var depositLimit = `@lang('Payment Limit'): ${minAmount} - ${maxAmount}  ${baseSymbol}`;
                $('.depositLimit').text(depositLimit);
                var depositCharge = `@lang('Charge'): ${fixCharge} ${baseSymbol}  ${(0 < percentCharge) ? ' + ' +percentCharge + ' % ' : ''}`;
                $('.depositCharge').text(depositCharge);
                $('.method-name').text(`@lang('Payment By ') ${name}`);
                $('.currency-addon').text(baseSymbol);
                $('.edit-currency').val(currency);
                $('.edit-method-code').val(method_code);
            });

            // $('.prevent-double-click').on('click',function(){
            //     $(this).addClass('button-none');
            //     $(this).html('<i class="fas fa-spinner fa-spin"></i> @lang('Processing')...');
            // });
        })(jQuery);
    </script>
@endpush


@push('style')
<style type="text/css">

</style>
@endpush