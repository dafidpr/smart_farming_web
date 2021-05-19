
var displayErrors = [
    {
        display: '#usernameErr',
        inputName: 'username'
    },
    {
        display: '#passErr',
        inputName: 'password'
    },
];

$('input[name="username"]').keydown(function(){
    $(this).removeClass('is-invalid');
    $('#usernameErr').addClass('d-none');
})

$('input[name="password"]').keydown(function(){
    $(this).removeClass('is-invalid');
    $('#passErr').addClass('d-none');
})

$('#formLogin').submit(function(e){
    e.preventDefault();
    //set display errors
    $('input[name="password"]').removeClass('is-invalid');
    $('input[name="password"]').removeClass('is-invalid');
    $('#usernameErr').addClass('d-none');
    $('#passErr').addClass('d-none');

    //set button loading...
    $('button[type="submit"]').addClass('disabled');
    $('button[type="submit"]').html('Sign in');
    setError(displayErrors);
    $('.d-error').html("")
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: $(this).attr('action'),
        method: $(this).attr('method'),
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(data){
            $('button[type="submit"]').removeClass('disabled');
            $('button[type="submit"]').html('Sign in');
            if(data.status == 400){
                if(data.username){
                    $('#usernameErr').html(data.username);
                    $('#usernameErr').removeClass('d-none');
                    $('input[name="username"]').addClass('is-invalid');
                }
                if(data.password){
                    $('#passErr').html(data.password);
                    $('#passErr').removeClass('d-none');
                    $('input[name="password"]').addClass('is-invalid');
                }
            } else {
                window.location.href = url + data.redirect;
            }
        },
        error: function(xhr, ajaxOptions, thrownError){
            $('button[type="submit"]').removeClass('disabled');
            $('button[type="submit"]').html('Sign in');
            if(xhr.status == 400){
                displayError(displayErrors, xhr.responseJSON);
            } else if(xhr.status == 409){
                Swal.fire({
                    title: 'Error ' + xhr.status,
                    icon: "error",
                    text: xhr.responseJSON['messages']
                });
            } else if(xhr.status == 404 || xhr.status == 403){
                var html = "";
                html += `<div class="example-alert mb-3">
                            <div class="alert alert-danger alert-icon alert-dismissible">
                                <em class="icon ni ni-cross-circle"></em> <strong>Error </strong>! ${xhr.responseJSON['messages']}. <button class="close" data-dismiss="alert"></button>
                            </div>
                        </div>`;
                $('.d-error').html(html)
            } else {
                Swal.fire({
                    title: 'Error ' + xhr.status,
                    icon: "error",
                    text: thrownError
                });
            }
        }
    })
})

$('.show-password').click(function () {
    if ($('#password').attr('type') == "password") {
        $('#password').attr('type', 'text');
    } else if ($('#password').attr('type') == "text") {
        $('#password').attr('type', 'password');

    }
});


function displayError(options, data){

    $.each(options, function(key, value){
        if(data.messages[value.inputName] && data.messages[value.inputName][0]){
            $(value.display).removeClass('d-none');
            $('input[name="'+value.inputName+'"]').addClass('is-invalid');
            $(value.display).html(data.messages[value.inputName][0]);
        }
    });
}

function setError(options){
    $.each(options, function(key, value){
        $(value.display).addClass('d-none');
        $(value.inputName).removeClass('is-invalid');
    })
}