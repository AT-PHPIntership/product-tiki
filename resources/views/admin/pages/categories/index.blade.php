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
                  <th class="column-title col-md-3">{{ __('category.admin.table.name') }}</th>
                  <th class="column-title col-md-3">{{ __('category.admin.add.parent_category') }}</th>
                  <th class="column-title col-md-3">{{ __('category.admin.table.sum_product') }}</th>
                  <th class="column-title no-link last"><span class="nobr">{{ __('category.admin.table.action') }}</span></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($listCategories as $list)
                <tr class="even pointer">
                  <td>{{ $list->name }}</td>
                  <td class=" ">
                    @foreach ($list->parentCategories as $cat)
                      {{ $cat->name }}
                    @endforeach
                  </td>
                  <td>{{ $list->products_count }}</td>
                  <td>
                    <form class="col-md-4">
                      <a class="btn btn-primary" href="{{ route('admin.categories.edit', ['id' => $list->id] ) }}"><i class="fa fa-edit"></i></a>
                    </form>
                    <form action="" class="col-md-4" method="POST" id="">
                      <button class="btn btn-danger" type="submit"><i class="fa fa-trash icon-size" ></i></button>
                    </form>
                    <form class="col-md-4">
                      <a class="btn btn-primary" href="{{ route('admin.categories.show', ['id' => $list->id]) }}"><i class="fa fa-eye icon-size" ></i></a>
                    </form>
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
