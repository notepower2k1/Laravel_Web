@extends('auth/layouts.app')

@section('content')
    <div class="nk-block nk-block-middle nk-auth-body wide-xs">
        <div class="brand-logo pb-4 text-center">
            <a href="html/index.html" class="logo-link">
                <img class="logo-light logo-img logo-img-lg" src="./images/logo.png" srcset="./images/logo2x.png 2x" alt="logo">
                <img class="logo-dark logo-img logo-img-lg" src="./images/logo-dark.png" srcset="./images/logo-dark2x.png 2x" alt="logo-dark">
            </a>
        </div>
        <div class="card card-bordered">
            <div class="card-inner card-inner-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h4 class="nk-block-title">Đăng ký</h4>              
                    </div>
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Tên tài khoản</label>
                        <div class="form-control-wrap">
                            <input id="name" 
                            type="text" class="form-control form-control-lg @error('name') 
                            is-invalid @enderror" name="name" value="{{ old('name') }}" 
                            required autocomplete="name"
                            placeholder="Nhập tên tài khoản của bạn">

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <div class="form-control-wrap">
                            <input id="email" 
                            type="email" class="form-control form-control-lg @error('email') 
                            is-invalid @enderror" name="email" value="{{ old('email') }}" 
                            required autocomplete="email"
                            placeholder="Nhập email của bạn">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">Mật khẩu</label>
                        <div class="form-control-wrap">
                            <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                            </a>
                            <input id="password" type="password" class="form-control 
                            form-control-lg @error('password') is-invalid @enderror" 
                            name="password" required autocomplete="new-password"
                            placeholder="Nhập mật khảu">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">Xác nhận mật khẩu</label>
                        <div class="form-control-wrap">
                            <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                            </a>                   
                            <input id="password-confirm" type="password" class="form-control form-control-lg" 
                            name="password_confirmation" required
                            placeholder="Xác nhận mật khảu">

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-control-xs custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkbox" required>
                            <label class="custom-control-label" for="checkbox">Bạn đồng ý với các <a href="#">điều khoản</a> và <a href="#"> chính sách.</a> của website</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-primary btn-block">Đăng ký</button>
                    </div>
                </form>
                <div class="form-note-s2 text-center pt-4"> Bạn đã có tài khoản? <a href="/login"><strong>Đăng nhập ngay</strong></a>
                </div>
               
            </div>
        </div>
    </div>
  

@endsection


