var $url = document.location.pathname;
const TYPE_REVIEW = 1;
const TYPE_COMMENT = 2;
var user;

function textAreaEdit(id, content, type = TYPE_COMMENT, starRating = 5) {
    let starRatingHtml = '';
    if (type == TYPE_REVIEW) {
        starRatingHtml = $('#star-rating').clone();
        starRatingHtml.find('input[value="' + starRating + '"]').attr('checked', 'checked');
        starRatingHtml = starRatingHtml.wrap("<div />").parent().html();
    }
    let textAreaHtml = '<div class="quick-edit padding-tr-10px" hidden>'+
                            starRatingHtml+
                            '<textarea class="form-control edit-post-comment" placeholder="'+ Lang.get('user/detail_product.placeholder_input') +'" rows="5">' + content + '</textarea><span class="help-block text-left"></span>'+
                            '<div id="replies-errors-' + id + '" class="alert alert-danger" hidden></div>'+
                            '<div class="alert alert-info" hidden></div>'+
                            '<button type="button" class="btn btn-primary btn_edit margin-right-10px">'+ Lang.get('user/detail_product.send') +'</button>'+
                            '<button type="button" class="btn btn-default js-quick-edit-hide margin-right-10px">'+ Lang.get('user/detail_product.cancel') +'</button>'+
                        '</div>';
    return textAreaHtml;
}

function generatePosts(data) {
    if (localStorage.getItem('userLogin')) {
        user = JSON.parse(localStorage.getItem('userLogin'));
    }
    html = '';
    data.forEach(posts => {
        let id = posts.id;
        let url = posts.image_path;
        let image = posts.user.user_info.avatar;
        let name = posts.user.user_info.full_name;
        let diffTime = posts.diff_time;
        let content = posts.content;
        let stars = '';
        let editArea = '';
        let ownerAction = '';
        if (user && posts.user_id == user.id) {
            ownerAction = '<button class="btn btn-success edit-post margin-right-10px" data-review-id="1105262" id='+ id +'>'+ Lang.get('product.index.edit') +'</button>'+
                          '<button class="btn btn-danger delete-post margin-right-10px" data-review-id="1105262" id='+ id +'>'+ Lang.get('product.index.delete') +'</button>';
        }
        if (posts.type == TYPE_REVIEW) {
            let rate = Math.round(posts.rating);
            editArea = textAreaEdit(id, content, posts.type, rate);
            for (i = 1; i <= 5; i++) {
                if (i <= rate) {
                    stars += '<i class="fa fa-star blue-star" aria-hidden="true"></i>';
                }
                else {
                    stars += '<i class="fa fa-star black-star" aria-hidden="true"></i>'
                }
            }
        }
        html += '<div class="item posts" data-id="' + id + '" itemprop="review" itemtype="http://schema.org/Review">'+
                    '<div class="product-col-1 col-md-2">'+
                        '<p class="image">'+
                            '<img src="' + url + image + '">'+
                        '</p>'+
                        '<p class="name user-info" itemprop="author">'+ name +'</p>'+
                        '<p class="diff_time">'+ diffTime +'</p>'+
                    '</div>'+
                    '<div class="product-col-2 col-md-10">'+
                        '<div class="area-edit-post">'+
                            editArea+
                        '</div>'+
                        '<div class="infomation">'+
                            '<span class="starRating">'+ stars +'</span>'+
                        '</div>'+

                        '<div class="description js-description">'+
                            '<p class="review_detail replies-text" itemprop="reviewBody">'+
                            '<span>'+ content + '</span>'+
                            '</p>'+
                            '<div class="owner-action">'+
                                '<button type="button" class="btn btn-primary add-comment margin-right-10px">'+ Lang.get('user/detail_product.reply') +'</button>'+
                                ownerAction +
                            '</div>'+
                        '</div>'+
                        '<div class="quick-reply padding-tr-10px">'+
                            '<textarea class="form-control review_comment" placeholder="'+ Lang.get('user/detail_product.placeholder_input') +'" rows="5"></textarea><span class="help-block text-left"></span>'+
                            '<button class="btn btn-primary btn_add_comment" data-review-id="1105262">'+ Lang.get('user/detail_product.send') +'</button>'+
                            '<button class="btn btn-default js-quick-reply-hide">'+ Lang.get('user/detail_product.cancel') +'</button>'+
                        '</div>'+
                        '<div id="replies'+id+'"></div>'+
                    '</div>'+
                '</div>';
                getComments(id);
    });
    $('#posts-list').append(html);

}

function getComments(id) {
    $.ajax({
        url: '/api/posts/'+ id + '/comments',
        type: 'get',
        header: {
            'Accept': 'application/json',
        },
        success: function(response) {
            html = '';
            response.result.data.forEach(comments => {
                let url = comments.image_path;
                let image = comments.user.user_info.avatar;
                let name = comments.user.user_info.full_name;
                let content = comments.content;
                let ownerAction = '';
                let editArea = textAreaEdit(comments.id, content, TYPE_COMMENT);
                if (user && comments.user_id == user.id) {
                    ownerAction = '<button class="btn btn-success edit-comment margin-right-10px" data-review-id="1105262" id='+ comments.id +'>'+ Lang.get('product.index.edit') +'</button>'+
                                  '<button onclick="deleteComment()" class="btn btn-danger delete-comment margin-right-10px" data-review-id="1105262" id='+ comments.id +'>'+ Lang.get('product.index.delete') +'</button>';
                }
                html += '<div id="replies-item-'+ comments.id +'" class="replies-item padding-tr-10px">\
                            <div class="rep-info-user">\
                                <p class="replies-image rep-custom">\
                                    <img src="'+ url + image +'">\
                                </p>\
                                <p class="replies-name rep-custom">'+ name +'</p>\
                            </div>\
                            <div class="text-area-edit-comment margin-left-10">\
                            ' + editArea + '\
                            </div>\
                            <p class="replies-text">\
                                <span>'+ content + '</span>\
                            </p>\
                            <div class="comment-owner-action margin-left-10  padding-tr-10px">\
                            ' + ownerAction + '\
                            </div>\
                        </div>';

            });
            $('#replies'+id).append(html);

        }
    })
}

function getAjax(url) {
    $.ajax({
        url: url,
        type: "get",
        header: {
            'Accept': 'application/json',
        },
        success: function(response) {
            generatePosts(response.result.data);
        }
    });
};

function submitPost(pathName) {
    let typePost = TYPE_COMMENT;
    if ($('.rating1 .starRating input:checked').val()) {
        typePost = TYPE_REVIEW;
    }

    $.ajax({
        url: '/api' + pathName + '/posts',
        type: 'post',
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('login-token'),
        },
        data: {
            type: typePost,
            rating: $('.rating1 .starRating input:checked').val(),
            content: $('#addReviewFrm .review-content #review_detail').val(),
        },
        success: function(response) {
            $('#addReviewFrm .review-content .alert-info').show();
        },
        error: function(response) {
            errorMessage = response.responseJSON.message + '<br/>';
            if (response.responseJSON.errors) {
                errors = Object.keys(response.responseJSON.errors);
                errors.forEach(error => {
                    errorMessage += response.responseJSON.errors[error] + '<br/>';
                });
            }
            $('#addReviewFrm .review-content .alert-danger').html(errorMessage);
            $('#addReviewFrm .review-content .alert-danger').show();
        }
    });
}

getAjax('/api' + $url + '/posts');
$(document).ready(function() {
    $(document).on('click', '.rating1 .starRating input', function() {
        if ($(this).attr('checked') == 'checked') {
            $(this).attr('checked', false);
            $(this).siblings().attr('checked', false);
        } else {
            $(this).attr('checked', true);
            $(this).siblings().attr('checked', false);
        }
    });

    $(document).on('click', '#addReviewFrm .action .btn-add-review', function(event) {
        event.preventDefault();
        submitPost($url);
    });

    $(document).on('click', '#posts-list .item .add-comment', function() {
        $(this).closest('.item').find('.owner-action').hide();
        $(this).closest('.item').find('.quick-reply').show();
        $(this).closest('.item').find('.quick-reply .review_comment').focus();
    });

    $(document).on('click', '#posts-list .item .js-quick-reply-hide', function() {
        $(this).closest('.item').find('.quick-reply').hide();
        $(this).closest('.item').find('.owner-action').show();
    });

    $(document).on('click', '#posts-list .item .js-quick-edit-hide', function() {
        $(this).closest('.item').find('.quick-edit').hide();

        $(this).closest('.item').find('.infomation').show();
        $(this).closest('.item').find('.review_detail').show();
        $(this).closest('.item').find('.owner-action').show();
        $(this).closest('.item').find('.comment-owner-action').show();
        $(this).closest('.item').find('.replies-text').show();
    });

    $(document).on('click', '#posts-list .item .edit-post', function() {
        $(this).closest('.item').find('.owner-action').hide();
        $(this).closest('.item').find('.infomation').hide();
        $(this).closest('.item').find('.review_detail').hide();

        $(this).closest('.item').find('.area-edit-post .quick-edit').show();
        $(this).closest('.item').find('.area-edit-post .edit-post-comment').focus();
    });

    $(document).on('click', '#posts-list .item .edit-comment', function() {
        $(this).closest('.replies-item').find('.comment-owner-action').hide();
        $(this).closest('.replies-item').find('.replies-text').hide();

        $(this).closest('.replies-item').find('.quick-edit').show();
        $(this).closest('.replies-item').find('.quick-edit .edit-post-comment').focus();
    });
});

function deleteComment() {
    $(document).on('click', '.delete-comment', function() {
        var commentId = $(this).attr('id');
        //console.log(commentId);
        confirm(Lang.get('messages.delete_record'));
        $.ajax({
            url: '/api/comments/' + commentId,
            type: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + accessToken,
            },
            success: function(result) {
                $('#replies-item-'+commentId).remove();
            },
            error: function(result) {
                alert(result.responseJSON.error);
            }
        });
    })
}
