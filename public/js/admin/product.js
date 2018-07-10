
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
      },
      statusCode: {
        400: function (result) {
          alert(result.responseText);
        }
      }
    });
  }
}

function submitForm(event) {
  event.preventDefault();
  $('#description').html($('#editor-description').html());
  $('#form-editor').submit();
}

$(document).ready(function () {
    $(document).on('click', '#add-meta', function() {
        $('#template-meta').clone().attr({"style":"display: ", "id":''}).insertBefore('#last-group');
    });

    $(document).on('click', '.remove-meta', function() {
        $(this).closest('.form-group').remove();
    })
});
