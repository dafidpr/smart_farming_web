@extends('admin.layouts.ajax')
@section('content')

<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">{{ $title }}</h3>
                <div class="nk-block-des text-soft">
                    <p>Anda dapat membuat pengaturan untuk aplikasi anda di halaman ini.</p>
                </div>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="card card-bordered card-preview">
            <div class="card-inner-group">
                <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tabGeneral"><em class="icon ni ni-db"></em><span> General</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabImage"><em class="icon ni ni-layout"></em><span> Image</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabConfig"><em class="icon ni ni-layout"></em><span> Config</span></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tabGeneral">
                        <div class="card-inner p-4">
                            <div class="nk-block">
                                <div class="nk-block-head" style="margin-top:-15px">
                                    <h5 class="title">General Settings</h5>
                                    <p>Pengaturan dasar untuk aplikasi anda ada di sini.</p>
                                </div><!-- .nk-block-head -->
                                <div class="nk-data data-list" style="margin-top:-5px">
                                    <div class="data-head">
                                        <h6 class="overline-title">Pengaturan Dasar</h6>
                                    </div>
                                    @foreach ($general as $generalSetting )    
                                        <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                                            <div class="data-col">
                                                <span class="data-label">{{ $generalSetting->options }}</span>
                                                <span class="data-value">{{ $generalSetting->value }}</span>
                                            </div>
                                            <div class="data-col data-col-end"><a href="/administrator/settings/{{ Hashids::encode($generalSetting->id) }}/edit" class="data-more ajaxAction"><em class="icon ni ni-forward-ios"></em></a></div>
                                        </div><!-- data-item -->
                                    @endforeach
                                </div><!-- data-list -->
                            </div>
                        </div><!-- .card-inner -->
                    </div>
                    <div class="tab-pane" id="tabImage">
                        <div class="card-inner p-4">
                            <div class="nk-block">
                                <div class="nk-block-head" style="margin-top:-15px">
                                    <h5 class="title">Image Settings</h5>
                                    <p>Pengaturan gambar aplikasi anda ada di sini.</p>
                                </div><!-- .nk-block-head -->
                                <div class="nk-data data-list" style="margin-top:-5px">
                                    <div class="data-head">
                                        <h6 class="overline-title">Images</h6>
                                    </div>
                                    @foreach ($image as $imageSetting )    
                                        <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                                            <div class="data-col">
                                                <span class="data-label">{{ $imageSetting->options }}</span>
                                                <span class="data-value">{{ $imageSetting->value }}</span>
                                            </div>
                                            <div class="data-col data-col-end"><a href="/administrator/settings/{{ Hashids::encode($imageSetting->id) }}/edit" class="data-more ajaxAction"><em class="icon ni ni-forward-ios"></em></a></div>
                                        </div><!-- data-item -->
                                    @endforeach
                                </div><!-- data-list -->
                            </div>
                        </div><!-- .card-inner -->
                    </div>
                    <div class="tab-pane" id="tabConfig">
                        <div class="card-inner p-4">
                            <div class="nk-block">
                                <div class="nk-block-head" style="margin-top:-15px">
                                    <h5 class="title">Config Settings</h5>
                                    <p>Pengaturan konfigurasi aplikasi anda ada di sini.</p>
                                </div><!-- .nk-block-head -->
                                <div class="card card-bordered">
                                    <div class="card-inner-group">
                                        @foreach ($config as $configSetting)
                                        @if ($configSetting->options == 'maintenance_mode')     
                                            <div class="card-inner">
                                                <div class="between-center flex-wrap flex-md-nowrap g-3">
                                                    <div class="nk-block-text">
                                                        <h6>Maintenance Mode</h6>
                                                        <p>Anda dapat mengatur mode pemeliharaan di sini.</p>
                                                    </div>
                                                    <div class="nk-block-actions">
                                                        <ul class="align-center gx-3">
                                                            <li class="order-md-last">
                                                                <div class="custom-control custom-switch mr-n2">
                                                                    <input type="checkbox" class="custom-control-input" {{ $configSetting->value == 'Y' ? 'checked="checked"' : '' }} id="maintenance-mode" onchange="maintenanceMode('{{ Hashids::encode($configSetting->id) }}')">
                                                                    <label class="custom-control-label" for="maintenance-mode"></label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div><!-- .card-inner -->
                                        @endif
                                        @endforeach
                                    </div><!-- .card-inner-group -->
                                </div><!-- .card -->
                            </div>
                        </div><!-- .card-inner -->
                    </div>
                </div>
            </div><!-- .card-inner-group -->
        </div><!-- .card -->
    </div><!-- .nk-block -->
</div>
@endsection
