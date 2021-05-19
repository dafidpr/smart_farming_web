@yield('content')

<script>
    document.title = "{{ $title .' | '. getSetting('web_name') }}";

    if(!window.jQuery){
        document.body.innerHTML = "";
        window.location.reload();
    }
</script>

<!-- JS Dynamic Dependencies -->
@stack('script')

@if(isset($mod))
<!--Script Custom-->
<script src="{{ asset('admin/mod/' . $mod . '.js') }}"></script>
@endif
<script src="{{ asset('admin/mod/mod_main.js') }}"></script>

