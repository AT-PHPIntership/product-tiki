$(document).ready(function () {
    var categoryRecommend = window.location.search;
    var arrUrl = categoryRecommend.split("=");
    var idCategoryRecommend =  arrUrl[(categoryRecommend.split("=").length-1)];

    localStorage.setItem('idCategoryRecommend', idCategoryRecommend);
    var url = '';
    if (window.location.search == "") {
        url = api.api_products_index;
    } else {
        url = api.api_products_index + window.location.search;
    }

    $('.rating-filter').click(function() {
        if (url.indexOf('?') > 0) {
            url += '&rating=' + $(this).val();
        } else {
            url += '?rating=' + $(this).val();
        }
        $('#product-list').html('');
        getProductList(url);
    });

    $('.price-filter').click(function() {
        if (url.indexOf('?') > 0) {
            url += '&price=' + $(this).val();
        } else {
            url += '?price=' + $(this).val();
        }
        $('#product-list').html('');
        getProductList(url);
    });

    $(document).on('change', '#country', function () {
        sortBy = $('#country').val();
        if (url.indexOf('?') > 0) {
            url += '&sortBy='+sortBy;
        } else {
            url += '?sortBy='+sortBy;
        }
        if (sortBy === 'rating' || sortBy === 'price') {
            url += '&order=DESC';
        }
        $('#product-list').html('');
        getProductList(url);
    })

    getProductList(url);

    function generateProductList(product) {
        html = '';
        if (product.images.length == 0) {
            src_img = product['image_path'] + 'img.jpg';
        } else {
            src_img = product['image_path'] + product['images'][0]['img_url'];
        }
        stars = '';
        rate = Math.round(product['avg_rating']);
        for (i = 1; i <= 5; i++) {
           if (i <= rate) {
               stars += '<i class="fa fa-star blue-star" aria-hidden="true"></i>';
           }
           else {
               stars += '<i class="fa fa-star black-star" aria-hidden="true"></i>'
           }
       }

        html += '<div class="col-md-4 top_brand_left">\
                    <div class="hover14 column">\
                        <div class="agile_top_brand_left_grid">\
                            <div class="agile_top_brand_left_grid_pos">\
                                <img src="/images/Example/offer.png" alt=" " class="img-responsive">\
                            </div>\
                            <div class="agile_top_brand_left_grid1">\
                            <figure>\
                                <div class="snipcart-item block">\
                                  <div class="snipcart-thumb">\
                                    <a href="'+ api.products_index +'/'+ product['id'] +'"><img title=" " alt=" " src="'+ src_img +'"></a>\
                                    <p>'+ product['name'] +'</p>\
                                    <div class="stars">' + stars + '</div>\
                                    <h4>'+ product['price_formated'] +'</h4>\
                                  </div>\
                                </div>\
                            </figure>\
                            <div class="detail-link">\
                                <a href="" class="btn btn-warning">Details</a>\
                            </div>\
                        </div>\
                        </div>\
                </div>';
        $('#product-list').append(html);
    }

    $('#next').click(function (event) {
        event.preventDefault();
        url_next = $('#next').attr('href');
        getProductList(url_next);
    })

    function getProductList(url) {
        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                if (response.result.paginator['next_page_url'] != null) {
                    $('#next').show();
                    $('#next').attr('href', response.result.paginator['next_page_url']);
                } else {
                    $('#next').hide();
                }
                response.result.data.forEach(product => {
                    generateProductList(product);
                });
            }
        });
    }
});
