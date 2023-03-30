@extends('client/layouts.app')
@section('pageTitle', `${{$book->name}}`)
@section('additional-style')
@endsection
@section('content')
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                </div><!-- .nk-block-head -->
                <div class="nk-block">
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
                                            @if(!$isRating)
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
                                                        <a class="btn btn-xl btn-primary disabled"><em class="icon ni ni-arrow-right-circle"></em><span>Đọc ngay</span></a>
                                                    @else
                                                        <a href="/doc-sach/{{$book->slug}}/{{ $chapters->first()->slug }}" class="btn btn-xl btn-primary"><em class="icon ni ni-arrow-right-circle"></em><span>Đọc ngay</span></a>
                                                    @endif
                                                </li>
                                                <li class="ms-n1">
                                                    @if(Auth::check())
                                                        @if(!$isMark)
                                                        <button class="btn btn-xl btn-primary" id="book-mark-btn"><em class="icon ni ni-bookmark"></em><span id="span-text">Đánh dấu</span></button>
                                                        @else
                                                        <button class="btn btn-xl btn-primary" id="book-mark-btn" disabled><em class="icon ni ni-bookmark"></em><span id="span-text">Đã đánh dấu</span></button>
                                                        @endif
                                                    @else
                                                    <a href="/login" class="btn btn-xl btn-primary"><em class="icon ni ni-bookmark"></em><span id="span-text">Đánh dấu</span></a>
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
                                        <div class="list-group mt-3">                            
                                                @foreach ($chapters as $chapter)                              
                                                <a href="/doc-sach/{{$book->slug}}/{{ $chapter->slug }}" class="list-group-item list-group-item-action">                                           
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
                                                                @if(Auth::check() && Auth::user()->id == $comment->users->id)

                                                                <div class="bg-white">
                                                                    <div class="d-flex flex-row fs-12">
                                                                        <button class="btn btn-outline-light create-reply-btn" data-id={{ $comment->id }}>
                                                                            <em class="icon ni ni-comments"></em>
                                                                        </button>
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
                                                                    </div>
                                                                   
                                                                           
                                                                    </ul>
                                                                </div>
                                                                @endif
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
                </div><!-- .nk-block -->
                {{-- <div class="nk-block nk-block-lg">
                    <div class="nk-block-head">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Related Products</h3>
                            </div>
                        </div>
                    </div><!-- .nk-block-head -->
                    <div class="slider-init row slick-initialized slick-slider" data-slick="{&quot;slidesToShow&quot;: 4, &quot;centerMode&quot;: false, &quot;slidesToScroll&quot;: 1, &quot;infinite&quot;:false, &quot;responsive&quot;:[ {&quot;breakpoint&quot;: 1540,&quot;settings&quot;:{&quot;slidesToShow&quot;: 3}},{&quot;breakpoint&quot;: 992,&quot;settings&quot;:{&quot;slidesToShow&quot;: 2}}, {&quot;breakpoint&quot;: 576,&quot;settings&quot;:{&quot;slidesToShow&quot;: 1}} ]}"><div class="slick-arrow-prev slick-arrow slick-disabled" aria-disabled="true" style=""><a href="javascript:void(0);" class="slick-prev"><em class="icon ni ni-chevron-left"></em></a></div>
                        <!-- .col -->
                        <!-- .col -->
                        <!-- .col -->
                        <!-- .col -->
                        <!-- .col -->
                        <!-- .col -->
                    <div class="slick-list draggable"><div class="slick-track" style="opacity: 1; width: 1638px; transform: translate3d(0px, 0px, 0px);"><div class="col slick-slide slick-current slick-active" style="width: 273px;" tabindex="0" data-slick-index="0" aria-hidden="false">
                            <div class="card card-bordered product-card">
                                <div class="product-thumb">
                                    <a href="html/product-details.html" tabindex="0">
                                        <img class="card-img-top" src="./images/product/lg-a.jpg" alt="">
                                    </a>
                                    <ul class="product-badges">
                                        <li><span class="badge bg-success">New</span></li>
                                    </ul>
                                    <ul class="product-actions">
                                        <li><a href="#" tabindex="0"><em class="icon ni ni-cart"></em></a></li>
                                        <li><a href="#" tabindex="0"><em class="icon ni ni-heart"></em></a></li>
                                    </ul>
                                </div>
                                <div class="card-inner text-center">
                                    <ul class="product-tags">
                                        <li><a href="#" tabindex="0">Smart Watch</a></li>
                                    </ul>
                                    <h5 class="product-title"><a href="html/product-details.html" tabindex="0">Classy Modern Smart watch</a></h5>
                                    <div class="product-price text-primary h5"><small class="text-muted del fs-13px">$350</small> $324</div>
                                </div>
                            </div>
                        </div><div class="col slick-slide slick-active" style="width: 273px;" tabindex="0" data-slick-index="1" aria-hidden="false">
                            <div class="card card-bordered product-card">
                                <div class="product-thumb">
                                    <a href="html/product-details.html" tabindex="0">
                                        <img class="card-img-top" src="./images/product/lg-b.jpg" alt="">
                                    </a>
                                    <ul class="product-actions">
                                        <li><a href="#" tabindex="0"><em class="icon ni ni-cart"></em></a></li>
                                        <li><a href="#" tabindex="0"><em class="icon ni ni-heart"></em></a></li>
                                    </ul>
                                </div>
                                <div class="card-inner text-center">
                                    <ul class="product-tags">
                                        <li><a href="#" tabindex="0">Vintage Phone</a></li>
                                    </ul>
                                    <h5 class="product-title"><a href="html/product-details.html" tabindex="0">White Vintage telephone</a></h5>
                                    <div class="product-price text-primary h5"><small class="text-muted del fs-13px">$209</small> $119</div>
                                </div>
                            </div>
                        </div><div class="col slick-slide" style="width: 273px;" tabindex="-1" data-slick-index="2" aria-hidden="true">
                            <div class="card card-bordered product-card">
                                <div class="product-thumb">
                                    <a href="html/product-details.html" tabindex="-1">
                                        <img class="card-img-top" src="./images/product/lg-c.jpg" alt="">
                                    </a>
                                    <ul class="product-badges">
                                        <li><span class="badge bg-danger">Hot</span></li>
                                    </ul>
                                    <ul class="product-actions">
                                        <li><a href="#" tabindex="-1"><em class="icon ni ni-cart"></em></a></li>
                                        <li><a href="#" tabindex="-1"><em class="icon ni ni-heart"></em></a></li>
                                    </ul>
                                </div>
                                <div class="card-inner text-center">
                                    <ul class="product-tags">
                                        <li><a href="#" tabindex="-1">Headphone</a></li>
                                    </ul>
                                    <h5 class="product-title"><a href="html/product-details.html" tabindex="-1">Black Wireless Headphones</a></h5>
                                    <div class="product-price text-primary h5"><small class="text-muted del fs-13px">$129</small> $89</div>
                                </div>
                            </div>
                        </div><div class="col slick-slide" style="width: 273px;" tabindex="-1" data-slick-index="3" aria-hidden="true">
                            <div class="card card-bordered product-card">
                                <div class="product-thumb">
                                    <a href="html/product-details.html" tabindex="-1">
                                        <img class="card-img-top" src="./images/product/lg-d.jpg" alt="">
                                    </a>
                                    <ul class="product-actions">
                                        <li><a href="#" tabindex="-1"><em class="icon ni ni-cart"></em></a></li>
                                        <li><a href="#" tabindex="-1"><em class="icon ni ni-heart"></em></a></li>
                                    </ul>
                                </div>
                                <div class="card-inner text-center">
                                    <ul class="product-tags">
                                        <li><a href="#" tabindex="-1">Smart Watch</a></li>
                                    </ul>
                                    <h5 class="product-title"><a href="html/product-details.html" tabindex="-1">Modular Smart Watch</a></h5>
                                    <div class="product-price text-primary h5"><small class="text-muted del fs-13px">$169</small> $120</div>
                                </div>
                            </div>
                        </div><div class="col slick-slide" style="width: 273px;" tabindex="-1" data-slick-index="4" aria-hidden="true">
                            <div class="card card-bordered product-card">
                                <div class="product-thumb">
                                    <a href="html/product-details.html" tabindex="-1">
                                        <img class="card-img-top" src="./images/product/lg-e.jpg" alt="">
                                    </a>
                                    <ul class="product-actions">
                                        <li><a href="#" tabindex="-1"><em class="icon ni ni-cart"></em></a></li>
                                        <li><a href="#" tabindex="-1"><em class="icon ni ni-heart"></em></a></li>
                                    </ul>
                                </div>
                                <div class="card-inner text-center">
                                    <ul class="product-tags">
                                        <li><a href="#" tabindex="-1">Headphones</a></li>
                                    </ul>
                                    <h5 class="product-title"><a href="html/product-details.html" tabindex="-1">White Wireless Headphones</a></h5>
                                    <div class="product-price text-primary h5"><small class="text-muted del fs-13px">$109</small> $78</div>
                                </div>
                            </div>
                        </div><div class="col slick-slide" style="width: 273px;" tabindex="-1" data-slick-index="5" aria-hidden="true">
                            <div class="card card-bordered product-card">
                                <div class="product-thumb">
                                    <a href="html/product-details.html" tabindex="-1">
                                        <img class="card-img-top" src="./images/product/lg-f.jpg" alt="">
                                    </a>
                                    <ul class="product-actions">
                                        <li><a href="#" tabindex="-1"><em class="icon ni ni-cart"></em></a></li>
                                        <li><a href="#" tabindex="-1"><em class="icon ni ni-heart"></em></a></li>
                                    </ul>
                                </div>
                                <div class="card-inner text-center">
                                    <ul class="product-tags">
                                        <li><a href="#" tabindex="-1">Phone</a></li>
                                    </ul>
                                    <h5 class="product-title"><a href="html/product-details.html" tabindex="-1">Black Android Phone</a></h5>
                                    <div class="product-price text-primary h5">$329</div>
                                </div>
                            </div>
                        </div></div></div><div class="slick-arrow-next slick-arrow" style="" aria-disabled="false"><a href="javascript:void(0);" class="slick-next"><em class="icon ni ni-chevron-right"></em></a></div></div>
                </div> --}}
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

</script>
@endsection