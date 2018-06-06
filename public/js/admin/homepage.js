$( document ).ready(function() {
    $.ajaxSetup({
      headers: {
          'X-CSRF-Token': $('#csrf-token').attr('content')
      }
    });
    $( '.dropdown-order li a' ).click( function (event) {
        event.preventDefault();
        url = $(this).attr("href");
        $.ajax({
            method: 'GET',
            url: url,
            success: function (data) {
                $('#order_time').text(data.time);
                for (let i = 0; i < data.numberOfRecords; i++) {
                    id = i + 1;
                    $('#order_route_' + id).attr('href', data['topOrders'][i].routes);
                    $('#order_username_' + id).text(data['topOrders'][i]['user'].username);
                    $('#order_total_' + id).text(new Intl.NumberFormat().format(data['topOrders'][i].total));
                    $('#order_product_count_' + id).text(data['topOrders'][i].orderdetails_count);
                }
            }
        });
    });
    $('.dropdown-user li a').click( function (event) {
        event.preventDefault();
        url = $(this).attr("href");
        $.ajax({
            method: 'GET',
            url: url,
            success: function (data) {
                $('#user_time').text(data.time);
                for (let i = 0; i < data.numberOfRecords; i++) {
                    id = i + 1;
                    $('#user_route_' + id).attr('href', data['users'][i].routes);
                    $('#user_name_' + id).text(data['users'][i]['user_info'].full_name);
                    $('#user_email_' + id).text(data['users'][i].email);
                    $('#user_point_' + id).text(data['users'][i].point);
                }
            }
        });
    });

});
