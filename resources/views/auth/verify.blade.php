@extends('auth/layouts.app')
@section('additional-styles')
<style>    
    .inputs input{
        width:40px;
        height:40px
    }
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button{
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;margin: 0
    }

    a.disabled {
    pointer-events: none;
    cursor: default;
    }
  
</style>
@endsection
@section('content')
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Verify Your Email Address</div>

                    <div class="card-body">
                    

                    

                        @if($expires>0)
                        <button class="btn btn-primary" id="send-otp" data-value="{{ $expires }}"></button>    
                        @else                 
                            <button class="btn btn-primary" id="send-otp" >Gửi mã OTP</button>
                        @endif
                        {{-- <span id="countdown"></span> --}}

                        {{-- <form id="myForm">
                            @csrf
                            
                                <p style="color:#31ab00;" id="confim">Check your email {{Auth::user()->email}} for the OTP</p>

                                <input type="number" name="otp" placeholder="One Time Password" class="login-input" required>

                            <button type="submit" name="submit" value="Submit" class="btn btn-primary">Xác nhận</button>
                            
                        

                            
                                
                        </form>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>  --}}

    <div class="nk-block nk-block-middle nk-auth-body wide-xs">
        
        <div class="card card-bordered">
                <div class="card-inner card-inner-lg">

                    <div class="card p-2 text-center"> 
                       
                        <h6>Vui lòng nhập mã OTP để xác nhận tài khoản của bạn</h6> 
                        <div> 
                            <span>Mã OTP sẽ được gửi đến email</span> 
                            <small>
                                <?=Str::mask(Auth::user()->email,'*',0,strpos(Auth::user()->email,'@')-3)?>
                            </small> 
                        </div> 

                        <div style="display:none" id="loading">
                            <div class="d-flex align-items-center mt-4">
                                <strong>Đang thực hiện...</strong>
                                <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                            </div>
                        </div>
                   
                        <form id="myForm">
                            @csrf
                            <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2"> 
                                <input class="m-2 text-center form-control rounded" type="text" id="first" maxlength="1" /> 
                                <input class="m-2 text-center form-control rounded" type="text" id="second" maxlength="1" /> 
                                <input class="m-2 text-center form-control rounded" type="text" id="third" maxlength="1" /> 
                                <input class="m-2 text-center form-control rounded" type="text" id="fourth" maxlength="1" /> 
                                <input class="m-2 text-center form-control rounded" type="text" id="fifth" maxlength="1" /> 
                                <input class="m-2 text-center form-control rounded" type="text" id="sixth" maxlength="1" /> 
                            </div> 
                            <div class="mt-4"> 
                                <button type="submit" name="submit" value="Submit" class="btn btn-danger px-4" id="verify-btn">Xác thực</button> 
                            </div> 
                        </form>

                    </div> 
                    <div class="card-2">
                        <div class="content d-flex justify-content-center align-items-center"> 
                            <span>Chưa nhận được OTP code</span> 
                            @if($expires>0)
                            <a href="#" class="text-decoration-none ms-1" id="send-otp" data-value="{{ $expires }}" onclick="return false;"></a>    
                            @else                 
                            <a href="#" class="text-decoration-none ms-1 " id="send-otp" >gửi mã OTP</a>
                            @endif
                        </div> 

                  
                    </div> 
                    <div class="card-2">
                        <div class="content d-flex justify-content-center align-items-center"> 
                            <strong>Hoặc</strong>
                        </div>
                    </div>
                    <div class="card-2">
                        <div class="content d-flex justify-content-center align-items-center"> 
                            <span>Bạn chưa muốn xác thực 
                                <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                <span> Đăng xuất</span>
                                </a>
                            </span> 
                          

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div> 
                    </div>

                </div>
            
        </div>
    </div>


@endsection

@section('additional-scripts')
<script src="{{ asset('assets/js/example-sweetalert.js?ver=3.1.2') }}" aria-hidden="true"></script>
<script>



    


$(document).ready(function() {
    
    
    function OTPInput() {
        const inputs = document.querySelectorAll('#otp > *[id]');
            for (let i = 0; i < inputs.length; i++) { 
                inputs[i].addEventListener('keydown', 
                function(event) { 
                    if (event.key==="Backspace" ) { 
                        inputs[i].value='' ; if (i !==0) inputs[i - 1].focus(); } 
                        else { 
                            if (i===inputs.length - 1 && inputs[i].value !=='' ) { return true; } 
                            else if (event.keyCode> 47 && event.keyCode < 58) 
                            {
                                inputs[i].value=event.key; 
                                if (i !==inputs.length - 1) inputs[i + 1].focus(); 
                                event.preventDefault(); 
                                } 
                                else if (event.keyCode> 95 && event.keyCode < 106) 
                                {
                                    inputs[i].value=event.key; 
                                    if (i !==inputs.length - 1) inputs[i + 1].focus(); 
                                    event.preventDefault(); 
                                } 
                                else if (event.keyCode> 64 && event.keyCode < 91) {
                                    inputs[i].value=String.fromCharCode(event.keyCode);  
                                    if (i !==inputs.length - 1) inputs[i + 1].focus(); event.preventDefault(); 
                                    } 
                                } 
                            }); 
                        } 
                    } 
    OTPInput();

    var timeleft = $('#send-otp').data('value');

    var seconds = timeleft , $seconds = document.querySelector('#send-otp');

    (function countdown() {
        $seconds.textContent = 'Thử lại sau: '+ seconds + 's';
        if(seconds --> 0) {
            setTimeout(countdown, 1000)
            $('#send-otp').attr('disabled','disabled');

        }
        else{
            $seconds.textContent = 'Gửi mã OTP';
            setTimeout(()=>{
                $('#send-otp').removeAttr('disabled');
            }, 1000);
        }
    })();

})




 $('#send-otp').on("click", function(e){
    

    $('#loading').show('slow');
    $('#send-otp').addClass('disabled');

    $.ajax({
    type:"GET",
    url:'/send-email'
    })
    .done(function() {
        $('#loading').hide();

        Swal.fire({
            icon: 'success',
            title: 'Gửi mã OTP thành công!!!',
            html:
                'Bạn có <b>10</b> lần thử,' +
                'và mã OTP có thời hạn <b>2</b> phút!',
            showCloseButton: true,
        });
        
        myFunction();

    })
    .fail(function(jqXHR, textStatus, errorThrown) {
    // If fail
    console.log(textStatus + ': ' + errorThrown);
    });

    setTimeout(()=>{
                $('#send-otp').removeClass('disabled');
    }, 120000);
})

$('#myForm').submit(function(e){
    var book_id = $(this).data('id');
    var name = $(this).data('name');

    e.preventDefault();

    var token = $("meta[name='csrf-token']").attr("content");

    var otp = $(this).find( "input[id='first']" ).val() + 
    $(this).find( "input[id='second']" ).val()+
    $(this).find( "input[id='third']" ).val()+
    $(this).find( "input[id='fourth']" ).val()+
    $(this).find( "input[id='fifth']" ).val()+
    $(this).find( "input[id='sixth']" ).val();

    if(otp){
        $.ajax({       
      type:"POST",
      url:'/verify-email',
      data : {
        "otp": otp,
        "_token": token,
      },
      })
      .done(function(res) {

        if(res.status === 1){

            $('#verify-btn').attr('disabled', 'disabled');

            Swal.fire({
                icon: 'success',
                title: 'Xác thực thành công!!!',
                showConfirmButton: false,
                timer: 2500
            });
            setTimeout(()=>{
                window.location.href = '/';
            }, 3000);
        }
        else{
            Swal.fire({
            icon: 'error',
            title: `${res.message}`,
            confirmButtonText: 'Thử lại'
            });
        }

      
      })
      .fail(function(jqXHR, textStatus, errorThrown) {
      // If fail
      console.log(textStatus + ': ' + errorThrown);
      })
    }
    else{
        Swal.fire({
            icon: 'error',
            title: `Bạn chưa nhập mã OTP`,
            confirmButtonText: 'Thử lại'
            });
    }
  


  })


  function myFunction() {

    var seconds = 120, $seconds = document.querySelector('#send-otp');

    
    (function countdown() {
        $seconds.textContent = 'Thử lại sau: '+ seconds + 's';
        if(seconds --> 0) {
            setTimeout(countdown, 1000)
        }
        else{
            $seconds.textContent = 'Gửi mã OTP';
        }
    })();
    }

   
    
</script>
@endsection

