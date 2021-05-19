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
                            <li><a href="/administrator/users" class="btn btn-light bg-white"><em class="icon ni ni-arrow-left"></em><span> Back</span></a></li>
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
                    <form action="/administrator/users/change_password/update_password" method="post" id="formSubmit">
                        <div class="row gy-4">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="default-03">Password Lama <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <input type="password" class="form-control" name="current_password"  placeholder="Password Lama" autocomplete="off">
                                    </div>
                                    <i class="text-danger small d-none" id="currentPassErr"></i>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="default-03">Password Baru <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <input type="password" class="form-control" name="new_password"  placeholder="Password Baru" autocomplete="off">
                                    </div>
                                    <i class="text-danger small d-none" id="newPassErr"></i>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="default-03">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <input type="password" class="form-control" name="confirm_password"  placeholder="Konfirmasi Password" autocomplete="off">
                                    </div>
                                    <i class="text-danger small d-none" id="confirmPassErr"></i>
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