@extends('admin.layout.master')
@section('title', __('orders.admin.show.title') )
@section('content')
  <div class="right_col" role="main" class="index-main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>{{ __('orders.admin.show.title') }}</h3>
        </div>
      </div>

      <div class="clearfix"></div>
      <div class="row">
      
        <div class="clearfix"></div>

        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>{{ __('orders.admin.show.subtitle') }}{{ $order_id }}</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content" class="list-table">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th class="col-md-2">{{ __('orders.admin.show.product_img_col') }}</th>
                    <th class="col-md-7">{{ __('orders.admin.show.product_name_col') }}</th>
                    <th class="col-md-1">{{ __('orders.admin.show.product_price_col') }}</th>
                    <th class="col-md-1">{{ __('orders.admin.show.quantity_col') }}</th>
                    <th class="col-md-2">{{ __('post.admin.list.action_col') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($orders as $order )
                  <tr>
                    <td>
                        @if (count($order['product']['images']))
                          <img style="width:100px;height:100px" src="{{ $order['product']['images'][0]->image_url }}" alt="">
                        @endif
                    </td>
                    <td>{{ $order['product']->name }}</td>
                    <td>{{ number_format($order->product_price) }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>
                      <form action="" class="col-md-4">
                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash icon-size" ></i></button>
                      </form>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        {{ $orders->render() }}
        <div class="clearfix"></div>       
      </div>
    </div>
  </div>

@endsection