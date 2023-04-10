<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashlite.css?ver=3.1.2') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme.css?ver=3.1.2') }}">

</head>

<body class="nk-body bg-white npc-general pg-auth no-touch nk-nio-theme">
        <div class="nk-app-root">
            <div class="nk-main ">
                
                <div class="nk-wrap nk-wrap-nosidebar">
                  
                    <div class="nk-content">    
                        <nav class="navbar navbar-light bg-light">
                            <a class="ms-3 navbar-brand" href="/">
                                Home
                              </a>
                        </nav>                
                        <div class="nk-block nk-block-middle nk-auth-body">                         
                            <div class="nk-block-head">
                               
                                <div class="nk-block-head-content text-center">       
                                    @if($errors->any())
                                    <div class="alert alert-warning">
                                        @foreach ($errors->all() as $error)
                                            <div class="">{{ $error }}</div>
                                        @endforeach
                        
                                    </div>
                                    @endif                        
                                    <em class="icon icon-circle bg-primary-dim" style="width:80px;height:80px" >
                                        <p id="seconds" style="font-size:30px"></p>
                                    </em>

                                    <div class="nk-block-des text-success">
                                        <p>Bạn có thể download sau khi hết 10s</p>
                                        
                                        
                                         
                                    </div>
                               
                                    <form action="/tai-tai-lieu" method="GET"> 
                                        <input type="hidden" name="id" value="{{ $id }}">


                                        <div id="captcha-box" style="display: none">
                                            <div class="d-flex justify-content-center" >
                                                {!! NoCaptcha::renderJs('vi') !!}
                                                {!! NoCaptcha::display() !!}      
                                            </div>
                                        </div>
                                     
                                        <div class="mt-4">

                                            <button type="submit" class="btn btn-primary btn-lg" id="download-btn">Download</button>
                                        </div>
                                    </form> 
                                </div>
                            </div>
                        </div>
                        <div class="nk-footer nk-auth-footer-full">
                            <div class="container wide-lg">
                                <div class="row g-3">
                                    <div class="col-lg-6 order-lg-last">
                                        <ul class="nav nav-sm justify-content-center justify-content-lg-end">
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Terms &amp; Condition</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Privacy Policy</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Help</a>
                                            </li>
                                          
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="nk-block-content text-center text-lg-start">
                                            <p class="text-soft">© 2022 Dashlite. All Rights Reserved.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- wrap @e -->
                </div>
                <!-- content @e -->
            </div>
            <!-- main @e -->
        </div>
        <!-- app-root @e -->
        <!-- JavaScript -->
    
        
    

    <script src=" {{ asset('assets/js/bundle.js?ver=3.1.2') }}"></script>
    <script src="{{ asset('assets/js/scripts.js?ver=3.1.2') }}"></script>

    <script>

        $(function() {
            $('#download-btn').attr('disabled','disabled');
           
            myFunction();

        
        })
            
        function myFunction() {

        var seconds = 10, $seconds = document.querySelector('#seconds');


        (function countdown() {
            $seconds.textContent = seconds;
            if(seconds --> 0) {
                setTimeout(countdown, 1000)
            }
            else{
                $('#download-btn').removeAttr('disabled');
                $('#captcha-box').show('slow');

            }
        })();
        }

        //  $("#download-btn").click(function(e){
        //     e.preventDefault();
        //     var id = {!! $id !!}
        //     $.ajax({
        //             type:"GET",
        //             url:'/tai-tai-lieu',
        //             data : {
        //                 "id": id
        //             },
        //             })
        //             .done(function() {
        //             // If successful           
        //             window.open(`/tai-tai-lieu?id=${id}`, "_blank");
                  
        //             })
        //             .fail(function(jqXHR, textStatus, errorThrown) {
        //             // If fail
        //             console.log(textStatus + ': ' + errorThrown);
        //             })
        
        
        // })
    </script>
</body>
</html>