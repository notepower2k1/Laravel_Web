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
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    
   
    @yield('additional-style')


</head>
<body class="nk-body bg-lighter ">
    <div class="nk-app-root">
        <div class="nk-main ">      
            <div class="nk-wrap">         
                <div class="nk-header is-light">
                    @include('client/layouts.header')
                </div>

                <div class="nk-content">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            
                            <div class="nk-content-body">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            {{-- @include('admin/layouts.footer') --}}
        </div>
  

    </div>
  
    
    @yield('modal')
   
    <script src=" {{ asset('assets/js/bundle.js?ver=3.1.2') }}"></script>
    <script src="{{ asset('assets/js/scripts.js?ver=3.1.2') }}"></script>
    {{-- <script src="{{ asset('assets/js/charts/gd-default.js?ver=3.1.2') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    
    @yield('additional-scripts')

    <script>
        $(document).on('click','#mark_all_notifications',function(){
    
            $.ajax({
                url:'/bookmark-status-all-update',
                type:"GET",
                data:{            
                }
            })
            .done(function(res) {
                
            
                Swal.fire({
                        icon: 'success',
                        title: `${res.success}`,
                        showConfirmButton: false,
                        timer: 2500
                    });      

                $("#bookMark_notifications_box").load(" #bookMark_notifications_box > *");
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
            });    
        })

        $('.nk-notification-item').click(function(){

            var id = $(this).data('id');

            $.ajax({
                url:'/bookmark-status-update',
                type:"GET",
                data:{          
                    'id':id
                }
            })
            .done(function(res) {
                
                window.location.href = res.url;
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
            });    
        })
      </script>
</body>
</html>