@extends('public.layout.master')
@section('title', __('user/resetpassword.title'))
@section('content')
  <!-- mail -->
    <div class="login">
      <div class="container">
        <h2>{{ __('user/resetpassword.title') }}</h2>

        <div class="login-form-grids animated wow slideInUp" data-wow-delay=".5s">
          <form>
            <input type="hidden" name="token" value="{{ $token }}">

            <input type="email" placeholder="{{ __('user/login.form.email_hint') }}" value="{{ $email }}" required="">

            <span class="invalid-feedback-email" hidden>
                <strong></strong>
            </span>

            <input type="password" placeholder="{{ __('user/login.form.password_hint') }}" required="">

            <span class="invalid-feedback-password" hidden>
                <strong></strong>
            </span>

            <input type="password" placeholder="{{ __('user/register.form.password_c') }}" required="">

            <input type="submit" value="{{ __('user/resetpassword.reset_form.reset_password_btn') }}">
          </form>
        </div>
      </div>
    </div>
  <!-- //mail -->
@endsection
@section('js')
<script src=""></script>
@endsection
