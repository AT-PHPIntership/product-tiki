let productsUri = '/products/';
let maxStar = 5;

if (window.sessionStorage.getItem('locale')) {
    Lang.setLocale(window.sessionStorage.getItem('locale'));
}
let limit = 10;
let urlRecommend = "/api/recommend?limit=" +limit;
let idCategoryRecommend = localStorage.getItem('idCategoryRecommend');
let idProductRecommend = localStorage.getItem('idProductRecommend');

if (!idCategoryRecommend && !idProductRecommend) {
    $('.recomment-product').hide();
} else {
    $('.recomment-product').show();
}
if (idCategoryRecommend) {
    urlRecommend += "&category_id=" + idCategoryRecommend;
}
if (idProductRecommend) {
    urlRecommend += "&product_id=" + idProductRecommend;
}

function generateProducts(data, selector, style) {
    let htmlProduct = '';
    data.forEach(product => {
        let stars = '';
        let id = product.id;
        let imagePath = product.image_path;
        let image;
        if (product.images.length > 0) {
            image = product.images[0].img_url;
        } else {
            image = 'img.jpg';
        }
        let name = product.name;
        let priceFormated = product.price_formated;
        let rate = Math.round(product.avg_rating);
        for (i=1; i<= maxStar; i++) {
            if (i <= rate) {
                stars += '<i class="fa fa-star blue-star" aria-hidden="true"></i>';
            }
            else {
                stars += '<i class="fa fa-star black-star" aria-hidden="true"></i>'
            }
        }
        $('#item-products').clone().attr({'style':'display:', 'id':selector + id}).addClass(style).insertBefore('#'+selector);
        $('#' + selector + id + ' .snipcart-thumb > a').attr('href', productsUri + id);
        $('#' + selector + id + ' .snipcart-thumb > a > img').attr('src', imagePath + image);
        $('#' + selector + id + ' .snipcart-thumb > p').text(name);
        $('#' + selector + id + ' .snipcart-thumb > .stars').html(stars);
        $('#' + selector + id + ' .snipcart-thumb > h4').append(priceFormated);
        $('#' + selector + id + ' .snipcart-details a').attr('href', productsUri + id);
    });
}

$(document).ready(function() {
    $('.locale').on('click', function (event) {
        event.preventDefault();
        url = $(this).attr('href');
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                window.sessionStorage.setItem('locale', response.locale);
                window.location.href = '/';
            }
        });
    });
    $.ajax({
        url: '/api/products?sortBy=quantity_sold&perpage=9',
        type: 'get',
        success: function(response) {
            generateProducts(response.result.data, 'top9news', 'col-md-4');
        }
    });
    $.ajax({
        url: '/api/products?sortBy=avg_rating&order=desc&perpage=9',
        type: 'get',
        success: function(response) {
            generateProducts(response.result.data, 'top9rating', 'col-md-4');
        }
    });
    $.ajax({
        url: '/api/products?sortBy=created_at&perpage=4',
        type: 'get',
        success: function(response) {
            generateProducts(response.result.data, 'top4', 'col-md-3');
        }
    });
});

function generateRecommend(data) {
    data.forEach(product => {
        let stars = '';
        let id = product.id;
        let imagePath = product.image_path;
        let image;
        if (product.images.length) {
            image = product.images[0].img_url;
        } else {
            image = 'img.jpg';
        }
        let name = product.name;
        let priceFormated = product.price_formated;
        let rate = Math.round(product.avg_rating);
        for (i=1; i<= maxStar; i++) {
            if (i <= rate) {
                stars += '<i class="fa fa-star blue-star" aria-hidden="true"></i>';
            }
            else {
                stars += '<i class="fa fa-star black-star" aria-hidden="true"></i>'
            }
        }
        $('#item_recommend').clone().attr({'style':'display:', 'id':'recommend' + id}).appendTo('.owl-carousel');
        $('#recommend' + id + ' .snipcart-thumb > a').attr('href', productsUri + id);
        $('#recommend' + id + ' .snipcart-thumb > a > img').attr('src', imagePath + image);
        $('#recommend' + id + ' .snipcart-thumb > p').text(name);
        $('#recommend' + id + ' .snipcart-thumb > .stars').html(stars);
        $('#recommend' + id + ' .snipcart-thumb > h4').append(priceFormated);
        $('#recommend' + id + ' .snipcart-details a').attr('href', productsUri + id);
    });
}

function loadRecommend(url) {
    $.ajax({
        url: url,
        type: "get",
        success: function(response) {
            generateRecommend(response.result);
            $('.list-recomment-product').each(function(){
                if ( $().owlCarousel ) {
                    var owl = $(this).find('.owl-carousel');
                    owl.owlCarousel({
                        loop: true,
                        nav: true,
                        dots: false,
                        margin: 15,
                        autoplay: true,
                        responsive:{
                            0:{
                                items: 1
                            },
                            767:{
                                items: 2
                            },
                            991:{
                                items: 3
                            },
                            1200: {
                                items: 4
                            }
                        }
                    });
                    owl.on('mousewheel', '.owl-stage', e => {
                        if (e.originalEvent.deltaY > 0) {
                            $('.owl-stage').trigger('next.owl');
                        } else {
                            $('.owl-stage').trigger('prev.owl');
                        }
                        e.preventDefault();
                    });  
                }
            });
            
        }
    });
}
loadRecommend(urlRecommend);
