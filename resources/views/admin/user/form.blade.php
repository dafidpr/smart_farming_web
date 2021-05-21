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
                            <li><a href="/administrator/users" class="ajaxAction btn btn-light bg-white"><em class="icon ni ni-arrow-left"></em><span> Back</span></a></li>
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
                                    <label class="form-label" for="default-01">Nama Lengkap <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap" autocomplete="off" value="{{ isset($user->name) ? $user->name : '' }}">
                                        <i class="text-danger small d-none" id="nameErr"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-01">Username <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" autocomplete="off" {{ isset($user->username) ? 'readonly' : '' }} value="{{ isset($user->username) ? $user->username : '' }}">
                                        <i class="text-danger small d-none" id="usernameErr"></i>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-03">Email <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-mail"></em>
                                        </div>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off" value="{{ isset($user->email) ? $user->email : '' }}">
                                    </div>
                                    <i class="text-danger small d-none" id="emailErr"></i>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-03">Password <span class="text-danger">{{ isset($user->password) ? '' : '*' }}</span></label>
                                    <div class="form-control-wrap">
                                        <a href="#" class="form-icon form-icon-right passcode-switch show-password" data-target="password">
                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                        </a>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off" {{ isset($user->password) ? 'disabled' : '' }}>
                                    </div>
                                    <i class="text-danger small d-none" id="passErr"></i>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Role <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <select class="form-select form-control form-control-lg" data-placeholder="{{ isset($user->name) ? ($user->roles[0]->name == 'Developer' ? 'Anda Sebagai Developer' : 'Pilih Role') : 'Pilih Role' }}" data-search="on" name="role">
                                            @foreach ($roles as $item)
                                                @if (isset($user->roles[0]->id))
                                                    @if ($user->roles[0]->name != 'Developer')
                                                        @if ($item->id == $user->roles[0]->id)
                                                            <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                                        @else
                                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endif
                                                    @endif
                                                @else
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <i class="text-danger small d-none" id="roleErr"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Kelompok Tani <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <select class="form-select form-control form-control-lg" data-placeholder="{{ isset($user->name) ? ($user->roles[0]->name == 'Developer' ? 'Anda Sebagai Developer' : 'Pilih Kelompok Tani') : 'Pilih Kelompok Tani' }}" data-search="on" name="farmer_group">
                                            @foreach ($farmerGroups as $item)
                                                @if (isset($user->farmer_group_id) OR isset($user->name))
                                                    @if ($user->roles[0]->name != 'Developer')
                                                        @if ($item->id == $user->farmer_group_id)
                                                            <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                                        @else
                                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endif
                                                    @endif
                                                @else
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <i class="text-danger small d-none" id="farmerGroupErr"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label" for="default-01">Nomor Telepon</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" autocomplete="off" value="{{ isset($user->phone_number) ? $user->phone_number : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label">Block <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <select class="form-select form-control form-control-lg" name="block">
                                            @if (isset($user->block))
                                                <option value="N" {{ $user->block == 'N' ? 'selected' : '' }}>Unblock</option>
                                                <option value="Y" {{ $user->block == 'Y' ? 'selected' : '' }}>Block</option>
                                            @else
                                                <option value="N">Unblock</option>
                                                <option value="Y">Block</option>
                                            @endif
                                            </select>
                                        <i class="text-danger small d-none" id="blockErr"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label" for="default-06">Picture</label>
                                    <div class="form-control-wrap">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="picture" id="pic">
                                            <label class="custom-file-label"  for="">Choose file</label>
                                        </div>
                                        <i class="text-danger small d-none" id="picErr"></i>
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