@extends('admin.layout.master')
@section('title', {{ __('post.admin.form.title') }})
@section('content')
  <div class="right_col" role="main" style="min-height: 3619px;">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>{{ __('post.admin.form.title') }}</h3>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>{{ __('post.admin.form.form_title') }}</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content" style="display: block;">
              <br>
              <form action="{{ route('admin.posts.store') }}" method="POST" id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                @csrf
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('post.admin.form.type') }}</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div id="post-type" class="btn-group" data-toggle="buttons">
                      <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="type" value="1"> &nbsp; {{ __('post.admin.form.type_reviews') }} &nbsp;
                      </label>
                      <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="type" value="0"> &nbsp; {{ __('post.admin.form.type_comments') }} &nbsp; 
                      </label>
                    </div>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="content">{{ __('post.admin.form.content') }} <span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                    <textarea name="content" class="resizable_textarea form-control" placeholder="{{ __('post.admin.form.content_hint') }}" style="margin-top: 0px; margin-bottom: 0px; height: 54px;"></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('post.admin.form.user_id') }}</label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                    <select name="user_id" class="select2_group form-control">
                      <optgroup label="Alaskan/Hawaiian Time Zone">
                        <option value="0">Alaska</option>
                        <option value="1">Hawaii</option>
                      </optgroup>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('post.admin.form.product_id') }}</label>
                    <div class="col-md-7 col-sm-7 col-xs-12">
                      <select name="product_id" class="select2_group form-control">
                        <optgroup label="Alaskan/Hawaiian Time Zone">
                          <option value="AK">Alaska</option>
                          <option value="HI">Hawaii</option>
                        </optgroup>
                      </select>
                    </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('post.admin.form.rate') }}</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div id="rating" class="btn-group" data-toggle="buttons">
                      <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="rate" value="1"> &nbsp; 1 &nbsp;
                      </label>
                      <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="rate" value="2"> &nbsp; 2 &nbsp; 
                      </label>
                      <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="rate" value="3"> &nbsp; 3 &nbsp; 
                      </label>
                      <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="rate" value="4"> &nbsp; 4 &nbsp; 
                      </label>
                      <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="rate" value="5"> &nbsp; 5 &nbsp; 
                      </label>
                    </div>
                  </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

