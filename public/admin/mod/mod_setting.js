var displayErrors = [
    {
        display: '#groupErr',
        inputName: 'group'
    },
    {
        display: '#optionErr',
        inputName: 'option'
    },
    {
        display: '#valueErr',
        inputName: 'value'
    }
];

function maintenanceMode(param){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url + '/administrator/settings/'+ param +'/maintenance',
        method:"post",
        dataType: "json",
        success: function (data) {
            Swal.fire({
                title: "Success",
                icon: "success",
                text: data.messages,
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

function imgPreview(input){
    if(input.files && input.files[0]){
      var reader = new FileReader();
      reader.onload = function(e){
        $('#imgPreview').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

$('#value').change(function(){
    $('.fileuploader-thumbnails-input-inner i').html('');
    $('#imgPreview').removeClass('d-none');

    imgPreview(this);
})