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

loadPage();
function recommendProduct() {
    $('.list-recomment-product').each(function(){
        if ( $().owlCarousel ) {
            $(this).find('.owl-carousel').owlCarousel({
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
        }
    });
};
$(document).ready(function() {
    $(document).on('mousewheel', '.owl-stage', function (e) {
        if (e.delta>0) {
            $('.owl-stage').trigger('next.owl');
        } else {
            $('.owl-stage').trigger('prev.owl');
        }
        e.preventDefault();
    });
    recommendProduct();
});
