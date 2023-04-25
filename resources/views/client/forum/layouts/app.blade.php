<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('pageTitle')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.tiny.cloud/1/eg8iogzlu3jipzfj7j3tuxbi6raibc22pcwt4y2jcu6d3qcn/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    

    <link rel="stylesheet" href="{{ asset('assets/css/dashlite.css?ver=3.1.2') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/loading.css') }}">

    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme.css?ver=3.1.2') }}">
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/css/bootstrap5-toggle.min.css"
    rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    
   
    @yield('additional-style')

    <style>
        textarea {
            resize: none;
        }
        #navbar-background{
            background-image: url('https://raw.githubusercontent.com/notepower2k1/MyImage/main/banner/forum_banner_1.png');
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
            min-height: 250px;
        }
        #navbar-content{
            background-color:rgba(25,45,64,0.3);
          
        }
    </style>
</head>
<body class="nk-body bg-lighter preload">
    <div class="nk-app-root">
        <div class="loader-wrapper">
            <span class="loader"><span class="loader-inner"></span></span>
        </div>  
        <div class="nk-main">    
            <div class="nk-wrap">         
                <div class="shadow-sm">
                    @include('client/forum.layouts.header')
                </div>
                @yield('navbar-Footer')
                <div class="nk-content">
                    <div class="nk-content-inner">

                        
                        
                        <div class="nk-content-body">      

                            <div class="container">
                                @yield('content')

                            </div>


                       

                          
                        </div>
                    </div>
                </div>
            </div>
           
            @include('client/forum.layouts.footer')
        </div>
  

    </div>
  
    
    @yield('modal')
   
    <script src=" {{ asset('assets/js/bundle.js?ver=3.1.2') }}"></script>
    <script src="{{ asset('assets/js/scripts.js?ver=3.1.2') }}"></script>
    {{-- <script src="{{ asset('assets/js/charts/gd-default.js?ver=3.1.2') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <script>
        $(window).on("load",function(){
            $(".loader-wrapper").fadeOut("slow");
            $("body").removeClass("preload");
        });


        $("#search-topic-form").find("input[type='text']").on("keydown", function(event) {
            if(event.which == 13){
                var topic = $(this).val();  
                if(topic){
                    window.location.href = `/dien-dan/bai-viet/${topic}`;
                }
                else{
                    Swal.fire({
                            icon: 'info',
                            title: `Vui lòng nhập ít nhất 1 ký tự`,
                            showConfirmButton: false,
                            timer: 2500
                    });
                    $('#search-topic-form').find("input[type='text']").focus();
                }
            }
        });
        $('#search-topic-btn').on("click",function(){

            var topic = $('#search-topic-form').find("input[type='text']").val();  
            if(topic){
                window.location.href = `/dien-dan/bai-viet/${topic}`;
            }
            else{
                Swal.fire({
                        icon: 'info',
                        title: `Vui lòng nhập ít nhất 1 ký tự`,
                        showConfirmButton: false,
                        timer: 2500
                });
                $('#search-topic-form').find("input[type='text']").focus();
            }
        })
    </script>
    @yield('additional-scripts')

   
</body>
</html>