@extends('admin.layouts.ajax')
@section('content')

<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">{{ $title }}</h3>
                <div class="nk-block-des text-soft">
                    <p>Anda memiliki total {{ $permissions->count() }} permission.</p>
                </div>
            </div><!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            @can('create-permissions')
                                <li><a href="#myModal" data-toggle="modal" class="btn btn-light bg-white add add-permission"><em class="icon ni ni-plus"></em><span>Tambah Permission Baru</span></a></li>
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
                <div class="card-inner position-relative card-tools-toggle">
                    <div class="card-title-group">
                        <div class="card-tools">
                            @can('delete-permissions')     
                                <div class="form-inline flex-nowrap gx-3">
                                    <div class="form-wrap w-150px">
                                        <select class="form-select form-select-sm" data-search="off" name="action" data-placeholder="Bulk Action">
                                            <option value="">Bulk Action</option>
                                            <option value="delete">Delete</option>
                                        </select>
                                    </div>
                                    <div class="btn-wrap">
                                        <span class="d-none d-md-block bulk-action" data-url="{{ route('permission.bulk-destroy') }}"><button class="btn btn-dim btn-outline-light">Apply</button></span>
                                        <span class="d-md-none bulk-action" data-url="{{ route('permission.bulk-destroy') }}"><button class="btn btn-dim btn-outline-light btn-icon"><em class="icon ni ni-arrow-right"></em></button></span>
                                    </div>
                                </div><!-- .form-inline -->
                            @endcan
                        </div><!-- .card-tools -->
                    </div><!-- .card-title-group -->
                </div><!-- .card-inner -->
                <div class="card-inner p-4">
                    <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false" id="">
                        <thead class="nk-tb-head bg-light-table">
                            <tr class="nk-tb-item">
                                <th class="nk-tb-col nk-tb-col-check">
                                    <div class="custom-control custom-control-sm custom-checkbox notext">
                                        <input type="checkbox" class="custom-control-input" id="uid">
                                        <label class="custom-control-label" for="uid"></label>
                                    </div>
                                </th>
                                <th class="nk-tb-col"><span class="sub-text">Nama Permission</span></th>
                                <th class="nk-tb-col tb-col-mb"><span class="sub-text">Guard</span></th>
                                <th class="nk-tb-col nk-tb-col-tools text-right"></th>
                            </tr>
                        </thead><!-- .nk-tb-item -->
                        <tbody>
                            @foreach ($permissions as $item)
                                <tr class="nk-tb-item">
                                    <td class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" class="custom-control-input uid deleteItems" value="{{ $item->id }}" id="uid{{ $loop->iteration }}">
                                            <label class="custom-control-label" for="uid{{ $loop->iteration }}"></label>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col tb-col-mb">
                                        <span>{{ $item->name }}</span>
                                    </td>
                                    <td class="nk-tb-col tb-col-mb">
                                        <span>{{ $item->guard_name }}</span>
                                    </td>
                                    <td class="nk-tb-col nk-tb-col-tools">
                                        @canany(['update-permissions','delete-permissions'])
                                            <ul class="nk-tb-actions gx-1">
                                                <li>
                                                    <div class="drodown">
                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <ul class="link-list-opt no-bdr">
                                                                @can('update-permissions')
                                                                    <li><a href="#"><em class="icon ni ni-edit"></em><span>Edit Permission</span></a></li>
                                                                @endcan
                                                                @can('delete-permissions')
                                                                    <li><a class="deleteItem" href="{{ route('permission.destroy', ['id' => Hashids::encode($item->id)]) }}"><em class="icon ni ni-trash"></em><span>Delete Permission</span></a></li>
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
        </div><!-- .card -->
    </div><!-- .nk-block -->
</div>
@include('admin.permission.form')
@endsection