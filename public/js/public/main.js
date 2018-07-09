let productsUri = '/products/';
let maxStar = 5;

if (window.sessionStorage.getItem('locale')) {
    Lang.setLocale(window.sessionStorage.getItem('locale'));
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
        $('#item-products').clone().attr({'style':'display:', 'id':id}).addClass(style).insertBefore('#'+selector);
        $('#' + id + ' .snipcart-thumb > a').attr('href', productsUri + id);
        $('#' + id + ' .snipcart-thumb > a > img').attr('src', imagePath + image);
        $('#' + id + ' .snipcart-thumb > p').text(name);
        $('#' + id + ' .snipcart-thumb > .stars').html(stars);
        $('#' + id + ' .snipcart-thumb > h4').append(priceFormated);
        $('#' + id + ' .snipcart-details a').attr('href', productsUri + id);
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
