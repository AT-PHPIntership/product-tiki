function deleteUser(e, id) {
    e.preventDefault();
    msg = "Do you want to delete ?";
    if (confirm(msg)) {
        document.getElementById('delete-user'+id).submit();
    }
}