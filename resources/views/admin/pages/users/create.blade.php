@extends('admin.layout.master')
@section('title', __('user.index.title'))
@section('content')
<div class="right_col" role="main">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>{{ __('user.index.createuser') }}</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br>
          @if (count($errors))
            <div class="form-group">
              <div class="alert alert-error">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            </div>
          @endif
          <form id="demo-form2" method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data" class="form-horizontal form-label-left">
            @csrf
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">{{ __('user.index.username') }}<span class="required">{{ __('user.index.requied') }}</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="username" name="username" value="{{ old('username') }}" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">{{ __('user.index.email') }}<span class="required">{{ __('user.index.requied') }}</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="email" name="email" value="{{ old('email') }}" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">{{ __('user.index.password') }}<span class="required">{{ __('user.index.requied') }}</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="password" id="password" name="password" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="full_name">{{ __('user.index.fullname') }}<span class="required">{{ __('user.index.requied') }}</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">{{ __('user.index.address') }}<span class="required">{{ __('user.index.requied') }}</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="address" name="address" value="{{ old('address') }}" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">{{ __('user.index.phone') }}<span class="required">{{ __('user.index.requied') }}</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="identity_card">{{ __('user.index.indentity_card') }}<span class="required">{{ __('user.index.requied') }}</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="identity_card" name="identity_card" value="{{ old('identity_card') }}" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="avatar">{{ __('user.index.avatar') }}</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="file" id="avatar" name="avatar" value="{{ old('avatar') }}"  class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('user.index.gender') }}<span class="required">{{ __('user.index.requied') }}</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div id="gender" class="btn-group" data-toggle="buttons">
                  <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                    <input type="radio" name="gender" value="0" data-parsley-multiple="gender"> &nbsp; {{ __('user.index.male') }} &nbsp;
                  </label>
                  <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                    <input type="radio" name="gender"  value="1" data-parsley-multiple="gender"> {{ __('user.index.female') }}</label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('user.index.dob') }}<span class="required">{{ __('user.index.requied') }}</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="dob" name="dob" value="{{ old('dob') }}" class="form-control col-md-7 col-xs-12" type="date">
              </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button class="btn btn-primary" type="reset">{{ __('user.index.reset') }}</button>
                <button type="submit" id="submit" name="submit" class="btn btn-success">{{ __('user.index.submit') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection