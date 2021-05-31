var pathStoreUrl = "/administrator/farmers/schedules/store";
var getHashid = window.location.pathname.split('/');
var displayErrors = [
    {
        display: '#start-error',
        inputName: 'start'
    },
    {
        display: '#end-error',
        inputName: 'end'
    }
];
$('.add-schedule').click(function() {
    $('.title').text('Tambah Jadwal Baru');
    $('#hashid').val(getHashid[4]);
})

$('.edit').click(function() {
    let id = $(this).data('id');
    $('.title').text('Edit Jadwal');
    $('#myModal form').attr('action', '/administrator/farmers/schedules/'+ id +'/update');
    $.ajax({
        url: url + '/administrator/farmers/schedules/'+ id +'/show',
        dataType: 'json',
        success:function(res){
            $('#start').val(res.response.start);
            $('#end').val(res.response.end);
        } 
    });
})

function scheduleAction(param){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url + '/administrator/farmers/schedules/'+ param +'/setSchedule',
        method:"post",
        dataType: "json",
        success: function (data) {
            if(data.is_active == 1) {
                $('#schedule-status').text('Aktif');
                $('.badge-dot').removeClass('badge-danger');
                $('.badge-dot').addClass('badge-success');
            } else {
                $('#schedule-status').text('Tidak Aktif');
                $('.badge-dot').removeClass('badge-success');
                $('.badge-dot').addClass('badge-danger');
            }
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