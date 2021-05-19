var pathStoreUrl = "/administrator/permissions/store";
var displayErrors = [
    {
        display: '#permissionNameErr',
        inputName: 'name'
    },
    {
        display: '#permissionErr',
        inputName: 'permission'
    }
];

$('.add-permission').click(function() {
    $('.title').text('Tambah Permission Baru');
})