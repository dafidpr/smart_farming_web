@extends('admin.layouts.auth')
@section('content')

<div class="nk-block nk-block-middle nk-auth-body  wide-xs">
    <div class="brand-logo pb-4 text-center">
        <a href="/" class="logo-link">
            <img class="logo-light logo-img" src="{{ asset('admin/uploads/img/' .getSetting('logo')) }}" srcset="{{ asset('admin/uploads/img/' .getSetting('logo')) }}" alt="logo">
            <img class="logo-dark logo-img" src="{{ asset('admin/uploads/img/' .getSetting('logo')) }}" srcset="{{ asset('admin/uploads/img/' .getSetting('logo')) }}" alt="logo-dark">
        </a>
    </div>
   
    <div class="card card-bordered mb-5">
        <div class="card-inner card-inner-lg">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title">Sign-In</h4>
                    <div class="nk-block-des">
                        <p>Access the Dashboard panel using your email and password.</p>
                    </div>
                </div>
            </div>
                
            <div class="d-error"></div>
            <form action="/login" method="POST" id="formLogin">
                <div class="form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="default-01">Username</label>
                    </div>
                    <input type="text" class="form-control form-control-lg" name="username" id="default-01" placeholder="Masukan username anda" autocomplete="off">
                    <i class="text-danger small d-none" id="usernameErr"></i>
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="password">Password</label>
                        <a class="link link-primary link-sm" href="/forgot">Forgot Password?</a>
                    </div>
                    <div class="form-control-wrap">
                        <a href="#" class="form-icon form-icon-right passcode-switch show-password" data-target="password">
                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                        </a>
                        <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="Masukan password anda" autocomplete="off">
                    </div>
                    <i class="text-danger small d-none" id="passErr"></i>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-lg btn-primary btn-block">Sign in</button>
                </div>
            </form>
        </div>
    </div>
</div>
    
@endsection