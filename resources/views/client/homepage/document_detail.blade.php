@extends('client/layouts.app')
@section('pageTitle', `${{$document->name}}`)
@section('additional-style')
<style>
   .doc {
    width: 100%;
    height: 500px;
}

</style>  
@endsection
@section('content')

<div class="container">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="product-gallery" >    
                                    <img src="{{ $document->url }}" class="w-100" alt="">                                     
                                </div>
                            </div><!-- .col -->
                            <div class="col-lg-6 d-flex align-items-end">
                                <div class="product-info mb-5 me-xxl-5">
                                        <h2 class="product-title">{{ $document->name }}
                                        
                                            @if(Auth::check())

                                            <button type="button" class="btn btn-icon btn-lg ms-1" data-bs-toggle="modal" data-bs-target="#reportForm">
                                                <em class="icon ni ni-alert" style="color:red"></em>
                                            </button>

                                            @endif
                                        </h2>    
                                      
                                        
                                    <p class="product-title">Tác giả: {{ $document->author }}</p>                                                           
                                    <div class="product-meta">
                                        <ul class="d-flex g-3 gx-5">
                                            <li>
                                                <div class="fs-14px text-muted">Lượt tải</div>
                                                <div class="fs-16px fw-bold text-secondary" id="totalDownload">{{ $document->totalDownloading }}</div>
                                            </li>
                                            <li>
                                                <div class="fs-14px text-muted">Số trang</div>
                                                <div class="fs-16px fw-bold text-secondary">{{ $document->numberOfPages }}</div>
                                            </li>
                                            <li>
                                                <div class="fs-14px text-muted">Định dạng</div>
                                                <div class="fs-16px fw-bold text-secondary">.{{ $document->extension }}</div>
                                            </li>
                                      
                                            
                                        </ul>
                                    </div>
                                    <div class="product-meta">
                                        <h6 class="title">Ngôn ngữ: 
                                            @if ($document->language === 1)
                                            <span class="text-success fs-14px">Tiếng việt</span>
                                            @else
                                            <span class="text-info fs-14px">Tiếng anh</span>

                                            @endif 
                                        </h6>
                                      
                                    </div><!-- .product-meta -->
                                    <div class="product-meta">
                                        <h6 class="title">Tình trạng: 

                                            @if ($document->isCompleted === 1)
                                            <span class="text-success fs-14px fw-bold">Đã hoàn thành</span>
                                            @else
                                            <span class="text-info fs-14px fw-bold">Chưa hoàn thành</span>

                                            @endif 
                                        </h6>
                                      
                                    </div><!-- .product-meta -->
                                    <div class="product-meta">
                                        <h6 class="title">Thể loại</h6>
                                        <ul class="d-flex flex-wrap ailgn-center g-2 pt-1">                                     
                                            <li class="ms-n1">
                                                <a href="/the-loai/the-loai-tai-lieu/{{$document->types->slug}}" class="btn btn-primary">{{ $document->types->name }}</a>
                                            </li>         
                                        </ul>
                                    </div><!-- .product-meta -->
                                    <div class="product-meta">
                                        <ul class="d-flex flex-wrap ailgn-center g-2 pt-1">
                                            {{-- <li class="ms-n1">
                                                @if($book->numberOfChapter === 0)
                                                <button class="btn btn-xl btn-primary disabled"><em class="icon ni ni-arrow-right-circle"></em><span>Đọc ngay</span></button>
                                                @else
                                                <button class="btn btn-xl btn-primary"><em class="icon ni ni-arrow-right-circle"></em><span>Đọc ngay</span></button>
                                                @endif
                                            </li> --}}
                                            <li class="ms-n1">
                                                <button class="btn btn-xl btn-primary" id="download-btn"><em class="icon ni ni-download"></em><span>Tải xuống</span></button>

                                            </li>
                                            <li class="ms-n1">
                                                <button id="preview-btn" class="btn btn-xl btn-primary" data-bs-toggle="modal" data-bs-target="#modalDefault" ><em class="icon ni ni-eye"></em><span>Xem trước</span></button>
                                            

                                            </li>
                                        </ul>
                                    </div><!-- .product-meta -->
                                </div><!-- .product-info -->
                                
                                
                            </div><!-- .col -->
                        </div><!-- .row -->
                        <div class="row g-gs flex-lg-row-reverse">                      
                            <div class="col-lg-12">
                                <div class="product-details entry me-xxl-3">
                                    <hr class="hr">
                                    <h3>Giới thiệu</h3>
                                    <div id="divhtmlContent" >{{ $document->description }}</div>   

                                </div>
                            </div><!-- .col -->
                        </div><!-- .row -->
                        <div class="row g-gs flex-lg-row-reverse">                      
                            <div class="col-lg-12">
                                <div class="product-details entry me-xxl-3">
                                    <hr class="hr">
                                    <h3>Bình luận</h3>
                                    <div class="list-group mt-3">
                                        <div class="bg-light p-2">
                                        @if(Auth::check())

                                            <div class="d-flex flex-row align-items-start">
                                                <img class="rounded-circle" src="{{ Auth::user()->profile->url }}" width="40" id="comment_avatar">
                                                <textarea class="form-control ml-1 shadow-none textarea" id="comment_area"></textarea>
                                            </div>
                                            <div class="mt-2 d-flex flex-row-reverse">

                                                <button class="btn btn-primary" id="comment-btn" type="button">
                                                    <em class="icon ni ni-comments"></em>
                                                    <span>Bình luận</span>
                                                </button>
                                            </div>
                                        </div>  
                                        @endif
                                        @if ($comments)
                                        <div id="comment-box">
                                            <p>{{ $document->totalComments }} bình luận</p>
                                            @foreach ($comments as $comment)
                                                <div id="comment-{{ $comment->id }}">
                                                        <div class="d-flex flex-column comment-section">
                                                            <div class="bg-white p-2">
                                                                <div class="d-flex flex-row user-info"><img class="rounded-circle" src="{{ $comment->users->profile->url }}" width="40">
                                                                    <div class="d-flex flex-column justify-content-start ms-2">
                                                                        <span class="d-block font-weight-bold name">{{ $comment->users->profile->displayName }}</span>
                                                                        <span class="date text-black-50">{{ $comment->created_at }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-2">
                                                                    <p contenteditable="false" id="comment-text-{{ $comment->id }}">
                                                                        {{ $comment->content }}
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="bg-white">
                                                                <div class="d-flex flex-row fs-12">
                                                                    <button class="btn btn-outline-light create-reply-btn" data-id={{ $comment->id }}>
                                                                        <em class="icon ni ni-comments"></em>
                                                                    </button>
                                                                    @if(Auth::check() && Auth::user()->id == $comment->users->id)

                                                                    <button class="btn btn-outline-light delete-comment-btn" data-id={{ $comment->id }}>
                                                                        <em class="icon ni ni-trash"></em>
                                                                    </button>
                                                                    {{-- <button class="btn btn-icon edit-comment-btn" data-id={{ $comment->id }}>
                                                                        <em class="icon ni ni-edit"></em>
                                                                    </button> --}}
                                                                    <div class="custom-control custom-checkbox custom-control-pro custom-control-pro-icon no-control">
                                                                        <input type="checkbox" class="custom-control-input edit-comment-btn" name="edit-comment-btn" id="edit-comment-btn-{{ $comment->id }}" value={{ $comment->id }}>
                                                                        <label class="custom-control-label" name="edit-comment-btn" for="edit-comment-btn-{{ $comment->id }}"><em class="icon ni ni-edit"></em></label>
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                               
                                                                       
                                                                </ul>
                                                            
                                                            </div>
                                                        </div> 
                                                        @foreach ($comment->replies as $reply)
                                                        @if(is_null($reply->deleted_at))
                                                        <div class="ms-5" id="reply-{{ $reply->id }}">
                                                            <div class="d-flex flex-column comment-section">
                                                                <div class="bg-white p-2">
                                                                    <div class="d-flex flex-row user-info"><img class="rounded-circle" src="{{ $reply->users->profile->url }}" width="40">
                                                                        <div class="d-flex flex-column justify-content-start ms-2">
                                                                            <span class="d-block font-weight-bold name">{{ $reply->users->profile->displayName }}</span>
                                                                            <span class="date text-black-50">{{ $reply->created_at }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mt-2">
                                                                        <p contenteditable="false" id="reply-text-{{ $reply->id }}">
                                                                            {{ $reply->content }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                @if(Auth::check() && Auth::user()->id == $reply->users->id)
    
                                                                <div class="bg-white">
                                                                    <div class="d-flex flex-row fs-12">
                                                                        <button class="btn btn-outline-light delete-reply-btn" data-id={{ $reply->id }}>
                                                                            <em class="icon ni ni-trash"></em>
                                                                        </button>
                                                                        <div class="custom-control custom-checkbox custom-control-pro custom-control-pro-icon no-control">
                                                                            <input type="checkbox" class="custom-control-input edit-reply-btn" name="edit-reply-btn" id="edit-reply-btn-{{ $reply->id }}" value={{ $reply->id }}>
                                                                            <label class="custom-control-label" name="edit-reply-btn" for="edit-reply-btn-{{ $reply->id }}"><em class="icon ni ni-edit"></em></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </div> 
                                                        </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                           
                                            @endforeach
                                        </div>
                                        @endif
                                        
                                    
                                            
                                    </div>
                                </div>
                            </div><!-- .col -->
                        </div><!-- .row -->
                     
                    </div>
                </div>
            </div>
          
        </div>
    </div>
</div>
@section('modal')
@if(Auth::check())

<div class="modal fade" id="reportForm" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Báo cáo tài liệu</h5>
                <button id="close-btn" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-validate is-alter" novalidate="novalidate">
                    @csrf
                    <input type="hidden" class="form-control" id="type_id" name="type_id" value=3>
                    <input type="hidden" class="form-control" id="identifier_id" name="identifier_id" value={{ $document->id }}>

                    <div class="form-group">
                        <label class="form-label" for="book-name">Tên tài liệu</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="book-name" required="" value='{{ $document->name }}' readonly>
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

            <iframe id="my_iframe" style="display:none;"></iframe>

        </div>
    </div>
</div>
@endif
<div class="modal fade" tabindex="-1" id="modalDefault">
    
    <div class="modal-dialog modal-lg" role="document">
        
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close" id="close-modal">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Xem trước</h5>
            </div>
            <div class="modal-body embed-responsive embed-responsive-16by9">
                <div id="spinner" style="display:none">
                    <div class="d-flex align-items-center">
                        <strong>Đang tải...</strong>
                        <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                      </div>
                </div>
                <iframe id="preview-iframe" class="doc embed-responsive-item"></iframe>
            </div>
            <div class="modal-footer">
                <span class="modal-title">Thử lại nếu chưa hiện dữ liệu</span><em class="icon ni ni-info"></em>
            </div>
        </div>
    </div>
</div>
@endsection

@endsection
@section('additional-scripts')

<script>
    
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    
    $(function () {
        $('#comment-btn').attr('disabled', true);

    })

    
    $("#download-btn").click(function(e){
        e.preventDefault();
        var id = {!! $document->id !!}
        $.ajax({
                type:"GET",
                url:'/tai-tai-lieu',
                data : {
                    "id": id
                },
                })
                .done(function(res) {
                // If successful           
                    window.location.assign(res.url);


                    
                    $('#totalDownload').text(res.totalDownload);
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                })
       
        
    })


    $("#preview-btn").click(function(e){
        e.preventDefault();

        var id = {!! $document->id !!}
     
            $.ajax({
                type:"GET",
                url:'/preview-document',
                data : {
                    "id": id
                },
                })
                .done(function(res) {
                    $('#spinner').show();

                // If successful           
                    var url = res.url;
                    $('#preview-iframe').attr('src',url);

                    setTimeout(()=>{
                        $('#modal-btn').click();
                    }, 2000);
                


                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                })
      
       
      

    })

    $("#close-modal").click(function(e){
        $('#preview-iframe').attr('src','');
    });

    $('#preview-iframe').on("load", function () {
        $('#spinner').hide();
    }); 

  

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
                            }, 3000);
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

    $(document).on('keyup','textarea',function() {
            var comment_value = $("#comment_area").val();

            var reply_value = $("#reply_area").val();

            if(comment_value != '') {
                $('#comment-btn').attr('disabled', false);
            } else {
                $('#comment-btn').attr('disabled', true);
            }

            if(reply_value != '') {
                $('#reply-btn').attr('disabled', false);
            } else {
                $('#reply-btn').attr('disabled', true);
            }

    });

    $(document).on('click','#comment-btn',function(){
        var content = $("#comment_area").val();
        
        var item_id = {!! $document->id !!};

        $.ajax({
                url:'/binh-luan',
                type:"POST",
                data:{
                    'item_id': item_id,
                    'content': content,
                    'option':0
                }
            })
            .done(function(res) {
                
            
                Swal.fire({
                        icon: 'success',
                        title: `${res.success}`,
                        showConfirmButton: false,
                        timer: 2500
                    });      
                $("#comment_area").val('');

                $("#comment-box").load(" #comment-box > *");
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
            });

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
                    url:'/xoa-binh-luan/0/' + comment_id,
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

                    $("#comment-box").load(" #comment-box > *");
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                    // If fail
                    console.log(textStatus + ': ' + errorThrown);
                    });
                
                }
            })

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
                    url:'/xoa-phan-hoi/0/' + reply_id,
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
        var avatar = $('#comment_avatar img').attr('src')


        if($("#reply-box").length){

            $("#reply-box").remove();
        }
        else{
            var htmlrender = '<div class="ms-5 p-2" id="reply-box" >'+
            '<div class="d-flex flex-row align-items-start">'+
                '<textarea class="form-control ml-1 shadow-none textarea" id="reply_area"></textarea>'+
            '</div>'+
            '   <div class="mt-2 d-flex flex-row-reverse">'+
                `<button class="btn btn-primary" id="reply-btn" type="button" data-id=${comment_id}>  `+
                    '<em class="icon ni ni-comments"></em>'+
                    '<span>Phản hồi</span>'+
                '</button>'+
            '</div>'+
        '</div> ';
       

        $('#comment-'+comment_id).append(htmlrender);

        $('#reply-btn').attr('disabled', true);

        }
        
    })

    $(document).on('click','#reply-btn',function(){
        var content = $("#reply_area").val();
        
        var comment_id = $(this).data('id');


        $.ajax({
                url:'/phan-hoi',
                type:"POST",
                data:{
                    'comment_id': comment_id,
                    'content': content,
                    'option':0

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
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
            });


    })
    
    $(document).on('change','.edit-comment-btn',function(){
        
        var comment_id = $(this).val();
        var item = $('#comment-text-'+comment_id)

        if ($(this).is(":checked")) {
        
            item.attr('contenteditable',true);

            item.focus();
        }
        else{

            item.attr('contenteditable',false);
            var content = $.trim(item.text());

            if(content){
                $.ajax({
                    url:'/cap-nhat-binh-luan/'+comment_id,
                    type:"PUT",
                    data:{
                        'content': content,
                        'option':0

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
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                });


            }
            else{
                Swal.fire({
                    icon: 'info',
                    title: `Không được để trống bình luận!!!`,
                    showConfirmButton: false,
                    timer: 2500
                });      

                $("#comment-box").load(" #comment-box > *");
            }
        }

    })

    $(document).on('change','.edit-reply-btn',function(){
        
        var reply_id = $(this).val();
        var item = $('#reply-text-'+reply_id)

        if ($(this).is(":checked")) {
        
            item.attr('contenteditable',true);

            item.focus();
        }
        else{

            item.attr('contenteditable',false);
            var content = $.trim(item.text());

            if(content){
                $.ajax({
                    url:'/cap-nhat-phan-hoi/'+reply_id,
                    type:"PUT",
                    data:{
                        'content': content,
                        'option':0
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
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                });


            }
            else{
                Swal.fire({
                    icon: 'info',
                    title: `Không được để trống phản hồi!!!`,
                    showConfirmButton: false,
                    timer: 2500
                });      

                $("#comment-box").load(" #comment-box > *");
            }
        }

    })
</script>
@endsection