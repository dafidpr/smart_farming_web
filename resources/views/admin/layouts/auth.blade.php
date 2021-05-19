@extends('admin.layouts.base')

@section('child')
<div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main ">
        <!-- wrap @s -->
        <div class="nk-wrap nk-wrap-nosidebar">
            <!-- content @s -->
            <div class="nk-content ">
               @yield('content')
            </div>
            <!-- wrap @e -->
        </div>
        <!-- content @e -->
    </div>
    <!-- main @e -->
</div>
@endsection

@section('script')
<script src="{{ asset('admin/assets/assets/js/bundle.js?ver=2.2.0') }}"></script>
<script src="{{ asset('admin/assets/assets/js/scripts.js?ver=2.2.0') }}"></script>
<script src="{{ asset('admin/assets/assets/js/example-sweetalert.js?ver=2.2.0') }}"></script>
<script src="{{ asset('admin/mod/mod_auth.js') }}"></script>
@endsection