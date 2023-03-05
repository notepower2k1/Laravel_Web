<!DOCTYPE html>
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
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme.css?ver=3.1.2') }}">
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/css/bootstrap5-toggle.min.css"
    rel="stylesheet" />
    

</head>
<body class="nk-body bg-white npc-general pg-survey">
    <div class="nk-app-root">
        <div class="nk-main ">
        
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content ">
                    <div class="nk-split nk-split-page nk-split-lg">
                        <div class="nk-split-content bg-dark is-dark p-5 d-flex justify-between flex-column text-center w-50">
                            <a href="html/index.html" class="logo-link nk-sidebar-logo">
                                <img class="logo-light logo-img" src="./images/logo.png" srcset="./images/logo2x.png 2x" alt="logo">
                                <img class="logo-dark logo-img" src="./images/logo-dark.png" srcset="./images/logo-dark2x.png 2x" alt="logo-dark">
                            </a>
                            <div class="text-block">
                                <img class="nk-survey-gfx mb-5" src="./images/gfx/survey.svg" alt="">
                                <h3 class="text-white">Satisfaction Survey</h3>
                                <p>Help us to improve our service and customer satisfaction.</p>
                            </div>
                            <p>&copy; 2022 DashLite. Template by Softnio</p>
                        </div><!-- .nk-split-content -->
                        <div class="nk-split-content nk-split-stretch bg-white p-5 d-flex justify-center align-center flex-column">
                            @yield('content')
                        </div>
                        
                    </div>
                </div>
            </div>
           
            {{-- @include('admin/layouts.footer') --}}
        </div>
  

    </div>
  
  

    <script src=" {{ asset('assets/js/bundle.js?ver=3.1.2') }}"></script>
    <script src="{{ asset('assets/js/scripts.js?ver=3.1.2') }}"></script>
    {{-- <script src="{{ asset('assets/js/charts/gd-default.js?ver=3.1.2') }}"></script> --}}
 
    
    @yield('additional-scripts')
</body>
</html>