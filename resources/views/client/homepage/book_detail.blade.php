@extends('client/homepage.layouts.app')
@section('pageTitle', `${{$book->name}}`)
@section('additional-style')
<link rel="stylesheet" href="{{ asset('assets/css/book3d.css') }}">
<link href="{{ asset('js/pagination/pagination.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('assets/css/infohelper.css') }}">

<style>
    .chapter-items{
        color:black;
    }
    .chapter-items:hover{
        color:orange;
    }
    .open-relies-btn:hover{
        cursor: pointer;
    }
    .delete-reply-btn,.create-reply-btn,.delete-comment-btn,.report-comment-btn,.like-reply-btn,.like-comment-btn,.edit-comment-btn:hover{
        cursor: pointer;
    }

    .emojionearea{
        border:none !important;
    }
    .emojionearea:focus{
        border:none !important;

    }

    .nk-content{
        background-image:url('https://raw.githubusercontent.com/notepower2k1/MyImage/main/banner/main-banner-1.png') !important;
        background-repeat: no-repeat;
        background-position: left top;

    }
    .container{
        margin-top:250px  !important;
    }

    .nav-tabs .nav-link.active{
        color:#b78a28 !important;
    }
    .nav-tabs .nav-link:after{
        color:#b78a28 !important;
        background:#b78a28 !important;
    }

    .nav-tabs .nav-link:focus{
        color:#b78a28 !important;

    }
    
</style>

@endsection
@section('content')
<div class="container">
    <div class="nk-content-inner">
        <div class="nk-content-body">         
            <div class="nk-block">
                <div class="row">
                    <div class="card">
                        <div class="">

                            <div class="col-12">                       
                                <div class="row">
                                    <div class="col-lg-6 mt-4 mb-5">
                                        <div class="">
                                            <a 
                                            class="book-container"
                                            href="#"
                                            target="_blank"
                                            rel="noreferrer noopener"
                                            >
                                            <div class="book">
                                                <img
                                                alt=""
                                                src="{{ $book->url }}"
                                                />
                                            </div>
                                            </a>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-lg-6 mt-4">
                                        <div class="product-info mb-5 me-xxl-5">

                                            <div class="d-flex justify-content-between align-items-center" id="book-info">
                                                <h3 class="text-left">{{ $book->name }}
                                               
                                                </h3>                         
                                                @if(Auth::check())

                                                    @if($reportBook)
                                                        @if($reportBook->isEnabled)
                                                            <button type="button" class="btn btn-icon mb-2" data-bs-toggle="modal" data-bs-target="#reportFormBook">
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
                                                        <button type="button" class="btn btn-icon mb-2" data-bs-toggle="modal" data-bs-target="#reportFormBook">
                                                            <em class="icon ni ni-flag " style="color:red"></em>
                                                        </button>
                                                    @endif
                                            
                                                @endif
                                            </div>
                                           
                                            <div class="d-flex flex-wrap">
                                                @foreach(explode(",",$book->author) as $author)                                                                       
                                                <span class="badge badge-md rounded-pill bg-outline-info me-1 mt-1"><a class="text-info" href="/tac-gia/tac-gia-sach/{{ $author }}">{{ $author }}</a></span>
                                                @endforeach        
                                                <span class="badge badge-md rounded-pill bg-outline-primary me-1 mt-1"><a class="text-primary" href="/the-loai/sort_by=created_at/the-loai-sach/{{$book->types->slug}}">{{ $book->types->name }}</a>
                                                </span> 

                                                @if ($book->language === 1)
                                                <span class="badge badge-md rounded-pill bg-outline-secondary me-1 mt-1"><a class="text-secondary" href="/ngon-ngu/ngon-ngu-sach/tieng-viet">Tiếng Việt</a></span>
                                                @else
                                                <span class="badge badge-md rounded-pill bg-outline-secondary me-1 mt-1"><a class="text-secondary" href="/ngon-ngu/ngon-ngu-sach/tieng-anh">Tiếng Anh</a></span>
                                                @endif 
    
                                                @if ($book->isCompleted === 1)
                                                <span class="badge badge-md rounded-pill bg-outline-success me-1 mt-1"><a class="text-success" href="/tinh-trang/tinh-trang-sach/da-hoan-thanh">Đã hoàn thành</a></span>
                                                @else
                                                <span class="badge badge-md rounded-pill bg-outline-success me-1 mt-1"><a class="text-success" href="/tinh-trang/tinh-trang-sach/chua-hoan-thanh">Chưa hoàn thành</a></span>
                                                @endif 
                                             
                                               
                                            </div>
                                                                
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
                                                <div class="product-rating">
                                                    {{-- @if(!$isRating && Auth::check())
                                                    <div id="rateYo"></div>
                                                    @else
                                                    <div id="rateYo" data-rateyo-read-only="true"></div>
                                                    @endif --}}
                                                    <div id="rateYo" data-rateyo-read-only="true"></div>

                                                    <p style="font-size: 18px"><span class="score">{{$book->ratingScore}}</span>/5 
                                                        (<span class="ratingPersonCount">{{ $ratingPersons->count() }}</span> đánh giá)</p>
                                                </div><!-- .product-rating -->          
                                            </div>
                                                
                                            
                                            <div class="product-meta">
                                                <ul class="d-flex flex-wrap ailgn-center g-2 pt-1">
                                                    @if($book->numberOfChapter)
                                                    <li class="ms-n1">
                                                       
                                                      
                                                        <a href="/doc-sach/{{$book->slug}}/{{ $chapters->first()->slug }}" class="btn btn-lg btn-warning">
                                                            <em class="icon ni ni-arrow-right-circle"></em><span>Đọc ngay</span>
                                                        </a>
                                                      
                                                    </li>
                                                    @endif
                                                    <li class="ms-n1">
                                                        @if(Auth::check())
                                                            @if(!$isMark)
                                                            <button class="btn btn-lg btn-outline-secondary" id="book-mark-btn"><em class="icon ni ni-bookmark"></em><span id="span-text">Đánh dấu</span></button>
                                                            @else
                                                            <button class="btn btn-lg btn-outline-secondary" id="book-mark-btn" disabled><em class="icon ni ni-bookmark"></em><span id="span-text">Đã đánh dấu</span></button>
                                                            @endif
                                                        @else
                                                        <a href="/login" class="btn btn-lg btn-outline-secondary"><em class="icon ni ni-bookmark"></em><span id="span-text">Đánh dấu</span></a>
                                                        @endif
                                                    </li>
                                                    @if($book->file)
                                                    <li class="ms-n1">
                                                        @if(Auth::check())

                                                        <a href="#" id="read-pdf-btn" class="btn btn-lg btn-warning">
                                                            <em class="icon ni ni-arrow-right-circle"></em><span>PDF</span>
                                                        </a>
                                                        @else
                                                        <a href="/login" class="btn btn-lg btn-warning"><em class="icon ni ni-download"></em><span id="span-text">PDF</span></a>

                                                        @endif
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div><!-- .product-meta -->
                                        </div><!-- .product-info -->
                                        
                                        
                                    </div><!-- .col -->
                                </div><!-- .row -->              
                            </div>

                            <div class="col-12">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#tabItem5"><span>Giới thiệu</span></a>
                                    </li>
                                    @if($chapters->count() > 0)

                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tabItem6"><span>Danh sách chương <span class="badge badge-dim bg-orange">{{ $book->numberOfChapter }}</span>
                                        </span></a>
                                    </li>
                                    @endif
                                    
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tabItem7"><span>Bình luận
                                            <span class="badge badge-dim bg-orange total-comment-span">{{ $book->totalComments }}</span> </span></a>

                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tabItem8"><span>Đánh giá
                                            <span class="badge badge-dim bg-orange ratingPersonCount">{{ $ratingPersons->count() }}</span> </span></a>
                                        </span></a>
                                    </li>
                                </ul>
                           
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tabItem5">
                                        <div class="row">                      
                                            <div class="col-lg-8">
                                                <div class="product-details entry me-xxl-3">
                                                    {!! clean($book->description) !!}
                                                </div>
                                            </div><!-- .col -->
                                            <div class="col-lg-4 col-xl-4 col-xxl-3">
                                                <div class="card card-bordered" style="background-color:#f5f4f2;">
                                                    <div class="card-inner-group">
                                                        <div class="card-inner">
                                                            <div class="user-card user-card-s2">
                                                                <div class="user-avatar lg bg-primary">
                                                                    <img src="{{ $book->users->profile->url }}" alt="">
                                                                </div>
                                                                <div class="user-info">
                                                                    {{-- <div class="badge bg-light rounded-pill ucap">Platinam</div> --}}
                                                                    <h5>
                                                                        <a class="text-dark" href="/thanh-vien/{{ $book->users->id }}">{{ $book->users->profile->displayName }}</a>
                                                                    </h5>
                                                                    {{-- <span class="sub-text">info@softnio.com</span> --}}
                                                                </div>
                                                            </div>
                                                        </div>                                                   
                                                        <div class="card-inner border-none">
                                                            <div class="row text-center">
                                                                <div class="col-6">
                                                                    <div class="profile-stats">
                                                                        <span class="amount">{{ $user_books->count() }}</span>
                                                                        <span class="sub-text text-warning" style="font-size:20px"><em class="icon ni ni-book-read"></em></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="profile-stats">
                                                                        <span class="amount">{{ $user_documents->count() }}</span>
                                                                        <span class="sub-text text-warning " style="font-size:20px"><em class="icon ni ni-file-docs"></em></span>
                                                                    </div>
                                                                </div>                                                        
                                                            </div>
                                                        </div><!-- .card-inner -->
                                                        <div class="card-inner text-center">
                                                            <div class="slider-init" data-slick='{"arrows": false, "dots": false, "slidesToShow": 1, "slidesToScroll": 1, "infinite":false, "responsive":[ {"breakpoint": 992,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}} ]}'>                                                               
                                                                @foreach ( $user_books as $user_book)
                                                                    @if($loop->index <3)
                                                                    <div class="col">                                    
                                                                        <div class="shine">
                                                                            <img src="{{ $user_book->url }}" class="card-img-top m-auto" alt="" style="width:150px;height:200px">
                            
                                                                        </div>
                                                                        <div class="info mt-2">
                                                                            <h5 class="card-title">{{ $user_book->name }}</h5>
                                                                            <p class="card-text">{{ Str::limit($user_book->description,100) }}</p>
                                                                            <div class="d-flex justify-content-center">
                                                                                
                                                                                <a href="the-loai/sort_by=created_at/the-loai-sach/{{$user_book->types->slug}}" class="fs-13px"><span class="badge badge-dim bg-outline-danger">{{$user_book->types->name }}</span></a>
                            
                            
                                                                            </div>
                                                                        </div>         
                                                                    </div>
                                                                    @endif 
                                                                @endforeach
                                                                @foreach ( $user_documents as $user_document)
                                                                    @if($loop->index <3)
                                                                        <div class="col">                                    
                                                                            <div class="shine">
                                                                                <img src="{{ $user_document->url }}" class="card-img-top m-auto" alt="" style="width:150px;height:200px">
                                
                                                                            </div>
                                                                            <div class="info mt-2">
                                                                                <h5 class="card-title">{{ $user_document->name }}</h5>
                                                                                <p class="card-text">{{ Str::limit($user_document->description,100) }}</p>
                                                                                <div class="d-flex justify-content-center">
                                                                                    
                                                                                    <a href="the-loai/sort_by=created_at/the-loai-tai-lieu/{{$user_document->types->slug}}" class="fs-13px"><span class="badge badge-dim bg-outline-danger">{{$user_document->types->name }}</span></a>
                                
                                
                                                                                </div>
                                                                            </div>         
                                                                        </div>    
                                                                    @endif 
                                                                @endforeach                                         
                                                            </div>
                                                        </div><!-- .card-inner -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .row -->
                                    </div>
                                    @if($chapters->count() > 0)
                                    <div class="tab-pane" id="tabItem6">                                  
                                        <div>
                                            <div class="d-flex justify-content-between">
                                                <h5 class="mb-4">Danh sách chương</h5>

                                                <a href="#" class="btn btn-icon btn-outline-secondary" id="sortbtn" data-order = "asc" >
                                                    <em class="icon ni ni-sort-up-fill"></em>
                                                </a>

                                            </div>
                                            <div class="row" id ="chapter-render-div">
                                               
                                                @foreach ($chapters as $chapter)          
                                                <div class="col-6" id={{ $loop->iteration }}>
                                                    <a href="/doc-sach/{{ $chapter->books->slug }}/{{ $chapter->slug }}" class="chapter-items" data-id="{{ $chapter->id }}">                                           
                                                        
                                                        @if($chapter->name)
                                                        <span>{{$chapter->code}}: {{ Str::limit($chapter->name, 40) }}</span>
                                                        @else    
                                                        <span>{{$chapter->code}}</span>                                                 
                                                        @endif                                              
                                                    </a>
                                                    <dfn data-info="{{ $chapter->created_at }}">
                                                        <span class="text-muted">({{ $chapter->time }})</span>
                                                    </dfn>
                                                   
                                                    <div class="w-100">
                                                        <hr class="hr">
                                                    </div>
                                                    
                                                </div>
                                               
                                                @endforeach
                                            </div>
                                            
                                            <div class="data-container"></div>
                                            <div class="col-md-12 d-flex justify-content-end mt-4">                          
                                                <div id="pagination"></div>
                                            </div>
                                        </div>                                        
                                    </div>
                                    @endif
                                    <div class="tab-pane" id="tabItem7">
                                        <div class="row g-gs flex-lg-row-reverse">                      
                                            <div class="col-lg-12">
                                                <div class="product-details entry me-xxl-3">
                                                    <div class="d-flex justify-content-between">
                                                        <h5><span class="total-comment-span">{{ $book->totalComments }} </span>bình luận</h5>
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
                                                    <div class="list-group mt-3">
                                                        @if(Auth::check())
                                                        <div class="d-flex">                                                     
                                                            <img class="rounded border shadow me-2 flex-grow-2" src="{{ Auth::user()->profile->url }}" id="comment_avatar" style="width:128px;height:128px">

                                                            <div class="nk-chat-editor border flex-grow-1 bg-light" id="main-comment-box">
                                                                <div class="nk-chat-editor-form">
                                                                    <div class="form-control-wrap">
                                                                        <textarea class="form-control form-control-simple no-resize bg-light textarea" id="comment_area" placeholder="Viết bình luận của bạn..."></textarea>
                                                                    </div>
                                                                </div>
                                                                <ul class="nk-chat-editor-tools g-2">                                                                                                                                                                                    
                                                                    <li>                                                           
                                                                        <button class="btn btn-round btn-warning btn-icon" id="comment-btn"><em class="icon ni ni-send-alt"></em></button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                      
                                                        <hr>
                                                        @endif
                                                        <div id="comment-box">
                                                            
                                                            <div id ="comment-render-div">
                                                                @foreach ($comments as $comment)
                                                                <div id="comment-{{ $comment->id }}">
                                                                        <div class="d-flex flex-column comment-section">
                                                                            <div class="bg-white p-2">
                                                                                    <div class="d-flex justify-content-between">
                                                                                        <div class="d-flex user-info">
                                                                                            <img class="rounded border shadow me-2" src="{{ $comment->users->profile->url }}" width="60px">
                                                                                            <div class="flex-grow-1">
                                                                                                <span class="d-block font-weight-bold name">{{ $comment->users->profile->displayName }}</span>
                                                                                                

                                                                                                <div class="d-flex">
                                                                                                    @foreach ($userTotalReading as $userTotal )
    
                                                                                                    @if($userTotal->userID == $comment->users->id)
                                                                                                        <div class="otherInfo me-5">
                                                                                                            <em class="icon ni ni-eye"></em>
                                                                                                            <span class="text-muted">Đã đọc: {{ $userTotal->total }} lần</span>
                                                                                                        </div>
                                                                                                    @endif
                                                                                                    @endforeach
                                                                                                    <div class="timeComment">
                                                                                                        <em class="icon ni ni-clock"></em>
                                                                                                        <span class="text-muted">{{ $comment->time }}</span>
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                               
                                                                                            </div>

                                                                                          
                                                                                            
                                                                                        </div>
                                                                                      
                                                                                        @if(Auth::check())
                                                                                            @if(Auth::user()->id == $comment->users->id || Auth::user()->role == 1)
                                                                                            <div class="dropdown">
                                                                                                <a class="dropdown-toggle text-dark" href="#" type="button" data-bs-toggle="dropdown">
                                                                                                    <em class="icon ni ni-more-v"></em>
                                                                                                </a>
                                                                                                <div class="dropdown-menu">
                                                                                                <ul class="link-list-opt">
                                                                                                    <li>
                                                                                                        <a class="delete-comment-btn" data-id={{ $comment->id }}>
                                                                                                            <em class="icon ni ni-trash"></em>
                                                                                                            <span>Xóa bình luận</span>
                                                                                                        </a>
                                                                                                    
                                                                                                    </li>
                                                                                                    <li> 
                                                                                                        <a class="edit-comment-btn" data-id="{{ $comment->id }}" data-option="1">
                                                                                                            <em class="icon ni ni-edit fs-16px"></em>
                                                                                                            <span>Chỉnh sửa bình luận</span>
                                                                                                        </a>

                                                                                                    
                                                                                                    </li>
                                                                                                </ul>
                                                                                                </div>
                                                                                            </div>
                                                                                            @endif
                                                                                        @endif
                                                                                    </div>
                                                                                    
                                                                                
                                                                                
                                                                                <div class="mt-2" id ="comment-content-{{ $comment->id }}">
                                                                                    <p>
                                                                                        {{ $comment->content }}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                
                                                                            
                                                                                <div class="bg-white">
                                                                                    <div class="d-flex align-items-center justify-content-between">
                                                                                        @if($comment->totalReplies > 0)
                                                                                            <div class="ms-2">
                                                                                                <p class="open-relies-btn fw-bold" data-id="{{ $comment->id }}">Xem {{ $comment->totalReplies }} phản hồi</p>
                                                                                            </div>
                                                                                        @else

                                                                                            <div></div>
                                                                                        @endif
                                                                                        
                                                                                        <div class="ms-2">

                                                                                            @if($comment->likes->count() > 0)
                                                                                                @if(Auth::check()) 
                                                                                                    @if($comment->likes->where("userID",'=',Auth::user()->id)->where('isLike','=',1)->count() > 0)   
                                                                                                        <span class="like-comment-btn me-2" data-id={{ $comment->id }}>
                                                                                                            <em class="icon ni ni-thumbs-up fs-16px text-primary">{{ $comment->totalLikes }}</em>
                                                                                                        </span>
                                                                                                    @else
                                                                                                        <span class="like-comment-btn me-2" data-id={{ $comment->id }}>
                                                                                                            <em class="icon ni ni-thumbs-up fs-16px">{{ $comment->totalLikes }}</em>
                                                                                                        </span>
                                                                                                    @endif

                                                                                                @else
                                                                                                    <span class="me-2">
                                                                                                        <em class="icon ni ni-thumbs-up fs-16px">{{ $comment->totalLikes }}</em>
                                                                                                    </span>
                                                                                                @endif
                                                                                         
                                                                                            @else
                                                                                                <span class="like-comment-btn me-2" data-id={{ $comment->id }}>
                                                                                                    <em class="icon ni ni-thumbs-up fs-16px">{{ $comment->totalLikes }}</em>
                                                                                                </span>
                                                                                            @endif
                                                                                           
                                                                                            @if(Auth::check())
                                                                                                <span class="create-reply-btn me-2" data-id={{ $comment->id }}>
                                                                                                    <em class="icon ni ni-reply fs-16px "></em>
                                                                                                </span>
                                                                                                
                            
                                                                                          
                                                                                                @if(Auth::user()->id != $comment->users->id)

                                                                                                        @if($reportComment->where('identifier_id','=',$comment->id)->first())
                                                                                                            @if($reportComment->where('identifier_id','=',$comment->id)->first()->isEnabled)
                                                                                                                <span class="report-comment-btn me-2" data-id={{ $comment->id }} data-type=6 data-user="{{ $comment->users->profile->displayName  }}" data-bs-toggle="modal" data-bs-target="#reportFormComment">
                                                                                                                    <em class="icon ni ni-flag fs-16px"></em>
                                                                                                                </span>
                                                                                                            @else

                                                                                                            <dfn data-info="Đã có người báo cáo">
                                                                                                                <span class="me-2" style="color:gray">
                                                                                                                    <em class="icon ni ni-flag fs-16px"></em>
                                                                                                                </span>
                                                                                                            </dfn>
                                                                                                            
                                                                                                            @endif
                                                                                                        @else
                                                                                                            <span class="report-comment-btn me-2" data-id={{ $comment->id }} data-type=6 data-user="{{ $comment->users->profile->displayName  }}" data-bs-toggle="modal" data-bs-target="#reportFormComment">
                                                                                                                <em class="icon ni ni-flag fs-16px"></em>
                                                                                                            </span>
                                                                                                        @endif
                                                                                                  
                                                                                                @endif
                                                                                               
                                                                                                
                                                                                               
                                                                                            @endif
                                                                                        </div>
                                                                                        
                                                                                      
                                                                                    </div>
                                                                                    
                                                                                            
                                                                                    
                                                                                </div>
                                                                            
                                                                        </div> 
                                                                        <hr>
                                                                        @foreach ($comment->replies as $reply)
                                                                        @if(is_null($reply->deleted_at))
                                                                        <div class="ms-5 replies-item replies-item-{{ $reply->commentID }}" id="reply-{{ $reply->id }}">
                                                                            <div class="d-flex flex-column comment-section">
                                                                                <div class="bg-white p-2">
                                                                                    <div class="d-flex justify-content-between">
                                                                                        <div class="d-flex user-info">
                                                                                            <img class="rounded border shadow me-2" src="{{ $reply->users->profile->url }}" width="60px">
                                                                                            <div class="flex-grow-1">
                                                                                                <span class="d-block font-weight-bold name">{{ $reply->users->profile->displayName }}</span>
                                                                                                
                                                                                                <div class="d-flex">
                                                                                                    @foreach ($userTotalReading as $userTotal )
    
                                                                                                    @if($userTotal->userID == $reply->users->id)
                                                                                                        <div class="otherInfo me-5">
                                                                                                            <em class="icon ni ni-eye"></em>
                                                                                                            <span class="text-muted">Đã đọc: {{ $userTotal->total }} lần</span>
                                                                                                        </div>
                                                                                                    @endif
                                                                                                    @endforeach
                                                                                                    <div class="timeComment">
                                                                                                        <em class="icon ni ni-clock"></em>
                                                                                                        <span class="text-muted">{{ $reply->time }}</span>
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                               
                                                                                            </div>
                                                                                        </div>
                                                                                      
                                                                                        @if(Auth::check())
                                                                                            @if(Auth::user()->id == $reply->users->id || Auth::user()->role == 1)
                                                                                            <div class="dropdown">
                                                                                                <a class="dropdown-toggle text-dark" href="#" type="button" data-bs-toggle="dropdown">
                                                                                                    <em class="icon ni ni-more-v"></em>
                                                                                                </a>
                                                                                                <div class="dropdown-menu">
                                                                                                    <ul class="link-list-opt">
                                                                                                    <li>
                                                                                                        <a class="delete-reply-btn" data-id={{ $reply->id }}>
                                                                                                            <em class="icon ni ni-trash"></em>
                                                                                                            <span>Xóa phản hồi</span>
                                                                                                        </a>
                                                                                                        
                                                                                                    </li>
                                                                                                    <li> 
                                                                                                        <a class="edit-comment-btn" data-id="{{ $reply->id }}" data-option="2">
                                                                                                            <em class="icon ni ni-edit fs-16px"></em>
                                                                                                            <span>Chỉnh sửa phản hồi</span>
                                                                                                        </a>

                                                                                                        
                                                                                                    </li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                            </div>
                                                                                            @endif
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="mt-2" id ="reply-content-{{ $reply->id }}">
                                                                                        <p>
                                                                                            {{ $reply->content }}
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                
                
                                                                                <div class="ms-2">
                                                                                    <div class="d-flex align-items-center">
                                                                                        @if($reply->likes->count() > 0)
                                                                                            @if(Auth::check()) 
                                                                                                @if($reply->likes->where("userID",'=',Auth::user()->id)->where('isLike','=',1)->count() > 0)   
                                                                                                    <span class="like-reply-btn me-2" data-id={{ $reply->id }}>
                                                                                                        <em class="icon ni ni-thumbs-up fs-16px text-primary">{{ $reply->totalLikes }}</em>
                                                                                                    </span>
                                                                                                @else
                                                                                                    <span class="like-reply-btn me-2" data-id={{ $reply->id }}>
                                                                                                        <em class="icon ni ni-thumbs-up fs-16px">{{ $reply->totalLikes }}</em>
                                                                                                    </span>
                                                                                                @endif

                                                                                            @else
                                                                                                <span class="me-2">
                                                                                                    <em class="icon ni ni-thumbs-up fs-16px">{{ $reply->totalLikes }}</em>
                                                                                                </span>
                                                                                            @endif
                                                                                
                                                                                        @else
                                                                                            <span class="like-reply-btn me-2" data-id={{ $reply->id }}>
                                                                                                <em class="icon ni ni-thumbs-up fs-16px">{{ $reply->totalLikes }}</em>
                                                                                            </span>                                                                             
                                                                                        @endif
                                                                                        
                                                                                        @if(Auth::check()) 
                                                                                                @if(Auth::user()->id != $reply->users->id)

                                                                                                    @if($reportReply->where('identifier_id','=',$reply->id)->first())
                                                                                                        @if($reportReply->where('identifier_id','=',$reply->id)->first()->isEnabled)
                                                                                                            <span class="report-comment-btn" data-id={{ $reply->id }} data-type=9 data-user="{{ $reply->users->profile->displayName  }}" data-bs-toggle="modal" data-bs-target="#reportFormComment">
                                                                                                                <em class="icon ni ni-flag fs-16px me-2 "></em>
                                                                                                            </span>
                                                                                                        @else

                                                                                                            <dfn data-info="Đã có người báo cáo">
                                                                                                                <span class="me-2" style="color:gray">
                                                                                                                    <em class="icon ni ni-flag fs-16px"></em>
                                                                                                                </span>
                                                                                                            </dfn>
                                                                                                        
                                                                                                        @endif
                                                                                                    @else

                                                                                                        <span class="report-comment-btn" data-id={{ $reply->id }} data-type=9 data-user="{{ $reply->users->profile->displayName  }}" data-bs-toggle="modal" data-bs-target="#reportFormComment">
                                                                                                            <em class="icon ni ni-flag fs-16px me-2 "></em>
                                                                                                        </span>
                                                                                                    @endif
                                                                                                @endif                                                                                
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                               
                                                                            </div> 
                                                                            <hr>
                                                                        </div>
    
                                                                        @endif
                                                                        
    
                                                                    @endforeach
                                                                </div>
                                                            
                                                            @endforeach
                                                            </div>
                                                       


                                                            {{-- <div class="col-md-12 d-flex justify-content-end mt-4">                          
                                                                {{ $comments->links('vendor.pagination.custom',['elements' => $comments]) }}
                                                            </div> --}}

                                                            @if ($comments->count() > 0)

                                                            <div class="data-container"></div>
                                                            <div class="col-md-12 d-flex justify-content-end mt-4">                          
                                                                <div id="pagination"></div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                       
                                                        
                                                    
                                                            
                                                    </div>
                                                </div>
                                            </div><!-- .col -->
                                        </div><!-- .row -->

                                    </div>
                                    <div class="tab-pane" id="tabItem8">
                                                           
                                            <div id="rating-box" class="row">                                                  
                                                    
                                                <div class="col-8">

                                                        @if(!$isRating && Auth::check())
                                                        <div class="rounded" style="background-color: #f7f5f0">
                                                            <div class="p-3">
                                                                <p class="text-muted">Đánh giá của bạn: </p>
                                                                <div id="rateYo3"></div>
                                                                {{-- @else
                                                                <div id="rateYo3" data-rateyo-read-only="true"></div>
                                                                @endif --}}
                                                            </div>
                                                        
        
                                                            <div class="nk-chat-editor border flex-grow-1">
                                                                <div class="nk-chat-editor-form">
                                                                    <div class="form-control-wrap">
                                                                        <textarea class="form-control form-control-simple no-resize textarea" id="rating-text-box" placeholder="Viết đánh giá của bạn!!!"></textarea>
                                                                    </div>
                                                                </div>
                                                                <ul class="nk-chat-editor-tools g-2">                                                                                                                                                                                    
                                                                    <li>                                                           
                                                                        <button class="btn btn-round btn-warning btn-icon" id="rating-btn"><em class="icon ni ni-send-alt"></em></button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        @endif
                                                        <div class="d-flex justify-content-between">
                                                            <h5><span class="total-comment-span">{{ $ratingPersons->count() }} </span>đánh giá</h5>
                                                            <div class="dropdown">
                                                                <a class="btn btn-icon btn-outline-secondary dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                                                    <em class="icon ni ni-sort-line"></em>    
                                                                </a>
                                                                <div class="dropdown-menu">
                                                                  <ul class="link-list-opt">
                                                                    <li><a href="#" id="sort-rating-new"><span>Mới nhất</span></a></li>
                                                                    <li><a href="#" id="sort-rating-old"><span>Cũ nhất</span></a></li>
                                                            
                                                                  </ul>
                                                                </div>
                                                              </div>                                                      
                                                        </div>
                                                        <hr>
                                                        <div class="row" id ="rating-list-content">                                           
                                                            @foreach ( $ratingPersons as $person )
                                                                <div id ="rating-{{ $person->id }}">
                                                                    <div class="d-flex justify-content-center">
                                                                        <img class="rounded border shadow me-2" src="{{ $person->users->profile->url }}" style="width:60px">
                                                                        <div class="w-100">
                                                                            <div class="d-flex justify-content-between">
                                                                                <span class="d-block font-weight-bold name">{{ $person->users->profile->displayName }}</span>
    
                                                                                @if(Auth::check())
                                                                                    @if(Auth::user()->id == $person->users->id || Auth::user()->role == 1)
                                                                                        <a href="#" class="delete-rating-btn text-dark" data-id={{ $person->id }} >
                                                                                            <em class="icon ni ni-cross"></em>      
                                                                                        </a>
                                                                                    @endif
                                                                                @endif
                                                                            </div>
                                                                            <div class="d-flex justify-content-between">
                                                                                <div>
                                                                                    <div class="me-6 d-flex align-items-center">
                                                                                        <div id="rateYo-{{ $loop->index }}" data-rateyo-read-only="true" data-person-rating-score={{ $person->score }}></div>                                                
                                                                                        <span style="font-size:20px"> {{ $person->score }}</span>                                                                            
                                                                                    </div>
                                                                                   
                                                                                </div>
                                                                                
                                                                                
                                                                                @foreach ($userTotalReading as $userTotal )

                                                                                @if($userTotal->userID == $person->users->id)
                                                                                    <div class="otherInfo">
                                                                                        <em class="icon ni ni-eye"></em>
                                                                                        <span class="text-muted">Đã đọc: {{ $userTotal->total }} lần</span>
                                                                                    </div>
                                                                                @endif
                                                                                @endforeach
                                                                                <div class="timeComment">
                                                                                    <em class="icon ni ni-clock"></em>
                                                                                    <span class="text-muted">{{ $person->time }}</span>
                                                                                </div>
                                                                                  
                                                                               
                                                                              
                                                                              
                                                                            </div>
                                                                            
                                                                        </div>
                                                                   
                                                                    </div>    
                                                                    <div class="rating-content mt-2">
                                                                        <p class="text-muted">{{ $person->content }}</p>     
                                                                    </div>  
                                                                    <hr>
                                                                </div>
                                                              
                                                                         
                                                            @endforeach
                                                        </div>
                                                </div>
                                               
                                                <div class="col-4">

                                                    <div class="rounded p-2" style="background-color: #f7f5f0">
                                                        <div class="progress-amount d-flex align-items-center flex-column">
                                                            <h1 class="title">{{ $book->ratingScore }}</h1>
                                                        
                                                            <div id="rateYo2" data-rateyo-read-only="true"></div>
                                                            
                                                            <span class="sub-text mt-1"><em class="icon ni ni-users-fill"></em> 
                                                                <span class="ratingPersonCount">{{ $ratingPersons->count() }} </span>đánh giá</span>
                                                        </div>
                                                        <hr>
                                                        <div class="rating-progress-bar gy-1 w-100">
                                                            @foreach ($percentOfScoreList as $key=>$value)
                                                                <div class="progress-rating">
                                                                    <div class="progress-rating-title">{{ $key }} sao</div>
                                                                    <div class="progress progress-md progress-alt">
    
                                                                        @if($key == '5')
                                                                        <div class="progress-bar bg-teal" data-progress="{{ $value }}" style="width: {{ $value }}%;"></div>
                                                                        @endif
                                                                        @if($key == '4')
                                                                        <div class="progress-bar bg-success" data-progress="{{ $value }}" style="width: {{ $value }}%;"></div>
                                                                        @endif
                                                                        @if($key == '3')
                                                                        <div class="progress-bar bg-info" data-progress="{{ $value }}" style="width: {{ $value }}%;"></div>
                                                                        @endif
                                                                        @if($key == '2')
                                                                        <div class="progress-bar bg-warning" data-progress="{{ $value }}" style="width: {{ $value }}%;"></div>
                                                                        @endif
                                                                        @if($key == '1')
                                                                        <div class="progress-bar bg-danger" data-progress="{{ $value }}" style="width: {{ $value }}%;"></div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="progress-rating-percent">{{ $value }}%</div>
                                                                </div>    
                                                            @endforeach                                                                    
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                                      
                                                   
                                                    
                                                    
                                            </div>
                                          
                                                             
                                       
                                    </div>
                                </div>
                               
                            </div>                        
                        </div>
                    </div>

                        
                    @if(isset($booksWithSameType))
                        @if($booksWithSameType->count() > 0)
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="nk-block-head nk-block-head-sm">
                                        <div class="nk-block-between">
                                            <div class="nk-block-head-content">
                                                <h5 class="nk-block-title">Sách cùng thể loại</h5>
                                            </div><!-- .nk-block-head-content -->                           
                                        </div><!-- .nk-block-between -->
                                    </div><!-- .nk-block-head -->
                                    <hr>
                                
                                        <div class="nk-block">
                                            <div class="slider-init" data-slick='{"slidesToShow": 4, "slidesToScroll": 2, "infinite":false, "responsive":[ {"breakpoint": 992,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}} ]}'>
                                                @foreach ($booksWithSameType as $book)
                                                    <div class="col high_rating_books" >
                                                        <div class="card card-bordered product-card shadow">
                                                            <div class="product-thumb shine">
                                                                <a href="/sach/{{$book->id}}/{{$book->slug}}">
                                                                    <img class="card-img-top" src="{{ $book->url }}" alt="" width="300px" height="350px">
                                                                </a>
                                                            
                                                                <ul class="product-badges">
                                                                    <li><span class="badge bg-success">{{ $book->ratingScore }}/5</span></li>
                                                                </ul>    
                                                            
                                                                
                                                                <ul class="product-actions d-flex h-100 align-items-center" >
                                                                    <li >
                                                                        <a href="#" class="preview-book-btn" data-id ={{ $book->id }} data-option="1">
                                                                            <em class="icon icon-circle bg-success ni ni-book-read"></em>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="card-inner text-center">
                                                                <ul class="product-tags">
                                                                    <li><a href="/tac-gia/tac-gia-sach/{{ $book->author }}">{{ $book->author }}</a></li>
                                                                </ul>
                                                                <h3 class="product-title fs-13px" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $book->name }}"><a href="/sach/{{$book->id}}/{{$book->slug}}"> {{ Str::limit($book->name,25) }}</a></h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                            
                            
                                            </div>
                                        </div><!-- .nk-block -->  
                                
                                </div>    
                            </div>
                        @endif
                    @endif
                </div>    
                               
            </div><!-- .nk-block -->       
        </div>
    </div>
</div>
 
@endsection

@section('modal')
@if(Auth::check())
<div class="modal fade" id="reportFormBook" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Báo cáo sách</h5>
                <button class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-validate is-alter" novalidate="novalidate">
                    @csrf
                    <input type="hidden" class="form-control" id="type_id" name="type_id" value=1>
                    <input type="hidden" class="form-control" id="identifier_id" name="identifier_id" value={{ $book_id }}>

                    <div class="form-group">
                        <label class="form-label" for="book-name">Tên sách</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="book-name" required="" value='{{ $book_name }}' readonly>
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
                        <button id="submitReportFormBook" class="btn btn-lg btn-primary">Báo cáo</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <span class="sub-text">Báo cáo bởi {{ Auth::user()->profile->displayName }}</span>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="reportFormComment" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Báo cáo bình luận</h5>
                <button class="close" data-bs-dismiss="modal" aria-label="Close">
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa bình luận</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <div class="nk-chat-editor border rounded-pill flex-grow-1 bg-light">
                    <div class="nk-chat-editor-form">
                        <div class="form-control-wrap">
                            <textarea class="form-control form-control-simple no-resize bg-light textarea" id="editCommentArea" placeholder="Viết bình luận của bạn...">

                            </textarea>
                        </div>
                    </div>
                    <ul class="nk-chat-editor-tools g-2">                   
                        <li>
                            <button class="btn btn-round btn-warning btn-icon" id="submitEditCommentForm"><em class="icon ni ni-send-alt "></em></button>
                        </li>
                    </ul>
                </div>
            
            </div>
           
        </div>
    </div>
</div>


<div class="modal fade" id="recommedRatingBook">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            <div class="modal-body modal-body-lg text-left" id='render-recommend-div'>
            
                
            </div>
            <div class="modal-footer bg-lighter">
                <div class="text-center w-100">
                    <p>Gợi ý cho bạn</p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="previewItemModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-left">
            
                
            </div>
        </div>
    </div>
</div>
@endif
@endsection
@section('additional-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script src="{{ asset('assets/js/example-sweetalert.js?ver=3.1.2') }}" aria-hidden="true"></script>
<script src="{{ asset('assets/js/emojionearea.min.js') }}" aria-hidden="true"></script>
<script src="{{ asset('js/pagination/pagination.min.js') }}" ></script>

<script>
   

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });


    $(function () {

  

    chapterRender();
    commentRender();
    $('#comment_area').emojioneArea({
        pickerPosition: "bottom",
        filtersPosition: "bottom",
        tones: false,
        events: {
            keyup: function (editor, event) {
                $('#comment_area').val(this.getText());
            }
        }
    });
        

    $('.replies-item').css('display', 'none');

    var chapter = {!! $book->numberOfChapter  !!}

    if(chapter > 0){

        const readingLog = window.localStorage.getItem('readingLog');

        if(readingLog){

        const log = JSON.parse(readingLog);
        const current_book_id = {!! $book_id !!}
        objIndex = log.findIndex((obj => obj.book_id == current_book_id));

        if(objIndex >= 0){
            log[objIndex].chapter_id.forEach(element => {
            var buttonChapters = $('#tabItem6').find('#chapter_list').find(`a[data-id='${element}']`);
            
            buttonChapters.each(function (i,item) {
                $(item).css("color", "#dbd7d3");
            })


            });
        }
        
        }
    }
    
    $('#comment-btn').attr('disabled', true);
    
       

    $("#rateYo3").rateYo({
        maxValue: 5,
        numStars: 5,
        halfStar: true,
        starWidth: "30px",
        spacing: "10px",

        multiColor: {

        "startColor": "#FF0000", //RED
        "endColor"  : "#00FF00"  //GREEN
        },
    });


    $("#rateYo2").rateYo({
        rating: {!! $ratingScore !!},
        starWidth: "18px",  

        
    });

    $("#rateYo").rateYo({
        rating: {!! $ratingScore !!},
        starWidth: "20px",    
    });
    
    defaultRatingSet();
      
       
    });

    function chapterRender(){
        const container = $('#tabItem6').find('#pagination');

  

        if (!container.length) return;
            var sources = function () {
            var result = [];

            $('#chapter-render-div').children().each(function(item){

                result.push($(this).get(0).outerHTML);

            })
        return result;
        }();

        var options = {
            dataSource: sources,
            callback: function (response, pagination) {
                var dataHtml = '<div class="row" id="chapter_list">';

                $.each(response, function (index, item) {
                    dataHtml += item;
                });

                dataHtml += '</div>';

                container.parent().prev().html(dataHtml);
                $('#chapter-render-div').remove();
            }
        };


  
        container.pagination(options);
    }


    function commentRender(){
        const container = $('#tabItem7').find('#pagination');


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

    function defaultRatingSet(){
        const totalOfRating = @json($ratingPersons->count());
        
        for(i=0;i<totalOfRating;i++){
            var color = '';
            const score = $(`#rateYo-${i}`).data('person-rating-score');

            var temp = parseInt(score);
            if(temp == 5){
                color = '#20c997';
            }
            if(temp >=4 && temp <5){
                color = '#1ee0ac';
            }
            if(temp >=3 && temp <4){
                color = '#09c2de';
            }
            if(temp >=2 && temp <3){
                color = '#f4bd0e';
            }
            if (temp >=1 && temp <2){
                color = '#e85347';
            }
            
            $(`#rateYo-${i}`).rateYo({
                rating: score,
                starWidth: "20px",   
                ratedFill: color,           
            });

        }
    }

    $(document).on('keypress','#rating-text-box',function(e){
        if (e.keyCode == 13) {
            $('#rating-btn').click();
        }
    });

    $(document).on('click','#rating-btn',function(){

        const content = $('#rating-text-box').val();

        var rating = $('#rateYo3').rateYo("rating");

        if(rating === 0){
            Swal.fire({
                icon: 'error',
                title: 'Vui lòng đánh giá số sao',
                showConfirmButton: false,
                timer: 2500
            });    
        }

        if(content.length){
            var book_id = {!! $book_id !!};

            $.ajax({
                url:'/sach-danh-gia',
                type:"POST",
                data:{
                    'id': book_id,
                    'score':rating,
                    'content':content
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

                $('span.score').text(`${currentScore}`);  
                
                $("#rateYo").rateYo("rating", `${currentScore}`);
                
                $("#rating-box").load(" #rating-box > *",function() {
                    const totalOfRating = res.totalOfRating;
                    
                    $("#rateYo2").rateYo({
                        rating: currentScore,
                        starWidth: "17px",   
                    });

                    for(i=0;i<totalOfRating;i++){

                        const score = $(`#rateYo-${i}`).data('person-rating-score');

                        if(score == 5){
                            color = '#20c997';
                        }
                        if(score >=4 && score <5){
                            color = '#1ee0ac';
                        }
                        if(score >=3 && score <4){
                            color = '#09c2de';
                        }
                        if(score >=2 && score <3){
                            color = '#f4bd0e';
                        }
                        if (score >=1 && score <2){
                            color = '#e85347';
                        }

                        $(`#rateYo-${i}`).rateYo({
                            rating: score,
                            starWidth: "20px",   
                            ratedFill: color,           
                        });

                        const temp =  $('#rating-box').find('.ratingPersonCount').text();
                        
                        $('.ratingPersonCount').text(temp);

                    }
                });

                setTimeout(function() {
                    if (res.recommened_book){

                    const item = res.recommened_book;
                    $('#recommedRatingBook').find('.modal-body').empty().append(item);

                    $('#recommedRatingBook').modal('show');
                    }
                },2600)
              

                
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
            })
        }
        else{
            Swal.fire({
                icon: 'error',
                title: 'Vui lòng để lại nội dung đánh giá!!!',
                showConfirmButton: false,
                timer: 2500
            });   
        }

    })
    $(document).on('click','.open-relies-btn',function() {

        const comment_id = $(this).data('id');

        $(`.replies-item-${comment_id}`).fadeToggle();
    });

    $(document).on('keyup','.emojionearea-editor',function() {
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
        
        var book_id = {!! $book_id !!};

        $.ajax({
                url:'/binh-luan',
                type:"POST",
                data:{
                    'item_id': book_id,
                    'content': content,
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

                $('#main-comment-box').find("#comment_area").val('');
                $('#main-comment-box').find('.emojionearea-editor').text('');
                $("#comment-box").load(" #comment-box > *");
                $('.total-comment-span').text(res.totalComments + " ");

            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
            });

    })
    
    $('#book-mark-btn').click(function(){
        var book_id = {!! $book_id !!};
        
        $(this).attr("disabled", 'disabled');
        $('#span-text').text('Đã theo dõi');

             $.ajax({
                url:'/theo-doi',
                type:"POST",
                data:{
                    'item_id': book_id,
                    'type_id':2
                }
            })
            .done(function(res) {
              
                Swal.fire({
                        icon: 'success',
                        title: `${res.success}`,
                        showConfirmButton: false,
                        timer: 2500
                    });      
            
                $('#totalBookMarking').text(res.totalMarking);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
            })

    })

    //Book Report
    $('#submitReportFormBook').click(function(e){
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

                var form = $('#reportFormBook');

                var type_id = form.find('input[name="type_id"]').val();
                var identifier_id = form.find('input[name="identifier_id"]').val();
                var description = form.find('textarea[name="description"]').val();
                var reason = form.find('select[name="reason"]').val();

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

                            $("#book-info").load(" #book-info > *");

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

    //Comments && Replies report
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
                var reason = form.find('select[name="reason"]').val();


  
                
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

                            $("#comment-box").load(" #comment-box > *");

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


    $(document).on('click','.delete-comment-btn',function(e){
        e.preventDefault();

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

                    $('.total-comment-span').text(res.totalComments + " ");

                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                    // If fail
                    console.log(textStatus + ': ' + errorThrown);
                    });
                
                }
            })

    })

    $(document).on('click','.delete-reply-btn',function(e){
        e.preventDefault();

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
                    .done(function(res) {
                    // If successful
                    Swal.fire({
                            icon: 'success',
                            title: `Xóa thành công`,
                            showConfirmButton: false,
                            timer: 2500
                    });
                    $("#reply-" + reply_id).fadeOut();
                    $("#comment-box").load(" #comment-box > *");

                    $('.total-comment-span').text(res.totalComments + " ");

                   
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                    // If fail
                    console.log(textStatus + ': ' + errorThrown);
                    });
                
                }
            })

    })

    $(document).on('click','.create-reply-btn',function(e){
        e.preventDefault();


        var comment_id = $(this).data('id');

        if($("#reply-box").length){

            $("#reply-box").remove();
        }
        else{
          
        var htmlrender = 
        `<div class="ms-5 nk-chat-editor border bg-light w-75" id="reply-box">
                <div class="nk-chat-editor-form">
                    <div class="form-control-wrap">
                        <textarea class="form-control form-control-simple no-resize bg-light" id="reply_area" placeholder="Viết phản hồi của bạn..."></textarea>
                    </div>
                </div>
                <ul class="nk-chat-editor-tools g-2">              
                    <li>
                        <button class="btn btn-round btn-warning btn-icon" id="reply-btn" data-id=${comment_id}><em class="icon ni ni-send-alt"></em></button>
                    </li>
                </ul>
        </div>`;
       

        $('#comment-'+comment_id).append(htmlrender);

        $('#reply-btn').attr('disabled', true);

        $('#reply_area').emojioneArea({
            pickerPosition: "bottom",
            filtersPosition: "bottom",
            tones: false,
            events: {
                keyup: function (editor, event) {
                    $('#reply_area').val(this.getText());
                }
            }
	    });
        }
        
    })

    $(document).on('click','#reply-btn',function(e){
        e.preventDefault();

        var content = $("#reply_area").val();
        
        var comment_id = $(this).data('id');
        
        $.ajax({
                url:'/phan-hoi',
                type:"POST",
                data:{
                    'comment_id': comment_id,
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

                $("#comment-box").load(" #comment-box > *");

                $('.total-comment-span').text(res.totalComments + " ");

            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
            });


    })
    

    $(document).on('click','.like-comment-btn',function(e){
        e.preventDefault();

        const commentID = $(this).data('id');

        const item = $(this);
        $.ajax({
            url:'/thich-binh-luan',
            type:"POST",
            data:{
                'commentID': commentID,
            }
        })
        .done(function(res) {

            const totalLike = res.totalLike;

            item.find('em').text(totalLike);    
            
            const status = res.status;
            
            if(status === 1){
                item.find('em').addClass('text-primary');
            }
            else{
                item.find('em').removeClass('text-primary');

            }

        })
        .fail(function(jqXHR, textStatus, errorThrown) {
        // If fail
        console.log(textStatus + ': ' + errorThrown);
        });

    })


    $(document).on('click','.like-reply-btn',function(e){
        e.preventDefault();

        const replyID = $(this).data('id');

        const item = $(this);
        $.ajax({
            url:'/thich-phan-hoi',
            type:"POST",
            data:{
                'replyID': replyID,
            }
        })
        .done(function(res) {

            const totalLike = res.totalLike;

            item.find('em').text(totalLike);    
            
            const status = res.status;
            
            if(status === 1){
                item.find('em').addClass('text-primary');
            }
            else{
                item.find('em').removeClass('text-primary');

            }

        })
        .fail(function(jqXHR, textStatus, errorThrown) {
        // If fail
        console.log(textStatus + ': ' + errorThrown);
        });

        })
        

    $(document).on('click','.edit-comment-btn',function(e) {
        e.preventDefault();

        const item_id = $(this).data('id');
        const option = $(this).data('option');

        $('#submitEditCommentForm').data('id',item_id);
        $('#submitEditCommentForm').data('option',option);

        if(option == 1){
            const text = $('#comment-content-' + item_id).find('p').text();


            $('#editCommentArea').val( $.trim(text));
        }
        if(option == 2){
            const text = $('#reply-content-' + item_id).find('p').text();

            $('#editCommentArea').val( $.trim(text));
        }
     
        $('#editCommentArea').emojioneArea({
            pickerPosition: "bottom",
            filtersPosition: "bottom",
            tones: false,
            autocomplete: false,
            inline: true,
            hidePickerOnBlur: false,
            events: {
                keyup: function (editor, event) {
                    $('#editCommentArea').val(this.getText());
                }
            }
	    });
        
        setTimeout(function() {
            $('#editCommentForm').modal('show');
        },500);
    })

    $(document).on('click','#submitEditCommentForm',function(e){
        e.preventDefault();
        const item_id = $(this).data('id');
        const option = $(this).data('option');

        var item = $('#editCommentArea');
        var content = $.trim(item.val());

      

        if(content){
            if(option == 1){
                
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

                  

                    $('#comment-content-' + item_id).find('p').text(content);

                    setTimeout(function() {
                        $('#editCommentForm').modal('hide');
                    },2500);
                

                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                });
            }
            if (option == 2){
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

                    $('#reply-content-' + item_id).find('p').text(content);

                    setTimeout(function() {
                        $('#editCommentForm').modal('hide');
                    },2500);

                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                });
            }    

        }
        else{
            Swal.fire({
                    icon: 'info',
                    title: `Không được để trống phản hồi!!!`,
                    showConfirmButton: false,
                    timer: 2500
            });      
            
        }
          
        

    });


    $(document).on('click','.delete-rating-btn',function(e){
        e.preventDefault();
        const rating_id = $(this).data('id');
        const book_id = {!! $book_id !!};

        Swal.fire({
                title: "Bạn muốn xóa đánh giá này này?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Không'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                    type:"DELETE",
                    url:'/xoa-danh-gia',
                    data : {
                        'rating_id': rating_id,
                        'book_id' : book_id
                    },
                    })
                    .done(function(res) {
                    // If successful
                    Swal.fire({
                            icon: 'success',
                            title: `${res.success}`,
                            showConfirmButton: false,
                            timer: 2500
                    });
                
                    var currentScore = res.currentScore;

                    $('span.score').text(`${currentScore}`);  
                    
                    $("#rateYo").rateYo("rating", `${currentScore}`);
                    
                    $("#rating-box").load(" #rating-box > *",function() {
                        const totalOfRating = res.totalOfRating;
                        
                        $("#rateYo2").rateYo({
                            rating: currentScore,
                            starWidth: "17px",   
                        });

                        $("#rateYo3").rateYo({
                            maxValue: 5,
                            numStars: 5,
                            halfStar: true,
                            starWidth: "30px",
                            spacing: "10px",

                            multiColor: {

                            "startColor": "#FF0000", //RED
                            "endColor"  : "#00FF00"  //GREEN
                            },
                        });

                        for(i=0;i<totalOfRating;i++){

                            const score = $(`#rateYo-${i}`).data('person-rating-score');

                            if(score == 5){
                                color = '#20c997';
                            }
                            if(score >=4 && score <5){
                                color = '#1ee0ac';
                            }
                            if(score >=3 && score <4){
                                color = '#09c2de';
                            }
                            if(score >=2 && score <3){
                                color = '#f4bd0e';
                            }
                            if (score >=1 && score <2){
                                color = '#e85347';
                            }

                            $(`#rateYo-${i}`).rateYo({
                                rating: score,
                                starWidth: "20px",   
                                ratedFill: color,           
                            });

                        const temp =  $('#rating-box').find('.ratingPersonCount').text();
                        
                        $('.ratingPersonCount').text(temp);

                    }

                   
                    })
                })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                    // If fail
                    console.log(textStatus + ': ' + errorThrown);
                    });
                
                }
            })


    })


    $(document).on('click', '#sortbtn',function(e){
        e.preventDefault();

        const order = $(this).data('order');

        if(order == 'asc'){
            $("#chapter_list").children().sort(function(a, b) {
                return parseInt(b.id) - parseInt(a.id);

                }).each(function() {
                var elem = $(this);

                elem.remove();

                $(elem).appendTo("#chapter_list");
            });

            $('#sortbtn').data('order','desc');

            $('#sortbtn').empty();
            $('#sortbtn').append('<em class="icon ni ni-sort-down-fill"></em>')
        }
        else{
            $("#chapter_list").children().sort(function(a, b) {
                return parseInt(a.id) - parseInt(b.id);

                }).each(function() {
                var elem = $(this);
                
                elem.remove();

                $(elem).appendTo("#chapter_list");
            });

            $('#sortbtn').data('order','asc')
            $('#sortbtn').empty();
            $('#sortbtn').append('<em class="icon ni ni-sort-up-fill"></em>')
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

    $(document).on('click','#sort-rating-new',function(e){

        e.preventDefault();
        $('#rating-list-content').children().sort(function(a,b){

            
            
            return parseInt(b.id.split('-')[1]) - parseInt(a.id.split('-')[1]);

            }).each(function() {
            var elem = $(this);

            elem.remove();

            $(elem).appendTo("#rating-list-content")
        })

    })

    $(document).on('click','#sort-rating-old',function(e){

        e.preventDefault();
        $('#rating-list-content').children().sort(function(a,b){

            return parseInt(a.id.split('-')[1]) - parseInt(b.id.split('-')[1]);

            }).each(function() {
            var elem = $(this);

            elem.remove();

            $(elem).appendTo("#rating-list-content")
        })

    })

    // $("#download-btn").click(function(e){  
    //     e.preventDefault();
    //     const id = {!! $book_id !!};

    //     $.ajax({
    //         url:'/generation-link',
    //         type:"GET",
    //         data:{
    //             'id':id,
    //             'option':1
    //         }
    //         })
    //         .done(function(res) {
                
    //             window.location.href = res.url;
    //         })

    //         .fail(function(jqXHR, textStatus, errorThrown) {
    //         // If fail
    //         console.log(textStatus + ': ' + errorThrown);
    //         })

    //     })


        $('#read-pdf-btn').click(function(e) {
            e.preventDefault();
            const book_id = {!! $book_id !!};

            $.ajax({
            url:'/doc-sach-pdf/' + book_id,
            type:"GET",
            data:{
        
            }
            })
            .done(function(res) {
                
                window.location.href = res.url;
            })

            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
            })

        })


    $('.preview-book-btn').on('click', function(e) {
            e.preventDefault();
            const item_id = $(this).data('id');
            const option = $(this).data('option');

            $.ajax({
                    url:'/preview-item',
                    type:"GET",
                    data:{
                        'option': option,
                        'item_id':item_id,
                    }
                })
                .done(function(res) {  

                    const item = res.item;

                    if (item){

                        $('#previewItemModal').find('.modal-body').empty().append(item);

                        $('#previewItemModal').modal('show');
                    }

                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                })
    })
</script>
@endsection