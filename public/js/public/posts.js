var $url = document.location.pathname;
const TYPE_REVIEW = 1;
const TYPE_COMMENT = 2;
var user;

function textAreaEdit(id, content, type = TYPE_COMMENT, starRating = maxStar) {
    let starRatingHtml = '';
    if (type == TYPE_REVIEW) {
        starRatingHtml = $('#star-rating').clone();
        for (let index = 1; index <= maxStar; index++) {
            starRatingHtml.find('input[id="rating' + index + '"]').prop('id', 'rating' + index + '-' + id).prop('name', 'rating-' + id);
            starRatingHtml.find('label[for="rating' + index + '"]').prop('for', 'rating' + index + '-' + id);
        }
        starRatingHtml.find('input[id="rating' + starRating + '-' + id + '"]').attr('checked', true);
        starRatingHtml = starRatingHtml.wrap('<div id="star-rating"><div/>').parent().html();
    }
    let textAreaHtml = '<div class="quick-edit padding-tr-10px" hidden>'+
                            starRatingHtml+
                            '<textarea class="form-control edit-post-comment" placeholder="'+ Lang.get('user/detail_product.placeholder_input') +'" rows="5">' + content + '</textarea><span class="help-block text-left"></span>'+
                            '<div id="replies-errors-' + id + '" class="alert alert-danger" hidden></div>'+
                            '<div class="alert alert-info" hidden></div>'+
                            '<button id="' + id + '" class="btn btn-primary btn_edit margin-right-10px">'+ Lang.get('user/detail_product.send') +'</button>'+
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
        let rate = Math.round(posts.rating);
        if (posts.type == TYPE_REVIEW) {
            for (i = 1; i <= 5; i++) {
                if (i <= rate) {
                    stars += '<i class="fa fa-star blue-star" aria-hidden="true"></i>';
                }
                else {
                    stars += '<i class="fa fa-star black-star" aria-hidden="true"></i>'
                }
            }
        }
        if (user && posts.user_id == user.id) {
            ownerAction = '<button class="btn btn-success edit-post margin-right-10px" data-review-id="1105262" id='+ id +'>'+ Lang.get('product.index.edit') +'</button>'+
            '<button class="btn btn-danger delete-post margin-right-10px" data-review-id="1105262" post-id=' + id + '>'+ Lang.get('product.index.delete') +'</button>';
            if (posts.type == TYPE_REVIEW) {
                editArea = textAreaEdit('post-' + id, content, posts.type, rate);
            } else {
                editArea = textAreaEdit('post-' + id, content);
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
                            '<div id="replies-errors-' + id + '" class="alert alert-danger" hidden></div>'+
                            '<div class="alert alert-info" hidden>' + Lang.get('user/detail_product.send_success') + '</div>'+
                            '<button class="btn btn-primary btn_add_comment" data-review-id="1105262" post-id='+ id +'>'+ Lang.get('user/detail_product.send') +'</button>'+
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
                let editArea = '';
                if (user && comments.user_id == user.id) {
                    editArea = textAreaEdit('comment-' + comments.id, content);
                    ownerAction = '<button class="btn btn-success edit-comment margin-right-10px" data-review-id="1105262" id='+ comments.id +'>'+ Lang.get('product.index.edit') +'</button>'+
                                  '<button class="btn btn-danger delete-comment margin-right-10px" data-review-id="1105262" id='+ comments.id +'>'+ Lang.get('product.index.delete') +'</button>';
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
                            <p id="replies-text-'+ comments.id +'" class="replies-text">\
                              <span id="com-content-'+ comments.id + '">'+ content + '</span>\
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
    $('#posts-list').html('');
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

function editPost(postId) {
    let typePost = TYPE_COMMENT;
    if ($('div[class="item posts"][data-id="' + postId + '"] .rating1 .starRating input:checked').val()) {
        typePost = TYPE_REVIEW;
    }
    $('div[class="item posts"][data-id="' + postId + '"] .quick-edit .alert-info').hide();
    $('div[class="item posts"][data-id="' + postId + '"] #replies-errors-post-' + postId).hide();

    $.ajax({
        url: '/api/posts/' + postId,
        type: 'put',
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('login-token'),
        },
        data: {
            type: typePost,
            rating: $('div[class="item posts"][data-id="' + postId + '"] .rating1 .starRating input:checked').val(),
            content: $('div[class="item posts"][data-id="' + postId + '"] .area-edit-post .edit-post-comment').val(),
        },
        success: function(response) {
            $('div[class="item posts"][data-id="' + postId + '"] .quick-edit .alert-info').html(Lang.get('common.edit_success') + '. ' + Lang.get('user/detail_product.edited_post_note'));
            $('div[class="item posts"][data-id="' + postId + '"] .quick-edit .alert-info').show();
        },
        error: function(response) {
            errorMessage = response.responseJSON.message + '<br/>';
            if (response.responseJSON.errors) {
                errors = Object.keys(response.responseJSON.errors);
                errors.forEach(error => {
                    errorMessage += response.responseJSON.errors[error] + '<br/>';
                });
            }
            $('div[class="item posts"][data-id="' + postId + '"] #replies-errors-post-' + postId).html(errorMessage);
            $('div[class="item posts"][data-id="' + postId + '"] #replies-errors-post-' + postId).show();
        }
    });
}

function deletePost(postId) {
    $.ajax({
        url: '/api/posts/' + postId,
        type: 'delete',
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('login-token'),
        },
        success: function(response) {
            alert(Lang.get('messages.delete_success'));
            $('div[class="item posts"][data-id="'+ postId + '"]').remove();
        },
        error: function(response) {
            alert(Lang.get('messages.delete_fail'));
        }
    });
}

function submitComment(postId) {
    $.ajax({
        url: '/api/posts/' + postId + '/comments',
        type: 'post',
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('login-token'),
        },
        data: {
            content: $('div[data-id="' + postId + '"] .quick-reply .review_comment').val(),
        },
        success: function(response) {
            $('div[data-id="' + postId + '"] .quick-reply .alert-info').show();
        },
        error: function(response) {
            errorMessage = response.responseJSON.message + '<br/>';
            if (response.responseJSON.errors) {
                errors = Object.keys(response.responseJSON.errors);
                errors.forEach(error => {
                    errorMessage += response.responseJSON.errors[error] + '<br/>';
                });
            }
            $('div[data-id="'+ postId +'"] .quick-reply #replies-errors-' + postId).html(errorMessage);
            $('div[data-id="'+ postId +'"] .quick-reply #replies-errors-' + postId).show();
        }
    });
}

$(document).ready(function() {
    getAjax('/api' + $url + '/posts');

    $(document).on('click', '.filter-post .sort-list li', function() {
        $(this).addClass('selected');
        $(this).siblings().removeClass('selected');
        $(this).closest('.filter-post').find('.title').text($(this).text());
    });

    $(document).on('click', '.sort-type .sort-list li', function() {
        if ($(this).text() == Lang.get('user/detail_product.review')) {
            $('.sort-rating > button').show();
            getAjax('/api' + $url + '/posts?type=' + TYPE_REVIEW);
        }
        else {
            $('.sort-rating > button').hide();
            getAjax('/api' + $url + '/posts?type=' + TYPE_COMMENT);
        };

    });

    $(document).on('click', '.sort-rating .sort-list li', function() {
        $rate = $(this).data('star');

        getAjax('/api' + $url + '/posts?rating=' + $rate);
    });

    $(document).on('click', '.rating1 .starRating input', function() {
        if ($(this).attr('checked') == 'checked') {
            $(this).attr('checked', false);
            $(this).siblings('input').attr('checked', false);
        } else {
            $(this).attr('checked', true);
            $(this).siblings('input').attr('checked', false);
        }
    });

    $(document).on('click', '#addReviewFrm .action .btn-add-review', function(event) {
        event.preventDefault();
        submitPost($url);
    });

    $(document).on('click', '.posts .description .owner-action .delete-post', function(event) {
        event.preventDefault();
        if (confirm(Lang.get('messages.delete_record'))) {
            deletePost($(this).attr('post-id'));
        }
    });

    $(document).on('click', '.review-list .posts .quick-reply .btn_add_comment', function(event) {
        event.preventDefault();
        submitComment($(this).attr('post-id'));
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

    $(document).on('click', '.quick-edit .btn_edit', function(event) {
        event.preventDefault();
        let id = $(this).attr('id');
        let data = id.split('-');
        if (data[0] == 'post') {
            editPost(data[1]);
        }
        if (data[0] == 'comment') {
            $.ajax({
                url: '/api/comments/' + data[1],
                type: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + accessToken,
                },
                data: {
                    content: $('#replies-item-' + data[1] + ' textarea').val(),
                },
                success: function(response) {
                    $('.quick-edit').hide();
                    $('#replies-item-' + data[1] + ' #replies-text-' + data[1]).html(response.result.content);
                    $('#replies-item-' + data[1] + ' #replies-text-' + data[1]).show();
                    $('.comment-owner-action').show();
                },
                error: function(response) {
                    errorMessage = response.responseJSON.message + '<br/>';
                    if (response.responseJSON.errors) {
                        errors = Object.keys(response.responseJSON.errors);
                        errors.forEach(error => {
                            errorMessage += response.responseJSON.errors[error] + '<br/>';
                        });
                    }
                }
            });
        }
    });
});

$(document).on('click', '.delete-comment', function() {
    var commentId = $(this).attr('id');
    var msgDelete = confirm(Lang.get('messages.delete_record'));
    if (msgDelete) {
        $.ajax({
            url: '/api/comments/' + commentId,
            type: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + accessToken,
            },
            success: function(result) {
                alert(Lang.get('messages.delete_success'));
                $('#replies-item-'+commentId).remove();
            },
            error: function(result) {
                alert(result.responseJSON.message);
            }
        });
    }
})

