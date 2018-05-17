@extends('admin.layout.master')
@section('title', __('product.create.title'))
@section('content')
<div class="right_col" role="main">
  <div class="">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>@lang('product.create.table-title')</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br />
          <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

            {{ csrf_field() }}

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product.create.category')</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="category" class="select2_single form-control" tabindex="-1">
                  <option value=""></option>
                  <option value=""></option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">@lang('product.create.name')
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12">
              </div>
            </div>

            <div class="form-group">
              <label for="description" class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product.create.description')</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea class="resizable_textarea form-control" rows='5' name="description" id="description"></textarea>
              </div>
            </div>

            <div class="form-group">
              <label for="price" class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product.create.price')
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="price" name="price" class="form-control col-md-7 col-xs-12" required="required" type="text">
              </div>
            </div>

            <div class="form-group">
              <label for="quantity" class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product.create.quantity')
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="quantity" name="quantity" class="form-control col-md-7 col-xs-12" required="required" type="text">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product.create.image')
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div id="image" class="btn-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="imageInput">@lang('product.create.file-input')</label>
                  <input data-preview="#preview" name="input_img" type="file" id="imageInput">
                </div>
              </div>
            </div>

            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button class="btn btn-primary" type="button">@lang('common.cancel')</button>
                <button type="submit" class="btn btn-success">@lang('product.create.create')</button>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
