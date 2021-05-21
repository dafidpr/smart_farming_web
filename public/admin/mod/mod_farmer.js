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
        display: '#passwordErr',
        inputName: 'password'
    },
    {
        display: '#genderErr',
        inputName: 'gender'
    },
    {
        display: '#phoneErr',
        inputName: 'phone'
    },
    {
        display: '#blockErr',
        inputName: 'block'
    },
    {
        display: '#serialNumberErr',
        inputName: 'serial_number'
    },
    {
        display: '#landAreaErr',
        inputName: 'land_area'
    },
    {
        display: '#farmerGroupErr',
        inputName: 'famrmer_group_id'
    },
];

$('.change-status').click(function(e) {
    e.preventDefault();
    let dataURL = $(this).data('url');
    const action = $(this).data('action');

    Swal.fire({
        title: action == "approve" ? "Anda yakin ingin approve petani ini ?" : "Anda yakin ingin reject petani ini ?",
        icon: "warning",
        text: action == "approve" ? "Petani yang telah di approve bisa menggunakan layanan aplikasi" : "Petani yang di reject tidak dapat menggunakan layanan aplikasi",
        showConfirmButton: true,
        confirmButtonText: action == "approve" ? "Yes, approve" : "Yes, reject",
        showCancelButton: true,
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url + dataURL,
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

$('.block-farmer').click(function(e) {
    e.preventDefault();
    let id = $(this).data('id');
    const title = $(this).text();
    Swal.fire({
        title: title == "Block Petani" ? "Anda yakin ingin blokir petani ?" : "Anda yakin ingin unblokir petani ?",
        icon: "warning",
        text: title == "Block Petani" ? "petani yang di blokir tidak bisa login aplikasi" : "petani yang di unblokir dapat login kembali",
        showConfirmButton: true,
        confirmButtonText: title == "Block Petani" ? "Yes, blokir" : "Yes, unblokir",
        showCancelButton: true,
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url + '/administrator/farmers/'+ id +'/block',
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