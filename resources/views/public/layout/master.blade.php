<!--
author: W3layouts
author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title')</title>
    <!-- for-mobile-apps -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Super Market Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
    Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
      function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- //for-mobile-apps -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="/css/public/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link href="/css/public/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="/css/public/custom.css" rel="stylesheet" type="text/css" media="all" />
    <link href="/css/public/owl.carousel.css" rel="stylesheet">
    @yield('css')
    <!-- font-awesome icons -->
    <link href="/css/public/font-awesome.css" rel="stylesheet">
    <!-- //font-awesome icons -->

    <!-- js -->
    <script src="/js/public/route.js"></script>
    <script src="/js/public/jquery-1.11.1.min.js"></script>
    <!-- //js -->
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,100,100italic,200,200italic,300,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <!-- start-smoth-scrolling -->
    <script type="/text/javascript" src="/js/public/move-top.js"></script>
    <script type="/text/javascript" src="/js/public/easing.js"></script>
    <script type="/text/javascript">
      jQuery(document).ready(function($) {
        $(".scroll").click(function(event){
          event.preventDefault();
          $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
        });
      });
    </script>
    <script src="/js/messages.js"></script>
    <!-- start-smoth-scrolling -->
    @yield('css')
  </head>

  <body>
  <!-- header -->
    <div class="agileits_header">
      <div class="container">
        <div class="w3l_offers">
        </div>
        <div class="agile-login">
          <ul>
            <li>
              <div class="">
                <ul>
                  <li><a class="locale" href="{{ route('locale', ['locale' => 'en']) }}">{{ __('user/locale.en') }}</a></li>
                  <li><a class="locale" href="{{ route('locale', ['locale' => 'vi']) }}">{{ __('user/locale.vi') }}</a></li>
                </ul>
              </div>
            </li>
            <li>
              <div id="header-login" hidden>
                <ul>
                  <li><a href="{{ route('user.register') }}">{{ __('user/layout.register') }}</a></li>
                  <li><a href="{{ route('user.login') }}">{{ __('user/layout.login') }}</a></li>
                </ul>
              </div>
            </li>
            <li>
              <div id="header-logout" hidden>
                <ul>
                  <li><a href="{{ route('user.info') }}">{{ __('user/layout.profile') }}</a></li>
                  <li><a id="btn-logout" href="#">{{ __('user/layout.logout') }}</a></li>
                </ul>
              </div>
            </li>
          </ul>
        </div>
        <div class="product_list_header">
          <form action="#" method="post" class="last">
            <input type="hidden" name="cmd" value="_cart">
            <input type="hidden" name="display" value="1">
            <button class="w3view-cart" type="submit" name="submit" value=""><i class="fa fa-cart-arrow-down" aria-hidden="true"></i></button>
          </form>
        </div>
        <div class="clearfix"> </div>
      </div>
    </div>
    <div class="logo_products">
      <div class="container">
      <div class="w3ls_logo_products_left1">
        <ul class="phone_email">
          <li><i class="fa fa-phone" aria-hidden="true"></i>Order online or call us : (+0123) 234 567</li>
        </ul>
      </div>
      <div class="w3ls_logo_products_left">
        <h1><a href="{{ route('user.home') }}">{{ __('user/layout.page_name') }}</a></h1>
      </div>
      <div class="w3l_search">
        <form id="product-search" action="/products" method="post">
          <input type="search" name="name" placeholder="{{ __('user/layout.search') }}" required="">
          <button type="submit" class="btn btn-default search" aria-label="Left Align">
            <i class="fa fa-search" aria-hidden="true"> </i>
          </button>
          <div class="clearfix"></div>
        </form>
      </div>
        <div class="clearfix"> </div>
      </div>
    </div>
  <!-- //header -->
  <!-- navigation -->
    <div class="navigation-agileits">
      <div class="container">
        <nav class="navbar navbar-default">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header nav_2">
          <button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
          <ul class="nav navbar-nav">
            <li class="active"><a href="{{ route('user.home') }}" class="act">{{ __('user/layout.home') }}</a></li>
            <!-- Mega Menu -->

          </ul>
        </div>
        </nav>
      </div>
    </div>
  <!-- //navigation -->
  @yield('content')
    </div>
  </div>
    <!-- new -->
    <div class="newproducts-w3agile recomment-product">
      <div class="container">
        <h3>@lang('user/detail_product.recommend_product')</h3>
          <div class="list-recomment-product">
            <div class="owl-carousel">
            </div>
        </div>
      </div>
    </div>
  <!-- //new -->
  <div class="top_brand_left" id="item_recommend" style="display:none">
    <div class="hover14 column">
      <div class="agile_top_brand_left_grid">
        <div class="agile_top_brand_left_grid_pos">
        </div>
        <div class="agile_top_brand_left_grid1">
          <figure>
            <div class="snipcart-item block">
              <div class="snipcart-thumb">
                <a href=""><img title=" " alt=" " src=""></a>
                <p></p>
                <div class="stars"></div>
                <h4>$ </h4>
              </div>
              <div class="snipcart-details top_brand_home_details">
                <a href="">
                  <input type="submit" name="submit" value="{{ __('user/index.detail') }}" class="button">
                </a>
              </div>
            </div>
          </figure>
        </div>
      </div>
    </div>
  </div>
  <!-- //footer -->
    <div class="footer">
      <div class="container">
        <div class="w3_footer_grids">
          <div class="col-md-3 w3_footer_grid">
            <h3>Contact</h3>
            <ul class="address">
              <li><i class="glyphicon glyphicon-map-marker" aria-hidden="true"></i>1234k Avenue, 4th block, <span>New York City.</span></li>
              <li><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i><a href="mailto:info@example.com">info@example.com</a></li>
              <li><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i>+1234 567 567</li>
            </ul>
          </div>
          <div class="col-md-3 w3_footer_grid">
            <h3>Information</h3>
            <ul class="info">
              <li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="about.html">About Us</a></li>
              <li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="contact.html">Contact Us</a></li>
              <li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="short-codes.html">Short Codes</a></li>
              <li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="faq.html">FAQ's</a></li>
              <li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="products.html">Special Products</a></li>
            </ul>
          </div>
          <div class="col-md-3 w3_footer_grid">
            <h3>Category</h3>
            <ul class="info">
              <li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="groceries.html">Groceries</a></li>
              <li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="household.html">Household</a></li>
              <li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="personalcare.html">Personal Care</a></li>
              <li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="packagedfoods.html">Packaged Foods</a></li>
              <li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="beverages.html">Beverages</a></li>
            </ul>
          </div>
          <div class="col-md-3 w3_footer_grid">
            <h3>Profile</h3>
            <ul class="info">
              <li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="products.html">Store</a></li>
              <li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="checkout.html">My Cart</a></li>
              <li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="login.html">Login</a></li>
              <li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="registered.html">Create Account</a></li>
            </ul>
          </div>
          <div class="clearfix"> </div>
        </div>
      </div>
      <div class="footer-copy">
        <div class="container">
          <p>© 2018 Product Tiki. All rights reserved | Design by <a href="http://w3layouts.com/">Team AT Intern Spring PHP</a></p>
        </div>
      </div>
    </div>
    <div class="footer-botm">
      <div class="container">
        <div class="w3layouts-foot">
          <ul>
            <li><a href="#" class="w3_agile_facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a href="#" class="agile_twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
            <li><a href="#" class="w3_agile_dribble"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
            <li><a href="#" class="w3_agile_vimeo"><i class="fa fa-vimeo" aria-hidden="true"></i></a></li>
          </ul>
        </div>
        <div class="clearfix"> </div>
      </div>
    </div>
  <!-- //footer -->
  <!-- Bootstrap Core JavaScript -->
  <script src="/js/public/bootstrap.min.js"></script>

  <!-- top-header and slider -->
  <!-- here stars scrolling icon -->
    <!-- <script type="text/javascript">
      $(document).ready(function() {
        /*
          var defaults = {
          containerID: 'toTop', // fading element id
          containerHoverID: 'toTopHover', // fading element hover id
          scrollSpeed: 1200,
          easingType: 'linear'
          };
        */

        $().UItoTop({ easingType: 'easeOutQuart' });

        });
    </script> -->
  <!-- //here ends scrolling icon -->
  <script src="/js/public/minicart.js"></script>
  <script>
    // Mini Cart
    paypal.minicart.render({
      action: '#'
    });

    if (~window.location.search.indexOf('reset=true')) {
      paypal.minicart.reset();
    }
  </script>
  <!-- main slider-banner -->
  <script src="/js/public/skdslider.min.js"></script>
  <link href="/css/public/skdslider.css" rel="stylesheet">
  <script type="text/javascript">
    jQuery(document).ready(function(){
      jQuery('#demo1').skdslider({'delay':5000, 'animationSpeed': 2000,'showNextPrev':true,'showPlayButton':true,'autoSlide':true,'animationType':'fading'});
      jQuery('#responsive').change(function(){
        $('#responsive_wrapper').width(jQuery(this).val());
      });
    });
  </script>
  <!-- //main slider-banner -->
  <script src="/js/public/main.js"></script>
  <script src="/js/public/master.js" charset="utf-8"></script>
  <script src="/js/public/category.js"></script>
  <script src="/js/public/masterpage.js"></script>
  <script src="/js/public/owl.carousel.js"></script>
  @yield('js')
  </body>
</html>
