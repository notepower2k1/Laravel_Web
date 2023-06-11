@extends('auth/layouts.app')
@section('pageTitle','Đăng nhập')

@section('content')
    <div class="brand-logo pb-4 text-center">
        <a href="/" class="logo-link">
            <img class="logo-light logo-img logo-img-lg" src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/logo.png" srcset="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/logo.png 2x" alt="logo">
            <img class="logo-dark logo-img logo-img-lg" src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/logo.png" srcset="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/logo.png 2x" alt="logo-dark">
        </a>
    </div>

    <div class="card card-bordered">
        <div class="card-inner card-inner-lg">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title">Đăng nhập</h4>             
                </div>
            </div>

            @if(Session::has('fail'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('fail') }}
                @php
                    Session::forget('fail');
                @endphp
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-warning">
                @foreach ($errors->all() as $error)
                    <div class="">{{ $error }}</div>
                @endforeach

            </div>
            @endif
            <form method="POST" action="/login">
                @csrf
                <div class="form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="name">Tên tài khoản</label>
                    </div>
                    <div class="form-control-wrap">
                        <input id="name" type="name" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                        placeholder="Nhập tên tài khoản">

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="password">Mật khẩu</label>
                        <a class="link link-primary link-sm" href="/password/forgot">Quên mật khẩu?</a>
                    </div>
                    <div class="form-control-wrap">
                        <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                        </a>
                        <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"
                        placeholder="Nhập mật khẩu của bạn">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                </div>
                <div class="form-group">
                    <button  type="submit" class="btn btn-lg btn-primary btn-block">Đăng nhập</button>
                </div>
            </form>
            <div class="form-note-s2 text-center pt-4"> Chưa có tài khoản? <a href="/register">Đăng ký ngay</a>
            </div>
            <div class="text-center pt-4 pb-3">
                <h6 class="overline-title overline-title-sap"><span>Hoặc</span></h6>
            </div>
            
            <ul class="nav justify-center gx-8">
                <a class="btn btn-outline-primary" href="/auth/google">
                    <em class="icon ni ni-google"></em>                   
                    <span>Đăng nhập bằng Google
                    </span>
                </a>
            </ul>
        </div>
    </div>
@endsection
