@extends('admin.layout.master')
@section('css')
<link rel="stylesheet" href="/css/admin/product-admin.css">
@endsection
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
          {{-- {!! route('admin.products.updateMeta', ['products' => $product->id) !!} --}}
          <form data-parsley-validate id="form-editor" method="POST" action="" enctype="multipart/form-data" class="form-horizontal form-label-left">

            @csrf
            @method('PUT')
            @include('admin.layout.errors')

            <div class="form-group">
              @include('admin.layout.message')
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">@lang('product.create.name')
                <select class="meta-key" name="meta">
                  @foreach ($metaList as $meta)
                    <option value="{{ $meta->key }}">{{ $meta->key }}</option>
                  @endforeach
                </select>
              </label>
              <div class="col-md-8 col-sm-8 col-xs-12">
                {{-- {{ old('name', $product->name) }} --}}
                <input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12" value="">
              </div>
            </div>

            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                <button class="btn btn-primary" type="reset">@lang('common.reset')</button>
                <button type="submit" onclick="submitForm(event)" class="btn btn-success">@lang('product.update.update')</button>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="/js/admin/product.js"></script>
@endsection
