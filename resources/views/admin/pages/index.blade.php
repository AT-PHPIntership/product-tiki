@extends('admin.layout.master')
@section('title', __('homepage.admin.title'))
@section('css')
  <link rel="stylesheet" href="/css/admin/homepage.css">
@endsection
@section('content')

<div class="right_col" role="main">
  <div class="">
    <div class="row top_tiles">
      <div class="x_title col-md-12">
        <a class="btn col-md-3 @if (app('request')->input('time') == config('define.homepage.time.month') || !app('request')->input('time')) active-filter @endif" href="{{ route('admin.homepage', ['time' => 'month']) }}">{{ __('homepage.admin.statistic.monthly') }}</a>
        <a class="btn col-md-3 @if (app('request')->input('time') == config('define.homepage.time.year')) active-filter @endif" href="{{ route('admin.homepage', ['time' => 'year']) }}">{{ __('homepage.admin.statistic.annually') }}</a>
        <a class="btn col-md-3 @if (app('request')->input('time') == config('define.homepage.time.week')) active-filter @endif" href="{{ route('admin.homepage', ['time' => 'week']) }}">{{ __('homepage.admin.statistic.weekly') }}</a>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-user"></i></div>
          <div class="count">{{ $countNewUsers }}</div>
          <h3>{{ __('homepage.admin.new_users') }}</h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-comments-o"></i></div>
          <div class="count">{{ $countNewPosts }}</div>
          <h3>{{ __('homepage.admin.new_posts') }}</h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-list-alt"></i></div>
          <div class="count">{{ $countNewOrders }}</div>
          <h3>{{ __('homepage.admin.new_orders') }}</h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-balance-scale"></i></div>
          <div class="count">{{ $productSold }}</div>
          <h3>{{ __('homepage.admin.product_sold') }}</h3>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <div class="x_panel">
          <div class="x_title">
            <h2 class="col-md-8">{{ __('homepage.admin.top_rating_product') }} </h2>
            <ul class="nav navbar-right panel_toolbox">
              <li>
                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
            <small class="col-md-6">{{ __('homepage.admin.time.all') }}</small>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            @foreach ($topRating as $index => $product)
              <div class="media event">
                <a class="pull-left date">
                  <p class="month">{{ __('homepage.admin.top_text') }}</p>
                  <p class="day">{{ ++$index }}</p>
                </a>
                <div class="media-body">
                  <a class="title" href="{!! route('admin.products.edit', ['id' => $product['id']]) !!}">
                    <div class="details">
                      <p>{{ $product->name }}</p>
                      <p>{{ $product->category->name }}</p>
                      <p>{{ $product->avg_rating.' '.__('homepage.admin.avg_rating') }}</p>
                    </div>
                  </a>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="x_panel">
          <div class="x_title">
            <h2 class="col-md-8">{{ __('homepage.admin.top_active_user') }}</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li>
                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-hourglass"></i></a>
                <ul class="dropdown-menu dropdown-user" role="menu">
                  <li>
                    <a href="{{ route('admin.api.home', ['type' => config('define.homepage.type.user')]) }}">{{ __('homepage.admin.time.all') }}</a>
                  </li>
                  <li>
                    <a href="{{ route('admin.api.home', ['type' => config('define.homepage.type.user'), 'time' => config('define.homepage.time.week')]) }}">{{ __('homepage.admin.time.week') }}</a>
                  </li>
                  <li>
                    <a href="{{ route('admin.api.home', ['type' => config('define.homepage.type.user'), 'time' => config('define.homepage.time.month')]) }}">{{ __('homepage.admin.time.month') }}</a>
                  </li>
                  <li>
                    <a href="{{ route('admin.api.home', ['type' => config('define.homepage.type.user'), 'time' => config('define.homepage.time.year')]) }}">{{ __('homepage.admin.time.year') }}</a>
                  </li>
                </ul>
              </li>
            </ul>
            <small class="col-md-6" id="user_time">{{ __('homepage.admin.time.all') }}</small>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            @foreach ($users as $index => $user)
              <div class="media event">
                <a class="pull-left date">
                  <p class="month">{{ __('homepage.admin.top_text') }}</p>
                  <p class="day">{{ ++$index }}</p>
                </a>
                <div class="media-body">
                  <a id="user_route_{{ $index }}" data-id="user_route_{{ $index }}" class="title user_route" href="{{ route('admin.users.show', array('id' => $user->id)) }}">
                    <div class="details">
                      <p id="user_name_{{ $index }}">{{ $user->userInfo->full_name }}</p>
                      <p id="user_email_{{ $index }}">{{ $user->email }}</p>
                      <p ><span id="user_point_{{ $index }}">{{ $user->point }} </span> {{ __('homepage.admin.post_comments') }}</p>
                    </div>
                  </a>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="x_panel">
          <div class="x_title">
            <h2 class="col-md-8">{{ __('homepage.admin.top_worth_order') }} </h2>
            <ul class="nav navbar-right panel_toolbox">
              <li>
                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-hourglass"></i></a>
                <ul class="dropdown-menu dropdown-order" role="menu">
                  <li><a href="{{ route('admin.api.home', ['type' => config('define.homepage.type.order')]) }}">{{ __('homepage.admin.time.all') }}</a></li>
                  <li><a href="{{ route('admin.api.home', ['type' => config('define.homepage.type.order'), 'time' => config('define.homepage.time.week')]) }}">{{ __('homepage.admin.time.week') }}</a></li>
                  <li><a href="{{ route('admin.api.home', ['type' => config('define.homepage.type.order'), 'time' => config('define.homepage.time.month')]) }}">{{ __('homepage.admin.time.month') }}</a></li>
                  <li><a href="{{ route('admin.api.home', ['type' => config('define.homepage.type.order'), 'time' => config('define.homepage.time.year')]) }}">{{ __('homepage.admin.time.year') }}</a></li>
                </ul>
              </li>
            </ul>
            <small class="col-md-6" id="order_time">{{ __('homepage.admin.time.all') }}</small>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            @foreach ($topOrders as $index => $order)
              <div class="media event">
                <a class="pull-left date">
                  <p class="month">{{ __('homepage.admin.top_text') }}</p>
                  <p class="day">{{ ++$index }}</p>
                </a>
                <div class="media-body">
                  <a id="order_route_{{ $index }}" data-id="order_route_{{ $index }}" class="title order_route" href="{{ route('admin.orders.show', ['id' => $order['id']]) }}">
                    <div class="details">
                      <p id="order_username_{{ $index }}">{{ $order->user->username }}</p>
                      <p id="order_total_{{ $index }}">{{ number_format($order->total) }}</p>
                      <p ><span id="order_product_count_{{ $index }}">{{ $order->orderdetails_count }}</span> {{ __('homepage.admin.product_count') }}</p>
                    </div>
                  </a>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@section('js')
  <script src="/js/admin/homepage.js"></script>
@endsection
@endsection
