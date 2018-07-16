function loadPage() {
    $.ajax({
        url: "/api" + window.location.pathname,
        type: "get",
        success: function(response) {
            let imagePath = response.result.image_path;
            let stars = '';
            let imageSub = '';
            let rate = Math.round(response.result.avg_rating);
            let currencyType = '$';
            const maxStar = 5;

            if (response.result.images.length > 0) {
                let imagePri = '<img id="example" src="' + imagePath + response.result.images[0].img_url + '" alt=" " class="img-responsive">';
                $('.agileinfo_single .col-md-4 .agileinfo_single_left').append(imagePri);
                response.result.images.forEach(image => {
                    imageSub = '<li class="col-md-4 sub-images-item"><div><img id="example" src="' + imagePath + image.img_url + '" alt=" " class="img-responsive"></div></li>';
                    $('.sub-images .sub-images-list').append(imageSub);
                });
            } else {
                let imagePri = '<img id="example" src="' + imagePath + 'img.jpg' + '" alt=" " class="img-responsive">';
                $('.agileinfo_single .col-md-4 .agileinfo_single_left').append(imagePri);
            }

            for (i = 1; i <= maxStar; i++) {
                if (i <= rate) {
                    stars += '<i class="fa fa-star blue-star" aria-hidden="true"></i>';
                }
                else {
                    stars += '<i class="fa fa-star black-star" aria-hidden="true"></i>';
                }
            }
            $('.agileinfo_single .agileinfo_single_right h2').append(response.result.name);
            $('.agileinfo_single .agileinfo_single_right .w3agile_description p').append(response.result.preview);
            $('.agileinfo_single > .description-detail p').append(response.result.description);
            $('.agileinfo_single .agileinfo_single_right .starRating').append(stars);
            $('.agileinfo_single .agileinfo_single_right .agileinfo_single_right_snipcart h4').append(currencyType + response.result.price_formated + '<span></span>');

            $('.agileinfo_single_right .agileinfo_single_right_details input[name="item_name"]').attr('value', response.result.name);
            $('.agileinfo_single_right .agileinfo_single_right_details input[name="amount"]').attr('value', response.result.price);
            $('.agileinfo_single_right .agileinfo_single_right_details form fieldset').append("<input type='hidden' name='id' value='"+ response.result.id +"'>");
        }
    });
}

function getCategories() {
    $.ajax({
        url: '/api/categories',
        type: 'GET',
        success: function(response) {
            let categoryHtml = '';
            response.result.forEach(categoryBase => {
                categoryHtml = '<li class="" category-id="' + categoryBase.id + '"><a href="javascript:void(0);"><strong>' + categoryBase.name + '</strong></a></li>';
                $('#product_compare .category_select .category-list').append(categoryHtml);
                if (categoryBase.children) {
                    categoryBase.children.forEach(categoryChild => {
                        categoryHtml = '<li class="" category-id="' + categoryChild.id + '"><a href="javascript:void(0);">' + categoryChild.name + '</a></li>';
                        $('#product_compare .category_select .category-list').append(categoryHtml);
                    });
                }
            });
        }
    });
}

function getProductList(categoryId, page) {
    let pageUrl = '';
    if (page) {
        pageUrl = '&page=' + page;
    } else {
        $('#product_compare .product-list .multi-column-dropdown').html('');
    }
    $.ajax({
        url: '/api/products?category=' + categoryId + '&perpage=20' + pageUrl,
        type: 'GET',
        success: function(response) {
            let productHtml = '';
            if (response.result.paginator.next_page_url) {
                $('#get_more_product').attr('page', response.result.paginator.current_page + 1);
                $('#get_more_product').attr('category-id', categoryId);
                $('#get_more_product').show();
            } else {
                $('#get_more_product').hide();
            }
            response.result.data.forEach(product => {
                productHtml = '<li class="col-sm-3" product-id="' + product.id + '"><a href="javascript:void(0);">' + product.name + '</a></li>';
                $('#product_compare .product-list .multi-column-dropdown').append(productHtml);
            });
        }
    });
}

function getProductComparision(productCompareId) {
    $.ajax({
        url: '/api' + location.pathname + '/compare/' + productCompareId,
        type: 'GET',
        success: function(response) {
            let metaKey = response.result.metaKey;
            $('#product_compare_table').show();
            $('#product_compare_table tbody').html('');
            let keys = Object.keys(metaKey);
            if (keys) {
                let keyCompareRow = '';
                keys.forEach(key => {
                    keyCompareRow = '<tr>\
                                        <td>' + metaKey[key] + '</td>\
                                        <td>' + response.result.metaBase[metaKey[key]] + '</td>\
                                        <td>' + response.result.metaCompare[metaKey[key]] + '</td>\
                                    </tr>';
                    $('#product_compare_table tbody').append(keyCompareRow);
                });
            }
        }
    });
}

$(document).ready(function() {
    var productRecommend = window.location.pathname;
    var arrUrl = productRecommend.split("/");
    var idProductRecommend =  arrUrl[(productRecommend.split("/").length-1)];
    
    localStorage.setItem('idProductRecommend', idProductRecommend);

    loadPage();
    getCategories();

    $(document).on('click', '#product_compare_btn', function(event) {
        event.preventDefault();
        $('#product_compare_table .product-base').html($('.agileinfo_single .agileinfo_single_right h2').html());
        $('#product_compare').modal('show');
    });

    $(document).on('click', '#product_compare .category-list li', function() {
        $(this).addClass('selected');
        $(this).siblings().removeClass('selected');
        $(this).closest('.category_select').find('.title').text($(this).text());
        $('#product_compare .modal-body .product_select').removeClass('hidden');
        getProductList($(this).attr('category-id'));

    });

    $(document).on('click', '#product_compare .product-list li', function() {
        $(this).addClass('selected');
        $(this).siblings().removeClass('selected');
        $(this).closest('.product_select').find('.title').text($(this).text());

        $('#product_compare_table .product-compare').html($(this).text());
        getProductComparision($(this).attr('product-id'));
    });

    $(document).on('click', '#get_more_product', function(event) {
        event.preventDefault();
        getProductList($(this).attr('category-id') ,$(this).attr('page'));
    });
});
