var imagePath;

function showUserProfile(response) {
  let user = response.result;
  if (!imagePath) {
    imagePath = user.image_path;
  }
  avatarPath = imagePath + user.userinfo.avatar;
  if (user.userinfo.gender == 0) {
    gender = Lang.get('user.index.male');
    $('#edit_profile .modal-body .form-group #gender option[value=0]').attr('selected','selected');
  } else {
    gender = Lang.get('user.index.female');
    $('#edit_profile .modal-body .form-group #gender option[value=1]').attr('selected','selected');
  }

  $('.profile_left .profile_img #crop-avatar img').attr('src', avatarPath);
  $('.profile_left .user_data #user_data_username a').html(user.username);
  $('.profile_left .user_data #user_data_gender a').html(gender);
  $('.profile_left .user_data #user_data_address a').html(user.userinfo.address);
  $('.profile_left .user_data #user_data_email a').html(user.email);

  $('#myTabContent #user_profile .user-info #username').html(user.username);
  $('#myTabContent #user_profile .user-info #email').html(user.email);
  $('#myTabContent #user_profile .user-info #full_name').html(user.userinfo.full_name);
  $('#myTabContent #user_profile .user-info #address').html(user.userinfo.address);
  $('#myTabContent #user_profile .user-info #gender').html(gender);
  $('#myTabContent #user_profile .user-info #dob').html(user.userinfo.dob);
  $('#myTabContent #user_profile .user-info #phone').html(user.userinfo.phone);
  $('#myTabContent #user_profile .user-info #identity_card').html(user.userinfo.identity_card);

  $('#edit_profile .modal-body .form-group #full_name').val(user.userinfo.full_name);
  $('#edit_profile .modal-body .form-group #address').val(user.userinfo.address);
  $('#edit_profile .modal-body .form-group #dob').val(user.userinfo.dob);
  $('#edit_profile .modal-body .form-group #phone').val(user.userinfo.phone);
  $('#edit_profile .modal-body .form-group #identity_card').val(user.userinfo.identity_card);
  $('#edit_profile .modal-body .form-group #img_avatar').attr('src', avatarPath);
}

function editProfile() {
  formData = new FormData($('#demo-form2')[0]);
  formData.append('_method', 'put');

  $.ajax({
    url: "/api/users/profile",
    type: "post",
    contentType: false,
    processData: false,
    headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer ' + accessToken
    },
    data: formData,
    success: function(response) {
      showUserProfile(response);
      $("#edit_profile").modal('hide');
    },
    error: function (response) {
      alert(response.responseJSON.message);
      if (response.responseJSON.errors) {
        errors = Object.keys(response.responseJSON.errors);
        errors.forEach(error => {
            $('#edit_profile .modal-body .form-group #' + error + '_error').html(response.responseJSON.errors[error]);
            $('#edit_profile .modal-body .form-group #' + error + '_error').show();
        });
      }
    }
  });
}

$(document).ready(function () {
  $.ajax({
    url: "/api/users/profile",
    type: "get",
    headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer ' + accessToken
    },
    success: function(response) {
      showUserProfile(response);
    }
  });

  $(document).on('click', '#edit_profile .modal-body .form-group #edit_profile_submit', function(event) {
    event.preventDefault();
    editProfile();
  });

  $.ajax({
     url: "api/users/profile/address",
     type: "get",
     headers: {
         "Accept": "application/json",
         "Authorization": "Bearer " + accessToken
     },
     success: function (response) {
         showAddress(response.result);
     }
  });

  $(document).on('click', '.btn-address', function () {
      addr_id = $(this).attr('data-id');
      action =$(this).attr('data-action');
      if(action == 'view') {
          $('#address-data-'+addr_id).replaceWith(function () {
              return "<input class='form-control' id='input-"+ addr_id +"' type='text' value ='" + $('#address-data-'+addr_id).text() +"' />";
          });
          $(this).text(Lang.get('user/profile.edit_address'));
          $(this).attr('data-action', 'edit');
      } else if (action == 'edit') {
          address = $('#input-'+addr_id).val();
          $.ajax({
              url: "api/users/profile/address/"+addr_id,
              type: "post",
              headers: {
                  "Accept": "application/json",
                  "Authorization": "Bearer " + accessToken
              },
              data: {
                  "address": address,
                  "_method": "PUT"
              },
              success: function (response){
                  $('#input-'+addr_id).replaceWith(function () {
                      return "<span class='address' id='address-data-"+ addr_id +"'> " + response.result.address +" </span>";
                  });
              }
          });
          $(this).text(Lang.get('user/profile.edit_address'));
          $(this).attr('data-action', 'view');
      }
  })
});

function showAddress(address) {
    address.forEach(addr => {
        let idAddr="addr-"+addr.id;
        $("#template-address").clone().attr({"style":"display: ","id":idAddr}).insertBefore('#template-address');
        $("#"+idAddr +" .address").text(addr.address);
        $("#"+idAddr +" .address").attr('id', 'address-data-'+addr.id);
        $("#"+idAddr +" .btn").attr('data-id', addr.id);
        $("#"+idAddr +" .btn").attr('data-action', 'view');
    })
}
