@extends('admin.layout.master')
@section('title', __('orders.admin.show.title') )
@section('css')
  <link href="/css/admin/show.css" rel="stylesheet">
@endsection
@section('content')
<?php
  $total = 0;
  $newTotal = $orderInfo->total;
?>
  <div class="right_col" role="main" class="index-main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>{{ __('orders.admin.show.title') }}</h3>
        </div>
      </div>
      <div class="clearfix"></div>
      @include('admin.layout.message')
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
                    <th class="col-md-4">{{ __('orders.admin.show.address') }}</th>
                    <th class="col-md-2">{{ __('orders.admin.list.total_product') }}</th>
                    <th class="col-md-2">{{ __('orders.admin.list.total_col') }}</th>
                    <th class="col-md-2">{{ __('post.admin.list.status_col') }}</th>
                    <th class="col-md-1">{{ __('orders.admin.list.note_col') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ $orderInfo['user']->username }}</td>
                    <td>{{ $orderInfo['user']->userinfo['address'] }}</td>
                    <td>{{ $orderInfo->orderdetails_count }}</td>
                    <td>{{ number_format($orderInfo->total) }}</td>
                    <td class="input-group">
                      <select id="order-status" class="form-control" name="status" data-id="{{ $orderInfo->id }}">
                        <option value="{{ App\Models\Order::UNAPPROVED }} @if ($orderInfo->status == APP\Models\Order::UNAPPROVED) selected @endif" >{{ __('common.pending') }}</option>
                        <option value="{{ App\Models\Order::APPROVED }}" @if ($orderInfo->status == APP\Models\Order::APPROVED) selected @endif>{{ __('common.approve') }}</option>
                        <option value="{{ App\Models\Order::ON_DELIVERY }}" @if ($orderInfo->status == APP\Models\Order::ON_DELIVERY) selected @endif>{{ __('orders.admin.show.on_delivery') }}</option>
                        <option value="{{ App\Models\Order::CANCELED }}" @if ($orderInfo->status == APP\Models\Order::CANCELED) selected @endif>{{ __('orders.admin.show.canceled') }}</option>
                      </select>
                    </td>
                    <td> <a class="btn btn-primary" data-toggle="modal" data-target="#show-note"><i class="fa fa-eye icon-size"></i></a></td>
                  </tr>
                </tbody>
              </table>
              <div class="clearfix"></div>
            </div>
            <div class="col-md-offset-1 list-table">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th class="col-md-2">{{ __('orders.admin.show.product_img_col') }}</th>
                    <th class="col-md-6">{{ __('orders.admin.show.product_name_col') }}</th>
                    <th class="col-md-1">{{ __('orders.admin.show.product_price_col') }}</th>
                    <th class="col-md-1">{{ __('orders.admin.show.quantity_col') }}</th>
                    <th class="col-md-2">{{ __('orders.admin.list.total_col') }}</th>
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
                    <td>{{ number_format($order->product_price * $order->quantity) }}</td>
                  </tr>
                    {{ $total += ($order->product_price * $order->quantity) }}
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="2"></td>
                    <td colspan="2"><strong>{{ __('orders.admin.show.order_total') }}</strong></td>
                    <td>{{ number_format($total) }}</td>
                  </tr>
                  <tr class="text-success">
                    <td colspan="2" class="border-0"></td>
                    <td colspan="2"><strong>{{ __('orders.admin.show.coupon') }}</strong></td>
                    <td>{{ ($newTotal > $total) ? number_format($newTotal - $total) : 0 }}</td>
                  </tr>
                  <tr class="text-danger">
                    <td colspan="2" class="border-0"></td>
                    <td colspan="2"><strong>{{ __('orders.admin.show.discount_total') }}</strong></td>
                    <td>{{ number_format($newTotal) }}</td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
        {{ $orders->render() }}
        <div class="clearfix"></div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="show-note" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" hidden>
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="myModalLabel">{{ __('orders.admin.show.list_note') }}</h4>
        </div>
        <div class="modal-body">
          <table class="table table-hover">
            <thead>
              <tr>
                <th class="col-md-1">{{ __('post.admin.list.user_col') }}</th>
                <th class="col-md-7">{{ __('orders.admin.show.note_content') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($orderInfo['noteOrder'] as $note )
              <tr>
                <td>{{ $note->user['username'] }}</td>
                <td>{{ $note->note }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="fill_in_note" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" hidden>
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h4>@lang('orders.admin.show.fill_in_note')</h4>
        </div>
        <div class="modal-body">
            <form id="demo-form2" method="POST" class="form-horizontal form-label-left" method="POST" action="{{ route('admin.orders.update', ['id' => $orderInfo->id]) }}">
              {{ csrf_field() }}
              @method('PUT')
              <div class="form-group">
                <div class="col-md-12 col-sm-6 col-xs-12">
                  <textarea rows="5" id="note" name="note" required="required" class="form-control col-md-7 col-xs-12"></textarea>
                </div>
              </div>
              <input id="note-change" type="text" name="status" hidden>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                  <input type="submit" class="btn btn-success" value="{{ __('category.admin.add.submit') }}">
                </div>
              </div>
            </form>

        </div>
      </div>
    </div>
  </div>
@section('js')
  <script src="/js/admin/order.js"></script>
@endsection
@endsection
