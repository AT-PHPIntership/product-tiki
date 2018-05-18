@extends('admin.layout.master')
@section('title', __('product.update.title'))
@section('content')
<div class="right_col" role="main">
  <div class="">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>@lang('product.update.table-title')</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br />
          <form data-parsley-validate method="POST" action="{!! route('admin.products.update', ['id' => $product['id']]) !!}" enctype="multipart/form-data" class="form-horizontal form-label-left">

            @csrf

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product.create.category')</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="category_id" class="select2_single form-control" tabindex="-1">
                  @foreach ( $categories as $category )
                    @if ($product->category_id == $category->id)
                      <option value="{{ $category->id }}" selected="selected">{{ $category->name }}</option>
                    @else
                      <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endif
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">@lang('product.create.name')
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12" value="{{ $product->name }}">
              </div>
            </div>

            <div class="form-group">
              <label for="description" class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product.create.description')</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea class="resizable_textarea form-control" rows='5' name="description" id="description">{{ $product->description }}</textarea>
              </div>
            </div>

            <div class="form-group">
              <label for="price" class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product.create.price')
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="price" name="price" class="form-control col-md-7 col-xs-12" required="required" type="text" value="{{ $product->price }}">
              </div>
            </div>

            <div class="form-group">
              <label for="quantity" class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product.create.quantity')
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="quantity" name="quantity" class="form-control col-md-7 col-xs-12" required="required" type="text" value="{{ $product->quantity }}">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product.create.image')
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div id="image" class="btn-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="imageInput">@lang('product.create.file-input')</label>
                  <input name="input_img" type="file" id="imageInput">
                </div>
              </div>
            </div>

            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button class="btn btn-primary" type="button">@lang('common.cancel-btn')</button>
                <button type="submit" class="btn btn-success">@lang('product.update.update')</button>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
