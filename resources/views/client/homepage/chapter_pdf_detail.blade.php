<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
</head>
<style>
    body {
    margin: 0;            /* Reset default margin */
    }
    iframe {
        display: block;       /* iframes are inline by default */
        background: #000;
        border: none;         /* Reset default border */
        height: 100vh;        /* Viewport-relative units */
        width: 100vw;
    }
    p {
    font-size: 13px;
    color: black;
    }

    .progress {
    position: absolute;
    left: 50%;
    top: 50%;
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    height: 80px;
    perspective: 300px;
    font-size: 0px;
    text-align: center;
    line-height: 55px;
    }

    .loading {
    width: 80px;
    height: 80px;
    display:inline-block;
    background-color: white;
    box-shadow: inset 1px 1px gray, inset -1px -1px gray;
    backface-visibility: hidden;
    -webkit-transform-style: preserve-3d;
    -ms-transform-style: preserve-3d;
    transform-style: preserve-3d;
    overflow: hidden;
    }
    .load-1{ 
    -webkit-transform-origin: 100% 0;
    -ms-transform-origin: 100% 0;
    transform-origin: 100% 0;
    & p {
        -webkit-transform: translateX(50%);
        -ms-transform: translateX(50%);
        transform: translateX(50%);
    }
    }
    .load-2{ 
    -webkit-transform-origin: 0 0;
    -ms-transform-origin: 0 0;
    transform-origin: 0 0;
    & p {
        -webkit-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        transform: translateX(-50%);
    }
    }
    .load-bg{ 
    position: absolute;
    left: 0;
    top: 0;
    width: 160px;
    height: 80px;
    background-color: white;
    box-shadow: inset 1px 1px gray, inset -1px -1px gray;
    outline: 3px solid darkred;
    }
</style>
<body>
    <div class="progress" id="loading-animation">
        <div class="load-bg">
          <p>ĐANG TẢI...</p>
        </div>
        <div class="loading load-1" data-start="180">
            <p>ĐANG TẢI...</p>
        </div>
        <div class="loading load-2" data-start="0">
            <p>ĐANG TẢI...</p>
        </div>

    </div>

    <iframe id="pdfView" src="#" style="display: none;"></iframe>
    
    <script src=" {{ asset('assets/js/bundle.js?ver=3.1.2') }}"></script>
    <script src="{{ asset('assets/js/scripts.js?ver=3.1.2') }}"></script>
    <script src="{{ asset('assets/js/example-sweetalert.js?ver=3.1.2') }}" aria-hidden="true"></script>

    <script>
        $(function() {
               // initiate animation
            flip(one, 1);
            flip(two, 1);
            
            fetchSrc();
         
        })
        
        function fetchSrc() {
            const book_id = {!! $book_id !!};
            $.ajax({
                    type:"GET",
                    url:'/api/getURL/'+book_id,
                    data : {
                    },
                    })
                    .done(function(res) {
                    // If successful
                        $('#pdfView').attr('src', '');

                        console.log('loading');
                        var url = encodeURIComponent(res.file);
                        var fullURL = `https://drive.google.com/viewerng/viewer?embedded=true&url=`+url;
                        $('#pdfView').attr('src', fullURL);

                    

                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                    // If fail
                    console.log(textStatus + ': ' + errorThrown);
            });
        }
        function iframeLoaded() {
            $("#loading-animation").remove();
            $('#pdfView').fadeIn('slow');

            setTimeout(() => {
                if($("#pdfView").contents().find('#loading-animation').length > 0) {
                    console.log(false);

                    Swal.fire({
                        icon: 'error',
                        title: `Tải dữ liệu không thành công, reload`,
                        showConfirmButton: false,
                    });

                    setTimeout(() => {
                      
                        window.location.reload();

                    }, 3000);
                }
                else{
                    console.log('success');
                } 
            }, 1000);
          
        }
        window.onload = function() {
            parent.iframeLoaded();
        }


        var one = document.querySelector('.load-1'),
            two = document.querySelector('.load-2'),
            prefix = window.getComputedStyle(one);

        //find vendor prefix
        if( prefix.getPropertyValue('-webkit-transform-origin') ) prefix = 'webkit';
        else if( prefix.getPropertyValue('-moz-transform-origin') ) prefix = 'moz';
        else if( prefix.getPropertyValue('-ms-transform-origin') ) prefix = 'ms';
        else prefix = '';

        //use vendor prefix
        function transform(el, change){
            if(prefix == 'webkit')
            el.style.webkitTransform = change;
            else if(prefix == 'ms')
            el.style.msTransform = change;
            else el.style.transform = change;
        }
            
        // setup animation
        function flip(el, duration){
            var i = 0,
                times = duration * 60,
                start = parseInt(el.dataset.start);

            // animate
            function flipAnim(){
            
            if(i <= times)
                transform(el, 'rotateY(' + (start - i * 180 / times) + 'deg)');
            else if(i > times + 30){
                //stop & begin again
                window.clearInterval(anim);
                flip(el, duration);
            }
            i++;
            }
            var anim = window.setInterval(flipAnim, 17);

        }

     
    </script>
    
</body>

</html>