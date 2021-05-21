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
                            <li><a href="/administrator/farmers" class="ajaxAction btn btn-light bg-white"><em class="icon ni ni-arrow-left"></em><span> Back</span></a></li>
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
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap" autocomplete="off" value="{{ isset($farmer->name) ? $farmer->name : '' }}">
                                        <i class="text-danger small d-none" id="nameErr"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-01">Username <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" {{ isset($farmer->username) ? 'readonly' : '' }} autocomplete="off" value="{{ isset($farmer->username) ? $farmer->username : '' }}">
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
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off" value="{{ isset($farmer->email) ? $farmer->email : '' }}">
                                    </div>
                                    <i class="text-danger small d-none" id="emailErr"></i>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-03">Password <span class="text-danger">{{ isset($farmer->password) ? '' : '*' }}</span></label>
                                    <div class="form-control-wrap">
                                        <a href="#" class="form-icon form-icon-right passcode-switch show-password" data-target="password">
                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                        </a>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off" {{ isset($farmer->password) ? 'disabled' : '' }}>
                                    </div>
                                    <i class="text-danger small d-none" id="passwordErr"></i>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-01">Tempat lahir</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="birthplace" name="birthplace" placeholder="Tempat Lahir" autocomplete="off" value="{{ isset($farmer->birthplace) ? $farmer->birthplace : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-01">Tanggal lahir</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control date-picker" id="birthday" name="birthday" placeholder="Tanggal Lahir" autocomplete="off" value="{{ isset($farmer->birthday) ? $farmer->birthday : '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <select class="form-select form-control form-control-lg" name="gender">
                                            @if (isset($farmer->gender))
                                                <option value="male" {{ $farmer->gender == 'male' ? 'selected' : ''}}>Laki-Laki</option>
                                                <option value="female" {{ $farmer->gender == 'female' ? 'selected' : ''}}>Perempuan</option>
                                            @else
                                                <option value="male">Laki-Laki</option>
                                                <option value="female">Perempuan</option>
                                            @endif
                                            </select>
                                        <i class="text-danger small d-none" id="genderErr"></i>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label" for="default-01">Nomor Telepon <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" autocomplete="off" value="{{ isset($farmer->phone) ? $farmer->phone : '' }}">
                                        <i class="text-danger small d-none" id="phoneErr"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label">Block <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <select class="form-select form-control form-control-lg" name="block">
                                            @if (isset($farmer->block))
                                                <option value="N" {{ $farmer->block == 'N' ? 'selected' : '' }}>Unblock</option>
                                                <option value="Y" {{ $farmer->block == 'Y' ? 'selected' : '' }}>Block</option>
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
                                    <label class="form-label" for="default-01">Serial Number <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="serial_number" name="serial_number" placeholder="Serial Number" autocomplete="off" value="{{ isset($farmer->serial_number) ? $farmer->serial_number : '' }}">
                                        <i class="text-danger small d-none" id="serialNumberErr"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label" for="default-01">Luas Lahan <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <input type="number" class="form-control" id="land_area" name="land_area" placeholder="Luas Lahan" autocomplete="off" value="{{ isset($farmer->land_area) ? $farmer->land_area : '' }}">
                                        <i class="text-danger small d-none" id="landAreaErr"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label">Kelompok Tani <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <select class="form-select form-control form-control-lg" name="farmer_group_id" data-search="on">
                                            @foreach ($farmerGroups as $item)
                                                @if (isset($farmer->farmer_group_id))
                                                    @if ($farmer->farmer_group_id == $item->id)
                                                        <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                                    @else
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
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

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="default-01">Alamat</label>
                                    <div class="form-control-wrap">
                                        <textarea name="address" id="address" cols="30" rows="1" class="form-control">{{ isset($farmer->address) ? $farmer->address : '' }}</textarea>
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