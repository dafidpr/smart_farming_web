@extends('admin.layouts.base')

@section('child')
<div class="nk-body bg-white npc-general pg-error d-none" id="contentError">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle wide-xs mx-auto">
                        <div class="nk-block-content nk-error-ld text-center">
                            <h1 class="nk-error-head" id="errorTitle"></h1>
                            <h3 class="nk-error-title">Oops! Why you’re here?</h3>
                            <p class="nk-error-text">We are very sorry for inconvenience. It looks like you’re try to access a page that either has been deleted or never existed.</p>
                        </div>
                    </div><!-- .nk-block -->
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
</div>

<div class="nk-app-root" id="contentMain">
    <!-- main @s -->
    <div class="nk-main ">
        <!-- sidebar @s -->
        @include('admin.layouts.partials.sidebar')
        <!-- sidebar @e -->
        <!-- wrap @s -->
        <div class="nk-wrap ">
            <!-- main header @s -->
            @include('admin.layouts.partials.topbar')
            <!-- main header @e -->
            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-lg">
                    <div class="loaderAction">
                        <ol>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ol>
                    </div>

                    <div id="renderContent"></div>
                </div>
            </div>
            <!-- content @e -->
            <!-- footer @s -->
            <div class="nk-footer">
                <div class="container-fluid">
                    <div class="nk-footer-wrap">
                        <div class="nk-footer-copyright"> &copy; 2020 - {{ date('Y') }} {{ getSetting('copyright') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer @e -->
        </div>
        <!-- wrap @e -->
    </div>
    <!-- main @e -->
</div>
<!-- app-root @e -->
@endsection
<!-- JavaScript -->
@section('script')
<script src="{{ asset('admin/assets/assets/js/bundle.js?ver=2.2.0') }}"></script>
<script src="{{ asset('admin/assets/assets/js/scripts.js?ver=2.2.0') }}"></script>
<script src="{{ asset('admin/assets/assets/js/charts/gd-default.js?ver=2.2.0') }}"></script>
<script src="{{ asset('admin/assets/assets/js/charts/gd-analytics.js?ver=2.2.0') }}"></script>
<script src="{{ asset('admin/assets/assets/js/libs/jqvmap.js?ver=2.2.0') }}"></script>
<script src="{{ asset('admin/assets/assets/js/example-sweetalert.js?ver=2.2.0') }}"></script>

<!-- Create SPA -->
<script>
loadContent();

function loadAjaxAction(){
    $('a.ajaxAction').unbind('click');
    $('a.ajaxAction').click(function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var toggle = $(this).attr('data-toggle');

        if(url !== '#' && toggle !== 'modal')
        pushState(url);
    })

    window.onpopstate = function(){
        loadContent();
    }

    NioApp.DataTable.init();
    NioApp.Select2.init();
    isDelete();
    deleteItems();
}

function pushState(url){
    history.pushState(null, null, url);
    loadContent();
}

function loadContent(){
    loadAjaxAction();
    // $('.pre-loader').removeClass('hide');
    $('#contentError').addClass('d-none');
    $('#renderContent').removeClass('fadeLoader');
    $('.loaderAction').removeClass('d-none');
    $('#contentMain').show();
    $.ajax({
        url: window.location.href,
        contentType: 'text/html',
        success: function(data){
            $('.loaderAction').addClass('d-none');
            $('.pre-loader').addClass('hide');
            $('#renderContent').html(data);
            $('#renderContent').addClass('fadeLoader');
            loadAjaxAction();
        },
        error: function(xhr){
            $('#contentMain').hide();
            $('#errorTitle').html(xhr.status);
            $('#contentError').removeClass('d-none');
        }
    })
}

function isDelete(){
    $('.deleteItem').click(function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
            title: "Hapus Item ?",
            icon: "question",
            text: "Apakah anda yakin ingin menghapus item ini ?",
            showConfirmButton: true,
            confirmButtonText: "Yes, delete it",
            showCancelButton: true,
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
            	$.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    method: 'delete',
            		dataType: "json",
            		success: function (data) {
                        swal.fire({
                            title: 'Success',
                            icon: 'success',
                            text: 'Data berhasil dihapus'
                        }).then(function(){
                            loadContent();
                        })
            		},
            		error: function (xhr, ajaxOptioins, thrownError) {
            			Swal.fire({
            				title: 'Kesalahan Penghapusan',
            				icon: "warning",
            				text: xhr.responseJSON.msg || thrownError,
            			});
            		},
            	});
            }
        });
    })
}

function deleteItems(){

    $('.bulk-action').click(function(){
        var action = $('select[name="action"').val();
        var url = $(this).data('url');

        if(action == ''){
            swal.fire({
                title: 'Warning!!!',
                icon: 'warning',
                text: 'Tidak ada aksi yang dipilih'
            });
        } else {
            if(action == 'delete'){
                var val = [];

                $('.deleteItems:checked').each(function(){
                    val.push($(this).val());
                })

                if(val.length == 0){
                    swal.fire({
                        title: 'Warning!!!',
                        icon: 'warning',
                        text: 'Tidak ada data yang dipilih.'
                    })
                } else {
                    Swal.fire({
                        title: "Hapus Item ?",
                        icon: "question",
                        text: "Apakah anda yakin ingin menghapus item yang dipilih ini ?",
                        showConfirmButton: true,
                        confirmButtonText: "Yes, delete it",
                        showCancelButton: true,
                        cancelButtonText: "No",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: url,
                                method: 'delete',
                                data: {id: val},
                                dataType: 'json',
                                success: function(data){
                                    swal.fire({
                                        title: 'Success',
                                        icon: 'success',
                                        text: 'Data berhasil dihapus'
                                    }).then(function(){
                                        loadContent();
                                    })
                                },
                                error: function(xhr, ajaxOptions, thrownError){
                                    swal.fire({
                                        title: 'Kesalahan Penghapusan',
                                        icon: 'warning',
                                        text: xhr.responseJSON.msg || thrownError
                                    });
                                }
                            })
                        }
                    });
                   
                }
            }
        }
    })

}
</script>

<!-- Start datatable js -->
{{-- <script src="{{ asset('admin/assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/datatables/responsive.bootstrap4.min.js') }}"></script> --}}
@if(isset($mod))
<!--Script Custom-->
<script src="{{ asset('admin/mod/' . $mod . '.js') }}"></script>
@endif
<script src="{{ asset('admin/mod/mod_main.js') }}"></script>
@endsection
