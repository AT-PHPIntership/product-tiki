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
              <h2>{{ __('orders.admin.show.subtitle') }}{{ $orderInfo->id }}</h2>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th id="alert-update" class="alert alert-warning" colspan="5" hidden>
                    </th>
                  </tr>
                  <tr>
                    <th class="col-md-1">{{ __('post.admin.list.user_col') }}</th>
                    <th class="col-md-2">{{ __('orders.admin.list.total_product') }}</th>
                    <th class="col-md-2">{{ __('orders.admin.list.total_col') }}</th>
                    <th class="col-md-2">{{ __('post.admin.list.status_col') }}</th>
                    <th class="col-md-5">{{ __('orders.admin.list.note_col') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ $orderInfo['user']->username }}</td>
                    <td>{{ $orderInfo->orderdetails_count }}</td>
                    <td>{{ number_format($orderInfo->total) }}</td>
                    <td class="input-group">
                      <select id="order-status" class="form-control" name="order-status" data-id="{{ $orderInfo->id }}">
                        <option value="{{ App\Models\Order::UNAPPROVED }} @if ($orderInfo->status == APP\Models\Order::UNAPPROVED) selected @endif" >{{ __('common.pending') }}</option>
                        <option value="{{ App\Models\Order::APPROVED }}" @if ($orderInfo->status == APP\Models\Order::APPROVED) selected @endif>{{ __('common.approve') }}</option>
                        <option value="{{ App\Models\Order::ON_DELIVERY }}" @if ($orderInfo->status == APP\Models\Order::ON_DELIVERY) selected @endif>{{ __('orders.admin.show.on_delivery') }}</option>
                        <option value="{{ App\Models\Order::CANCELED }}" @if ($orderInfo->status == APP\Models\Order::CANCELED) selected @endif>{{ __('orders.admin.show.canceled') }}</option>
                      </select>
                    </td>
                    <td>{{ $orderInfo->note }}</td>
                  </tr>
                </tbody>
              </table>
              <div class="clearfix"></div>
            </div>
            <div class="col-md-offset-1" class="list-table">
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
@section('js')
  <script src="/js/admin/order.js"></script>
@endsection
@endsection
