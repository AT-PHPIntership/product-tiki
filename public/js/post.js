function deletePost(e, id) {
    e.preventDefault();
    msg = Lang.get('post.admin.form.delete_msg');
    if (confirm(msg)) {
        document.getElementById('delete' + id).submit();
    }
}

function updateStatus(e, id, url) {
    e.preventDefault();
    loadAjax(url, id);
}
function loadAjax(url, id) {
    var xmlhttp;
    var approved = '<i class="fa fa-check-circle icon-size"></i>';
    var pending = '<i class="fa fa-times-circle icon-size"></i>';

    xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
      if ( xmlhttp.readyState === 4 && xmlhttp.status === 200 ) {
        json_data = JSON.parse(xmlhttp.responseText);
        status = json_data['status'];
        var btnStatus = document.getElementById('update'+id).innerHTML;
        var textStatus = document.getElementById('update'+id).innerHTML;
        btnStatus = '';
        if (status == 1) {
            btnStatus = pending;
            textStatus = Lang.get('common.approve');
        }
        if (status == 0) {
            btnStatus = approved;
            textStatus = Lang.get('common.pending');
        }
        document.getElementById('info-message').innerHTML = json_data['msg'];
      }
    }

    xmlhttp.open("PUT", url, true);
    csrf = document.getElementById('csrf-token').getAttribute('content');
    xmlhttp.setRequestHeader('X-CSRF-Token', csrf);

    xmlhttp.send();
}

function deleteComment(e, id) {
    e.preventDefault();
    msg = Lang.get('post.admin.form.delete_comment_msg') + id;
    if (confirm(msg)) {
        document.getElementById('delete' + id).submit();
    }
}