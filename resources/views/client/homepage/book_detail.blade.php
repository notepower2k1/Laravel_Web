@extends('client/homepage.layouts.app')
@section('pageTitle', `${{$book->name}}`)
@section('additional-style')


@endsection
@section('content')
<div class="container">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            </div><!-- .nk-block-head -->
            <div class="nk-block">
             

                        <div class="row">
                          
                                    <div class="col-9">
                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="product-gallery" >    
                                                            <img src="{{ $book->url }}" class="w-100" alt="">                                     
                                                        </div>
                                                    </div><!-- .col -->
                                                    <div class="col-lg-6 d-flex align-items-end">
                                                        <div class="product-info mb-5 me-xxl-5">
                                                                <h2 class="product-title">{{ $book->name }}
                                                                    @if(Auth::check())
                        
                                                                    <button type="button" class="btn btn-icon btn-lg ms-1" data-bs-toggle="modal" data-bs-target="#reportForm">
                                                                        <em class="icon ni ni-alert" style="color:red"></em>
                                                                    </button>
                                                                    @endif
                                                                </h2>                                        
                                                            <p class="product-title">Tác giả: {{ $book->author }}</p>
                                                            <div class="product-rating">
                                                                @if(!$isRating && Auth::check())
                                                                <div id="rateYo"></div>
                                                                @else
                                                                <div id="rateYo" data-rateyo-read-only="true"></div>
                                                                @endif
                                                                <p>(<span id="score">{{$book->ratingScore}}</span>/5)</p>
                                                            </div><!-- .product-rating -->                                   
                                                            <div class="product-meta">
                                                                <ul class="d-flex g-3 gx-5">
                                                                    <li>
                                                                        <div class="fs-14px text-muted">Số chương</div>
                                                                        <div class="fs-16px fw-bold text-secondary">{{ $book->numberOfChapter }}</div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="fs-14px text-muted">Lượt đọc</div>
                                                                        <div class="fs-16px fw-bold text-secondary">{{ $book->totalReading }}</div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="fs-14px text-muted">Đánh dấu</div>
                                                                        <div class="fs-16px fw-bold text-secondary" id="totalBookMarking">{{ $book->totalBookMarking }}</div>
                                                                    </li>
                                                                    
                                                                </ul>
                                                            </div>
                                                            
                                                            <div class="product-meta">
                                                                <h6 class="title">Ngôn ngữ: 
                                                                    @if ($book->language === 1)
                                                                    <span class="text-success fs-14px">Tiếng việt</span>
                                                                    @else
                                                                    <span class="text-info fs-14px">Tiếng anh</span>
                        
                                                                    @endif 
                                                                </h6>
                                                                
                                                            </div><!-- .product-meta -->
                                                            <div class="product-meta">
                                                                <h6 class="title">Tình trạng: 
                        
                                                                    @if ($book->isCompleted === 1)
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
                                                                        <a href="/the-loai/the-loai-sach/{{$book->types->slug}}" class="btn btn-primary">{{ $book->types->name }}</a>
                                                                    </li>         
                                                                </ul>
                                                            </div><!-- .product-meta -->
                                                            <div class="product-meta">
                                                                <ul class="d-flex flex-wrap ailgn-center g-2 pt-1">
                                                                    <li class="ms-n1">
                                                                        @if($book->numberOfChapter === 0)
                                                                            <a class="btn btn-lg btn-primary disabled"><em class="icon ni ni-arrow-right-circle"></em><span>Đọc ngay</span></a>
                                                                        @else
                                                                            <a href="/doc-sach/{{$book->slug}}/{{ $chapters->first()->slug }}" class="btn btn-lg btn-primary">
                                                                                <em class="icon ni ni-arrow-right-circle"></em><span>Đọc ngay</span>
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                    <li class="ms-n1">
                                                                        @if(Auth::check())
                                                                            @if(!$isMark)
                                                                            <button class="btn btn-lg btn-primary" id="book-mark-btn"><em class="icon ni ni-bookmark"></em><span id="span-text">Đánh dấu</span></button>
                                                                            @else
                                                                            <button class="btn btn-lg btn-primary" id="book-mark-btn" disabled><em class="icon ni ni-bookmark"></em><span id="span-text">Đã đánh dấu</span></button>
                                                                            @endif
                                                                        @else
                                                                        <a href="/login" class="btn btn-lg btn-primary"><em class="icon ni ni-bookmark"></em><span id="span-text">Đánh dấu</span></a>
                                                                        @endif
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
                                                            <div id="divhtmlContent" >{{ $book->description }}</div>   
                        
                                                        </div>
                                                    </div><!-- .col -->
                                                </div><!-- .row -->
                        
                                                <div class="row g-gs flex-lg-row-reverse">                      
                                                    <div class="col-lg-12">
                                                        <div class="product-details entry me-xxl-3">
                                                            <hr class="hr">
                                                            <h3>Danh sách chương</h3>
                                                            <div class="list-group mt-3" id="chapter_list">                            
                                                                    @foreach ($chapters as $chapter)                         
                                                                    <a href="/doc-sach/{{ $chapter->books->slug }}/{{ $chapter->slug }}" class="list-group-item list-group-item-action" data-id="{{ $chapter->id }}">                                           
                                                                        {{$chapter->code}}
                        
                                                                        @if($chapter->name)
                                                                        <span>: {{ $chapter->name }}</span>
                                                                        @else
                                                                        
                                                                        @endif
                                                                    
                                                                    </a>
                                                                    @endforeach
                                                                    <div class="col-md-12">                          
                        
                                                                        {{ $chapters->links('vendor.pagination.custom',['elements' => $chapters]) }}
                                                                    </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div><!-- .col -->
                                                </div><!-- .row -->
                        
                                                <div class="row g-gs flex-lg-row-reverse">                      
                                                    <div class="col-lg-12">
                                                        <div class="product-details entry me-xxl-3">
                                                            <hr class="hr">
                                                            <h3>Bình luận</h3>
                                                            <div class="list-group mt-3">
                                                                @if(Auth::check())
                        
                                                                <div class="bg-light p-2">
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
                                                                    <p>{{ $book->totalComments }} bình luận</p>
                        
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
                              
                                    @if($booksWithSameType->count()> 0)
                                    <div class="col-3">
                                        <div class="card card-bordered min-vh-100">
                                            <div class="card-inner">
                                            <h6 class="title">Sách cùng thể loại</h6>
                                            @foreach ($booksWithSameType as $book)

                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="product-gallery" >    
                                                            <a href="/sach/{{$book->id}}/{{$book->slug}}">                                          

                                                                <img src="{{ $book->url }}" class="w-100" alt="">  
                                                            </a>                                   
                                                        </div>
                                                    </div><!-- .col -->
                                                    <div class="col-lg-6 d-flex align-items-start">
                                                        <div class="product-info mb-5 me-xxl-5">
                                                            <a href="/sach/{{$book->id}}/{{$book->slug}}"class="product-title">{{ $book->name }}                                          
                                                            </a>                                        
                                                            <p class="product-title">{{ $book->author }}</p>                          
                                                        </div><!-- .product-info -->
                                                        
                                                        
                                                    </div><!-- .col -->
                                                </div><!-- .row -->

                                            @endforeach
                                            </div>
                                        </div>

                                    </div>
                                    @endif

                        </div>
                       
                        
                            
                            
              
            </div><!-- .nk-block -->
       
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
                <h5 class="modal-title">Báo cáo sách</h5>
                <button id="close-btn" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-validate is-alter" novalidate="novalidate">
                    @csrf
                    <input type="hidden" class="form-control" id="type_id" name="type_id" value=1>
                    <input type="hidden" class="form-control" id="identifier_id" name="identifier_id" value={{ $book->id }}>

                    <div class="form-group">
                        <label class="form-label" for="book-name">Tên sách</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="book-name" required="" value='{{ $book->name }}' readonly>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script src="{{ asset('assets/js/example-sweetalert.js?ver=3.1.2') }}" aria-hidden="true"></script>


<script>
   

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    $(function () {
        var value = document.getElementById('divhtmlContent').textContent;
        document.getElementById('divhtmlContent').innerHTML =
        marked.parse(value);

        var chapter = {!! $book->numberOfChapter  !!}

        if(chapter > 0){
            if(readCookie('readingLog')){

            var log = readCookie('readingLog');
            const current_book_id = {!! $book->id !!}
            objIndex = log.findIndex((obj => obj.book_id == current_book_id));

            if(objIndex >= 0){
                log[objIndex].chapter_id.forEach(element => {
                var buttonChapters = $('#chapter_list').find(`a[data-id='${element}']`);
                
                buttonChapters.each(function (i,item) {
                    $(item).css("background-color", "#dbd7d3");
                })


                });
            }
          
            }
        }
       
        $('#comment-btn').attr('disabled', true);
    
       

        $("#rateYo").rateYo({
            rating: {!! $ratingScore !!},
            maxValue: 5,
            numStars: 5,
            halfStar: true,
            starWidth: "20px",


            onSet: function (rating, rateYoInstance) {

                var rating = rating;
                var book_id = {!! $book->id !!};

                $("#rateYo").rateYo("option", "readOnly", true);
                    $.ajax({
                        url:'/sach-danh-gia',
                        type:"POST",
                        data:{
                            'id': book_id,
                            'score':rating
                        }
                    })
                    .done(function(res) {
                    
                        Swal.fire({
                            icon: 'success',
                            title: `${res.success}`,
                            showConfirmButton: false,
                            timer: 2500
                        });
                        
                        var currentScore = res.currentScore;

                        $('#score').text(`${currentScore}`);  
                        
                        $("#rateYo").rateYo("rating", `${currentScore}`);
                        
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                    // If fail
                    console.log(textStatus + ': ' + errorThrown);
                    })
                },

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
        
        var book_id = {!! $book->id !!};

        $.ajax({
                url:'/binh-luan',
                type:"POST",
                data:{
                    'item_id': book_id,
                    'content': content,
                    'option':1
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
    $('#book-mark-btn').click(function(){
        var book_id = {!! $book->id !!};
        
        $(this).attr("disabled", 'disabled');
        $('#span-text').text('Đã theo dõi');

             $.ajax({
                url:'/sach-theo-doi',
                type:"POST",
                data:{
                    'book_id': book_id
                }
            })
            .done(function(res) {
              
                Swal.fire({
                        icon: 'success',
                        title: `${res.success}`,
                        showConfirmButton: false,
                        timer: 2500
                    });      
            
                $('#totalBookMarking').text(res.totalBookMarking);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
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
                    url:'/xoa-binh-luan/1/' + comment_id,
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
                    url:'/xoa-phan-hoi/1/' + reply_id,
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

        if($("#reply-box").length){

            $("#reply-box").remove();
        }
        else{
            var htmlrender = '<div class="ms-5 p-2" id="reply-box" >'+
            '<div class="d-flex flex-row align-items-start">'+
                '<textarea class="form-control ml-1 shadow-none textarea" id="reply_area"></textarea>'+
            '</div>'+
            '   <div class="mt-2 d-flex flex-row-reverse">'+
                `<button class="btn btn-primary" id="reply-btn" type="button" data-id=${comment_id}>`+
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
                    'option':1
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
                        'option':1
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
                        'option':1
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

    function createCookie(name, value, days) {
        var expires;

        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        } else {
            expires = "";
        }
        document.cookie = encodeURIComponent(name) + "=" + JSON.stringify(value) + expires + "; path=/";
    }

    function readCookie(name) {
      var result = document.cookie.match(new RegExp(name + '=([^;]+)'));
      result && (result = JSON.parse(result[1]));
      return result;
    }

    function eraseCookie(name) {
        createCookie(name, "", -1);
    }

   


   
</script>
@endsection