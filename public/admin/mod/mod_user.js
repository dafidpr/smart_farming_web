var displayErrors = [
    {
        display: '#nameErr',
        inputName: 'name'
    },
    {
        display: '#usernameErr',
        inputName: 'username'
    },
    {
        display: '#emailErr',
        inputName: 'email'
    },
    {
        display: '#passErr',
        inputName: 'password'
    },
    {
        display: '#roleErr',
        inputName: 'role'
    },
    {
        display: '#blockErr',
        inputName: 'block'
    },
    {
        display: '#farmerGroupErr',
        inputName: 'farmer_group'
    },
    {
        display: '#picErr',
        inputName: 'picture'
    },
    {
        display: '#currentPassErr',
        inputName: 'current_password'
    },
    {
        display: '#newPassErr',
        inputName: 'new_password'
    },
    {
        display: '#confirmPassErr',
        inputName: 'confirm_password'
    },
];

$('.block-user').click(function(e) {
    e.preventDefault();
    let id = $(this).data('id');
    const title = $(this).text();
    Swal.fire({
        title: title == "Block User" ? "Anda yakin ingin blokir user ?" : "Anda yakin ingin unblokir user ?",
        icon: "warning",
        text: title == "Block User" ? "User yang di blokir tidak bisa login aplikasi" : "User yang di unblokir dapat login kembali",
        showConfirmButton: true,
        confirmButtonText: title == "Block User" ? "Yes, blokir" : "Yes, unblokir",
        showCancelButton: true,
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url + '/administrator/users/'+ id +'/block',
                method:"post",
                dataType: "json",
                success: function (data) {
                    Swal.fire({
						title: "Success",
						icon: "success",
						text: data.messages,
					}).then(function () {
                        loadContent();
                    });
                },
                error: function (xhr, ajaxOptioins, thrownError) {
                    Swal.fire({
                        title: xhr.status,
                        icon: "warning",
                        text: thrownError,
                    });
                },
            });
        }
    });
})