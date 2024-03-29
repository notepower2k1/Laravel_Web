@extends('client/forum.layouts.app')
@section('pageTitle', `${{$post->topic}}`)
@section('additional-style')
<link rel="stylesheet" href="{{ asset('assets/css/infohelper.css') }}">
<link href="{{ asset('js/pagination/pagination.css') }}" rel="stylesheet" type="text/css">

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
                    <div class="entry ">
                    
                        <div class="d-flex align-items-center" id="post-info">
                            <h3 class="text-left">{{ $post->topic }}
                           
                            </h3>                         
                            @if(Auth::check())

                                @if($reportPost)

                                    @if($reportPost->isEnabled)
                                        <button type="button" class="btn btn-icon mb-2" data-bs-toggle="modal" data-bs-target="#reportForm">
                                            <em class="icon ni ni-flag " style="color:red"></em>
                                        </button>
                                    @else

                                    <dfn data-info="Đã có người báo cáo">
                                        <button type="button" class="btn btn-icon border-0 mb-2" disabled>
                                            <em class="icon ni ni-flag" style="color:red"></em>
                                        </button>
                                    </dfn>
                                    
                                    @endif
                                @else
                                    <button type="button" class="btn btn-icon mb-2" data-bs-toggle="modal" data-bs-target="#reportForm">
                                        <em class="icon ni ni-flag " style="color:red"></em>
                                    </button>
                                @endif
                        
                            @endif
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
            <div class="d-flex align-items-center border bg-gray-200 p-1 mt-3 fs-11px justify-content-between">
                <div>
                    <em class="icon ni ni-clock"></em>
                    <span> Update vào lúc {{  $post->updated_at->format("H:i Y/m/d") }}</span>  
                </div>
                <div>
                    <em class="icon ni ni-eye"></em>
                    <span> {{ $post->totalViews }} lượt xem</span>  
                </div>
            </div>
            </div>
        
    </div>

    <div class="card card-bordered"  style=" background: hsla(48, 100%, 96%, 1)">
        <div class="card-inner">        
            <div class="d-flex justify-content-between">
                <h5><span id="total-comment-span">{{ $post->totalComments }} </span>bình luận</h5>
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
                    <div class="col-md-12" id ="comment-render-div">
                        @foreach ($comments as $comment)

                        <div class="media mt-4" id="comment-{{ $comment->id }}">
                            <div class="d-flex flex-column me-3">
                                <img class="border border-secondary" alt="Bootstrap Media Preview" src="{{ $comment->users->profile->url }}" width="100px" />

                                @if(Auth::check())

                                <button class="btn btn-icon btn-success create-reply-btn" data-id={{ $comment->id }} data-commentowner = "{{ $comment->users->profile->displayName }}">
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
                                                                    <li> 
                                                                        <a href="#" class="edit-comment-btn" data-id="{{ $comment->id }}" data-option="1">
                                                                            <em class="icon ni ni-edit fs-16px"></em>
                                                                            <span>Chỉnh sửa bình luận</span>
                                                                        </a>                                                                  
                                                                    </li>
                                                                    @if(Auth::user()->id != $comment->users->id)
                                                                        @if($reportComment->where('identifier_id','=',$comment->id)->first())
                                                                            @if($reportComment->where('identifier_id','=',$comment->id)->first()->isEnabled)
                                                                                <li>
                                                                                    <a class="report-comment-btn" data-id={{ $comment->id }} data-type=6 data-user="{{ $comment->users->profile->displayName  }}" 
                                                                                        data-bs-toggle="modal" data-bs-target="#reportFormComment"
                                                                                        href="#">
                                                                                        <em class="icon ni ni-flag"></em>
                                                                                        <span>Báo cáo bình luận</span>
                                                                                    </a>
                                                                                </li>
                                                                            @else


                                                                            <li style="background-color:rgb(215, 208, 208)">
                                                                                <a>
                                                                                    <em class="icon ni ni-flag"></em>
                                                                                    <span>Đã báo cáo</span>
                                                                                </a>
                                                                            </li>
                                                                            @endif
                                                                        @else
                                                                            <li>

                                                                                <a class="report-comment-btn" data-id={{ $comment->id }} data-type=6 data-user="{{ $comment->users->profile->displayName  }}" 
                                                                                    data-bs-toggle="modal" data-bs-target="#reportFormComment"
                                                                                    href="#">
                                                                                    <em class="icon ni ni-flag"></em>
                                                                                    <span>Báo cáo bình luận</span>
                                                                                </a>
                                                                            </li>
                                                                        @endif
                                                                    
                                                                    @endif
                                                                </ul>
                                                                </div>
                                                            </div>                                         
                                                        </div>                               
                                                    </div>
                                                @endif
                                            @endif
                                        </div>		
                                    
                                        <div class="content" id ="comment-content-{{ $comment->id }}">
                                            {!! clean($comment->content) !!}
                                        </div>
                                    </div>
                                </div>
                                
                               
                                @if($comment->totalReplies > 0)
                                    <div class="mt-2">
                                        <p class="open-relies-btn fw-bold" data-id="{{ $comment->id }}">Xem {{ $comment->totalReplies }} phản hồi</p>
                                    </div>
                                @endif
                                @foreach ($comment->replies as $reply)
                                    @if(is_null($reply->deleted_at))
                                    <div class="media mt-4 replies-item replies-item-{{ $reply->commentID }}" id="reply-{{$reply->id}}">
                                        <a class="pr-3" href="#"><img class="rounded-circle" alt="..." src="{{ $reply->users->profile->url }}" width="70px" /></a>
                                        
                                        <div class="media-body">
                                            <div class="card card-bordered">
                                                <div class="p-1">
                                                    <div class="row">
                                                        <div class="col-8 d-flex flex-column justify-content-start">
                                                            <a href="/thanh-vien/{{ $reply->users->id }}"class="d-block font-weight-bold name text-dark">{{ $reply->users->profile->displayName }}</a>
                                                            <span class="date text-black-50">{{ $reply->created_at }}</span>
                                                        </div>
                                                        @if(Auth::check())
                                                            @if(Auth::user()->id == $reply->users->id || Auth::user()->role == 1)

                                                            <div class="col-4">                                   
                                                                <div class="d-flex flex-row-reverse">    
                                                                    <div class="dropdown">
                                                                        <a class="dropdown-toggle text-dark" href="#" type="button" data-bs-toggle="dropdown">
                                                                            <em class="icon ni ni-more-v"></em>
                                                                        </a>
                                                                        <div class="dropdown-menu">
                                                                        <ul class="link-list-opt">
                                                                            <li><a href="#" class="delete-reply-btn" data-id={{ $reply->id }} >
                                                                                <em class="icon ni ni-cross"></em>      
                                                                                <span>Xóa phản hồi</span>
                                                                                </a>
                                                                            </li>
                                                                            <li> 
                                                                                <a href="#" class="edit-comment-btn" data-id="{{ $reply->id }}" data-option="2">
                                                                                    <em class="icon ni ni-edit fs-16px"></em>
                                                                                    <span>Chỉnh sửa phản hồi</span>
                                                                                </a>

                                                                                
                                                                            </li>
                                                                            @if(Auth::user()->id != $comment->users->id)

                                                                                    @if($reportReply->where('identifier_id','=',$reply->id)->first())
                                                                                        @if($reportReply->where('identifier_id','=',$reply->id)->first()->isEnabled)
                                                                                            <li>
                                                                                                <a class="report-comment-btn" data-id={{ $reply->id }} data-type=7 data-user="{{ $reply->users->profile->displayName  }}" 
                                                                                                    data-bs-toggle="modal" data-bs-target="#reportFormComment"
                                                                                                    href="#">
                                                                                                    <em class="icon ni ni-flag"></em>
                                                                                                    <span>Báo cáo bình luận</span>
                                                                                                </a>
                                                                                            </li>

                                                                                        @else

                                                                                            <li style="background-color:rgb(215, 208, 208)">
                                                                                                <a>
                                                                                                    <em class="icon ni ni-flag"></em>
                                                                                                    <span>Đã báo cáo</span>
                                                                                                </a>
                                                                                            </li>
                                                                                        
                                                                                     
                                                                                        @endif
                                                                                    @else
                                                                                        <li>           

                                                                                            <a class="report-comment-btn" data-id={{ $reply->id }} data-type=7 data-user="{{ $reply->users->profile->displayName  }}" 
                                                                                                data-bs-toggle="modal" data-bs-target="#reportFormComment"
                                                                                                href="#">
                                                                                                <em class="icon ni ni-flag"></em>
                                                                                                <span>Báo cáo bình luận</span>
                                                                                            </a>
                                                                                        </li>
                                                                                    @endif

                                                                              
                                                                            @endif
                                                                        </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>   
                                                                
                                                                
                                                            </div>
                                                            @endif
                                                        @endif
                                                    </div>
        
                                                        <div class="content"  id ="reply-content-{{ $reply->id }}">
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

                    <div id="new-comment-loading" style="display:none">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                              <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    @if ($comments->count() > 0)
    
                    <div class="data-container"></div>
                    <div class="col-md-12 d-flex justify-content-end mt-4">                          
                        <div id="pagination"></div>
                    </div>
                    @endif
                </div>

            </div>

            @if (Auth::check())
            <div class="create-comment-box shadow">
                <textarea id="mytextarea" 
                    required 
                    name="content" 
                    class="form-control">
                </textarea>
                <div class="d-flex flex-row-reverse p-2">
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
                      <label class="form-label" for="post-name">Tên thành viên</label>
                      <div class="form-control-wrap">
                          <input type="text" class="form-control" id="post-name" required="" value='{{ $post->topic }}' readonly>
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

<div class="modal fade" id="editCommentForm" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa bình luận</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
               
            </div>
           
        </div>
    </div>
</div>

<div class="modal fade" id="reply-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body text-left">
            
                
            </div>
        </div>
    </div>
</div>
@endif
@endsection
@section('additional-scripts')
<script src="https://js.pusher.com/4.3/pusher.min.js"></script>
<script src="{{ asset('js/pagination/pagination.min.js') }}" ></script>

<script>

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
            cluster: 'ap1',
            encrypted: true
    });

    const post_id = {!! $post->id !!};
    //live time comment
    var commentChannel  = pusher.subscribe(`comment_3_${post_id}`);

    // Bind a function to a Event (the full Laravel class)
    if(commentChannel){
        commentChannel.bind('send-comment', function(data) {
            if (post_id == data['itemID'] && data['typeID'] == 3){       
                const oldComment = $('#total-comment-span').text();
          
                switch(data['eventType']) {
                    case "add-comment":

                        $('#new-comment-loading').show();          

                        $('#total-comment-span').text(parseInt(oldComment) + 1 + " ");


                        $("#comment-box").load(" #comment-box > *",function(){
                            commentRender();
                            $('.replies-item').css('display', 'none');
                            $('#new-comment-loading').hide();          

                        });
                        break;    
                    case "edit-comment":
                        $("#comment-content-"+ data['id']).load(` #comment-content-${data['id']} > *`)
                        break;         
                    case "delete-comment":


                        var totalRepliesLeft = $("#comment-" + data['id']).find(".replies-item").length;

                        if(totalRepliesLeft){
                            $('#total-comment-span').text(parseInt(oldComment) - parseInt(totalRepliesLeft) -1);

                        }
                        else{
                            $('#total-comment-span').text(parseInt(oldComment) - 1);

                        }

                        $("#comment-" + data['id']).fadeOut();
                        $("#comment-" + data['id']).remove();

                        break;
                    case "add-reply":
                        $('#new-comment-loading').show();          

                        $('#total-comment-span').text(parseInt(oldComment) + 1 + " ");
                        $("#comment-box").load(" #comment-box > *",function(){
                            commentRender();
                            $('.replies-item').css('display', 'none');
                            $('#new-comment-loading').hide();          

                        });
                        break;  
                    case "edit-reply":
                        $("#reply-content-"+ data['id']).load(` #reply-content-${data['id']} > *`)
                        break;      
                    case "delete-reply":


                        $('#total-comment-span').text(parseInt(oldComment) - 1 + " ");

                        var totalRepliesLeft = $("#reply-"+ data['id']).parent().find(".replies-item").length;

                        totalRepliesLeft = totalRepliesLeft - 1;

                        if(totalRepliesLeft > 0){
                            $("#reply-" + data['id']).parent().find('.open-relies-btn').text(`Xem ${totalRepliesLeft} phản hồi`)
                        }
                        else{
                            $("#reply-" + data['id']).parent().find('.open-relies-btn').remove();
                        }

                        $("#reply-" + data['id']).fadeOut();
                        $("#reply-" + data['id']).remove();
                       
                        break;
                    default:
                        // code block
                }
                

            }
        });
    }

    
    function commentRender(){
        const container = $('#pagination');


        if (!container.length) return;
            var sources = function () {
            var result = [];

            $('#comment-render-div').children().each(function(item){


                result.push($(this).get(0).outerHTML);

            })
        return result;
        }();

        var options = {
            dataSource: sources,
            callback: function (response, pagination) {
                var dataHtml = '<div id ="comment_list" >';

                $.each(response, function (index, item) {
                    dataHtml += item;
                });

                dataHtml += '</div>';

                container.parent().prev().html(dataHtml);
                $('#comment-render-div').remove();
            }
        };


  
        container.pagination(options);
    }

    $(window).bind('beforeunload', function(e){

        var content = tinymce.activeEditor.getContent("myTextarea");

        if(content){
            return e.originalEvent.returnValue = "Your message here";        
        }
    });

    $(function () {
        commentRender();
        $('.replies-item').css('display', 'none');

        tinymce.init({
        entity_encoding : "raw",
        selector: '#mytextarea',
        branding: false,
        statusbar: false,
        min_height: 400,
        resize: false,
        menubar: false,
        plugins: [
                    "advlist", "anchor", "autolink", "charmap", "code", "fullscreen", 
                    "help", "image", "insertdatetime", "link", "lists", "media", 
                    "preview", "searchreplace", "table", "visualblocks"," wordcount","emoticons","wordcount", 'charmap',"directionality","quickbars","autoresize","table"
                ],
        toolbar: "undo redo |  blockquote bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | emoticons charmap |  preview searchreplace wordcount | table | ltr rtl",
        table_toolbar: 'tableprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
        quickbars_selection_toolbar: 'bold italic underline strikethrough',
        quickbars_insert_toolbar: false,
        toolbar_mode: 'sliding',
        image_title: true,
        /* enable automatic uploads of images represented by blob or data URIs*/
        images_upload_url: '/upload',
        automatic_uploads: false,
        file_picker_types: 'image',
        paste_block_drop: true,
        block_unsupported_drop: true,
        image_uploadtab: false,
        image_description: false,

        /* and here's our custom image picker*/
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function () {
            var file = this.files[0]; 
            if(this.files[0].size > 2000000) {
                alert("Kích thước ảnh phải nhỏ hơn 2MB");
                $(this).val('');
            }
            else{
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
            }
          

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

                    
                        // $('#total-comment-span').text(res.totalComments + " ");

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
            var commentOwner = $(this).data('commentowner');

            tinyMCE.remove("textarea#reply_textarea");
            $('#reply-modal').find('.modal-body').empty();


            var htmlrender = '<div class="create-reply-box" id="reply-box">'+
                    '<textarea id="reply_textarea" required name="content" class="form-control"></textarea>'+
                    '<div class="mt-2 d-flex flex-row-reverse">'+
                    `<button class="btn btn-primary" id="reply-btn" type="button" data-id=${comment_id}>  `+
                            '<em class="icon ni ni-comments"></em>' +
                            '<span>Phản hồi</span>'+
                        ' </button>' +
                    ' </div>' +
                ' </div>';

            $('#reply-modal').find('.modal-body').append(htmlrender);
            $('#reply-modal').find('.modal-title').text(`Phản hồi bình luận của ${commentOwner}`)

            // $('#create-reply-box-'+comment_id).append(htmlrender);

            tinyMcePromise= tinymce.init({
                selector: "#reply_textarea",
                entity_encoding : "raw",
                branding: false,
                statusbar: false,
                min_height: 400,
                resize: false,
                menubar: false,
                plugins: [
                    "advlist", "anchor", "autolink", "charmap", "code", "fullscreen", 
                    "help", "image", "insertdatetime", "link", "lists", "media", 
                    "preview", "searchreplace", "table", "visualblocks"," wordcount","emoticons","wordcount", 'charmap',"directionality","quickbars","autoresize","table"
                ],
                toolbar: "undo redo |  blockquote bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | emoticons charmap |  preview searchreplace wordcount | table | ltr rtl",
                table_toolbar: 'tableprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
                quickbars_selection_toolbar: 'bold italic underline strikethrough',
                quickbars_insert_toolbar: false,
                toolbar_mode: 'sliding',
                image_title: true,
                /* enable automatic uploads of images represented by blob or data URIs*/
                images_upload_url: '/upload',
                automatic_uploads: false,
                file_picker_types: 'image',
                paste_block_drop: true,
                block_unsupported_drop: true,
                image_uploadtab: false,
                image_description: false,

                /* and here's our custom image picker*/
                file_picker_callback: function (cb, value, meta) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.onchange = function () {
                        var file = this.files[0]; 
                        if(this.files[0].size > 2000000) {
                            alert("Kích thước ảnh phải nhỏ hơn 2MB");
                            $(this).val('');
                        }
                        else{
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
                        }
                      
                    };

                    input.click();
                    },
                    content_style: 'body { font-size: 16px; font-family: Roboto; }' 
                });
            

            
                tinyMcePromise.then(function(editors){
                editors[0].focus();
            });

            
            $('#reply-modal').modal('show');
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

                  
                    $('#reply-modal').modal('hide');
                    // $('#total-comment-span').text(res.totalComments + " ");


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
                            $("#post-info").load(" #post-info > *");

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

                            $("#comment-box").load(" #comment-box > *",function(){
                                $('.replies-item').css('display', 'none');

                            });

                            // $('#total-comment-span').text(res.totalComments + " ");

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

    $(document).on('click','.edit-comment-btn',function(e) {
        e.preventDefault();

        tinyMCE.remove("textarea#editCommentArea");
        $("#editCommentForm").find('.modal-body').empty();

        const item_id = $(this).data('id');
        const option = $(this).data('option');

        var htmlrender = '<div class="edit-comment-box" id="edit-box">'+
                    '<textarea id="editCommentArea" required name="content" class="form-control"></textarea>'+
                    '<div class="mt-2 d-flex flex-row-reverse">'+
                    `<button class="btn btn-primary" id="edit-btn" type="button" data-id=${item_id} data-option=${option}> `+
                            '<em class="icon ni ni-comments"></em>' +
                            '<span>Chỉnh sửa</span>'+
                        ' </button>' +
                    ' </div>' +
        ' </div>';
        $("#editCommentForm").find('.modal-body').append(htmlrender);

        tinymce.init({
        entity_encoding : "raw",
        selector: '#editCommentArea',
        branding: false,
        statusbar: false,
        min_height: 400,
        resize: false,
        menubar: false,
        plugins: [
                    "advlist", "anchor", "autolink", "charmap", "code", "fullscreen", 
                    "help", "image", "insertdatetime", "link", "lists", "media", 
                    "preview", "searchreplace", "table", "visualblocks"," wordcount","emoticons","wordcount", 'charmap',"directionality","quickbars","autoresize","table"
                ],
        toolbar: "undo redo |  blockquote bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | emoticons charmap |  preview searchreplace wordcount | table | ltr rtl",
        table_toolbar: 'tableprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
        quickbars_selection_toolbar: 'bold italic underline strikethrough',
        quickbars_insert_toolbar: false,
        toolbar_mode: 'sliding',
        image_title: true,
        /* enable automatic uploads of images represented by blob or data URIs*/
        images_upload_url: '/upload',
        automatic_uploads: false,
        file_picker_types: 'image',
        paste_block_drop: true,
        block_unsupported_drop: true,
        image_uploadtab: false,
        image_description: false,
        /* and here's our custom image picker*/
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function () {
            var file = this.files[0]; 
            if(this.files[0].size > 2000000) {
                alert("Kích thước ảnh phải nhỏ hơn 2MB");
                $(this).val('');
            }
            else{
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
            }
          

            input.click();
        },
        content_style: 'body { font-size: 16px; font-family: Roboto; }' 
        });

        if(option == 1){
            const text = $('#comment-content-' + item_id).html();

            console.log(`${text}`);
            // tinymce.get("editCommentArea").setContent(`<p>Hello</p>`);
            $("#editCommentArea").val(text);

        }
        if(option == 2){
            const text = $('#reply-content-' + item_id).html();
            console.log(`${text}`);

            // tinymce.get("editCommentArea").setContent(`${text}`);
            $("#editCommentArea").val(text);

        }
     
        
        
        setTimeout(function() {
            $('#editCommentForm').modal('show');
        },500);
    })

    $(document).on('click','#edit-btn',function(e){
        e.preventDefault();
        const item_id = $(this).data('id');
        const option = $(this).data('option');

        var content = tinymce.activeEditor.getContent("editCommentArea");              
        if(content){
            if(option == 1){
                tinymce.activeEditor.uploadImages().then((response)=>{
                var update_content = tinymce.activeEditor.getContent("editCommentArea");
                    $.ajax({
                        url:'/cap-nhat-binh-luan/'+item_id,
                        type:"PUT",
                        data:{
                            'content': content,
                        }
                    })
                    .done(function(res) {

                        Swal.fire({
                                icon: 'success',
                                title: `${res.success}`,
                                showConfirmButton: false,
                                timer: 2500
                            });      

                    
                        setTimeout(function() {
                            $('#editCommentForm').modal('hide');
                        },2600);
                


                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                    // If fail
                    console.log(textStatus + ': ' + errorThrown);
                });
                })
            }

            if(option == 2){
                tinymce.activeEditor.uploadImages().then((response)=>{
                var update_content = tinymce.activeEditor.getContent("editCommentArea");
                    $.ajax({
                        url:'/cap-nhat-phan-hoi/'+item_id,
                        type:"PUT",
                        data:{
                            'content': content,
                        }
                    })
                    .done(function(res) {

                        Swal.fire({
                                icon: 'success',
                                title: `${res.success}`,
                                showConfirmButton: false,
                                timer: 2500
                            });      

                    
                        setTimeout(function() {
                            $('#editCommentForm').modal('hide');
                        },2600);
                


                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                    // If fail
                    console.log(textStatus + ': ' + errorThrown);
                });
                })
            }
           
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