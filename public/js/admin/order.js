$(document).ready(function () {
    var old_val;
    $('#order-status').focus(function () {
        old_val = $(this).val();
    }).change(function () {
        var status = $(this).val();
        $('#fill_in_note').modal('show');
        $('#note-change').attr('value', status);
    });
    $('#fill_in_note').on('hidden.bs.modal', function () {
        $('#order-status').val(old_val);
    })
});
