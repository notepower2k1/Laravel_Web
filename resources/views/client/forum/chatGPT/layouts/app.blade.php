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
        body {
            min-height: 100vh;
            overflow: hidden; /* Hide scrollbars */
        }
        html {
            scroll-behavior: smooth;
        }
        textarea {
            resize: none;
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
                <div class="content">
                    <div class="nk-content-inner">                     
                        <div class="nk-content-body">                            
                                @yield('content')                        
                        </div>
                    </div>
                </div>
            </div>      
        </div>
    </div>  
   
    <script src=" {{ asset('assets/js/bundle.js?ver=3.1.2') }}"></script>
    <script src="{{ asset('assets/js/scripts.js?ver=3.1.2') }}"></script>
    {{-- <script src="{{ asset('assets/js/charts/gd-default.js?ver=3.1.2') }}"></script> --}}

    <script>
        $(window).on("load",function(){
            $(".loader-wrapper").fadeOut("slow");
            $("body").removeClass("preload");
        });
    </script>
    @yield('additional-scripts')

   
</body>
</html>