$(document).ready(function () {
    var old_val;
    $('#order-status').focus(function () {
        old_val = $(this).val();
    }).change(function () {
        var status = $(this).val();
        console.log(status);
        var id = $(this).data("id");
        if (confirm(Lang.get('orders.admin.show.update_msg'))) {
            $.ajax({
                type: "PUT",
                url: "/api/admin/orders/"+id+"/status",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: 'json',
                data: {
                    "status": status
                },
                success: function (data) {
                    $('#alert-update').text(data['msg']);
                    $('#alert-update').attr('hidden' , null);
                },
                error: function (data) {
                    $(this).val(old_val);
                    $('#alert-update').text(JSON.parse(data.responseText).message);
                    $('#alert-update').attr('hidden' , null);
                }
            })
        } else {
            $(this).val(old_val);
        }
    });
});
