$( document ).ready(function() {
    accessToken = localStorage.getItem('login-token');
    if (accessToken) {
        checkLogin();
    } else {
        $('.agile-login #header-login').show();
    }

    $(document).on('click', '.agile-login #header-logout #btn-logout', function (event) {
        event.preventDefault();
        if (accessToken) {
            $.ajax({
                url: "/api/logout",
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + accessToken
                },
                type: "post",
                success: function (response) {
                    localStorage.removeItem('login-token');
                    localStorage.removeItem('userLogin');
                    window.location.reload();
                }
            });
        }
    })
});

$(document).on('click', '#submit-cart', function (event) {
    event.preventDefault();
    cart = localStorage.getItem('PPMiniCart');
    cart = JSON.parse(unescape(cart));
    products = cart.value.items;
    let product_data;
    let data = [];
    products.forEach(function (product) {
        product_data = {};
        product_data.id = product.id;
        product_data.quantity = product.quantity;
        data.push(product_data);
    });
    $.ajax({
        type: 'POST',
        url: '/api/orders',
        headers: ({
            Accept: 'application/json',
            Authorization: 'Bearer ' + accessToken,
        }),
        data: {'products': data},
        success: function(response) {
            alertStr = '';

            if (response.result.errors.length) {
                response.result.errors.forEach(error => {
                    alertStr += error + '\n';
                });
            } else {
                alertStr = Lang.get('user/cart.submit_success');
            }
            alert(alertStr);
            localStorage.removeItem('PPMiniCart');
            window.location.href = '/profile';
        },
        statusCode: {
            401: function() {
                alert(Lang.get('user/cart.need_login_alert'));
                localStorage.removeItem('login-token');
                window.location.pathname = '/login';
            },
            422: function (response) {
                alertStr = '';
                response.responseJSON.error.forEach(error => {
                    alertStr += error + '\n';
                })
                alert(alertStr);
            }
        }
    });
})

function checkLogin() {
    $.ajax({
        type: 'GET',
        url: '/api/checkAccessToken',
        headers: ({
            Accept: 'application/json',
            Authorization: 'Bearer ' + accessToken,
        }),
        success: function(response) {
            $('.agile-login #header-logout').show();
            $('.agile-login #header-login').hide();
            localStorage.setItem('userLogin', JSON.stringify(response.result));
        },
        statusCode: {
            401: function() {
                window.localStorage.removeItem('login-token');
                localStorage.removeItem('userLogin');
                $('.agile-login #header-logout').hide();
                $('.agile-login #header-login').show();
            }
        }
    });
}
