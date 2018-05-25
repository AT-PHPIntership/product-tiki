function deleteProduct(e, id) {
  e.preventDefault();
  msg = "Do you want to delete Product ID = " + id;
  if (confirm(msg)) {
    document.getElementById('delete-prd'+id).submit();
  }
}
