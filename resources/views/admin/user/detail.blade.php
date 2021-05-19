@extends('admin.layouts.ajax')
@section('content')

<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between g-3">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Users / <strong class="text-primary small">{{ $user->name }}</strong></h3>
                <div class="nk-block-des text-soft">
                    <ul class="list-inline">
                        <li>Email: <span class="text-base">{{ $user->email }}</span></li>
                        <li>Terakhir Login: <span class="text-base">{{ $user->last_login }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            <li><a href="/administrator/users" class="btn btn-light bg-white ajaxAction"><em class="icon ni ni-arrow-left"></em><span> Back</span></a></li>
                            @can('update-users')
                                <li><a href="/administrator/users/{{ Hashids::encode($user->id) }}/edit" class="btn btn-primary ajaxAction"><em class="icon ni ni-edit"></em><span>Edit Profile</span></a></li>
                            @endcan
                        </ul>
                    </div>
                </div><!-- .toggle-wrap -->
            </div><!-- .nk-block-head-content -->
        </div>
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="card card-bordered">
            <div class="card-aside-wrap">
                <div class="card-content">
                    <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                        <li class="nav-item">
                            <a class="nav-link active" href="#"><em class="icon ni ni-user-circle"></em><span>Informasi Pribadi</span></a>
                        </li>
                    </ul><!-- .nav-tabs -->
                    <div class="card-inner">
                        <div class="nk-block">
                            <div class="nk-block-head">
                                <h5 class="title">Informasi Pribadi</h5>
                                <p>Informasi dasar mengenai data pengguna di aplikasi ini.</p>
                            </div><!-- .nk-block-head -->
                            <div class="profile-ud-list">
                                <div class="profile-ud-item">
                                    <div class="profile-ud wider">
                                        <span class="profile-ud-label">Nama Lengkap</span>
                                        <span class="profile-ud-value">{{ $user->name }}</span>
                                    </div>
                                </div>
                                <div class="profile-ud-item">
                                    <div class="profile-ud wider">
                                        <span class="profile-ud-label">Username</span>
                                        <span class="profile-ud-value">{{ $user->username }}</span>
                                    </div>
                                </div>
                                <div class="profile-ud-item">
                                    <div class="profile-ud wider">
                                        <span class="profile-ud-label">Email</span>
                                        <span class="profile-ud-value">{{ $user->email }}</span>
                                    </div>
                                </div>
                                <div class="profile-ud-item">
                                    <div class="profile-ud wider">
                                        <span class="profile-ud-label">Role</span>
                                        <span class="profile-ud-value">{{ $user->roles[0]['name'] }}</span>
                                    </div>
                                </div>
                                <div class="profile-ud-item">
                                    <div class="profile-ud wider">
                                        <span class="profile-ud-label">Nomor Telepon</span>
                                        <span class="profile-ud-value">{{ $user->phone_number }}</span>
                                    </div>
                                </div>
                                <div class="profile-ud-item">
                                    <div class="profile-ud wider">
                                        <span class="profile-ud-label">Kelompok Tani</span>
                                        <span class="profile-ud-value">{{ $user->farmer_group_id != null ?  $user->farmerGroup->name : 'Root' }}</span>
                                    </div>
                                </div>
                            </div><!-- .profile-ud-list -->
                        </div><!-- .nk-block -->
                        <div class="nk-block">
                            <div class="nk-block-head nk-block-head-line">
                                <h6 class="title overline-title text-base">Informasi Tambahan</h6>
                            </div><!-- .nk-block-head -->
                            <div class="profile-ud-list">
                                <div class="profile-ud-item">
                                    <div class="profile-ud wider">
                                        <span class="profile-ud-label">Teregistrasi</span>
                                        <span class="profile-ud-value">{{ $user->created_at }}</span>
                                    </div>
                                </div>
                                <div class="profile-ud-item">
                                    <div class="profile-ud wider">
                                        <span class="profile-ud-label">Terakhir Login</span>
                                        <span class="profile-ud-value">{{ $user->last_login }}</span>
                                    </div>
                                </div>
                                <div class="profile-ud-item">
                                    <div class="profile-ud wider">
                                        <span class="profile-ud-label">Picture</span>
                                        <span class="profile-ud-value">
                                            <div class="user-avatar bg-primary ml-auto">
                                                <img src="{{ asset('admin/uploads/img/profile').'/'.$user->picture }}" alt="" width="100%">
                                             </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="profile-ud-item">
                                    <div class="profile-ud wider">
                                        <span class="profile-ud-label">Status</span>
                                        <span class="profile-ud-value">
                                            <span class="badge badge-dot badge-{{$user->block == 'Y' ? 'danger' : 'success'}}">{{$user->block == 'Y' ? 'Terblokir' : 'Aktif'}}</span>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- .profile-ud-list -->
                        </div><!-- .nk-block -->
                    </div><!-- .card-inner -->
                </div><!-- .card-content -->
            </div><!-- .card-aside-wrap -->
        </div><!-- .card -->
    </div><!-- .nk-block -->
</div>

@endsection