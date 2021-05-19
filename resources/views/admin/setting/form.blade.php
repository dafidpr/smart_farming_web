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
                            <li><a href="/administrator/settings" class="btn btn-light bg-white ajaxAction"><em class="icon ni ni-arrow-left"></em><span> Back</span></a></li>
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
                                    <label class="form-label" for="default-01">Group <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="group" name="group" placeholder="Group Name" autocomplete="off" value="{{ isset($settings->groups) ? $settings->groups : '' }}" readonly>
                                        <i class="text-danger small d-none" id="groupErr"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-01">Option <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="option" name="option" placeholder="Option Name" autocomplete="off" value="{{ isset($settings->options) ? $settings->options : '' }}" readonly>
                                        <i class="text-danger small d-none" id="optionErr"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="default-01">Value <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        @if ($settings->groups == 'Image')
                                            <div class="img-prev">
                                                <img src="" id="imgPreview" class="d-none" alt="Image">
                                                <input type="file" id="value" name="value" class="d-none">
                                            </div>
                                            <div>     
                                                <label for="value" class="btn btn-dim btn-outline-primary btn-action mt-3">
                                                    <span>Upload Image</span><em class="icon ni ni-upload"></em>
                                                </label>
                                            </div>
                                            <i class="text-danger small d-none" id="valueErr"></i>
                                        @else
                                            <input type="text" class="form-control" id="value" name="value" placeholder="Value" autocomplete="off" value="{{ isset($settings->value) ? $settings->value : '' }}">
                                            <i class="text-danger small d-none" id="valueErr"></i>
                                        @endif
                                    </div>
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