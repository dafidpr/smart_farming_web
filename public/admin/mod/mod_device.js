var pathStoreUrl = "/administrator/devices/store";
var displayErrors = [
    {
        display: '#name-error',
        inputName: 'name'
    },
    {
        display: '#serial_number-error',
        inputName: 'serial_number'
    },
];

$('.add-device').click(function() {
    $('.title').text('Tambah Perangkat Baru');
})

$('.edit').click(function() {
    let id = $(this).data('id');
    $('.title').text('Edit Perangkat');
    $('#myModal form').attr('action', '/administrator/devices/'+ id +'/update');
    $.ajax({
        url: url + '/administrator/devices/'+ id +'/show',
        dataType: 'json',
        success:function(res){
            $('#name').val(res.response.name);
            $('#serial_number').val(res.response.serial_number);
        } 
    });
})
