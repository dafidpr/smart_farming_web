@extends('admin.layouts.ajax')
@section('content')

<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">{{ $title }}</h3>
                <div class="nk-block-des text-soft">
                    <p>You have total {{ $farmers->count() }}  petani.</p>
                </div>
            </div><!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            @can('create-farmers')
                                <li><a href="/administrator/farmers/create" class="ajaxAction btn btn-light bg-white"><em class="icon ni ni-plus"></em><span>Tambah  Petani</span></a></li>
                            @endcan
                        </ul>
                    </div>
                </div><!-- .toggle-wrap -->
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="card card-bordered card-preview">
            <div class="card-inner-group">
                <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tabGeneral"><em class="icon ni ni-db"></em><span> Semua Petani</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabImage"><em class="icon ni ni-layout"></em><span> Permintaan Registrasi</span></a>
                        @if ($farmerPending->count() > 0)
                            <div class="dot dot-primary" style="margin-bottom:10px"></div>
                        @endif
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabConfig"><em class="icon ni ni-trash"></em><span> Trash</span></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tabGeneral">
                        <div class="card-inner p-4">
                            <div class="nk-block">
                                <div class="nk-block-head" style="margin-top:-15px">
                                    <h5 class="title">Semua Data Petani</h5>
                                    <p>Semua data petani yang petani ada pada halaman ini.</p>
                                </div><!-- .nk-block-head -->
                                <div class="card-inner-group">
                                    {{-- <div class="card-inner position-relative card-tools-toggle">
                                        <div class="card-title-group">
                                            <div class="card-tools">
                                                @can('delete-farmers')     
                                                <div class="form-inline flex-nowrap gx-3">
                                                    <div class="form-wrap w-150px">
                                                        <select class="form-select form-select-sm" name="action" data-search="off" data-placeholder="Bulk Action">
                                                            <option value="">Bulk Action</option>
                                                            <option value="delete">Delete</option>
                                                        </select>
                                                    </div>
                                                    <div class="btn-wrap">
                                                        <span class="d-none d-md-block"><button class="btn btn-dim btn-outline-light bulk-action" data-url="/administrator/farmers/multipleDelete">Apply</button></span>
                                                        <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon bulk-action" data-url="/administrator/farmers/multipleDelete"><em class="icon ni ni-arrow-right"></em></button></span>
                                                    </div>
                                                </div><!-- .form-inline -->
                                                @endcan
                                            </div><!-- .card-tools -->
                                        </div><!-- .card-title-group -->
                                    </div><!-- .card-inner --> --}}
                                    <div class="card-inner p-4">
                                        <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false" id="">
                                            <thead class="nk-tb-head bg-light-table">
                                                <tr class="nk-tb-item">
                                                    {{-- <th class="nk-tb-col nk-tb-col-check">
                                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                                            <input type="checkbox" class="custom-control-input" id="uid">
                                                            <label class="custom-control-label" for="uid"></label>
                                                        </div>
                                                    </th> --}}
                                                    <th class="nk-tb-col"><span class="sub-text">Nama Petani</span></th>
                                                    <th class="nk-tb-col tb-col-mb"><span class="sub-text">Kelompok Tani</span></th>
                                                    <th class="nk-tb-col tb-col-mb"><span class="sub-text">Nomor Telp</span></th>
                                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">Email</span></th>
                                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">Luas Lahan</span></th>
                                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Status</span></th>
                                                    <th class="nk-tb-col nk-tb-col-tools text-right"></th>
                                                </tr>
                                            </thead><!-- .nk-tb-item -->
                                            <tbody>
                                                @foreach ($farmers as $item) 
                                                    <tr class="nk-tb-item">
                                                        {{-- <td class="nk-tb-col nk-tb-col-check">
                                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                <input type="checkbox" class="custom-control-input uid deleteItems" value="{{ $item->id }}" id="uid{{ $loop->iteration  }}">
                                                                <label class="custom-control-label" for="uid{{ $loop->iteration  }}"></label>
                                                            </div>
                                                        </td> --}}
                                                        <td class="nk-tb-col">
                                                            <div>
                                                                <div class="user-card">
                                                                    <div class="user-info">
                                                                        <span class="tb-lead">{{ $item->name }}</span>
                                                                        <ul class="list-status">
                                                                            <li><em class="icon ni ni-alert-circle"></em> <span>Serial Number : {{ $item->serial_number }}</span></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-mb">
                                                            <span>{{ $item->farmerGroup->name }}</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-mb">
                                                            <span>{{ $item->phone }}</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span>{{ $item->email }}</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span>{{ $item->land_area }} M2</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-lg">
                                                            <span class="badge badge-dot badge-{{$item->block == 'Y' ? 'danger' : 'success'}}">{{$item->block == 'Y' ? 'Terblokir' : 'Aktif'}}</span>
                                                        </td>
                                                        <td class="nk-tb-col nk-tb-col-tools">
                                                            @canany(['update-farmers','delete-farmers'])
                                                                <ul class="nk-tb-actions gx-1">
                                                                    <li>
                                                                        <div class="drodown">
                                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                <ul class="link-list-opt no-bdr">
                                                                                    @can('update-farmers')
                                                                                        <li><a href="/administrator/farmers/{{ Hashids::encode($item->id) }}/edit" class="ajaxAction"><em class="icon ni ni-edit"></em><span>Edit  Petani</span></a></li> 
                                                                                    @endcan
                                                                                    @can('delete-farmers')
                                                                                        <li><a class="deleteItem" href="/administrator/farmers/{{ Hashids::encode($item->id) }}/delete"><em class="icon ni ni-trash"></em><span>Delete  Petani</span></a></li>
                                                                                    @endcan
                                                                                    @can('update-farmers')     
                                                                                        <li class="divider"></li>
                                                                                        <li><a href="#" class="block-farmer" data-id="{{ Hashids::encode($item->id) }}"><em class="{{ $item->block == 'N' ? 'icon ni ni-na' : 'icon ni ni-unlock' }}"></em><span>{{ $item->block == 'N' ? 'Block Petani' : 'Unblock Petani' }}</span></a></li>
                                                                                    @endcan
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            @endcanany
                                                        </td>
                                                    </tr><!-- .nk-tb-item -->
                                                @endforeach
                                            </tbody>
                                        </table><!-- .nk-tb-list -->
                                    </div><!-- .card-inner -->
                                </div><!-- .card-inner-group -->
                            </div>
                        </div><!-- .card-inner -->
                    </div>
                    <div class="tab-pane" id="tabImage">
                        <div class="card-inner p-4">
                            <div class="nk-block">
                                <div class="nk-block-head" style="margin-top:-15px">
                                    <h5 class="title">Permintaan Registrasi</h5>
                                    <p>Semua permintaan registrasi petani ada pada halaman ini.</p>
                                </div><!-- .nk-block-head -->
                                <div class="card-inner-group">
                                    {{-- <div class="card-inner position-relative card-tools-toggle">
                                        <div class="card-title-group">
                                            <div class="card-tools">
                                                @can('delete-farmers')     
                                                <div class="form-inline flex-nowrap gx-3">
                                                    <div class="form-wrap w-150px">
                                                        <select class="form-select form-select-sm" name="action" data-search="off" data-placeholder="Bulk Action">
                                                            <option value="">Bulk Action</option>
                                                            <option value="delete">Delete</option>
                                                        </select>
                                                    </div>
                                                    <div class="btn-wrap">
                                                        <span class="d-none d-md-block"><button class="btn btn-dim btn-outline-light bulk-action" data-url="/administrator/farmers/multipleDelete">Apply</button></span>
                                                        <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon bulk-action" data-url="/administrator/farmers/multipleDelete"><em class="icon ni ni-arrow-right"></em></button></span>
                                                    </div>
                                                </div><!-- .form-inline -->
                                                @endcan
                                            </div><!-- .card-tools -->
                                        </div><!-- .card-title-group -->
                                    </div><!-- .card-inner --> --}}
                                    <div class="card-inner p-4">
                                        <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false" id="">
                                            <thead class="nk-tb-head bg-light-table">
                                                <tr class="nk-tb-item">
                                                    {{-- <th class="nk-tb-col nk-tb-col-check">
                                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                                            <input type="checkbox" class="custom-control-input" id="uid">
                                                            <label class="custom-control-label" for="uid"></label>
                                                        </div>
                                                    </th> --}}
                                                    <th class="nk-tb-col"><span class="sub-text">Nama Kelompok Tani</span></th>
                                                    <th class="nk-tb-col tb-col-mb"><span class="sub-text">Kelompok Tani</span></th>
                                                    <th class="nk-tb-col tb-col-mb"><span class="sub-text">Nomor Telp</span></th>
                                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">Email</span></th>
                                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">Luas Lahan</span></th>
                                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Status</span></th>
                                                    <th class="nk-tb-col nk-tb-col-tools text-right"></th>
                                                </tr>
                                            </thead><!-- .nk-tb-item -->
                                            <tbody>
                                                @foreach ($farmerPending as $item) 
                                                    <tr class="nk-tb-item">
                                                        {{-- <td class="nk-tb-col nk-tb-col-check">
                                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                <input type="checkbox" class="custom-control-input uid deleteItems" value="{{ $item->id }}" id="uid{{ $loop->iteration  }}">
                                                                <label class="custom-control-label" for="uid{{ $loop->iteration  }}"></label>
                                                            </div>
                                                        </td> --}}
                                                        <td class="nk-tb-col">
                                                            <div>
                                                                <div class="user-card">
                                                                    <div class="user-info">
                                                                        <span class="tb-lead">{{ $item->name }}</span>
                                                                        <ul class="list-status">
                                                                            <li><em class="icon ni ni-alert-circle"></em> <span>Serial Number : {{ $item->serial_number }}</span></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-mb">
                                                            <span>{{ $item->farmerGroup->name }}</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-mb">
                                                            <span>{{ $item->phone }}</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span>{{ $item->email }}</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span>{{ $item->land_area }} M2</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-lg">
                                                            <span class="badge badge-dot badge-warning">Pending</span>
                                                        </td>
                                                        <td class="nk-tb-col nk-tb-col-tools">
                                                            @canany(['update-farmers'])
                                                                <ul class="nk-tb-actions gx-1">
                                                                    <li>
                                                                        <div class="drodown">
                                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                <ul class="link-list-opt no-bdr">
                                                                                    @can('update-farmers')
                                                                                        <li><a data-url="/administrator/farmers/{{ Hashids::encode($item->id) }}/approve" href="#" data-action="approve" class="change-status"><em class="icon ni ni-check-c"></em><span>Approve  Petani</span></a></li> 
                                                                                    @endcan
                                                                                    @can('update-farmers')
                                                                                        <li><a class="change-status" href="#" data-action="reject" data-url="/administrator/farmers/{{ Hashids::encode($item->id) }}/reject"><em class="icon ni ni-cross-c"></em><span>Reject  Petani</span></a></li>
                                                                                    @endcan
                                                                                    @can('delete-farmers')
                                                                                        <li><a class="deleteItem" href="/administrator/farmers/{{ Hashids::encode($item->id) }}/delete"><em class="icon ni ni-trash"></em><span>Delete  Petani</span></a></li>
                                                                                    @endcan
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            @endcanany
                                                        </td>
                                                    </tr><!-- .nk-tb-item -->
                                                @endforeach
                                            </tbody>
                                        </table><!-- .nk-tb-list -->
                                    </div><!-- .card-inner -->
                                </div><!-- .card-inner-group -->
                            </div>
                              
                        </div><!-- .card-inner -->
                    </div>
                    <div class="tab-pane" id="tabConfig">
                        <div class="card-inner p-4">
                            <div class="nk-block">
                                <div class="nk-block-head" style="margin-top:-15px">
                                    <h5 class="title">Trash</h5>
                                    <p>Semua petani yang registrasinya di tolak ada di sini.</p>
                                </div><!-- .nk-block-head -->
                                <div class="card-inner-group">
                                    {{-- <div class="card-inner position-relative card-tools-toggle">
                                        <div class="card-title-group">
                                            <div class="card-tools">
                                                @can('delete-farmer-groups')     
                                                <div class="form-inline flex-nowrap gx-3">
                                                    <div class="form-wrap w-150px">
                                                        <select class="form-select form-select-sm" name="action" data-search="off" data-placeholder="Bulk Action">
                                                            <option value="">Bulk Action</option>
                                                            <option value="delete">Delete</option>
                                                        </select>
                                                    </div>
                                                    <div class="btn-wrap">
                                                        <span class="d-none d-md-block"><button class="btn btn-dim btn-outline-light bulk-action" data-url="/administrator/farmers/multipleDelete">Apply</button></span>
                                                        <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon bulk-action" data-url="/administrator/farmers/multipleDelete"><em class="icon ni ni-arrow-right"></em></button></span>
                                                    </div>
                                                </div><!-- .form-inline -->
                                                @endcan
                                            </div><!-- .card-tools -->
                                        </div><!-- .card-title-group -->
                                    </div><!-- .card-inner --> --}}
                                    <div class="card-inner p-4">
                                        <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false" id="">
                                            <thead class="nk-tb-head bg-light-table">
                                                <tr class="nk-tb-item">
                                                    {{-- <th class="nk-tb-col nk-tb-col-check">
                                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                                            <input type="checkbox" class="custom-control-input" id="uid">
                                                            <label class="custom-control-label" for="uid"></label>
                                                        </div>
                                                    </th> --}}
                                                    <th class="nk-tb-col"><span class="sub-text">Nama Kelompok Tani</span></th>
                                                    <th class="nk-tb-col tb-col-mb"><span class="sub-text">Kelompok Tani</span></th>
                                                    <th class="nk-tb-col tb-col-mb"><span class="sub-text">Nomor Telp</span></th>
                                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">Email</span></th>
                                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">Luas Lahan</span></th>
                                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Status</span></th>
                                                    <th class="nk-tb-col nk-tb-col-tools text-right"></th>
                                                </tr>
                                            </thead><!-- .nk-tb-item -->
                                            <tbody>
                                                @foreach ($farmerReject as $item) 
                                                    <tr class="nk-tb-item">
                                                        {{-- <td class="nk-tb-col nk-tb-col-check">
                                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                <input type="checkbox" class="custom-control-input uid deleteItems" value="{{ $item->id }}" id="uid{{ $loop->iteration  }}">
                                                                <label class="custom-control-label" for="uid{{ $loop->iteration  }}"></label>
                                                            </div>
                                                        </td> --}}
                                                        <td class="nk-tb-col">
                                                            <div>
                                                                <div class="user-card">
                                                                    <div class="user-info">
                                                                        <span class="tb-lead">{{ $item->name }}</span>
                                                                        <ul class="list-status">
                                                                            <li><em class="icon ni ni-alert-circle"></em> <span>Serial Number : {{ $item->serial_number }}</span></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-mb">
                                                            <span>{{ $item->farmerGroup->name }}</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-mb">
                                                            <span>{{ $item->phone }}</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span>{{ $item->email }}</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span>{{ $item->land_area }} M2</span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-lg">
                                                            <span class="badge badge-dot badge-danger">Rejected</span>
                                                        </td>
                                                        <td class="nk-tb-col nk-tb-col-tools">
                                                            @canany(['delete-farmers'])
                                                                <ul class="nk-tb-actions gx-1">
                                                                    <li>
                                                                        <div class="drodown">
                                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                <ul class="link-list-opt no-bdr">
                                                                                    @can('delete-farmers')
                                                                                        <li><a class="deleteItem" href="/administrator/farmers/{{ Hashids::encode($item->id) }}/delete"><em class="icon ni ni-trash"></em><span>Delete  Petani</span></a></li>
                                                                                    @endcan
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            @endcanany
                                                        </td>
                                                    </tr><!-- .nk-tb-item -->
                                                @endforeach
                                            </tbody>
                                        </table><!-- .nk-tb-list -->
                                    </div><!-- .card-inner -->
                                </div><!-- .card-inner-group -->
                            </div>
                        </div><!-- .card-inner -->
                    </div>
                </div>
            </div><!-- .card-inner-group -->
        </div><!-- .card -->
    </div><!-- .nk-block -->
</div>

@endsection