function deleteRecord(e, id) {
    e.preventDefault();
    msg = Lang.get('messages.delete_record');
    if (confirm(msg)) {
      document.getElementById('deleted'+id).submit();
    }
  }
  