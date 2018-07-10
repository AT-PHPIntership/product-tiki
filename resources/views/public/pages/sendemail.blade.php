@extends('public.layout.master')
@section('title', __('user/resetpassword.title'))
@section('content')
  <!-- mail -->
    <div class="login">
      <div class="container">
        <h2>{{ __('user/resetpassword.title') }}</h2>

        <div class="login-form-grids animated wow slideInUp" data-wow-delay=".5s">
          <form>
            <input type="email" placeholder="{{ __('user/login.form.email_hint') }}" required="">

            <span class="invalid-feedback" hidden>
                <strong></strong>
            </span>

            <input type="submit" value="{{ __('user/resetpassword.email_form.send_email_btn') }}">
          </form>
        </div>
      </div>
    </div>
  <!-- //mail -->
@endsection
@section('js')
<script src=""></script>
@endsection
