@extends('admin.layout.master')
@section('title', 'Category')
@section('content')
<div class="right_col" role="main" style="min-height: 1381px;">
  <div class="">
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>{{ __('category.admin.add.title') }}</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <form class="form-horizontal form-label-left">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('category.admin.add.name') }}</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" class="form-control" placeholder="{{ __('category.admin.add.placeholder_name') }}">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('category.admin.add.parent_category') }}</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <select class="form-control">
                    <option></option>
                    <option>Option one</option>
                    <option>Option two</option>
                    <option>Option three</option>
                    <option>Option four</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                  <button type="reset" class="btn btn-primary">{{ __('category.admin.add.reset') }}</button>
                  <button type="submit" class="btn btn-success">{{ __('category.admin.add.submit') }}</button>
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