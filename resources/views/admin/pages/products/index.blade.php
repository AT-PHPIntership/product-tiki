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

        <div class="x_content">

          <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
              <thead>
                <tr class="headings">
                  <th class="column-title"> @lang('product.index.id') </th>
                  <th class="column-title"> @lang('product.index.category_id') </th>
                  <th class="column-title"> @lang('product.index.name') </th>
                  <th class="column-title col-md-3"> @lang('product.index.description') </th>
                  <th class="column-title"> @lang('product.index.avg_rating') </th>
                  <th class="column-title"> @lang('product.index.price') </th>
                  <th class="column-title"> @lang('product.index.status') </th>
                  <th class="column-title"> @lang('product.index.image') </th>
                  <th class="column-title no-link last">
                    <span class="nobr"> @lang('product.index.action') </span>
                  </th>
                  <th class="column-title no-link last">
                    <span class="nobr"> @lang('product.index.action') </span>
                  </th>
                </tr>
              </thead>

              @foreach ($products as $product)
                <tbody>
                  <tr class="odd pointer">
                    <td class=" ">{{ $product->id }}</td>
                    <td class=" ">{{ $product->category_id }}</td>
                    <td class=" ">{{ $product->name }}</td>
                    <td class=" ">{{ $product->description }}</td>
                    <td class=" ">{{ $product->avg_rating }}</td>
                    <td class=" ">{{ $product->price }}</td>
                    <td class=" ">{{ $product->status }}</td>
                    <td class=" ">
                      <img src="" alt="">
                    </td>
                    <td class=" ">
                      <a href="#"><i class="fa fa-edit"></i></a>
                    </td>
                    <td class=" last">
                      <a href="{!! route('admin.products.edit', ['id' => $product['id']]) !!}"> @lang('product.index.edit') </a>
                      <form id="delete-prd{{ $product->id }}" action="{!! route('admin.products.destroy', ['id' => $product['id']]) !!}" method="post">
                        @csrf
                        @method('DELETE')
                        <button onclick="deleteProduct(event, {{ $product->id }})" type="submit"><i class="fa fa-trash btn-danger"></i></button>
                      </form>
                    </td>
                  </tr>
                </tbody>
              @endforeach

            </table>
          </div>
        </div>
        {{ $products->render() }}
      </div>
    </div>
  </div>
</div>
<script src="/js/product.js"></script>
@endsection
