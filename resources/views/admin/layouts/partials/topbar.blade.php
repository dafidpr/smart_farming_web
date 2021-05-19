<div class="nk-header nk-header-fixed is-light">
    <div class="container-fluid">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger d-xl-none ml-n1">
                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
            </div>
            <div class="nk-header-brand d-xl-none">
                <a href="html/index.html" class="logo-link">
                    <img class="logo-light logo-img" src="{{ asset('admin/uploads/img/'.getSetting('logo')) }}" srcset="{{ asset('admin/uploads/img/'.getSetting('logo')) }}" alt="logo">
                    <img class="logo-dark logo-img" src="{{ asset('admin/uploads/img/'.getSetting('logo')) }}" srcset="{{ asset('admin/uploads/img/'.getSetting('logo')) }}" alt="logo-dark">
                </a>
            </div><!-- .nk-header-brand -->
            <div class="nk-header-news d-none d-xl-block">
                <div class="nk-news-list">
                    <a class="nk-news-item" href="#">
                        <div class="nk-news-icon">
                            <em class="icon ni ni-card-view"></em>
                        </div>
                        <div class="nk-news-text">
                            <p>{{ getSetting('web_name') }}</p>
                        </div>
                    </a>
                </div>
            </div><!-- .nk-header-news -->
            <div class="nk-header-tools">
                <ul class="nk-quick-nav">
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm">
                                    <img src="{{ asset('admin/uploads/img/profile').'/'.getInfoLogin()->picture }}" alt="">
                                </div>
                                <div class="user-info d-none d-md-block">
                                    <div class="user-status">{{ getInfoLogin()->roles[0]['name'] }}</div>
                                    <div class="user-name dropdown-indicator">{{ getInfoLogin()->name }}</div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right dropdown-menu-s1">
                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                <div class="user-card">
                                    <div class="user-avatar">
                                        <img src="{{ asset('admin/uploads/img/profile').'/'.getInfoLogin()->picture }}" alt="">
                                    </div>
                                    <div class="user-info">
                                        <span class="lead-text">{{ getInfoLogin()->name }}</span>
                                        <span class="sub-text">{{ getInfoLogin()->email }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a class="ajaxAction" href="/administrator/users/{{ Hashids::encode(getInfoLogin()->id) }}/detail"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                                    @if (getInfoLogin()->roles[0]->name == 'Developer')
                                        @can('update-users')
                                        <li><a class="ajaxAction" href="/administrator/users/{{ Hashids::encode(getInfoLogin()->id) }}/edit"><em class="icon ni ni-setting-alt"></em><span>Account Setting</span></a></li>
                                        @endcan
                                    @else
                                        <li><a class="ajaxAction" href="/administrator/lecturers/{{ Hashids::encode(getInfoLogin()->lecturer->id) }}/edit"><em class="icon ni ni-edit-alt"></em><span>Update Profile</span></a></li>
                                    @endif
                                   
                                    <li><a class="ajaxAction" href="/administrator/users/change_password"><em class="icon ni ni-shield-star"></em><span>Ubah Password</span></a></li>
                                    <li><a class="ajaxAction" href="/administrator/manuals"><em class="icon ni ni-help"></em><span>Panduan Pengguna</span></a></li>
                                </ul>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="/logout"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </li><!-- .dropdown -->
                </ul><!-- .nk-quick-nav -->
            </div><!-- .nk-header-tools -->
        </div><!-- .nk-header-wrap -->
    </div><!-- .container-fliud -->
</div>