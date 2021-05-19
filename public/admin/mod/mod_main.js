$(document).ready(function () {
    if (typeof dataColumns == "undefined") {
        dataColumns = "";
    }

    if (typeof displayErrors == "undefined") {
        displayErrors = "";
    }

    if (typeof dtDrawCallback == "undefined") {
        dtDrawCallback = null;
    }

    if (typeof dtDrawCallback == "undefined") {
        dtDrawCallback = () => {};
    }

    loadData(dataColumns, dtDrawCallback);

    if (typeof dataTableOptions == "undefined") {
        var dataTableOptions = null;
    }

    function loadData(columns = [], drawCallback) {
        // var attr = {
        // 	processing: true,
        // 	serverSide: true,
        // 	ajax: url + datatableUrl,
        // 	columns: columns,
        // 	drawCallback,
        // };

        loadDataTablesInit();
        loadDataTablesResponsive();
        formSubmit();
    }

    function loadDataTablesInit() {
        $("#DataTable").on("draw.dt", function () {
            $(".action").click(function () {
                var toggle = $(this).data("toggle");
                var dataUrl = $(this).data("url");

                if (toggle == "edit") {
                    window.location.assign(url + dataUrl);
                }
                if (toggle == "delete") {
                    itemDelete(dataUrl);
                }
            });
        });
    }

    function loadDataTablesResponsive() {
        $("#DataTable")
            .DataTable()
            .on("responsive-display", function () {
                $(".action").click(function () {
                    var toggle = $(this).data("toggle");
                    var dataUrl = $(this).data("url");

                    if (toggle == "edit") {
                        window.location.assign(url + dataUrl);
                    }
                    if (toggle == "delete") {
                        itemDelete(dataUrl);
                    }
                });
            });
    }

    function itemDelete(dataUrl) {
        Swal.fire({
            title: "Delete?",
            icon: "question",
            text: "Do you delete item?",
            showConfirmButton: true,
            confirmButtonText: "Yes, delete it",
            confirmButtonClass: "bg-danger",
            showCancelButton: true,
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url + dataUrl,
                    dataType: "json",
                    success: function (data) {
                        if (data.status == 400) {
                            Swal.fire({
                                title: "Failed",
                                icon: "error",
                                text: data.message,
                            });
                        } else {
                            $("#DataTable").DataTable().ajax.reload();
                        }
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
    }

    function formSubmit() {
        $("#formSubmit").submit(function (e) {
            e.preventDefault();
            setError(displayErrors);
            $('button[type="submit"]').addClass("disabled");
            $('button[type="submit"]').html("Loading...");
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: $(this).attr("action"),
                method: $(this).attr("method"),
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    $('button[type="submit"]').removeClass("disabled");
                    $('button[type="submit"]').html(
                        '<em class="icon ni ni-send"></em><span> Save changes </span>'
                    );
                    Swal.fire({
                        title: "Success",
                        icon: "success",
                        text: data.messages,
                    }).then(function () {
                        $("#myModal").modal("hide");
                        $("body").removeClass("modal-open");
                        $(".modal-backdrop").remove();
                        pushState(data.redirect);
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.error(thrownError);
                    $('button[type="submit"]').removeClass("disabled");
                    $('button[type="submit"]').html(
                        '<em class="icon ni ni-send"></em><span> Save changes </span>'
                    );
                    if (xhr.status == 400) {
                        displayError(displayErrors, xhr.responseJSON);
                    } else if (xhr.status == 409) {
                        Swal.fire({
                            title: "Error " + xhr.status,
                            icon: "error",
                            text: xhr.responseJSON["messages"],
                        });
                    } else if(xhr.status == 422){
                        Swal.fire({
                            title: "Opps!",
                            icon: "warning",
                            text: xhr.responseJSON["messages"],
                        });
                    } else {
                        Swal.fire({
                            title: "Error " + xhr.status,
                            icon: "error",
                            text: thrownError,
                        });
                    }
                },
            });
        });
    }

    function displayError(options, data) {
        $.each(options, function (key, value) {
            if (
                data.messages[value.inputName] &&
                data.messages[value.inputName][0]
            ) {
                $(value.display).removeClass("d-none");
                $('input[name="' + value.inputName + '"]').addClass(
                    "is-invalid"
                );
                $(value.display).html(data.messages[value.inputName][0]);
            }
        });
    }
    function setError(options) {
        $.each(options, function (key, value) {
            $(value.display).addClass("d-none");
            $('input[name="' + value.inputName + '"]').removeClass(
                "is-invalid"
            );
        });
    }

    $.each(displayErrors, function (key, value) {
        $('input[name="' + value.inputName + '"]').keydown(function () {
            $(value.display).addClass("d-none");
            $(this).removeClass("is-invalid");
        });
    });

    checkAll();
    function checkAll() {
        $("#uid").click(function () {
            if (this.checked == true) {
                $(".uid").prop("checked", true);
            } else {
                $(".uid").prop("checked", false);
            }
        });
    }

    storeModal();
    function storeModal() {
        $(".add").click(function () {
            $("#myModal form").attr("action", url + pathStoreUrl);
            $.each(displayErrors, function (key, value) {
                $('input[name="' + value.inputName + '"]').val("");
            });
        });
    }

    $("ul.nk-menu > li").click(function () {
        $("ul.nk-menu > li").removeClass("active");
        $(this).addClass("active");

        if (!$(".has-sub").hasClass("active")) {
            $(".nk-menu-sub").slideUp();
            $("ul.nk-menu-sub > li").removeClass("active");
        }
    });

    $("ul.nk-menu-sub > li").unbind("click");
    $("ul.nk-menu-sub > li").click(function () {
        $("ul.nk-menu-sub > li").removeClass("active");
        $(this).addClass("active");
        console.log($(this).attr("class"));
    });

    $(".custom-file-input").on("change", function (e) {
        if ($(this).val()) {
            const fakePath = $(this).val().split("\\");
            $(this)
                .siblings("label")
                .html(fakePath[fakePath.length - 1]);
        } else {
            $(this).siblings("label").html("Choose file");
        }
    });

    $(".date-picker").datepicker({
        format: "yyyy-mm-dd",
    });

    $(".date-picker-year").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
    });
    

    if (typeof AutoNumeric != "undefined" && $(".autonumeric").length > 0) {
        new AutoNumeric(".autonumeric", {
            currencySymbol: "Rp. ",
            allowDecimalPadding: false,
        });
    }
});
