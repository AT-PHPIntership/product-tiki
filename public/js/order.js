function deleteOrder(e, id) {
    e.preventDefault();
    msg = Lang.get('orders.admin.list.delete_msg')+id;
    if (confirm(msg)) {
        document.getElementById('delete' + id).submit();
    }
}