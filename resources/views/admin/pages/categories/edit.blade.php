@extends('admin.layout.master')
@section('title', __('category.admin.title') )
@section('content')
<div class="right_col" role="main">
  <div class="">
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>{{ __('category.admin.edit.title') }}</h2>
            <div class="clearfix"></div>
          </div>
          @include('admin.layout.message')
          <div class="x_content">
            <br />
            <form class="form-horizontal form-label-left" method="POST" action="{{ route('admin.categories.update', ['id' => $category['id']]) }}">
              @include('admin.layout.errors')
              {{ csrf_field() }}
              @method('PUT')
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('category.admin.add.name') }}</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input type="text" class="form-control" value="{{ old('name', $category->name) }}" name="name">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('category.admin.add.parent_category') }}</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <select class="form-control" name="parent_id">
                    <option value=""></option>
                    @foreach ($categories as $parentCategory)
                      <option value="{{ $parentCategory->id }}" @if ($parentCategory->id == $category->parent_id) selected @endif>{{ $parentCategory->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                  <a href="{{ route('admin.categories.index') }}" class="btn btn-success">{{ __('category.admin.add.back') }}</a>
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
