@extends('client/forum.chatGPT.layouts.app')
@section('pageTitle', 'Chat GPT')
@section('additional-style')
<style>
    .nk-chat-head{
        background-color: #394867;
    }
    .lead-text,em,.chat-meta>li{
        color:#F1F6F9;
    }
    .nk-chat-panel{
        min-height: 75vh;
        max-height: 75vh;
        overflow-y: scroll;
        background-color: #9BA4B5;
    }
    .loading{
        position:absolute; 
        /* margin: auto;
        top: 0;
        bottom: 0; */
        /* left: 0;
        right:0; */
        background: #155d93 /*#5197d6*/;
        border-radius: 50%;
        /* box-shadow: 0 0 2px black; */
        animation: loading 2s infinite;
    }
    /* .chat-msg{
        white-space: break-spaces;
    } */

.loading:nth-child(1) {
    animation-delay: 0.6s;  
    width: 8px;
    height: 8px;
    margin-left: 20px;

    background: green;
}

.loading:nth-child(2) {
   animation-delay: 0.8s; 
    width: 8px;
    height: 8px;
    margin-left: 40px;
    background: green;

}

.loading:nth-child(3) {
    animation-delay: 1s;
    width: 8px;
    height: 8px;
    margin-left: 60px;
    background: green;


}

.loading { 
 animation-iteration-count:infinite; 
 animation-timing-function: ease-in;
}

pre { 
    white-space: pre-wrap; 
    overflow-x: auto; 
    tab-size: 4;
    background: #212A3E;
    color:#F1F6F9;
    padding:20px;
    display: flex;
}


@keyframes loading {
  0%{
  transform: translateY(0px);
  }
  20%{
  transform: translateY(0px);
  }
  30%{
  transform: translateY(-8px);
  }
  40%{
  transform: translateY(5px);
  }
  50%{
  transform: translateY(-2px);
  }
  60%{
  transform: translateY(2px);
  }
  80%{
  transform: translateY(0px);
  }
  100%{
  transform: translateY(0px);
  }
  
}
</style>
@endsection
@section('content')
<div class="nk-block nk-block-lg">
   
        <div class="row">
            <div class="col-12">
                <div class="nk-chat-content">
                    <div class="nk-chat-head">
                        <ul class="nk-chat-head-info">
                            <li class="nk-chat-body-open">
                                <a href="/dien-dan" class="btn btn-icon btn-trigger nk-chat-hide ms-n1"><em class="icon ni ni-arrow-left"></em></a>
                            </li>
                            <li class="nk-chat-head-user">
                                <div class="user-card">
                                    <div class="user-avatar bg-purple">
                                        <img src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/chatGPT-bot.png" alt="">
                                    </div>
                                    <div class="user-info">
                                        <div class="lead-text">Bot</div>
                                        <div class="text-success"><span class="d-none d-sm-inline me-1">Active</div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="nk-chat-head-tools">
                            <li><a href="#" class="btn btn-icon btn-trigger text-primary" id="deleteLog"><em class="icon ni ni-trash"></em></a></li>                     
                        </ul>
                    </div><!-- .nk-chat-head -->
                    <div class="nk-chat-panel" style="position: relative;">                  
                      
                      
                    </div><!-- .nk-chat-panel -->
                    <div class="nk-chat-editor">
                        <div class="nk-chat-editor-form">
                            <div class="form-control-wrap">
                                <textarea class="form-control form-control-simple no-resize" rows="4" id="chat-text-area" placeholder="Type your message..."></textarea>
                            </div>
                        </div>
                        <ul class="nk-chat-editor-tools g-2">
                            <li>
                                <button id="chatbtn" class="btn btn-round btn-primary btn-icon"><em class="icon ni ni-send-alt"></em></button>
                            </li>
                        </ul>
                    </div><!-- .nk-chat-editor -->
                   
                </div>
            </div>
        </div>
     
    
</div>



@endsection
@section('additional-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.4/moment-with-locales.js"></script>

<script>

    function htmlEncode ( html )
    {
        html = $.trim(html);
        return html.replace(/[&"'\<\>]/g, function(c) 
        {
            switch (c) 
            {
                case "&":
                    return "&amp;";
                case "'":
                    return "&#39;";
                case '"':
                    return "&quot;";
                case "<":
                    return "&lt;";
                default:
                    return "&gt;";
            }
        });
    };

  

    $(function() {
        var isHtml = RegExp.prototype.test.bind(/(<([^>]+)>)/i);

        const chatLOG = window.localStorage.getItem('chatLOG');
        const userName = @json(Auth::user()->name);
        const renderArea =  $('.nk-chat-panel');

        if(chatLOG){
            const log = JSON.parse(chatLOG);

            log.forEach(function(item){
                var vietnameseDate = moment(item.time).format('llll').toString();

                if(item.user == userName){
                    var myChat = '';

                    if(isHtml(item.chatContent)){
                        myChat = 
                       
                        '<div class="chat is-me">'+
                            '<div class="chat-content">'+
                                '<div class="chat-bubbles">'+
                                ' <div class="chat-bubble">'+
                                    `<div class="chat-msg"> 
                                        <pre>
                                        <code>${htmlEncode(item.chatContent)}</code>
                                        </pre>
                                    </div>`+            
                                '  </div>'+
                            '   </div>'+
                            ' <ul class="chat-meta">'+
                                    `<li>${userName}</li>`+
                                    `<li>${vietnameseDate}</li>`+
                            '  </ul>'+
                            '   </div>'+
                        ' </div>';
                    }
                    else{

                        myChat =   '<div class="chat is-me">'+
                        '<div class="chat-content">'+
                            '<div class="chat-bubbles">'+
                            ' <div class="chat-bubble">'+
                                `<div class="chat-msg">${item.chatContent}</div>`+            
                            '  </div>'+
                        '   </div>'+
                        ' <ul class="chat-meta">'+
                                `<li>${userName}</li>`+
                                `<li>${vietnameseDate}</li>`+
                        '  </ul>'+
                        '   </div>'+
                    ' </div>';

                    }
                   
                    renderArea.append(myChat);

                }
                else{
                    var botChat = '';

                    if(isHtml(item.chatContent)){

                        botChat = '<div class="chat is-you">'+
                            '<div class="chat-avatar">'+
                                '<div class="user-avatar bg-purple">'+
                                '<img src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/chatGPT-bot.png" alt="">'+
                                '</div>'+
                            '</div>'+
                            '<div class="chat-content">'+
                                '<div class="chat-bubbles">'+
                                ' <div class="chat-bubble">'+
                                    `<div class="chat-msg"> 
                                        <pre>
                                            <code>${htmlEncode(item.chatContent)}</code>
                                        </pre>
                                    </div>`+   
                                    '<ul class="chat-msg-more">'+
                                        '<li class="d-none d-sm-block"><a href="#" class="btn btn-icon btn-sm btn-trigger copybtn"><em class="icon ni ni-copy"></em></a></li>'+              
                                    ' </ul>  '+
                                '  </div>'+
                            '   </div>'+
                            ' <ul class="chat-meta">'+
                                    '<li>BOT</li>'+
                                    `<li>${vietnameseDate}</li>`+
                            '  </ul>'+
                            '   </div>'+
                            ' </div>';

                    }
                    else{

                        botChat = '<div class="chat is-you">'+
                            '<div class="chat-avatar">'+
                                '<div class="user-avatar bg-purple">'+
                                '<img src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/chatGPT-bot.png" alt="">'+
                                '</div>'+
                            '</div>'+
                            '<div class="chat-content">'+
                                '<div class="chat-bubbles">'+
                                ' <div class="chat-bubble">'+
                                    `<div class="chat-msg">${item.chatContent}</div>`+            
                                        '<ul class="chat-msg-more">'+
                                            '<li class="d-none d-sm-block"><a href="#" class="btn btn-icon btn-sm btn-trigger copybtn"><em class="icon ni ni-copy"></em></a></li>'+              
                                        ' </ul>  '+
                                '  </div>'+
                            '   </div>'+
                            ' <ul class="chat-meta">'+
                                    '<li>BOT</li>'+
                                    `<li>${vietnameseDate}</li>`+
                            '  </ul>'+
                            '   </div>'+
                        ' </div>';
                    }
                    

                    renderArea.append(botChat);

                }
            })

            $('.chat-msg:not(:has(pre))').css('white-space', 'break-spaces');
        }
    })

    $(document).on('click','.copybtn',function(){
        var text = $(this).parent().parent().prev().text();


        navigator.clipboard.writeText($.trim(text)).then(function () {

                Swal.fire({
                icon: 'success',
                title: `Sao chép thành công!`,              
                showConfirmButton: true,
            });

        }, function () {
                Swal.fire({
                icon: 'error',
                title: `Sao chép thất bại!`,              
                showConfirmButton: true,
            });
        });
        
    });

    $("#chat-text-area").on("keypress", function(event) {

        const content = $(this).val();

        if(event.which == 13){
            if(content.length > 5){
                $("#chatbtn").click();

            }
            else{
                Swal.fire({
                    icon: 'error',
                    title: `Câu hỏi ít nhất 5 ký tự!`,             
                    showConfirmButton: true,
                });
            }
        }
    });

    $('#chatbtn').on('click',function(e){
        e.preventDefault();
        const renderArea =  $('.nk-chat-panel');
    

        const content = $('#chat-text-area').val();
        const userName = @json(Auth::user()->name);

      
        if(content.length > 5){

            renderArea.animate({ scrollTop: 20000000 }, "slow"); 

            const myChat =   '<div class="chat is-me">'+
            '<div class="chat-content">'+
                '<div class="chat-bubbles">'+
                ' <div class="chat-bubble">'+
                    `<div class="chat-msg" style="white-space: break-spaces;">${htmlEncode(content)}</div>`+            
                '  </div>'+
            '   </div>'+
            ' <ul class="chat-meta">'+
                `<li>${userName}</li>`+
                '</ul>'+
            '   </div>'+
            ' </div>';

            renderArea.append(myChat);
            renderArea.children().last().hide().fadeIn('slow');

            $('#chat-text-area').val('');
            
            const loading =
            '<div class="chat is-you" id="loading-chat-is-you">'+
                    '<div id="darkblue">'+
                        '<span class="loading"></span>'+
                        '<span class="loading"></span>'+
                        '<span class="loading"></span>'+
                    '</div>'+ 
            ' </div>';
            renderArea.append(loading);



            $.ajax({
                type:"GET",
                url:'/chat_gpt',
                data: {
                    'content':content
                }
                })
                .done(function(res) {
                // If successful          
                //render bot-chat
                saveChat(userName,content);

                $('.nk-chat-panel').find('#loading-chat-is-you').remove();

                renderArea.append(res.botChat);
                renderArea.children().last().hide().fadeIn('slow');

                console.log(res.content);
                saveChat('BOT',res.content);


                $('.chat-msg:not(:has(pre))').css('white-space', 'break-spaces');
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
            })

        }
        else{
            Swal.fire({
                icon: 'error',
                title: `Câu hỏi ít nhất 5 ký tự!`,             
                showConfirmButton: true,
            });
        }       
        

    })


    function saveChat(user,content){

        const chatLOG = window.localStorage.getItem('chatLOG');
        const now = new Date();
        const isoDate = now.toISOString();

        if(chatLOG){
            const getCurrentChat = window.localStorage.getItem('chatLOG');

            const log = JSON.parse(getCurrentChat);

            var chatObject = {
                'user':user,
                'chatContent':content,
                'time':isoDate  
            }

            log.push(chatObject);

            window.localStorage.setItem('chatLOG', JSON.stringify(log));
        }
        else{
          
            var chatObject = {
                'user':user,
                'chatContent':content,
                'time':isoDate  
            }
        

            var log =[];
            log.push(chatObject);
            window.localStorage.setItem('chatLOG', JSON.stringify(log));
        }
     
    }

    $('#deleteLog').click(function(e){
        e.preventDefault();
        window.localStorage.removeItem('chatLOG');
        Swal.fire({
            icon: 'success',
            title: `Xóa lịch sử trò chuyện thành công`,              
            showConfirmButton: true,
        });
        $(".nk-chat-panel").load(" .nk-chat-panel > *");


    })

    $('textarea').keyup(function(){
        var input_val = $(this).val();
        var inputRGEX = /^[a-zA-Z0-9]*$/;
        var inputResult = inputRGEX.test(input_val);
          if(!(inputResult))
          {     
            this.value = this.value.replace(/[^a-z0-9\s]/gi, '');
          }
       });
</script>

@endsection