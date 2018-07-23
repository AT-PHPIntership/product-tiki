var nextPageUrl = '';
const UNAPPROVED = 0;
const APPROVED = 1;
const ON_DELIVERY = 2;
const CANCELED = 3;
var order_detail;
var order_id;
var total = 0;
var order_total;

function showOrder(url) {
  $.ajax({
    url: url,
    type: "get",
    headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer ' + accessToken
    },
    success: function(response) {
      data = response.result.data;

      if (!data) {
        $('#myTabContent #recent_order #no-record').show();
        $('#myTabContent #recent_order table').hide();
      } else {
        $('#myTabContent #recent_order table tbody').html('');
        data.forEach(order => {
          noteHtml = '<td>' + order.note + '</td>';
          totalHtml = '<td>' + order.total.toLocaleString() + '</td>';
          switch (order.status) {
            case UNAPPROVED:
              statusHtml = '<td class="status">' + Lang.get('common.pending') + '</td>';
              break;
            case APPROVED:
              statusHtml = '<td class="status">' + Lang.get('common.approve') + '</td>';
              break;
            case ON_DELIVERY:
              statusHtml = '<td class="status">' + Lang.get('orders.admin.show.on_delivery') + '</td>';
              break;
            case CANCELED:
              statusHtml = '<td class="status">' + Lang.get('common.cancel') + '</td>';
              break;
            default:
              statusHtml = '<td class="status">' + Lang.get('common.done') + '</td>';
              break;
          }
          actionHtml = '<td><button order_id='+ order.id +' class="btn btn-primary btn-order-detail">' + Lang.get('user.index.detail') + '</button></td>';
          if (order.status == UNAPPROVED) {
            actionHtml += '<td><button class="btn btn-danger" orderId="' + order.id + '">' + Lang.get('common.cancel-btn') + '</button></td>';
          } else {
            actionHtml += '<td><button class="btn btn-danger" disabled="disabled">' + Lang.get('common.cancel-btn') + '</button></td>';
          }

          tableItem = '<tr id="order_' + order.id + '">' + noteHtml + totalHtml + statusHtml + actionHtml + '</tr>';
          $('#myTabContent #recent_order table tbody').append(tableItem);
        });

        nextPageUrl = response.result.paginator.next_page_url;
        if (nextPageUrl) {
          $('#myTabContent #recent_order .paginate-profile #next').show();
        } else {
          $('#myTabContent #recent_order .paginate-profile #next').hide();
        }
      }
    }
  });
}

function deleteProduct(event, id) {
    event.preventDefault();
    $('#items_'+id).remove();
}

function showOrderDetail(url) {
  $.ajax({
    url: url,
    type: "get",
    headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer ' + accessToken
    },
    success: function(response) {
      orderDetailList = response.result.order_details;
      productListHtml = '';
      order_detail = orderDetailList;
      order_id = response.result.id;
      order_total = response.result.total;
      orderDetailList.forEach(orderDetail => {
        
        product = orderDetail.product;
        total += (orderDetail.product_price * orderDetail.quantity);
        productListHtml += '<div id="items_'+ product.id +'" class="form-group">\
                              <input type="number" id="product_id_' + product.id + '" value="' + product.id + '" class="product_id_" hidden>\
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="full_name">' + product.name + '</label>\
                              <div class="col-md-2 col-sm-6 col-xs-12">\
                                <input type="number" id="quantity_'+ product.id +'" value="' + orderDetail.quantity + '" class="form-control col-md-7 col-xs-12">\
                              </div>\
                              <label class="control-label col-md-2 col-sm-3 col-xs-12">' + orderDetail.product_price.toLocaleString() + '</label>\
                              <label class="control-label col-md-2 col-sm-3 col-xs-12">' + (orderDetail.product_price * orderDetail.quantity).toLocaleString() + '</label>\
                              <button onclick="deleteProduct(event,'+ product.id +')" class="btn btn-danger"><i class="fa fa-trash"></i></button>\
                            </div>';
      });
      productListHtml += '<div class="form-group">\
                            <div class="col-md-12 col-sm-6 col-xs-1">\
                              <lable class="control-label col-md-7 col-sm-3 col-xs-1"><strong>' + Lang.get('messages.order_total') + '</strong></lable>\
                              <lable class="control-label col-md-2 col-sm-3 col-xs-12"><strong>'+ total.toLocaleString() +'</strong></lable>\
                            </div>\
                            <div class="col-md-12 col-sm-6 col-xs-1">\
                              <lable class="control-label col-md-7 col-sm-3 col-xs-1"><strong>' + Lang.get('messages.order_total_discount') + '</strong></lable>\
                              <lable class="control-label col-md-2 col-sm-3 col-xs-12"><strong>' + order_total.toLocaleString() + '</strong></lable>\
                            </div>\
                          </div>';
      productListHtml += '<div class="form-group">\
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">\
                              <button id="update-order" class="btn btn-success btn-order-edit-submit">' + Lang.get('category.admin.add.submit') + '</button>\
                              <button class="btn btn-primary btn-order-detail-back">' + Lang.get('category.admin.add.back') + '</button>\
                            </div>\
                          </div>';
      $('#myTabContent #recent_order #order_detail form').html(productListHtml);

      $('#myTabContent #recent_order table').hide();
      $('#myTabContent #recent_order .paginate-profile #next').hide();

      $('#myTabContent #recent_order #order_detail').show();
    }
  });
}

function cancelOrder(orderId) {
  let note = '';
  if ($('#note').val()) {
    note = $('#note').val();
  }
  $.ajax({
    url: 'api/users/orders/' + orderId + '/cancel',
    type: "put",
    headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer ' + accessToken
    },
    data: {
      note: note,
    },
    success: function(response) {
      $('#recent_order tbody tr[id="order_' + response.result.id + '"] .status').html(Lang.get('common.cancel'));
      $('#recent_order tbody button[orderId="' + response.result.id + '"]').prop("disabled",true);
      alert(Lang.get('common.done'));
    },
    statusCode: {
      500: function(response) {
        alert(response.responseJSON.message);
      }
    }
  });
}

$(document).ready(function() {
  showOrder('/api/orders');

  $(document).on('click', '#recent_order tbody button[orderId]', function(event) {
    event.preventDefault();
    if (confirm(Lang.get('user/profile.cancel_order_confirm'))) {
      $('#note_cancel_order_submit').attr('order-id', $(this).attr('orderId'));
      $('#note_cancel_order').modal('show');
    }
  });

  $(document).on('click', '#myTabContent #recent_order .paginate-profile #next', function(event) {
    event.preventDefault();
    showOrder(nextPageUrl);
  });

  $(document).on('click', '#myTabContent #recent_order table tbody .btn-order-detail', function(event) {
    event.preventDefault();
    showOrderDetail('/api/orders/' + $(this).attr('order_id'));
  });

  $(document).on('click', '#myTabContent #recent_order #order_detail .btn-order-detail-back', function(event) {
    event.preventDefault();
    $('#myTabContent #recent_order #order_detail').hide();
    showOrder('api/orders');
    $('#myTabContent #recent_order table').show();
    if (nextPageUrl) {
      $('#myTabContent #recent_order .paginate-profile #next').show();
    } else {
      $('#myTabContent #recent_order .paginate-profile #next').hide();
    }
  });

  $(document).on('click', '#note_cancel_order .modal-body input[id="note_cancel_order_submit"][order-id]', function(event) {
    event.preventDefault();
    cancelOrder($(this).attr('order-id'));
    $('#note_cancel_order').modal('hide');
  });

  $(document).on('click', '#update-order', function(event) {
      event.preventDefault();
      let data = [];
      let i = 0;
      let product_data;
      order_detail.forEach(order => {
          product_data = {};
          product = order.product;
          if ($(document).find('#product_id_'+ product.id).length > 0) {
              product_data.id = product.id;
              product_data.quantity = $('#quantity_'+ product.id).val();
              data.push(product_data);
          }
      });
      $.ajax({
          type: 'POST',
          url: '/api/orders/'+order_id,
          headers: ({
              Accept: 'application/json',
              Authorization: 'Bearer ' + accessToken,
          }),
          data: {'products': data, '_method': 'PUT'},
          success: function(response) {
              alertStr = '';

              if (typeof response.result.errors != undefined) {
                 response.result.errors.forEach(error => {
                     alertStr += error + '\n';
                 });
             } else {
                 alertStr = Lang.get('user/cart.submit_success');
             }
             alert(alertStr);
             showOrderDetail('api/orders/'+order_id);
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
  });
});
