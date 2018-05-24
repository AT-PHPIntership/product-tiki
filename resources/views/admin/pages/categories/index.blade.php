@extends('admin.layout.master')
@section('title', __('category.admin.title') )
@section('content')
<div class="right_col" role="main">
  <div class="">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>{{ __('category.admin.list.title') }}</h2>
          <div class="clearfix"></div>
        </div>
        @include('admin.layout.message')        
        <div class="x_content">
          <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
              <thead>
                <tr class="headings">
                  <th class="column-title" style="display: table-cell;">{{ __('category.admin.table.id') }}</th>
                  <th class="column-title" style="display: table-cell;">{{ __('category.admin.table.name') }}</th>
                  <th class="column-title" style="display: table-cell;">{{ __('category.admin.table.parent_id') }}</th>
                  <th class="column-title" style="display: table-cell;">{{ __('category.admin.table.created_at') }}</th>
                  <th class="column-title" style="display: table-cell;">{{ __('category.admin.table.updated_at') }}</th>
                  <th class="column-title no-link last" style="display: table-cell;"><span class="nobr">{{ __('category.admin.table.action') }}</span>
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach ($listCategories as $list)
                <tr class="even pointer">
                  <td>{{ $list->id }}</td>
                  <td>{{ $list->name }}</td>
                  <td>{{ $list->parent_id }}</td>
                  <td>{{ $list->created_at }}</td>
                  <td class="a-right a-right ">{{ $list->updated_at }}</td>
                  <td class="last"><a href="#">View</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        {{ $listCategories->render() }}
      </div>
      </div>
    </div>
  </div>
</div>
@endsection