@extends('client/forum.layouts.app')
@section('pageTitle', `${{$post->topic}}`)
@section('content')
<div class="nk-block">
  <nav>
      <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dien-dan">Diễn đàn</a></li>
          <li class="breadcrumb-item"><a href="/dien-dan/{{ $post->forums->slug }}">{{ $post->forums->name }}</a></li>
          <li class="breadcrumb-item active">{{ $post->topic }}</li>
      </ul>
  </nav>
  <div class="card card-bordered">
      <div class="card-inner">
          <div class="row g-gs flex-lg-row-reverse">
             
              <div class="col-lg-12">
                  <div class="entry me-xxl-3">
                   
                    <div class="d-flex align-content-center">
                      <h3>{{ $post->topic }}
                        
                        @if(Auth::check())
                        <button type="button" class="btn btn-icon btn-lg ms-1" data-bs-toggle="modal" data-bs-target="#reportForm">
                          <em class="icon ni ni-alert" style="color:red"></em>
                        </button>
                        @endif
                    </h3>
                     
                      
                    </div>
                      <span class="text-mute ff-italic fw-bold">Đăng bởi: <a href="/thanh-vien/{{ $post->users->id }}" class="text-primary fs-14px">{{ $post->users->profile->displayName }}</a></span>
                      <br>
                      <span class="text-mute ff-italic fw-bold">Ngày đăng: {{ $post->created_at->format("H:i Y/m/d") }} </span>

                    <div>
                        {!! clean($post->content) !!}

                    </div>
                  </div>

               
              </div><!-- .col -->
          </div><!-- .row -->
          <div class="d-flex align-items-center border bg-gray-200 p-1 mt-3 fs-11px">
            <em class="icon ni ni-clock"></em>
            <span> Update vào lúc {{  $post->updated_at->format("H:i Y/m/d") }}</span>  
          </div>
        </div>
     
  </div>

  <div class="card card-bordered">
        <div class="card-inner">        
            <div class=" mb-5 bg-white rounded" id="comment-box" style="overflow-y:scroll; overflow-x:hidden; max-height:1000px;">
                <div class="row">
                    <div class="col-md-12">
                        @foreach ($comments as $comment)

                        <div class="media mt-4" id="comment-{{ $comment->id }}">
                            <div class="d-flex flex-column me-3 ">
                                <img class="border border-primary" alt="Bootstrap Media Preview" src="{{ $comment->users->profile->url }}" width="150px" />

                                @if(Auth::check())

                                <button class="btn btn-icon btn-lg btn-success create-reply-btn" data-id={{ $comment->id }}>
                                    <em class="icon ni ni-reply m-auto">
                                        </em>
                                </button>

                                @endif
                            </div>
                           
                            <div class="media-body">
                                <div class="card card-bordered">
                                    <div class="p-1">

                                        <div class="row">
                                            <div class="col-8 d-flex flex-column justify-content-start">                                      
                                                    <a href="/thanh-vien/{{ $comment->users->id }}" class="d-block font-weight-bold name">{{ $comment->users->profile->displayName }}</a>
                                                    <span class="date text-black-50">{{ $comment->created_at }}</span>                                     
                                            </div>    
                                            @if(Auth::check() && Auth::user()->id == $comment->users->id)
                                                             
                                            <div class="col-4">                                   
                                                <div class="d-flex flex-row-reverse">    
                                                    <button class="btn btn-icon delete-comment-btn" data-id={{ $comment->id }}>
                                                        <em class="icon ni ni-cross"></em>                     

                                                    </button>
                          
                                                </div>                               
                                            </div>
                                            @endif
                                        </div>		
                                    
                                        <div class="content">
                                            {!! clean($comment->content) !!}
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="create-reply-box-{{$comment->id}}">

                                </div>
                                @foreach ($comment->replies as $reply)
                                    @if(is_null($reply->deleted_at))
                                    <div class="media mt-4" id="reply-{{$reply->id}}">
                                        <a class="pr-3" href="#"><img class="rounded-circle" alt="Bootstrap Media Another Preview" src="{{ $reply->users->profile->url }}" width="70px" /></a>
                                        
                                        <div class="media-body">
                                            <div class="card card-bordered">
                                                <div class="p-1">
                                                    <div class="row">
                                                        <div class="col-8 d-flex flex-column justify-content-start">
                                                            <a href="/thanh-vien/{{ $reply->users->id }}"class="d-block font-weight-bold name">{{ $reply->users->profile->displayName }}</a>
                                                            <span class="date text-black-50">{{ $reply->created_at }}</span>
                                                        </div>
                                                        @if(Auth::check() && Auth::user()->id == $reply->users->id)

                                                        <div class="col-4">                                   
                                                            <div class="d-flex flex-row-reverse">    
                                                                <a href="#" class="btn btn-icon delete-reply-btn" data-id={{ $reply->id }} >
                                                                    <em class="icon ni ni-cross"></em>                     
            
                                                                </a>
                                      
                                                            </div>                               
                                                        </div>
                                                        @endif
                                                    </div>
        
                                                        <div class="content">
                                                            {!! clean($reply->content) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                    </div>
                                    @endif
                                @endforeach
                             
                            </div>
                        </div>
                        
                        
                        @endforeach
                        
                      
                    </div>
                </div>

            </div>

            @if (Auth::check())
            <div class="create-comment-box shadow p-3">
                <h2>Viết bình luận</h2>
                <textarea id="mytextarea" 
                    required 
                    name="content" 
                    class="form-control">
                </textarea>
                <div class="mt-2 d-flex flex-row-reverse">
                    <button class="btn btn-primary" id="comment-btn" type="button">
                        <em class="icon ni ni-comments"></em>
                        <span>Bình luận</span>
                    </button>
                </div>
            </div>
            @endif
           
        </div>
    </div>
</div>
@endsection
@section('modal')
@if(Auth::check())

<div class="modal fade" id="reportForm" style="display: none;" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Báo cáo bài đăng</h5>
              <button id="close-btn" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <em class="icon ni ni-cross"></em>
              </button>
          </div>
          <div class="modal-body">
              <form class="form-validate is-alter" novalidate="novalidate">
                  @csrf
                  <input type="hidden" class="form-control" id="type_id" name="type_id" value=4>
                  <input type="hidden" class="form-control" id="identifier_id" name="identifier_id" value={{ $post->id }}>

                  <div class="form-group">
                      <label class="form-label" for="book-name">Tên thành viên</label>
                      <div class="form-control-wrap">
                          <input type="text" class="form-control" id="book-name" required="" value='{{ $post->topic }}' readonly>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="form-label" for="description">Lý do</label>
                      <div class="form-control-wrap">
                          <textarea class="form-control form-control-sm" id="description" name="description" placeholder="Lý do của bạn" required></textarea>
                      </div>
                    
                  </div>
                  <div class="form-group text-right">
                      <button id="report-btn" class="btn btn-lg btn-primary">Báo cáo</button>
                  </div>
              </form>
          </div>
          <div class="modal-footer bg-light">
              <span class="sub-text">Báo cáo bởi {{ Auth::user()->profile->displayName }}</span>
          </div>
      </div>
  </div>
</div>

@endif
@endsection
@section('additional-scripts')

<script>

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    $(window).bind('beforeunload', function(e){

        var content = tinymce.activeEditor.getContent("myTextarea");

        if(content){
            return e.originalEvent.returnValue = "Your message here";        
        }
    });

    $(function () {
        tinymce.init({
        entity_encoding : "raw",
        selector: '#mytextarea',
        branding: false,
        statusbar: false,
        height: 300,
        resize: false,
        menubar: false,
        plugins: [
            "advlist", "anchor", "autolink", "charmap", "code", "fullscreen", 
            "help", "image", "insertdatetime", "link", "lists", "media", 
            "preview", "searchreplace", "table", "visualblocks",
        ],
        toolbar: "undo redo |  bold italic underline strikethrough | link image | forecolor ",
        image_title: true,
        /* enable automatic uploads of images represented by blob or data URIs*/
        images_upload_url: '/upload',
        automatic_uploads: false,
        file_picker_types: 'image',
        /* and here's our custom image picker*/
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function () {
            var file = this.files[0]; 
            var reader = new FileReader();
            reader.onload = function () {
                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);

                /* call the callback and populate the Title field with the file name */
                cb(blobInfo.blobUri(), { title: file.name });
            };
            reader.readAsDataURL(file);
            };

            input.click();
        },
        content_style: 'body { font-size: 16px; font-family: Roboto; }' 
        });

    })
    
    $(document).on('click','#comment-btn',function(){
        var content = tinymce.activeEditor.getContent("myTextarea");
        var post_id = {!! $post->id !!};

        if($("#reply-box").length){
                tinyMCE.remove("textarea#reply_textarea");
                $("#reply-box").remove();
        }
        else{
            if(content){

                tinymce.activeEditor.uploadImages().then((response)=>{
                var update_content = tinymce.activeEditor.getContent("myTextarea");

                    $.ajax({
                        url:'/binh-luan',
                        type:"POST",
                        data:{
                            'item_id': post_id,
                            'content': update_content,
                            'option':2
                        }
                    })
                    .done(function(res) {

                        Swal.fire({
                                icon: 'success',
                                title: `${res.success}`,
                                showConfirmButton: false,
                                timer: 2500
                            });      
                        tinymce.activeEditor.setContent("");

                        $("#comment-box").load(" #comment-box > *");
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                    // If fail
                    console.log(textStatus + ': ' + errorThrown);
                    });


                })
                    
                }
            else{
                Swal.fire({
                        icon: 'error',
                        title: `Vui lòng điền nội dung`,
                        showConfirmButton: false,
                        timer: 2500
                    });    
            }

        }
       
       
    
    })

    $(document).on('click','.delete-comment-btn',function(){
        var comment_id = $(this).data('id');

            Swal.fire({
                title: "Bạn muốn xóa bình luận này?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Không'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                    type:"GET",
                    url:'/xoa-binh-luan/2/' + comment_id,
                    data : {
                    },
                    })
                    .done(function(res) {
                    // If successful
                    Swal.fire({
                            icon: 'success',
                            title: `Xóa thành công`,
                            showConfirmButton: false,
                            timer: 2500
                    });

                    $("#comment-" + comment_id).fadeOut();
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                    // If fail
                    console.log(textStatus + ': ' + errorThrown);
                    });
                
                }
            })

    })
 
    $(document).on('click','.create-reply-btn',function(){

            var comment_id = $(this).data('id');

        
            if($("#reply-box").length){
                tinyMCE.remove("textarea#reply_textarea");
                $("#reply-box").remove();
            }
            else{

                var htmlrender = '<div class="create-reply-box shadow p-3" id="reply-box">'+
                        '<textarea id="reply_textarea" required name="content" class="form-control"></textarea>'+
                       ' <div class="mt-2 d-flex flex-row-reverse">'+
                        `<button class="btn btn-primary" id="reply-btn" type="button" data-id=${comment_id}>  `+
                                '<em class="icon ni ni-comments"></em>' +
                                '<span>Phản hồi</span>'+
                           ' </button>' +
                       ' </div>' +
                 ' </div>';


                $('#create-reply-box-'+comment_id).append(htmlrender);

                tinyMcePromise= tinymce.init({
                    selector: "#reply_textarea",
                    entity_encoding : "raw",
                    branding: false,
                    statusbar: false,
                    height: 300,
                    resize: false,
                    menubar: false,
                    plugins: [
                        "advlist", "anchor", "autolink", "charmap", "code", "fullscreen", 
                        "help", "image", "insertdatetime", "link", "lists", "media", 
                        "preview", "searchreplace", "table", "visualblocks",
                    ],
                    toolbar: "undo redo |  bold italic underline strikethrough | link image | forecolor ",
                    image_title: true,
                    /* enable automatic uploads of images represented by blob or data URIs*/
                    images_upload_url: '/upload',
                    automatic_uploads: false,
                    file_picker_types: 'image',
                    /* and here's our custom image picker*/
                    file_picker_callback: function (cb, value, meta) {
                        var input = document.createElement('input');
                        input.setAttribute('type', 'file');
                        input.setAttribute('accept', 'image/*');

                        input.onchange = function () {
                        var file = this.files[0]; 
                        var reader = new FileReader();
                        reader.onload = function () {
                            var id = 'blobid' + (new Date()).getTime();
                            var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                            var base64 = reader.result.split(',')[1];
                            var blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);

                            /* call the callback and populate the Title field with the file name */
                            cb(blobInfo.blobUri(), { title: file.name });
                        };
                        reader.readAsDataURL(file);
                        };

                        input.click();
                        },
                        content_style: 'body { font-size: 16px; font-family: Roboto; }' 
                    });
              

                
                    tinyMcePromise.then(function(editors){
                    editors[0].focus();
                });

            }

    })

    $(document).on('click','#reply-btn',function(){

        var content = tinymce.activeEditor.getContent("reply_textarea");
        
        var comment_id = $(this).data('id');

        if(content){
            tinymce.activeEditor.uploadImages().then((response)=>{
            var update_content = tinymce.activeEditor.getContent("reply_textarea");
            

            
                $.ajax({
                    url:'/phan-hoi',
                    type:"POST",
                    data:{
                        'comment_id': comment_id,
                        'content': update_content,
                        'option':2
                    }
                })
                .done(function(res) {

                    Swal.fire({
                            icon: 'success',
                            title: `${res.success}`,
                            showConfirmButton: false,
                            timer: 2500
                        });      

                    $("#comment-box").load(" #comment-box > *");

                    tinyMCE.remove("textarea#reply_textarea");
                    $("#reply-box").remove();

                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
            });
            })
        }
        else{
            Swal.fire({
                        icon: 'error',
                        title: `Vui lòng điền nội dung`,
                        showConfirmButton: false,
                        timer: 2500
                    });    
        }

    


    })

    $(document).on('click','.delete-reply-btn',function(){
        var reply_id = $(this).data('id');

            Swal.fire({
                title: "Bạn muốn xóa phản hồi này?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Không'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                    type:"GET",
                    url:'/xoa-phan-hoi/2/' + reply_id,
                    data : {
                    },
                    })
                    .done(function() {
                    // If successful
                    Swal.fire({
                            icon: 'success',
                            title: `Xóa thành công`,
                            showConfirmButton: false,
                            timer: 2500
                    });

                    $("#reply-" + reply_id).fadeOut();

                   
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                    // If fail
                    console.log(textStatus + ': ' + errorThrown);
                    });
                
                }
            })

    })

    $('#report-btn').click(function(e){
        e.preventDefault();
        Swal.fire({
            icon: 'info',
            html:
                'Tài khoản của bạn có thể bị <b>khóa</b> nếu bạn cố tình báo cáo sai',
            showCloseButton: true,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Báo cáo',
            cancelButtonText: `Không báo cáo`,
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                var form = $('#reportForm');

                var type_id = form.find('input[name="type_id"]').val();
                var identifier_id = form.find('input[name="identifier_id"]').val();
                var description = form.find('textarea[name="description"]').val();
                
                if(description){
                        $.ajax({
                        url:'/bao-cao',
                        type:"POST",
                        data:{
                            'description': description,
                            'identifier_id':identifier_id,
                            'type_id':type_id
                        }
                        })
                        .done(function(res) {
                        
                            Swal.fire({
                                    icon: 'success',
                                    title: `${res.report}`,
                                    showConfirmButton: false,
                                    timer: 2500
                                });     

                            
                            setTimeout(()=>{
                                $('#close-btn').click();
                            }, 2500);
                        })

                        .fail(function(jqXHR, textStatus, errorThrown) {
                        // If fail
                        console.log(textStatus + ': ' + errorThrown);
                        })
                }
                else{
                    Swal.fire('Vui lòng nhập lý do!!!', '', 'info')
                }

              



            } else if (result.isDenied) {
                Swal.fire('Báo cáo thất bại', '', 'info')
            }
        })
    })
</script>
@endsection