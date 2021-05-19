@extends('admin.layouts.base')

@section('child')
<div class="nk-app-root">
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
                    @yield('content')
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
<!-- <script src="{{ asset('admin/assets/assets/js/bundle.js?ver=2.2.0') }}"></script> -->
<script src="{{ asset('admin/assets/assets/js/scripts.js?ver=2.2.0') }}"></script>
<script src="{{ asset('admin/assets/assets/js/libs/jqvmap.js?ver=2.2.0') }}"></script>
<script src="{{ asset('admin/assets/assets/js/example-sweetalert.js?ver=2.2.0') }}"></script>

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