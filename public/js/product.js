
function deleteProduct(e, id) {
  e.preventDefault();
  msg = Lang.get('product.index.delete_confirm') + id;
  if (confirm(msg)) {
    document.getElementById('delete-prd'+id).submit();
  }
}

function deleteImage(url, e) {
  e.preventDefault();
  if(confirm(Lang.get('product.update.delete_confirm'))){
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('#csrf-token').attr('content')
      },
      type: "delete",
      url: url,
      data: {},
      success: function (result) {
        document.getElementById('img-' + result.id).remove();
      }
    });
  }
}
