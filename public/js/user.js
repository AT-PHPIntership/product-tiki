function deleteUser(e, id) {
    e.preventDefault();
    msg = "Do you want to delete User ID = " + id;
    if (confirm(msg)) {
        document.getElementById('delete-user'+id).submit();
    }
}