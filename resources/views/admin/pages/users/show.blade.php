@extends('admin.layout.master')
@section('title', __('user.index.title'))
@section('content')
  <div class="right_col" role="main">
    <div class="col-md-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>{{ __('user.index.userinfo') }}</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br>
          <form class="form-horizontal form-label-left">
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('user.index.username') }}</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="text" class="form-control" readonly="readonly" placeholder="{{ $result->username }}">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('user.index.fullname') }}</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="text" class="form-control" readonly="readonly" placeholder="{{ $result->userInfo['full_name'] }}">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('user.index.email') }}</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="text" class="form-control" readonly="readonly" placeholder="{{ $result->email }}">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('user.index.address') }}</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="text" class="form-control" readonly="readonly" placeholder="{{ $result->userInfo['address'] }}">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('user.index.gender') }}</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                @if ( $result->userInfo['gender'] == 1)
                <input type="text" class="form-control" readonly="readonly" placeholder="{{ __('user.index.female') }}">
                @else
                <input type="text" class="form-control" readonly="readonly" placeholder="{{ __('user.index.male') }}">
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('user.index.avatar') }}</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <img src="{{ $result->userInfo['avatar_url'] }}" alt="img.jpg" >
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('user.index.dob') }}</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="text" class="form-control" readonly="readonly" placeholder="{{ $result->userInfo['dob'] }}">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('user.index.phone') }}</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="text" class="form-control" readonly="readonly" placeholder="{{ $result->userInfo['phone'] }}">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('user.index.indentity_card') }}</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="text" class="form-control" readonly="readonly" placeholder="{{ $result->userInfo['identity_card'] }}">
              </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                <a href="{{ route('admin.users.index') }}" class="btn btn-success">Back</a>
              </div>
            </div>
          </form>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
@endsection