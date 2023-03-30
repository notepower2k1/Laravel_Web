@extends('client/layouts.app')
@section('pageTitle', 'Đổi mật khẩu')

@section('content')

<div class="nk-block nk-block nk-block-lg">
    <div class="row g-gs d-flex justify-content-center">
        <div class="col-lg-6">
                <div class="card card-bordered h-100">
                    <div class="card-inner">
                        <div class="card-head">
                            <h5 class="card-title">Đổi mật khẩu</h5>
                        </div>
                        <form method="POST" action="/user/{{ Auth::user()->id }}">
                            @csrf
                            @method('PUT')
                             <div class="form-group">
                                <label for="password" class="form-label">{{ __('Mật khẩu') }}</label>
                            
                                <div class="form-control-wrap">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="password-confirm" class="form-label">{{ __('Xác nhận mật khẩu') }}</label>
                            
                                <div class="form-control-wrap">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            
                            
                            <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                            </form>
                    </div>
                </div>
      
        </div>
    </div>
</div>
@endsection 