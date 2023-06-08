@extends('auth/layouts.app')
@section('pageTitle','Đăng ký')

@section('content')
    <div class="nk-block nk-block-middle nk-auth-body wide-xs">
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
                        <h4 class="nk-block-title">Đăng ký</h4>              
                    </div>
                </div>
                @if($errors->any())
                <div class="alert alert-warning">
                    @foreach ($errors->all() as $error)
                        <div class="">{{ $error }}</div>
                    @endforeach
    
                </div>
                @endif
                <form method="POST" action="/register">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Tên tài khoản</label>
                        <div class="form-control-wrap">
                            <input id="name" 
                            type="text" class="form-control form-control-lg" name="name" value="{{ old('name') }}" 
                            required 
                            placeholder="Nhập tên tài khoản của bạn">

                      

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <div class="form-control-wrap">
                            <input id="email" 
                            type="email" class="form-control form-control-lg" name="email" value="{{ old('email') }}" 
                            required
                            placeholder="Nhập email của bạn">

                       

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
                            form-control-lg" 
                            name="password" required
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
                        {!! NoCaptcha::renderJs('vi') !!}
                        {!! NoCaptcha::display() !!}

                 
                    </div>

                 
                    <div class="form-group">
                        <div class="custom-control custom-control-xs custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkbox" required>
                            <label class="custom-control-label" for="checkbox">Bạn đồng ý với các <a href="/thong-tin/quy-dinh">điều khoản</a> và <a href="/thong-tin/quy-dinh"> chính sách.</a> của website</label>
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
@section('additional-scripts')
<script>
 $('input[name=name]').keyup(function(){
        var input_val = $(this).val();
        var inputRGEX = /^[a-zA-Z0-9]*$/;
        var inputResult = inputRGEX.test(input_val);
          if(!(inputResult))
          {     
            this.value = this.value.replace(/[^a-z0-9\s]/gi, '');
          }
       });
</script>
@endsection

