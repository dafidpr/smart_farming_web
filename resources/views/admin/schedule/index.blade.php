@extends('admin.layouts.ajax')
@section('content')

<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">{{ $title }}</h3>
                <div class="nk-block-des text-soft">
                    <p>Anda dapat mengatur penjadwalan alat anda di halaman ini.</p>
                </div>
            </div><!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            <li><a href="/administrator/farmers" class="ajaxAction btn btn-light bg-white"><em class="icon ni ni-arrow-left"></em><span> Back</span></a></li>
                        </ul>
                    </div>
                </div><!-- .toggle-wrap -->
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="card card-bordered card-preview">
            <div class="card-inner-group">
                <div class="tab-content">
                    <div class="tab-pane active" id="tabGeneral">
                        <div class="card-inner p-4">
                            <div class="nk-block">
                                <div class="nk-data data-list" style="margin-top:-5px">
                                    @if ($schedules->count() > 0)
                                    @foreach ($schedules as $item)    
                                        <div class="nk-block">
                                            <div class="card card-bordered card-stretch">
                                                <div class="card-inner-group">
                                                    <div class="card-inner p-0">
                                                        <table class="nk-tb-list nk-tb-ulist">
                                                            <tbody>
                                                                <tr class="nk-tb-item">
                                                                    <td class="nk-tb-col">
                                                                        <a href="html/apps-kanban.html" class="project-title">
                                                                            <div class="user-avatar sq bg-purple"><span><em class="icon ni ni-clock"></em></span></div>
                                                                            <div class="project-info">
                                                                                <h6 class="title">{{ $item->start .' - '. $item->end }}</h6>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                  
                                                                    <td class="nk-tb-col tb-col-xxl">
                                                                        <span class="badge badge-dot badge-{{$item->is_active == 1 ? 'success' : 'danger'}}" id="schedule-status">{{$item->is_active == 1 ? 'Aktif' : 'Tidak Aktif'}}</span>
                                                                    </td>
                                                                    <td class="nk-tb-col tb-col-md">
                                                                        <div class="project-list-progress">
                                                                            <div class="custom-control custom-switch mr-n2">
                                                                                <input type="checkbox" class="custom-control-input" {{ $item->is_active == 1 ? 'checked="checked"' : '' }} id="schedule-action" onchange="scheduleAction('{{ Hashids::encode($item->id) }}')">
                                                                                <label class="custom-control-label" for="schedule-action"></label>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="nk-tb-col tb-col-mb">
                                                                        <span class="badge badge-dim badge-warning"><em class="icon ni ni-clock"></em><span>
                                                                            @php
                                                                                $start = strtotime($item->start);
                                                                                $end = strtotime($item->end);
                                                                                $diff = $end - $start;
                                                                                $hours = floor($diff / (60 * 60));
                                                                                $minutes = $diff - $hours * (60 * 60);
                                                                            @endphp    
                                                                        </span>{{ $hours }} jam {{ $minutes / 60 }} menit</span>
                                                                    </td>
                                                                    <td class="nk-tb-col nk-tb-col-tools">
                                                                        <ul class="nk-tb-actions gx-2">
                                                                            <li class="">
                                                                                <a  data-id="{{ Hashids::encode($item->id) }}" href="#myModal" data-toggle="modal" class="btn btn-sm btn-icon btn-trigger edit" data-toggle="tooltip" data-placement="top" title="Edit Jadwal">
                                                                                    <em class="icon ni ni-edit"></em>
                                                                                </a>
                                                                            </li>
                                                                            <li class="">
                                                                                <a href="{{ url('administrator/farmers/schedules/'. Hashids::encode($item->id) .'/delete') }}" class="btn btn-sm btn-icon btn-trigger deleteItem" data-toggle="tooltip" data-placement="top" title="Hapus Jadwal">
                                                                                    <em class="icon ni ni-trash"></em>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr><!-- .nk-tb-item -->
                                                            </tbody>
                                                        </table><!-- .nk-tb-list -->
                                                    </div><!-- .card-inner -->
                                                </div><!-- .card-inner-group -->
                                            </div><!-- .card -->
                                        </div><!-- .nk-block -->
                                    @endforeach
                                    @else
                                        <div>
                                            <img src="{{ asset('admin/uploads/img/ilustration/empty.svg') }}" class="mx-auto d-block mt-3 mb-3" width="37%" alt="">
                                            <p class="text-center mb-3">Opps! Tidak ada jadwal nihh</p>
                                            @can('create-schedules')      
                                                <div class="row mb-5">
                                                    <a href="#myModal" data-toggle="modal" class="btn btn-primary mx-auto add add-schedule"><em class="icon ni ni-plus"></em><span>Buat Jadwal</span> </a>
                                                </div>
                                            @endcan
                                        </div>
                                    @endif
                                </div><!-- data-list -->
                            </div>
                        </div><!-- .card-inner -->
                    </div>
                </div>
            </div><!-- .card-inner-group -->
        </div><!-- .card -->
    </div><!-- .nk-block -->
</div>
@component('admin._components.modal')
    @slot('id', 'myModal')
    @slot('title', 'Tambah Jadwal Baru')
    @slot('form')
        <form action="" method="POST" id="formSubmit">
    @endslot
    @include('admin.schedule._partials.form')
@endcomponent
@endsection
