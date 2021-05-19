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
                            <li><a href="/administrator/roles" class="btn btn-light bg-white ajaxAction"><em class="icon ni ni-arrow-left"></em><span> Back</span></a></li>
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
                    <form action="{{ $action }}" method="post" id="formSubmit">
                        <div class="row gy-4">
                            <div class="col-md-12 text-center">
                                <div class="form-check">
                                    <label><input type="checkbox" id="uid" class="form-check-input" /> <b> Pilih Semua </b></label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    @foreach ($permissions as $idx => $permission)
                                        <div class="col-md-3 col-sm-6" style="margin-bottom: 10px">
                                            @foreach($permission as $singlePermission)
                                                <div class="form-check d-block">
                                                    <input type="checkbox" class="uid mr-1 form-check-input" id="uid-{{$idx . '-' . $loop->iteration }}" name="permission[]" value="{{ $singlePermission }}" {{ $role->hasPermissionTo($singlePermission) ? "checked" : "" }} /><label for="uid-{{ $idx . '-' . $loop->iteration }}" class="mb-0"> {{ $singlePermission }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
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

@endsection
