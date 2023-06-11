<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('pageTitle')</title>
    <meta name="auth-check" content="{{ (Auth::check()) ? Auth::user()->id : '-1' }}">


    <link rel = "icon" href ="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/logo_title.png" type = "image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.tiny.cloud/1/eg8iogzlu3jipzfj7j3tuxbi6raibc22pcwt4y2jcu6d3qcn/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    

    <link rel="stylesheet" href="{{ asset('assets/css/dashlite.css?ver=3.1.2') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/loading.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/shine.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/emojionearea.min.css') }}">


    
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme.css?ver=3.1.2') }}">
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/css/bootstrap5-toggle.min.css"
    rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">

   
    @yield('additional-style')

    <style>
        .book_sameType:hover{
            background-color:#062788;
        }
        textarea {
            resize: none;
        }

        .nk-content{
            background-color:#ffffff;
        }

        .nk-header,.accordion-item{
            background-color:#f5f4f2;
        }
        
        .a-more-button{
            text-decoration: none;
            color:#b78a28;
        }

        .preview-book-btn >em {
            -webkit-transition: background-color 1s ease-out;
            -moz-transition: background-color 1s ease-out;
            -o-transition: background-color 1s ease-out;
            transition: background-color 1s ease-out;
        }

        .preview-book-btn > em:hover{
            color:#f5f4f2;
            background-color:orange !important ;
        }
    </style>
</head>
<body class="nk-body bg-lighter preload">
    <div class="nk-app-root">
        <div class="loader-wrapper">
            <span class="loader"><span class="loader-inner"></span></span>
        </div>  
        <div class="nk-main">      
            <div class="">         
                <div class="nk-header nk-header-fixed shadow-sm">
                    @include('client/homepage.layouts.header')
                </div>

                <div class="nk-content">
                    <div class="nk-content-inner">                    
                        <div class="nk-content-body">                   
                            @yield('content')                
                        </div>
                    </div>
                </div>
            </div>
         

            @include('client/homepage.layouts.footer')
        </div>
  

    </div>
  
    
    @yield('modal')
    
    @include('client/homepage.layouts.search_navbar')
    <script src=" {{ asset('assets/js/bundle.js?ver=3.1.2') }}"></script>
    <script src="{{ asset('assets/js/scripts.js?ver=3.1.2') }}"></script>
    {{-- <script src="{{ asset('assets/js/charts/gd-default.js?ver=3.1.2') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="https://js.pusher.com/4.3/pusher.min.js"></script>

    @yield('additional-scripts')

    <script>
        var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
            cluster: 'ap1',
            encrypted: true
        });
        var authcheck = $('meta[name="auth-check"]').attr('content');

          // Subscribe to the channel we specified in our Laravel Event
        var notifyChannel  = pusher.subscribe('private_notify_'+authcheck.toString());

        // Bind a function to a Event (the full Laravel class)
        if(notifyChannel){
            notifyChannel.bind('send-notify', function(receiverID) {
                const currentUser = authcheck.toString();
                    if(receiverID == currentUser){
                        console.log("trigger");

                        $("#comment_notifications_box").load(" #comment_notifications_box > *");
                }             
            });
        }
      

        $(window).on("load",function(){
            $(".loader-wrapper").fadeOut("slow");
            $("body").removeClass("preload");
        });
   

        $('#bookMark_notifications_box').on('click','#mark_all_bookMark_notifications',function(){

            $.ajax({
                url:'/following-status-all-update',
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

        $('#bookMark_notifications_box').on('click','.bookMark-notifications',function(){
            var id = $(this).data('id');

            $.ajax({
                url:'/following-status-update',
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
        });

        



        $('#comment_notifications_box').on('click','#mark_all_comment_notifications',function(){

            $.ajax({
                url:'/notification-all-update',
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

                $("#comment_notifications_box").load(" #comment_notifications_box > *");
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
            });    
        })

        $('#comment_notifications_box').on('click','.comment-notifications',function(){

            var id = $(this).data('id');

            $.ajax({
                url:'/notification-update',
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


        $('.comment-notifications').on('click',function(){

            var id = $(this).data('id');

            $.ajax({
                url:'/notification-update',
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


        @if(!Request::is('tim-kiem'))
        <script>
         var typingTimer;                //timer identifier
        var doneTypingInterval = 1000;  //time in ms, 5 seconds for example


        //on keyup, start the countdown
        $('#modalSearchHomePage').on('keyup','#search', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        //on keydown, clear the countdown 
        $('#modalSearchHomePage').on('keydown','#search', function () {
        clearTimeout(typingTimer);
        });

        //user is "finished typing," do something
        function doneTyping () {

            const bookNames = @json($bookContentsForSearch);
            const documentNames = @json($documentContentsForSearch);

            const renderBox = $('#modalSearchHomePage').find('#renderArea-ul');

            renderBox.empty();
            const inputValue = $('#modalSearchHomePage').find('#search').val();


            const option_value = $('#modalSearchHomePage').find('ul').find('.active').find('a').data('value');

            
            if(inputValue){

                var fullValue = []
                if(option_value == '1'){
                    // fullName =  bookNames.filter(function(name){

                    //     return name.toLowerCase().normalize().includes(inputValue.toLowerCase().normalize());
                    // });

                    bookNames.forEach((obj, i) => {
                        
                        const name = obj.name.toLowerCase().normalize();
                        const author = obj.author.toLowerCase().normalize();

                        const inputNormalize = inputValue.toLowerCase().normalize();

                        if(name.includes(inputNormalize) || author.includes(inputNormalize)){
                            fullValue.push(obj);
                        }

                     

                    });
                }
                if(option_value == '2'){
                    documentNames.forEach((obj, i) => {
                        
                        const name = obj.name.toLowerCase().normalize();
                        const author = obj.author.toLowerCase().normalize();

                        const inputNormalize = inputValue.toLowerCase().normalize();

                        if(name.includes(inputNormalize) || author.includes(inputNormalize)){
                            fullValue.push(obj);
                        }

                    });
                }

                
                fullValue.forEach(value => {

                    var item = '';
                    if(option_value==1){
                        item = `<li><a href="/sach/${value.id}/${value.slug}" class="search-items text-blue"><span>Sách: ${value.name} / Tác giả: ${value.author}</span></a></li>`;
                    }
                    else{
                        item = `<li><a href="/tai-lieu/${value.id}/${value.slug}" class="search-items text-danger"><span>Tài liệu: ${value.name} / Tác giả: ${value.author}</span></a></li>`;

                    }
                    renderBox.append(item).hide().show('slow');
                });

                
            }
        }



        $('#modalSearchHomePage').on('click','.search-items',function(){

            const text = $(this).find('span').text();
            $('#modalSearchHomePage').find('#search').val(text);

            const renderBox = $('#modalSearchHomePage').find('#renderArea-ul');

            renderBox.empty();
            item = `<li><div class="d-flex align-items-center">
                    <strong>Đang chuyển hướng...</strong>
                    <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                    </div></li>`;

            renderBox.append(item).hide().show('slow');

            $('#modalSearchHomePage').find('#search').attr('disabled', 'disabled');
            $('#modalSearchHomePage').find('#renderArea-ul').addClass('mt-3');

        })

        
        $('#modalSearchHomePage').on('click','.search-option',function(){
            const renderBox = $('#modalSearchHomePage').find('#renderArea-ul');

            renderBox.empty();

            $('#modalSearchHomePage').find(".search-option").parent().removeClass("active");
            var option_text = $(this).text();
            var option_value = $(this).attr('data-value');

            $('#modalSearchHomePage').find('#option_show').text(option_text);
            
            
            $(this).parent().addClass("active");
            $('#modalSearchHomePage').find('#search').val("");
        });
      </script>
      @endif
</body>
</html>