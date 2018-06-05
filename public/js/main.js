function deleteMain(e, id) {
    e.preventDefault();
    msg = Lang.get('messages.main_delete');
    if (confirm(msg)) {
      document.getElementById('deleted'+id).submit();
    }
  }
  