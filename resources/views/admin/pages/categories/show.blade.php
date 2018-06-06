@extends('admin.layout.master')
@section('title', __('category.admin.title') )
@section('css')
  <link href="/css/admin/show.css" rel="stylesheet">
@endsection
@section('content')
<div class="right_col" role="main">
  <div class="">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>{{ __('category.admin.show.title') }}</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
              <thead>
                <tr class="headings">
                  <th class="column-title col-md-4">{{ __('category.admin.table.name') }}</th>
                  <th class="column-title col-md-4">{{ __('category.admin.table.child_category') }}</th>
                  <th class="column-title col-md-4">{{ __('category.admin.add.parent_category') }}</th>
                </tr>
              </thead>
              <tbody>
                <tr class="even pointer">
                  <td>{{ $category->name }}</td>
                  <td></td>
                  <td></td>
                </tr>
                @if($category->parent['name'])
                <tr class="even pointer">
                  <td></td>
                  <td></td>
                  <td><a href="{{ route('admin.categories.show', ['id' => $category->parent['id']]) }}">{{ $category->parent['name'] }}</a></td>
                </tr>
                @endif
                @foreach ($category->children as $child)
                <tr class="even pointer">
                  <td></td>
                  <td id="showChild">
                  <a href="{{ route('admin.categories.show', ['id' => $child->id]) }}">{{ $child->name }}</a>
                    <ul class="child">
                    @foreach ($child->children as $grandchild) 
                      <li>{{ $grandchild->name }}</li>
                    @endforeach
                    </ul>
                  </td>
                  <td></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-0">
              <a href="{{ route('admin.categories.index') }}" class="btn btn-success">Back</a>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
</div>
@endsection
