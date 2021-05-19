@extends('admin.layouts.ajax')
@section('content')

<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">{{ $title }}</h3>
            </div><!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            <li><a href="/administrator/farmer-groups" class="ajaxAction btn btn-light bg-white"><em class="icon ni ni-arrow-left"></em><span> Back</span></a></li>
                        </ul>
                    </div>
                </div><!-- .toggle-wrap -->
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="card card-bordered card-stretch">
            <div class="card-inner">
                <div class="preview-block">
                    <form action="{{ $action }}" method="post" enctype="multipart/form-data" id="formSubmit">
                        <div class="row gy-4">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-01">Nama Kelompok Tani <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Kelompok Tani" autocomplete="off" value="{{ isset($farmerGroup->name) ? $farmerGroup->name : '' }}">
                                        <i class="text-danger small d-none" id="nameErr"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-01">Nama Ketua <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="chairman" name="chairman" placeholder="Nama Ketua" autocomplete="off" value="{{ isset($farmerGroup->chairman) ? $farmerGroup->chairman : '' }}">
                                        <i class="text-danger small d-none" id="chairmanErr"></i>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-03">Tahun Terbentuk <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-calendar"></em>
                                        </div>
                                        <input type="text" class="form-control date-picker-year" id="year" name="year" placeholder="Tahun Terbentuk" autocomplete="off" value="{{ isset($farmerGroup->year_formed) ? $farmerGroup->year_formed : '' }}">
                                    </div>
                                    <i class="text-danger small d-none" id="yearErr"></i>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-03">Alamat <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-map-pin"></em>
                                        </div>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Alamat" autocomplete="off" value="{{ isset($farmerGroup->address) ? $farmerGroup->address : '' }}">
                                    </div>
                                    <i class="text-danger small d-none" id="addressErr"></i>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-01">Latitude <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude" autocomplete="off" value="{{ isset($farmerGroup->latitude) ? $farmerGroup->latitude : '' }}" readonly>
                                        <i class="text-danger small d-none" id="latitudeErr"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-01">Longitude <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Longitude" autocomplete="off" value="{{ isset($farmerGroup->longitude) ? $farmerGroup->longitude : '' }}" readonly>
                                        <i class="text-danger small d-none" id="longitudeErr"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div id='mapLocation' style='width: 100%; height: 300px;'></div>
                                </div>
                            </div>
                        </div>
                        <hr class="preview-hr">
                        <button type="submit" class="btn btn-primary"><em class="icon ni ni-send"></em><span> Save changes </span> </button>
                    </form>
                </div>
            </div>
        </div><!-- .card -->
    </div><!-- .nk-block -->
</div>

<script>

    mapboxgl.accessToken = map_token;
    var long = document.getElementById('longitude');
    var lat = document.getElementById('latitude');
    var setLat = {{ isset($farmerGroup->latitude) ? ($farmerGroup->latitude == null ?  -8.228027916016387 : $farmerGroup->latitude) :  -8.228027916016387 }};
    var setLong = {{ isset($farmerGroup->longitude) ? ($farmerGroup->longitude == null ? 114.36757301845535 : $farmerGroup->longitude) : 114.36757301845535 }};

    var map = new mapboxgl.Map({
        container: 'mapLocation',
        style: 'mapbox://styles/mapbox/streets-v11',
        zoom: 5,
        center: [setLong, setLat]
    });
    var marker = new mapboxgl.Marker({
        draggable: true
    }).setLngLat([setLong, setLat]).addTo(map);
    
    function onDragEnd(){
        
        var lngLat = marker.getLngLat();
        lat.value = lngLat.lat;
        long.value = lngLat.lng;
    }

    marker.on('dragend', onDragEnd);
</script>

@endsection