@extends('public.layout.master')
@section('title', __('user/master.title.detail'))
@section('css')
  <link href="/css/public/custom.css" rel="stylesheet">
@endsection
@section('content')
<!-- breadcrumbs -->
  <div class="breadcrumbs">
    <div class="container">
      <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
        <li><a href="{{ route('user.home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>@lang('user/layout.home')</a></li>
        <li class="active">@lang('user/product.single_page')</li>
      </ol>
    </div>
  </div>
<!-- //breadcrumbs -->
  <div class="products">
    <div class="container">
      <div class="agileinfo_single">
        <div class="col-md-4 ">
          <div class="agileinfo_single_left">

          </div>
          <div class="sub-images">
            <ul class="sub-images-list">

            </ul>
          </div>
        </div>
        <div class="col-md-8 agileinfo_single_right">
          <h2></h2>
          <div class="rating1">
            <span class="starRating">

            </span>
            <!-- ID  XRATING -->
          </div>
          <div class="w3agile_description">
            <h4>@lang('user/product.show.preview') :</h4>
            <p></p>
          </div>
          <div class="snipcart-item block">
            <div class="snipcart-thumb agileinfo_single_right_snipcart">
              <h4 class="m-sing"></h4>
            </div>
            <div class="snipcart-details agileinfo_single_right_details width-50">
              <form action="#" method="post">
                <fieldset>
                  <input type="hidden" name="cmd" value="_cart">
                  <input type="hidden" name="add" value="1">
                  <input type="hidden" name="business" value="">
                  <input type="hidden" name="item_name" value="">
                  <input type="hidden" name="amount" value="">
                  <input type="hidden" name="discount_amount" value="">
                  <input type="hidden" name="currency_code" value="USD">
                  <input type="hidden" name="return" value="">
                  <input type="hidden" name="cancel_return" value="">
                  <input type="submit" name="submit" value="Add to cart" class="button width-49">
                  <input id="product_compare_btn" type="submit" value="Compare" class="button btn-success width-49">
                </fieldset>
              </form>
            </div>
          </div>
        </div>
        <div class="clearfix"> </div>
        <div class="description-detail">
          <h4>@lang('user/product.show.description') :</h4>
          <p></p>
        </div>
      </div>
    </div>
  </div>
  <div class="review">
    <div class="container review-background">
      <h3 class="js-customer-h3" style="display: block;font-size: 30px;text-align:  center;">@lang('user/detail_product.send_cmt_message')</h3>
      <div class="product-customer-col-4 js-customer-col-4" style="display: block;">
        <form action="" method="post" id="addReviewFrm" novalidate="novalidate" class="bv-form"><button type="submit" class="bv-hidden-submit" style="display: none; width: 0px; height: 0px;"></button>
          <input type="hidden" name="entity_pk_value" value="917986" id="entity_pk_value">
          <input type="hidden" name="productset_id" value="58" id="productset_id">
          <div class="rate form-group has-feedback" id="rating_wrapper">
            <label>1. @lang('user/detail_product.rating_message'):</label>
            <div id='star-rating' class="rating1">
              <span class="starRating">
                <input id="rating5" type="radio" name="rating" value="5">
                <label for="rating5">5</label>
                <input id="rating4" type="radio" name="rating" value="4">
                <label for="rating4">4</label>
                <input id="rating3" type="radio" name="rating" value="3">
                <label for="rating3">3</label>
                <input id="rating2" type="radio" name="rating" value="2">
                <label for="rating2">2</label>
                <input id="rating1" type="radio" name="rating" value="1">
                <label for="rating1">1</label>
              </span>
            </div>
            <div class="review-content form-group has-feedback has-error">
              <label for="review_detail">2. @lang('user/detail_product.review_message'):</label>
              <textarea placeholder="@lang('user/detail_product.post_message')" class="form-control" name="detail" id="review_detail" cols="30" rows="10" data-bv-field="detail"></textarea><i class="form-control-feedback fa fa-close" data-bv-icon-for="detail"></i>
              <div class="alert alert-info" hidden>@lang('user/detail_product.send_success')</div>
              <div id="dob_error" class="alert alert-danger" hidden></div>
            </div>
            <div class="action">
              <div class="word-counter"></div>
              <button class="btn btn-default btn-add-review ">@lang('user/detail_product.btn_send_cmt')</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="product-review-box">
    <div class="container review-background">
      <div class="product-review-content">
        <div id="product-review-box">
      <div data-reactroot="">
      <div class="review-filter">
        <span>{{ __('user/detail_product.let_see_review') }}</span>
        <div class="btn-group dropdown filter-post sort-type">
          <button class="btn btn-default btn-sm dropdown-toggle font-14" type="button" data-toggle="dropdown" aria-expanded="false"><span class="title">{{ __('user/detail_product.review') }}</span><span class="caret"></span></button>
          <ul class="sort-list dropdown-menu" role="menu">
            <li class="selected"><a href="javascript:void(0);">{{ __('user/detail_product.review') }}</a></li>
            <li class=""><a href="javascript:void(0);">{{ __('user/detail_product.comment') }}</a></li>
          </ul>
        </div>
        <div class="btn-group dropdown filter-post sort-rating">
          <button class="btn btn-default btn-sm dropdown-toggle font-14" type="button" data-toggle="dropdown" aria-expanded="false"><span class="title">{{ __('user/detail_product.five_star') }}</span><span class="caret"></span></button>
          <ul class="sort-list dropdown-menu" role="menu">
            <li class="selected" data-star="5"><a href="javascript:void(0);">{{ __('user/detail_product.five_star') }}</a></li>
            <li class="" data-star="4"><a href="javascript:void(0);">{{ __('user/detail_product.four_star') }}</a></li>
            <li class="" data-star="3"><a href="javascript:void(0);">{{ __('user/detail_product.three_star') }}</a></li>
            <li class="" data-star="2"><a href="javascript:void(0);">{{ __('user/detail_product.two_star') }}</a></li>
            <li class="" data-star="1"><a href="javascript:void(0);">{{ __('user/detail_product.one_star') }}</a></li>
          </ul>
        </div>
      </div>
      <div class="review-list" id="posts-list">

      </div>
    </div>
  </div>
</div>
</div>
<!-- new -->
  <div class="newproducts-w3agile">
    <div class="container">
      <h3>{{ __('user/index.title-new-offers') }}</h3>
        <div class="agile_top_brands_grids">
          <div id="top4"></div>
        <div class="clearfix"> </div>
    </div>
  </div>
<!-- //new -->
<!-- modal -->
<div class="modal fade" id="product_compare" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" hidden>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">{{ __('user/detail_product.compare_product_title') }}</h4>
      </div>
      <div class="modal-body">

          <form id="demo-form2" method="GET" class="form-horizontal form-label-left">

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('user/detail_product.select_product') }}</label>
              <div class="col-md-6 col-sm-6 col-xs-12">

                <div class="btn-group dropdown category_select">
                  <button class="btn btn-primary btn-sm dropdown-toggle font-14" type="button" data-toggle="dropdown" aria-expanded="false"><span class="title">{{ __('messages.categories') }}</span><span class="caret"></span></button>
                  <ul class="category-list dropdown-menu" role="menu">

                  </ul>
                </div>

                <div class="btn-group dropdown product_select">
                  <button class="btn btn-success btn-sm dropdown-toggle font-14" type="button" data-toggle="dropdown" aria-expanded="false"><span class="title">{{ __('messages.products') }}</span><span class="caret"></span></button>
                  <ul class="product-list dropdown-menu multi-column columns-3" role="menu">

                    <div class="row">
                      <ul class="multi-column-dropdown">

                      </ul>
                    </div>

                    <a id="get_more_product" href="#" hidden>{{ __('user/profile.next') }}</a>
                  </ul>
                </div>

              </div>
            </div>

            <div id="product_compare_table" class="form-group" hidden>
              <table class="data table table-striped no-margin">
                <thead>
                  <tr>
                    <th class="col-md-2 key-compare">{{ __('user/detail_product.keys') }}</th>
                    <th class="col-md-4 product-base"></th>
                    <th class="col-md-4 product-compare"></th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>

          </form>

      </div>
    </div>
  </div>
</div>
<!-- //modal -->
@endsection
@section('js')
<script src="/js/public/details.js"></script>
<script src="/js/public/posts.js"></script>
@endsection
