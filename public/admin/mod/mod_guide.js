var pathStoreUrl = "/administrator/guides/store";
var displayErrors = [
    {
        display: "#title-error",
        inputName: "title",
    },
    {
        display: "#file-error",
        inputName: "file",
    },
];

$('.add-guide').click(function() {
    $('.title').text('Tambah Panduan Baru');
})

$(".edit").click(function () {
    let id = $(this).data("id");
    $('.title').text('Edit Panduan Baru');
    $("#myModal form").attr(
        "action",
        "/administrator/guides/" + id + "/update"
    );
    $.ajax({
        url: url + "/administrator/guides/" + id + "/show",
        dataType: "json",
        success: function (res) {
            $("#title").val(res.response.title);
            $("#description").val(res.response.description);
        },
    });
});
