@extends('public.layout.master')
@section('title', __('user/login.form.login'))
@section('content')
  <!-- login -->
    <div class="login">
      <div class="container">
        <h2>{{ __('user/login.login_form') }}</h2>

        <div class="login-form-grids animated wow slideInUp" data-wow-delay=".5s">
          <form>
            <input type="email" placeholder="{{ __('user/login.form.email_hint') }}" required=" " >
            <input type="password" placeholder="{{ __('user/login.form.password_hint') }}" required=" " >
            <div class="forgot">
              <a href="{{ route('password.request') }}">{{ __('user/login.form.forgot_password') }}</a>
            </div>
            <input type="submit" value="{{ __('user/login.form.login') }}">
            <a id="login-facebook" href="redirect/facebook" class="login-facebook"><i class="fa fa-facebook" aria-hidden="true"></i> {{ __('user/login.form.login_facebook') }} </a>
          </form>
        </div>
        <p><a href="registered.html">{{ __('user/login.form.register') }}</a> {{ __('user/login.form.or_go_back') }} <a href="{{ route('user.home') }}">{{ __('user/layout.home') }}<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a></p>
      </div>
    </div>
  <!-- //login -->
@endsection
@section('js')
<script src="/js/public/login.js"></script>
@endsection
