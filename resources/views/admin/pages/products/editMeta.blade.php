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

            @foreach ($productMeta as $metaData)
              <div class="form-group rows">
                <div class="col-md-3">
                  <select class="form-control meta-key col-md-4" name="meta-key[]">
                    @foreach ($metaList as $meta)
                      <option @if ($metaData->meta_key == $meta->key)
                        selected
                      @endif value="{{ $meta->key }}">{{ $meta->key }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6 col-sm-8 col-xs-12">
                  <input type="text" name="meta-data[]" required="required" class="form-control col-md-7 col-xs-12" value="{{ old('meta_data', $metaData->meta_data) }}">
                </div>
                <div class="col-md-3">
                  <button class="btn btn-danger remove-meta" type="button"><i class="fa fa-trash"></i></button>
                </div>
              </div>
            @endforeach

            <div class="form-group rows" id="template-meta" style="display:none">
              <div class="col-md-3">
                <select class="form-control meta-key col-md-4" name="meta-key[]">
                  @foreach ($metaList as $meta)
                    <option value="{{ $meta->key }}">{{ $meta->key }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 col-sm-8 col-xs-12">
                <input type="text" name="meta-data[]" required="required" class="form-control col-md-7 col-xs-12" value="">
              </div>
              <div class="col-md-3">
                <button class="btn btn-danger remove-meta" type="button"><i class="fa fa-trash"></i></button>
              </div>
            </div>

            <div class="ln_solid" id="last-group"></div>
            <div class="form-group">
              <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                <button type="button" id="add-meta" class="btn btn-info" name="button">Add Meta</button>
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
