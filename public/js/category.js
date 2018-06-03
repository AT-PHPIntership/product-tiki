function deleteCategory(e, id) {
  e.preventDefault();
  msg = Lang.get('category.admin.message.msg_del');
  if (confirm(msg)) {
    document.getElementById('deleted'+id).submit();
  }
}
