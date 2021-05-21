@extends('admin.layouts.ajax')
@section('content')

<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">{{ $title }}</h3>
                <div class="nk-block-des text-soft">
                    <p>Analytics Dashboard</p>
                </div>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-md-4">
                <div class="card card-bordered card-full">
                    <div class="card-inner">
                        <div class="card-title-group align-start mb-0">
                            <div class="card-title">
                                <h6 class="subtitle">Total User</h6>
                            </div>
                            <div class="card-tools">
                                <em class="card-hint icon ni ni-users" data-toggle="tooltip" data-placement="left" title="Total Deposited"></em>
                            </div>
                        </div>
                        <div class="card-amount">
                            <span class="amount">{{ $users->count() }}</span>
                        </div>
                        <div class="invest-data">
                            <div class="invest-data-amount g-2">
                                <div class="invest-data-history">
                                    <div class="title">User Aktif</div>
                                    <div class="amount">{{ $userUnblock->count() }} </div>
                                </div>
                                <div class="invest-data-history">
                                    <div class="title">User Terblokir</div>
                                    <div class="amount">{{ $userBlock->count() }} </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .card -->
            </div><!-- .col -->
            <div class="col-md-4">
                <div class="card card-bordered card-full">
                    <div class="card-inner">
                        <div class="card-title-group align-start mb-0">
                            <div class="card-title">
                                <h6 class="subtitle">Total Kelompok Tani</h6>
                            </div>
                            <div class="card-tools">
                                <em class="card-hint icon ni ni-home-alt" data-toggle="tooltip" data-placement="left" title="Total Withdraw"></em>
                            </div>
                        </div>
                        <div class="card-amount">
                            <span class="amount">{{ $farmerGroups->count() }}</span>
                            
                        </div>
                        <div class="invest-data">
                            <div class="invest-data-amount g-2">
                                <div class="invest-data-history">
                                    <div class="title">Keterangan</div>
                                    <div class="amount">Mitra Kelompok Tani</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .card -->
            </div><!-- .col -->
            <div class="col-md-4">
                <div class="card card-bordered  card-full">
                    <div class="card-inner">
                        <div class="card-title-group align-start mb-0">
                            <div class="card-title">
                                <h6 class="subtitle">Total Petani</h6>
                            </div>
                            <div class="card-tools">
                                <em class="card-hint icon ni ni-user-list" data-toggle="tooltip" data-placement="left" title="Total Balance in Account"></em>
                            </div>
                        </div>
                        <div class="card-amount">
                            <span class="amount"> {{ $farmers->count() }} <span class="currency currency-usd">Org</span>
                            </span>
                        </div>
                        <div class="invest-data">
                            <div class="invest-data-amount g-2">
                                <div class="invest-data-history">
                                    <div class="title">Pending</div>
                                    <div class="amount">{{ $farmerPending->count() }}</div>
                                </div>
                                <div class="invest-data-history">
                                    <div class="title">Reject</div>
                                    <div class="amount">{{ $farmerReject->count() }}</div>
                                </div>
                                <div class="invest-data-history">
                                    <div class="title">Terblokir</div>
                                    <div class="amount">{{ $farmerBlock->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .card -->
            </div><!-- .col -->
            <div class="col-xl-12 col-xxl-8">
                <div class="card card-bordered card-full">
                    <div class="card-inner border-bottom">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Permintaan Registrasi</h6>
                            </div>
                            <div class="card-tools">
                                <a href="/administrator/farmers" class="link ajaxAction">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="nk-tb-list">
                        <div class="nk-tb-item nk-tb-head">
                            <div class="nk-tb-col"><span>Nama</span></div>
                            <div class="nk-tb-col tb-col-sm"><span>Kelompok</span></div>
                            <div class="nk-tb-col tb-col-lg"><span>Registrasi</span></div>
                            <div class="nk-tb-col"><span>Status</span></div>
                            <div class="nk-tb-col"><span>&nbsp;</span></div>
                        </div>
                        @foreach ($farmerPending as $item)    
                            <div class="nk-tb-item">
                                <div class="nk-tb-col">
                                    <div class="user-name">
                                        <span class="tb-lead">{{ $item->name }}</span>
                                    </div>
                                </div>
                                <div class="nk-tb-col tb-col-sm">
                                    <div class="user-card">
                                        <div class="user-name">
                                            <span class="tb-lead">{{ $item->farmerGroup->name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="nk-tb-col tb-col-lg">
                                    <span class="tb-sub">{{ $item->created_at }}</span>
                                </div>
                                <div class="nk-tb-col">
                                    <span class="badge badge-dot badge-warning">Pending</span>
                                </div>
                                <div class="nk-tb-col nk-tb-col-action"></div>
                            </div>
                        @endforeach
                    </div>
                </div><!-- .card -->
            </div><!-- .col -->
            <div class="col-lg-4">
                <div class="card card-bordered h-100">
                    <div class="card-inner-group">
                        <div class="card-inner card-inner-md">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Pintasan</h6>
                                </div>
                            </div>
                        </div><!-- .card-inner -->
                        <div class="card-inner">
                            <div class="nk-wg-action">
                                <div class="nk-wg-action-content">
                                    <em class="icon ni ni-user-list-fill"></em>
                                    <div class="title">Data Petani</div>
                                    <p>Lihat semua data petani.</p>
                                </div>
                                <a href="/administrator/farmers" class="btn btn-icon btn-trigger mr-n2 ajaxAction"><em class="icon ni ni-forward-ios"></em></a>
                            </div>
                        </div><!-- .card-inner -->
                        <div class="card-inner">
                            <div class="nk-wg-action">
                                <div class="nk-wg-action-content">
                                    <em class="icon ni ni-home-fill"></em>
                                    <div class="title">Kelompok Tani</div>
                                    <p>Lihat semua data kelompok tani. </p>
                                </div>
                                <a href="/administrator/farmer-groups" class="btn btn-icon btn-trigger mr-n2"><em class="icon ni ni-forward-ios"></em></a>
                            </div>
                        </div><!-- .card-inner -->
                        <div class="card-inner">
                            <div class="nk-wg-action">
                                <div class="nk-wg-action-content">
                                    <em class="icon ni ni-map-pin-fill"></em>
                                    <div class="title">Pemetaan Lokasi</div>
                                    <p>Lihat semua pemetaan lokasi kelompok tani.</p>
                                </div>
                                <a href="/administrator/mappings" class="btn btn-icon btn-trigger mr-n2 ajaxAction"><em class="icon ni ni-forward-ios"></em></a>
                            </div>
                        </div><!-- .card-inner -->
                    </div><!-- .card-inner-group -->
                </div><!-- .card -->
            </div><!-- .col -->
        </div>
    </div>
</div>

@endsection