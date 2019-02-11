$('button.btn-wd').on('click', function (e) {
    var userID = $('[data-userid]').val(),
        selectedUser = $('[data-usertype="userType"] :selected').val(),
        userEmail = $('[data-useremail="userEmail"]').val(),
        userName = $('[data-username="userName"]').val(),
        userLastName = $('[data-userlastname="userLastName"]').val(),
        userAddress = $('[data-useraddress="userAddress"]').val(),
        userCity = $('[data-usercity="userCity"]').val(),
        updateData = [];
    e.preventDefault();

    updateData.push({
        userID: userID,
        selectedUserType: selectedUser,
        userEmail: userEmail,
        userName: userName,
        userLastName: userLastName,
        userAddress: userAddress,
        userCity: userCity
    });

    $.ajax({
        method: 'POST',
        url: $('meta[name="root-site"]').attr('content') + '/user_update',
        data: {_token:  $('meta[name="csrf-token"]').attr('content'), data: updateData}
    }).done(function(msg) {
        $('.successful_Buy').modal();
    })
});