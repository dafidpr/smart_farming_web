var datatableUrl = '/administrator/roles/loadData';
var pathStoreUrl = "/administrator/roles/store";
var displayErrors = [
    {
        display: '#role-error',
        inputName: 'role'
    }
];

$('.add-role').click(function() {
    $('.title').text('Tambah Role Baru');
})

$('.edit').click(function() {
    let id = $(this).data('id');
    $('.title').text('Edit Role');
    $('#myModal form').attr('action', '/administrator/roles/'+ id +'/update');
    $.ajax({
        url: url + '/administrator/roles/'+ id +'/show',
        dataType: 'json',
        success:function(res){
            $('#role').val(res.response.name);
        } 
    });
})
