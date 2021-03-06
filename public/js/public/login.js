$(document).ready(function () {
    if (localStorage.getItem('login-token')) {
        window.location.href = 'https://' + window.location.hostname;
    }

    window.fbAsyncInit = function() {
      FB.init({
        appId: '2772181833007240',
        cookie: true,
        version: 'v2.2'
      });
    };

    $('#btn-login-facebook').on('click', function() {
      FB.login(function(response) {
        if (response.authResponse) {
          window.localStorage.setItem('fb-token', response.authResponse.accessToken);
          $.ajax({
              url: '/api/login-facebook',
              type: 'POST',
              headers: {
                  'Accept': 'application/json'
              },
              data: {'access-token': response.authResponse.accessToken},
              success: function(response) {
                  localStorage.setItem('login-token', response.result.token);
                  window.location.href = 'https://' + window.location.hostname;
              },
              statusCode: {
                  401: function (response) {
                      alert(response.responseJSON.error);
                      localStorage.removeItem('fb-token');
                  }
              }
          });
        }
      });
      return false;
    });

    (function(d, s, id){
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {return;}
      js = d.createElement(s); js.id = id;
      js.src = "https://connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    $(document).on('click', '.login-form-grids input[type="submit"]', function (event) {
        event.preventDefault();
        $.ajax({
            url: "/api/login",
            type: "post",
            headers: {
                'Accept': 'application/json',
            },
            data: {
                email: $('.login-form-grids input[type="email"]').val(),
                password: $('.login-form-grids input[type="password"]').val()
            },
            success: function (response) {
                localStorage.setItem('login-token', response.result.token);
                window.location.href = 'http://' + window.location.hostname;
            },
            statusCode: {
                401: function (response) {
                    alert(response.responseJSON.error);
                    $('.login-form-grids input[type="password"]').val('');
                }
            }
        });
    })
})
