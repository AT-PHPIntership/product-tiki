@extends('admin.layout.master')
@section('title', __('product.index.title'))
@section('content')
<div class="right_col" role="main">
  <div class="">
    <div class="col-md-12 col-sm-12 col-xs-12">
      @include('admin.layout.message')
      <div class="x_panel">
        <div class="x_title">
          <h2>@lang('product.index.table-title')</h2>
          <div class="clearfix"></div>
        </div>

        <div class="form-group pull-right top_search">
          <form action="{{ route('admin.products.index') }}" method="GET">
            <div class="">
              <div class="col-md-6">
                <input type="text" name="content" class="form-control" placeholder="{{ __('post.admin.list.search') }}">
              </div>
              <span class="input-group-btn">
                <button class="btn btn-default" type="submit">@lang('product.index.go')</button>
              </span>
            </div>
          </form>
        </div>

        <div class="x_content">

          <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
              <thead>
                <tr class="headings">
                  <th class="column-title"> @lang('product.index.id') </th>
                  <th class="column-title"> @lang('product.index.category') </th>
                  <th class="column-title"> @lang('product.index.name') </th>
                  <th class="column-title col-md-3"> @lang('product.index.description') </th>
                  <th class="column-title"> @lang('product.create.quantity') </th>
                  <th class="column-title"> @lang('product.index.avg_rating') </th>
                  <th class="column-title"> @lang('product.index.price') </th>
                  <th class="column-title"> @lang('product.index.status') </th>
                  <th class="column-title no-link last">
                    <span class="nobr"> @lang('product.index.action') </span>
                  </th>
                  <th class="column-title no-link last">
                    <span class="nobr"> @lang('product.index.action') </span>
                  </th>
                </tr>
              </thead>

              <tbody>
                @foreach ($products as $product)
                  <tr class="odd pointer">
                    <td class=" ">{{ $product->id }}</td>
                    <td class=" ">{{ $product->category->name }}</td>
                    <td class=" ">{{ $product->name }}</td>
                    <td class=" ">{{ $product->description }}</td>
                    <td class=" ">{{ $product->quantity }}</td>
                    <td class=" ">{{ $product->avg_rating }}</td>
                    <td class=" ">{{ $product->price }}</td>
                    <td class=" ">{{ $product->status }}</td>
                    <td class=" ">
                      <a class="btn btn-primary" href="{!! route('admin.products.edit', ['id' => $product['id']]) !!}"><i class="fa fa-edit"></i></a>
                    </td>
                    <td class=" last">
                      <form id="delete-prd{{ $product->id }}" action="{!! route('admin.products.destroy', ['id' => $product['id']]) !!}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-primary" onclick="deleteProduct(event, {{ $product->id }})" type="submit"><i class="fa fa-trash btn-danger"></i></button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>

            </table>
          </div>
        </div>
        {{ $products->render() }}
      </div>
    </div>
  </div>
</div>
<script src="/js/product.js"></script>
<script src="/js/messages.js"></script>
@endsection
