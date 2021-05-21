@extends('admin.layouts.ajax')
@section('content')
<style>
    .mapboxgl-popup {
max-width: 200px;
}
</style>
<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">{{ $title }}</h3>
                <p>Pemetaan Lokasi Kelompok Tani yang sudah bermitra dengan kami</p>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="card card-bordered card-stretch">
            <div class="card-inner">
                <div class="preview-block">
                    <div class="form-group">
                        <div id='mapLocation' style='width: 100%; height: 600px;'></div>
                    </div>
                </div>
            </div>
        </div><!-- .card -->
    </div><!-- .nk-block -->
</div>

<script>

    mapboxgl.accessToken = map_token;
    var map = new mapboxgl.Map({
        container: 'mapLocation',
        style: 'mapbox://styles/mapbox/streets-v11',
        zoom: 5,
        center: [114.36757301845535, -8.228027916016387]
    });
    
    $.ajax({
        url: url + '/administrator/mappings/getDataMap',
        dataType: 'json',
        success:function(res){
            var objJSON = {};
           res.response.forEach(function(data){
            new mapboxgl.Marker({
                    draggable: false
                })
                .setLngLat([data.longitude, data.latitude])
                .setPopup( new mapboxgl.Popup({ offset: 25 }) // add popups
                .setHTML('<h6>' + data.name + '</h6><p>' + data.address + '</p>'))
                .addTo(map);
           })
        } 
    });
    
</script>

@endsection