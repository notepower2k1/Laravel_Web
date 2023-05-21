@extends('client/forum.layouts.app')
@section('pageTitle', `${{$post->topic}}`)
@section('additional-style')

<style>
   
    .open-relies-btn:hover{
        cursor: pointer;
    }
  
</style>
@endsection
@section('content')
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <nav>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dien-dan">Diễn đàn</a></li>
                    <li class="breadcrumb-item"><a href="/dien-dan/{{ $post->forums->slug }}">{{ $post->forums->name }}</a></li>
                    <li class="breadcrumb-item active">{{ $post->topic }}</li>
                </ul>
            </nav>
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
            <div class="d-flex justify-content-between">
                <h5><span class="total-comment-span">{{ $post->totalComments }} </span>bình luận</h5>
                <div class="dropdown">
                    <a class="btn btn-icon btn-outline-secondary dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <em class="icon ni ni-sort-line"></em>    
                    </a>
                    <div class="dropdown-menu">
                      <ul class="link-list-opt">
                        <li><a href="#" id="sort-comment-new"><span>Mới nhất</span></a></li>
                        <li><a href="#" id="sort-comment-old"><span>Cũ nhất</span></a></li>
                
                      </ul>
                    </div>
                  </div>                                                      
            </div>
            <div class="mb-5 bg-white rounded" id="comment-box" style="overflow-y:scroll; overflow-x:hidden; max-height:1000px;">
                <div class="row">
                    <div class="col-md-12" id="comment_list">
                        @foreach ($comments as $comment)

                        <div class="media mt-4" id="comment-{{ $comment->id }}">
                            <div class="d-flex flex-column me-3">
                                <img class="border border-secondary" alt="Bootstrap Media Preview" src="{{ $comment->users->profile->url }}" width="100px" />

                                @if(Auth::check())

                                <button class="btn btn-icon btn-success create-reply-btn" data-id={{ $comment->id }}>
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
                                                    <a href="/thanh-vien/{{ $comment->users->id }}" class="d-block font-weight-bold name text-dark">{{ $comment->users->profile->displayName }}</a>
                                                    <span class="date text-black-50">{{ $comment->created_at }}</span>                                     
                                            </div>    

                                            @if(Auth::check())
                                                @if(Auth::user()->id == $comment->users->id || Auth::user()->role == 1)
                                                                
                                                    <div class="col-4">                                   
                                                        <div class="d-flex flex-row-reverse">                              
                                                            <div class="dropdown">
                                                                <a class="dropdown-toggle text-dark" href="#" type="button" data-bs-toggle="dropdown">
                                                                    <em class="icon ni ni-more-v"></em>
                                                                </a>
                                                                <div class="dropdown-menu">
                                                                <ul class="link-list-opt">
                                                                    <li><a class="delete-comment-btn" data-id={{ $comment->id }} href="#">
                                                                        <em class="icon ni ni-cross"></em>      
                                                                        <span>Xóa bình luận</span>
                                                                        </a>
                                                                    </li>
                                                                    @if(Auth::user()->id != $comment->users->id)
                                                                    <li>
                                                                        <a class="report-comment-btn" data-id={{ $comment->id }} data-type=8 data-user='{{ $comment->users->profile->displayName  }}'
                                                                            data-bs-toggle="modal" data-bs-target="#reportFormComment"
                                                                            href="#">
                                                                            <em class="icon ni ni-flag"></em>
                                                                            <span>Báo cáo bình luận</span>
                                                                        </a>
                                                                    </li>
                                                                    @endif
                                                                </ul>
                                                                </div>
                                                            </div>                                         
                                                        </div>                               
                                                    </div>
                                                @endif
                                            @endif
                                        </div>		
                                    
                                        <div class="content">
                                            {!! clean($comment->content) !!}
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="create-reply-box-{{$comment->id}}">

                                </div>
                                @if($comment->totalReplies > 0)
                                    <div class="mt-2">
                                        <p class="open-relies-btn fw-bold" data-id="{{ $comment->id }}">Xem {{ $comment->totalReplies }} phản hồi</p>
                                    </div>
                                @endif
                                @foreach ($comment->replies as $reply)
                                    @if(is_null($reply->deleted_at))
                                    <div class="media mt-4 replies-item replies-item-{{ $reply->commentID }}" id="reply-{{$reply->id}}">
                                        <a class="pr-3" href="#"><img class="rounded-circle" alt="Bootstrap Media Another Preview" src="{{ $reply->users->profile->url }}" width="70px" /></a>
                                        
                                        <div class="media-body">
                                            <div class="card card-bordered">
                                                <div class="p-1">
                                                    <div class="row">
                                                        <div class="col-8 d-flex flex-column justify-content-start">
                                                            <a href="/thanh-vien/{{ $reply->users->id }}"class="d-block font-weight-bold name">{{ $reply->users->profile->displayName }}</a>
                                                            <span class="date text-black-50">{{ $reply->created_at }}</span>
                                                        </div>
                                                        @if(Auth::check())
                                                            @if(Auth::user()->id == $reply->users->id || Auth::user()->role == 1)

                                                            <div class="col-4">                                   
                                                                <div class="d-flex flex-row-reverse">    
                                                                    <div class="dropdown">
                                                                        <a class="dropdown-toggle" href="#" type="button" data-bs-toggle="dropdown">
                                                                            <em class="icon ni ni-more-v"></em>
                                                                        </a>
                                                                        <div class="dropdown-menu">
                                                                        <ul class="link-list-opt">
                                                                            <li><a href="#" class="delete-reply-btn" data-id={{ $reply->id }} >
                                                                                <em class="icon ni ni-cross"></em>      
                                                                                <span>Xóa bình luận</span>
                                                                                </a>
                                                                            </li>
                                                                            @if(Auth::user()->id != $comment->users->id)

                                                                            <li>           
                                                                                <a class="report-comment-btn" data-id={{ $comment->id }} data-type=9 data-user="{{ $comment->users->profile->displayName  }}" 
                                                                                    data-bs-toggle="modal" data-bs-target="#reportFormComment"
                                                                                    href="#">
                                                                                    <em class="icon ni ni-flag"></em>
                                                                                    <span>Báo cáo bình luận</span>
                                                                                </a>
                                                                            </li>
                                                                            @endif
                                                                        </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>   
                                                                
                                                                
                                                            </div>
                                                            @endif
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

<div class="modal fade" id="reportForm">
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
                    <label class="form-label" for="reason">Lý do</label>
                    <div class="form-control-wrap">
                        <select required class="form-control mb-4 col-6" name="reason" id="reason">
                            @foreach ($reportReasons as $reason)
                            <option value="{{ $reason->id }}" >{{ $reason->name }}</option>
                            @endforeach
                        </select>                        
                    </div>                     
                </div>

                  <div class="form-group">
                      <label class="form-label" for="description">Ghi chú</label>
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

<div class="modal fade" id="reportFormComment">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Báo cáo bình luận</h5>
                <button id="close-btn" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-validate is-alter" novalidate="novalidate">
                    @csrf

                    <input type="hidden" class="form-control" id="type_id" name="type_id" value=0>
                    <input type="hidden" class="form-control" id="identifier_id" name="identifier_id" value=0>
               
                    <div class="form-group">
                        <label class="form-label" for="user-name">Bình luận bởi</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="user-name" name="user-name" required="" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reason">Lý do</label>
                        <div class="form-control-wrap">
                            <select required class="form-control mb-4 col-6" name="reason" id="reason">
                                @foreach ($reportReasons as $reason)
                                <option value="{{ $reason->id }}" >{{ $reason->name }}</option>
                                @endforeach
                            </select>                        
                        </div>                     
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="description">Ghi chú</label>
                        <div class="form-control-wrap">
                            <textarea class="form-control form-control-sm" id="description" name="description" placeholder="Lý do của bạn" required></textarea>
                        </div>
                      
                    </div>
                    <div class="form-group text-right">
                        <button id="submitReportFormComment" class="btn btn-lg btn-primary">Báo cáo</button>
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
        $('.replies-item').css('display', 'none');

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
            "preview", "searchreplace", "table", "visualblocks","emoticons"
        ],
        toolbar: "undo redo |  bold italic underline strikethrough | link image | forecolor | emoticons ",
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

    $(document).on('click','.open-relies-btn',function() {
        const comment_id = $(this).data('id');
        $(`.replies-item-${comment_id}`).fadeToggle();
    });

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
                            'option':3
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
                    url:'/xoa-binh-luan/' + comment_id,
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
                    $("#comment-box").load(" #comment-box > *");
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
                        "preview", "searchreplace", "table", "visualblocks","emoticons"
                    ],
                    toolbar: "undo redo |  bold italic underline strikethrough | link image | forecolor | emoticons",
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
                    url:'/xoa-phan-hoi/' + reply_id,
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
                    $("#comment-box").load(" #comment-box > *")
                   
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
                const reason = form.find('select[name="reason"]').val();

                if(description){
                        $.ajax({
                        url:'/bao-cao',
                        type:"POST",
                        data:{
                            'description': description,
                            'identifier_id':identifier_id,
                            'type_id':type_id,
                            'reason':reason
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
                                form.modal('hide');
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

    $(document).on('click','.report-comment-btn',function(e){
        e.preventDefault();
        const form = $('#reportFormComment');
        const identifier_id = $(this).data('id');
        const type_id = $(this).data('type');
        const userName = $(this).data('user');
        form.find('input[name="user-name"]').val(userName);
        form.find('input[name="type_id"]').val(type_id);
        form.find('input[name="identifier_id"]').val(identifier_id);
        
        console.log(identifier_id,type_id,userName);
    })
    $('#submitReportFormComment').click(function (e) {

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
                const form = $('#reportFormComment');
                const type_id = form.find('input[name="type_id"]').val();
                const identifier_id = form.find('input[name="identifier_id"]').val();
                const description = form.find('textarea[name="description"]').val();
                const reason = form.find('select[name="reason"]').val();

                
                if(description){
                            $.ajax({
                        url:'/bao-cao',
                        type:"POST",
                        data:{
                            'description': description,
                            'identifier_id':identifier_id,
                            'type_id':type_id,
                            'reason':reason
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
                                form.modal('hide');
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
    });


    $(document).on('click','#sort-comment-new',function(e){

        e.preventDefault();
    $('#comment_list').children().sort(function(a,b){

        
        
        return parseInt(b.id.split('-')[1]) - parseInt(a.id.split('-')[1]);

        }).each(function() {
        var elem = $(this);

        elem.remove();

        $(elem).appendTo("#comment_list")
    })

    })

    $(document).on('click','#sort-comment-old',function(e){

        e.preventDefault();
    $('#comment_list').children().sort(function(a,b){

        return parseInt(a.id.split('-')[1]) - parseInt(b.id.split('-')[1]);

        }).each(function() {
        var elem = $(this);

        elem.remove();

        $(elem).appendTo("#comment_list")
    })

    })
</script>
@endsection