@extends($activeTemplate.'layouts.auth')

@section('content')
@php
    $account_content = getContent('account.content', true);
@endphp
    <!-- account section start -->
  <section class="account-section bg_img" style="background-image: url('{{ getImage('assets/images/frontend/account/' . @$account_content->data_values->image, '1920x1079') }}');">
    <div class="left">
      <div class="account-form-area">
        <div class="text-center">
          <a href="{{ route('home') }}" class="account-logo"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="image"></a>
        </div>
        <form class="account-form mt-5" method="POST" action="{{ route('user.password.email') }}">
            @csrf

            <div class="form-group">
                <label>@lang('Select One')</label>
                <select class="form--control" name="type">
                    <option value="email">@lang('E-Mail Address')</option>
                    <option value="username">@lang('Username')</option>
                </select>
            </div>
            <div class="form-group">
                <label class="my_value"></label>
                <input type="text" class="form--control @error('value') is-invalid @enderror" name="value" value="{{ old('value') }}" required autofocus="off">
            </div>
        
          <div class="form-group mt-4">
            <button type="submit" class="btn btn--base w-100">@lang('Send Password Code')</button>
          </div>
        </form>
      </div>
    </div>
  </section> 
  <!-- account section end -->
@endsection

@push('script')
<script>

    (function($){
        "use strict";
        
        myVal();
        $('select[name=type]').on('change',function(){
            myVal();
        });
        function myVal(){
            $('.my_value').text($('select[name=type] :selected').text());
        }
    })(jQuery)
</script>
@endpush