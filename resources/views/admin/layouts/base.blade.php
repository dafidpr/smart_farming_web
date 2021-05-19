<!DOCTYPE html>
<html lang="en" class="js">
<head>
    <meta charset="utf-8">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset('admin/uploads/img/' .getSetting('favicon')) }}">
    <title>{{ $title .' | '. getSetting('web_name') }}</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset('admin/assets/assets/css/dashlite.css?ver=2.2.0') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/assets/css/style.css') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('admin/assets/assets/css/theme.css?ver=2.2.0') }}">
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css' rel='stylesheet' />
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js'></script>


    <script>
        var url = '{{ url("") }}';
        var map_token = 'pk.eyJ1Ijoid2VibWVkaWEyNyIsImEiOiJjazg5dGFrd2wwM3N6M2dyeGRiYmtxMjZiIn0.0BobJA3lBPZKlAdMRq1OPA';
    </script>
</head>

<body class="nk-body bg-white has-sidebar ">
    <div class="pre-loader">
        <div class="pre-loader-content">
            <img src="{{ asset('admin/uploads/img/' .getSetting('logo')) }}" class="w-100" alt="">
        </div>
    </div>

    @yield('child')
    @yield('script')

    <script>
        $(window).on('load', function(){
            $('.pre-loader').addClass('hide');
        })
    </script>
</body>

</html>