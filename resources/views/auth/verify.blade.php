@extends('auth/layouts.app')

@section('content')
<div class="container">
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

                    <form id="myForm">
                        @csrf
                           
                        <p style="color:#31ab00;">Check your email {{Auth::user()->email}} for the OTP</p>

                            <input type="number" name="otp" placeholder="One Time Password" class="login-input" required>

                           <button type="submit" name="submit" value="Submit" class="btn btn-primary">Xác nhận</button>
                           
                            
                            
                        
                            
                    </form>
                
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('additional-scripts')
<script>

$(document).ready(function() {
    
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




 $('#send-otp').click(function(e){
    

    $('#send-otp').attr('disabled','disabled');

    $.ajax({
    type:"GET",
    url:'/send-email'
    })
    .done(function() {
        
        alert("Gửi mã OTP thành công!!!!");
        myFunction();

    })
    .fail(function(jqXHR, textStatus, errorThrown) {
    // If fail
    console.log(textStatus + ': ' + errorThrown);
    });

    setTimeout(()=>{
                $('#send-otp').removeAttr('disabled');
    }, 120000);
})

$('#myForm').submit(function(e){
    // var book_id = $(this).data('id');
    // var name = $(this).data('name');

    e.preventDefault();

    var token = $("meta[name='csrf-token']").attr("content");

    var otp = $(this).find( "input[name='otp']" ).val();


    $.ajax({       
      type:"POST",
      url:'/verify-email',
      data : {
        "otp": otp,
        "_token": token,
      },
      })
      .done(function(result) {
      // If successful
        
        alert(result.result);
      })
      .fail(function(jqXHR, textStatus, errorThrown) {
      // If fail
      console.log(textStatus + ': ' + errorThrown);
      })
  


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

