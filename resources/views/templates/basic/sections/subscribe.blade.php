@php
    $subscribe_content = getContent('subscribe.content', true);
@endphp
<!-- subscribe section start -->
<section class="pt-50 pb-100">
    <div class="container">
      <div class="subscribe-wrapper bg_img" style="background-image: url('{{ getImage('assets/images/frontend/subscribe/' . @$subscribe_content->data_values->image, '1920x987') }}');">
        <div class="paper-plane">
          <img src="{{asset($activeTemplateTrue.'images/elements/paper-plane.png')}}" alt="image">
        </div>
        <div class="row gy-4 align-items-center">
          <div class="col-lg-5 wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="0.3s">
            <h2 class="section-title text-white">{{ __(@$subscribe_content->data_values->heading) }}</h2>
          </div>
          <div class="col-lg-7 wow fadeInRight" data-wow-duration="0.5s" data-wow-delay="0.5s">
            <form class="subscribe-form" method="POST" action="{{ route('subscribe') }}" id="subscribeForm">
                @csrf
              <input type="email" name="email" class="form--control subscribe_email" autocomplete="off" placeholder="@lang('Enter email address')">
              <button type="submit"><i class="lab la-telegram-plane"></i></button>
            </form>
          </div>
        </div> 
      </div>
    </div>
  </section>
  <!-- subscribe section end -->

  @push('script')
  <script>
    (function ($) {
        "use strict";

        $(document).on("submit", "#subscribeForm", function(e) {
            e.preventDefault();

            var data = $('#subscribeForm').serialize();
            
            $.ajax({
                url:'{{ route('subscribe') }}',
                method:'post',
                data:data,
                success:function(response){
                    if(response.success){
                        $('.subscribe_email').val('');
                        notify('success', response.message);
                    }else{
                        $.each(response.error, function( key, value ) {
                            notify('error', value);
                        });
                    }
                },
                error:function(error){
                    console.log(error)
                }
            });
        });

    })(jQuery);
</script>
  @endpush