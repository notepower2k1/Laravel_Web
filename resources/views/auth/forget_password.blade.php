@extends('auth/layouts.app')
@section('content')
<div class="nk-block nk-block-middle nk-auth-body  wide-xs">
    <div class="brand-logo pb-4 text-center">
        <a href="/" class="logo-link">
            <img class="logo-light logo-img logo-img-lg" src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/logo.png" srcset="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/logo.png 2x" alt="logo">
            <img class="logo-dark logo-img logo-img-lg" src=".https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/logo.png" srcset="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/logo.png 2x" alt="logo-dark">
        </a>
    </div>
    <div class="card card-bordered">
        <div class="card-inner card-inner-lg">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h5 class="nk-block-title">Quên mật khẩu</h5>
                    <div class="nk-block-des">
                        <p>Mật khẩu mới sẽ được gửi đến email của bạn</p>
                    </div>
                </div>
            </div>

            <div id="spinner" style="display:none">
                <div class="d-flex align-items-center">
                    <strong>Đang kiểm tra...</strong>
                    <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                  </div>
            </div>

            <div>
                <div class="form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="default-01">Tên tài khoản</label>
                    </div>
                    <div class="form-control-wrap">
                        <input type="text" class="form-control form-control-lg" id="default-01" name='userName' placeholder="Nhập tên tài khoản....">
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-lg btn-primary btn-block" id="send-password">Gửi mật khẩu mới</button>
                </div>
            </div>
            <div class="form-note-s2 text-center pt-4">
                <a href="/login"><strong>Quay lại đăng nhập</strong></a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('additional-scripts')
<script src="{{ asset('assets/js/example-sweetalert.js?ver=3.1.2') }}" aria-hidden="true"></script>

<script>
     $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    $('#send-password').click(function(e) {
        
        var userName = $('input[name="userName"]').val();
        
        if(userName){
            $("input").attr('disabled', 'disabled');
            $('#send-password').attr('disabled','disabled');

            $('#spinner').show();
            $.ajax({
            type:"POST",
            url:'/password/forgot',
            data:{
                'UserName': userName
            }
            })
            .done(function(res) {
              
                Swal.fire({
                    icon: `${res.status==0?'error':'success'}`,
                    title: `${res.message}`,
                    showCloseButton: true,
                });
                $('input[name="userName"]').removeAttr('disabled');
                $('#send-password').removeAttr('disabled');
                $('#spinner').hide();

            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
            });

        }
        else{
            Swal.fire({
            icon: 'error',
            title: 'Không được để trống mật khẩu',
            showCloseButton: true,
        });
        }
    })
</script>
@endsection