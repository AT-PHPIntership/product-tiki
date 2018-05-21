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
        @if(isset($msg)) 
            <p class="alert alert-info">{{$msg}}</p>
          @endif
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
                  <th class="bulk-actions" colspan="7" style="display: none;">
                    <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt">1 Records Selected</span> ) <i class="fa fa-chevron-down"></i></a>
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach ($listCategories as $list)
                <tr class="even pointer">
                  <td class=" ">{{ $list->id }}</td>
                  <td class=" ">{{ $list->name }}</td>
                  <td class=" ">{{ $list->parent_id }}</td>
                  <td class=" ">{{ $list->created_at }}</td>
                  <td class="a-right a-right ">{{ $list->updated_at }}</td>
                  <td class=" last"><a href="#">View</a>
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