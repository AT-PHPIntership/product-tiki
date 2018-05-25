@extends('admin.layout.master')
@section('title', __('orders.admin.list.title') )
@section('content')
  <div class="right_col" role="main" class="index-main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>{{ __('orders.admin.list.title') }}</h3>
        </div>

        <div class="title_right">
          <div class="col-md-10 col-sm-10 col-xs-12 form-group pull-right top_search">
            <form action="{{ route('admin.orders.index') }}" method="GET">
              <div class="input-group">   
                <div class="col-md-5">
                  <select name="order_status" class="form-control">
                    <option value="">{{ __('orders.admin.list.subtitle') }}</option>
                    <option value="{{ App\Models\Order::UNAPPROVED }}">{{ __('orders.admin.list.unapproved_order') }}</option>
                    <option value="{{ App\Models\Order::APPROVED }}">{{ __('orders.admin.list.approved_order') }}</option>
                  </select>
                </div>          
                <div class="col-md-7">
                  <select name="order_by_total" class="form-control">
                    <option value="{{ App\Models\Order::ORDER_ASC }}">{{ __('orders.admin.list.order_by_total_asc') }}</option>
                    <option value="{{ App\Models\Order::ORDER_DESC }}">{{ __('orders.admin.list.order_by_total_desc') }}</option>
                  </select>
                </div>        
                <span class="input-group-btn">
                  <button class="btn btn-default" type="submit">{{ __('post.admin.list.go') }}</button>
                </span>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="clearfix"></div>

      <div class="row">
      
        <div class="clearfix"></div>

        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>
                  {{ __('orders.admin.list.subtitle') }}
              </h2>
              <div class="clearfix"></div>
            </div>
              <h2 id="info-message">@if (session()->has('message')) {{ session()->pull('message', 'default') }} @endif</h2>
            
            <div class="x_content" class="list-table">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th class="col-md-3">{{ __('post.admin.list.user_col') }}</th>
                    <th class="col-md-2">{{ __('post.admin.list.status_col') }}</th>
                    <th class="col-md-3">{{ __('orders.admin.list.total_col') }}</th>
                    <th class="col-md-4">{{ __('post.admin.list.action_col') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($orders as $order)
                  <tr>
                    <td>{{ $order['user']->username }}</td>
                    <td id='status{{ $order['id'] }}'>
                        @if ($order['status'] ) 
                          {{ __('common.approve') }}
                        @else
                          {{ __('common.pending') }}
                        @endif
                    </td>
                    <td>{{ number_format($order['total']) }}</td>
                    <td>
                      <form action="" class="col-md-4" method="POST">
                        @method('PUT')
                        @csrf
                        <button id="update{{ $order['id'] }}" onclick="updateStatus(event, {{ $order['id'] }}, '{{ route('admin.posts.update.status', ['id' => $order['id']]) }}')" class="btn btn-primary update-btn" type="button">
                          @if ($order['status'])
                            <i class="fa fa-times-circle icon-size" ></i>
                          @else
                            <i class="fa fa-check-circle icon-size" ></i>
                          @endif
                        </button>
                      </form>
                      <form action="{{ route('admin.orders.destroy', ['id' => $order['id']]) }}" class="col-md-4" method="POST" id="delete{{ $order['id'] }}">
                        @csrf
                        @method('DELETE')
                        <button onclick="deletePost(event, {{ $order['id'] }})" class="btn btn-danger" type="submit"><i class="fa fa-trash icon-size" ></i></button>
                      </form>
                      <form action="{{ route('admin.orders.show', ['id' => $order['id']]) }}" class="col-md-4">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-eye icon-size" ></i></button>
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
