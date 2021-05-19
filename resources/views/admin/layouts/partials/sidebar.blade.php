<div class="nk-sidebar nk-sidebar-fixed " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="/administrator/dashboard" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="{{ asset('admin/uploads/img/'.getSetting('logo')) }}" srcset="{{ asset('admin/uploads/img/'.getSetting('logo')) }}" alt="logo">
                <img class="logo-dark logo-img" src="{{ asset('admin/uploads/img/'.getSetting('logo')) }}" srcset="{{ asset('admin/uploads/img/'.getSetting('logo')) }}" alt="logo-dark">
            </a>
        </div>
        <div class="nk-menu-trigger mr-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element">
        <div class="nk-sidebar-body" data-simplebar>
            <div class="nk-sidebar-content">
                <div class="nk-sidebar-menu">
                    <ul class="nk-menu">
                        @canany(['read-dashboard'])
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Dashboards</h6>
                            </li><!-- .nk-menu-item -->
                        @endcanany
                        @can('read-dashboard')
                            <li class="nk-menu-item">
                                <a href="/administrator/dashboard" class="ajaxAction nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-growth"></em></span>
                                    <span class="nk-menu-text">Analytics Dashboard</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                        @endcan
                        @canany(['read-users','read-roles','read-permissions'])
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Applications</h6>
                            </li><!-- .nk-menu-heading -->
                        @endcanany
                        @canany(['read-users','read-roles'])
                            <li class="nk-menu-item has-sub">
                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                    <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                    <span class="nk-menu-text">Management Users</span>
                                </a>
                                <ul class="nk-menu-sub">
                                    @can('read-users')
                                        <li class="nk-menu-item">
                                            <a href="/administrator/users" class="ajaxAction nk-menu-link"><span class="nk-menu-text">Users</span></a>
                                        </li>
                                    @endcan
                                    @can('read-roles')
                                        <li class="nk-menu-item">
                                            <a href="/administrator/roles" class="ajaxAction nk-menu-link"><span class="nk-menu-text">Roles</span></a>
                                        </li>
                                    @endcan
                                </ul><!-- .nk-menu-sub -->
                            </li><!-- .nk-menu-item -->
                        @endcanany
                        @can('read-permissions')
                            <li class="nk-menu-item">
                                <a href="/administrator/permissions" class="ajaxAction nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-security"></em></span>
                                    <span class="nk-menu-text">Permissions</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                        @endcan
                        <li class="nk-menu-heading">
                            <h6 class="overline-title text-primary-alt">Help Center</h6>
                        </li><!-- .nk-menu-heading -->
                        <li class="nk-menu-item">
                            <a href="/administrator/guides" class="ajaxAction nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-help"></em></span>
                                <span class="nk-menu-text">Master Panduan</span>
                            </a>
                        </li><!-- .nk-menu-item -->
                        @canany(['read-settings'])
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Settings</h6>
                            </li><!-- .nk-menu-heading -->
                        @endcanany
                        @can('read-settings')
                            <li class="nk-menu-item">
                                <a href="/administrator/settings" class="ajaxAction nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-setting"></em></span>
                                    <span class="nk-menu-text">Settings</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                        @endcan
                    </ul><!-- .nk-menu -->
                </div><!-- .nk-sidebar-menu -->
                <div class="nk-sidebar-footer">
                    <ul class="nk-menu nk-menu-footer">
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-help-alt"></em></span>
                                <span class="nk-menu-text">Support</span>
                            </a>
                        </li>
                        <li class="nk-menu-item ml-auto">
                            <div class="dropup">
                                <a href="#" class="nk-menu-link dropdown-indicator has-indicator" data-toggle="dropdown" data-offset="0,10">
                                    <span class="nk-menu-icon"><em class="icon ni ni-globe"></em></span>
                                    <span class="nk-menu-text">English</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                    <ul class="language-list">
                                        <li>
                                            <a href="#" class="language-item">
                                                <img src="{{ asset('admin/assets/images/flags/english.png') }}" alt="" class="language-flag">
                                                <span class="language-name">English</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="language-item">
                                                <img src="{{ asset('admin/assets/images/flags/spanish.png') }}" alt="" class="language-flag">
                                                <span class="language-name">Español</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="language-item">
                                                <img src="{{ asset('admin/assets/images/flags/french.png') }}" alt="" class="language-flag">
                                                <span class="language-name">Français</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="language-item">
                                                <img src="{{ asset('admin/assets/images/flags/turkey.png') }}" alt="" class="language-flag">
                                                <span class="language-name">Türkçe</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul><!-- .nk-footer-menu -->
                </div><!-- .nk-sidebar-footer -->
            </div><!-- .nk-sidebar-content -->
        </div><!-- .nk-sidebar-body -->
    </div><!-- .nk-sidebar-element -->
</div>
