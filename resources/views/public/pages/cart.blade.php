@extends('public.layout.master')
@section('title', __('user/cart.title'))
@section('content')
<!-- breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
      <ol class="breadcrumb breadcrumb1">
        <li><a href="index.html"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>{{ __('user/layout.home') }}</a></li>
        <li class="active">{{ __('user/cart.title') }}</li>
      </ol>
    </div>
  </div>
<!-- //breadcrumbs -->
<!-- checkout -->
  <div class="checkout">
    <div class="container">
      <h2>{{ __('user/cart.my_cart_page.cart_contain_text') }} <span>3 Products</span></h2>
      <div class="checkout-right">
        <table class="timetable_sub">
          <thead>
            <tr>
              <th>{{ __('user/cart.my_cart_page.index') }}</th>
              <th>{{ __('user/cart.my_cart_page.product') }}</th>
              <th>{{ __('user/cart.my_cart_page.quantity') }}</th>
              <th>{{ __('user/cart.my_cart_page.product_name') }}</th>
              <th>{{ __('user/cart.my_cart_page.price') }}</th>
              <th>{{ __('user/cart.my_cart_page.remove') }}</th>
            </tr>
          </thead>
          <tr class="rem1">
            <td class="invert">1</td>
            <td class="invert-image"><a href="single.html"><img class="image-product-cart" src="http://192.168.21.12/images/upload/img.jpg" alt=" " class="img-responsive" /></a></td>
            <td class="invert">
               <div class="quantity">
                <div class="quantity-select">
                  <div class="entry value-minus">&nbsp;</div>
                  <input class="entry value no-spinners" type="number" value="0" min="0" max="10"/>
                  <div class="entry value-plus active">&nbsp;</div>
                </div>
              </div>
            </td>
            <td class="invert">Tata Salt</td>

            <td class="invert">$290.00</td>
            <td class="invert">
              <div class="rem">
                <div class="close1"> </div>
              </div>
            </td>
          </tr>
        </table>
      </div>
      <div class="checkout-left">
        <div class="checkout-left-basket">
          <a href="#">{{ __('user/cart.my_cart_page.order_submit') }}</a>
          <a href="#">{{ __('user/cart.my_cart_page.add_coupon_code') }}</a>
          <ul>
            <li>Product1 <i>-</i> <span>$15.00 </span></li>
            <li>Product2 <i>-</i> <span>$25.00 </span></li>
            <li>Product3 <i>-</i> <span>$29.00 </span></li>
            <li>Total Service Charges <i>-</i> <span>$15.00</span></li>
            <li>{{ __('user/cart.my_cart_page.total') }} <i>-</i> <span>$84.00</span></li>
          </ul>
        </div>
        <div class="checkout-right-basket">
          <a href="single.html"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>{{ __('user/cart.my_cart_page.go_to_shopping') }}</a>
        </div>
        <div class="clearfix"> </div>
      </div>
    </div>
  </div>
<!-- //checkout -->
@endsection
@section('js')
<script src="/js/public/cart.js"></script>
@endsection
