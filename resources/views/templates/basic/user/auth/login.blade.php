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
        <form class="account-form mt-5" method="POST" action="{{ route('user.login')}}" onsubmit="return submitUserForm();">
            @csrf

          <div class="form-group">
            <label>@lang('Username or Email')</label>
            <input type="text" name="username" value="{{ old('username') }}" placeholder="@lang('Username or Email')" class="form--control" required>
          </div>
          <div class="form-group">
            <label>{{ __('Password') }}</label>
            <input id="password" type="password" class="form--control" name="password" required required placeholder="{{ __('Password') }}">
          </div>

          <div class="form-group d-flex justify-content-center">
            @php echo loadReCaptcha() @endphp
        </div>
          @include($activeTemplate.'partials.custom_captcha')
          
          <div class="row gy-1">
            <div class="col-lg-6">
              <div class="form-check custom--checkbox">
                <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} id="chekbox-1">
                <label class="form-check-label" for="chekbox-1">
                  @lang('Remember me')
                </label>
              </div>
            </div>
            <div class="col-lg-6 text-lg-end">
              <a href="{{route('user.password.request')}}" class="text--base">@lang('Forgot password?')</a>
            </div>
          </div>

          <div class="form-group mt-4">
            <button type="submit" class="btn btn--base w-100" id="recaptcha">@lang('Login Now')</button>
          </div>
          <p class="text-end"><a href="{{route('user.register')}}" class="text--base">@lang("Haven't an account?")</a></p>
        </form>
      </div>
    </div>
  </section> 
  <!-- account section end -->
@endsection

@push('script')
    <script>
        "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }
    </script>
@endpush
