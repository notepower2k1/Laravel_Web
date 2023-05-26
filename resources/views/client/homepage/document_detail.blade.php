@extends('client/homepage.layouts.app')
@section('pageTitle', `${{$document->name}}`)
@section('additional-style')
<link rel="stylesheet" href="{{ asset('assets/css/book3d.css') }}">
<link href="{{ asset('js/pagination/pagination.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('assets/css/infohelper.css') }}">

<style>
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
                                                    src="{{ $document->url }}"
                                                    />
                                                </div>
                                                </a>
                                            </div>
                                        </div><!-- .col -->
                                        <div class="col-lg-6 mt-4">
                                            <div class="product-info mb-5 me-xxl-5">
                                                <div class="d-flex justify-content-between align-items-center" id="document-info">
                                                    <h3 class="text-left">{{ $document->name }}
                                                   
                                                    </h3>                         
                                                    @if(Auth::check())
            
                                                        @if($reportDocument)

                                                            @if($reportDocument->isEnabled)
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
                                                
                                            
                                                <div class="d-flex flex-wrap">
                                                    @foreach(explode(",",$document->author) as $author)                                                                       
                                                    <span class="badge badge-md rounded-pill bg-outline-info me-1 mt-1"><a class="text-info" href="/tac-gia/tac-gia-tai-lieu/{{ $author }}">{{ $author }}</a></span>
                                                    @endforeach        
                                                    <span class="badge badge-md rounded-pill bg-outline-primary me-1 mt-1"><a class="text-primary" href="/the-loai/sort_by=created_at/the-loai-tai-lieu/{{$document->types->slug}}">{{ $document->types->name }}</a>
                                                    </span> 

                                                    @if ($document->language === 1)
                                                    <span class="badge badge-md rounded-pill bg-outline-secondary me-1 mt-1"><a class="text-secondary" href="/ngon-ngu/ngon-ngu-tai-lieu/tieng-viet">Tiếng Việt</a></span>
                                                    @else
                                                    <span class="badge badge-md rounded-pill bg-outline-secondary me-1 mt-1"><a class="text-secondary" href="/ngon-ngu/ngon-ngu-tai-lieu/tieng-anh">Tiếng Anh</a></span>
                                                    @endif 
        
                                                    @if ($document->isCompleted === 1)
                                                    <span class="badge badge-md rounded-pill bg-outline-success me-1 mt-1"><a class="text-success" href="/tinh-trang/tinh-trang-tai-lieu/da-hoan-thanh">Đã hoàn thành</a></span>
                                                    @else
                                                    <span class="badge badge-md rounded-pill bg-outline-success me-1 mt-1"><a class="text-success" href="/tinh-trang/tinh-trang-tai-lieu/chua-hoan-thanh">Chưa hoàn thành</a></span>
                                                    @endif 
                                                 
                                                   
                                                </div>
                                                
                                                                                     
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
                                                        {{-- <li>
                                                            <div class="fs-14px text-muted">Định dạng</div>
                                                            <div class="fs-16px fw-bold text-secondary">.{{ $document->extension }}</div>
                                                        </li> --}}
                                                        <li>
                                                            <div class="fs-14px text-muted">Đánh dấu</div>
                                                            <div class="fs-16px fw-bold text-secondary" id="totalMarking">{{ $document->totalDocumentMarking }}</div>
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                              
                                                <div class="product-meta">
                                                    <ul class="d-flex flex-wrap ailgn-center g-2 pt-1">
                                                        
                                                        <li class="ms-n1">
                                                            @if(Auth::check())
                                                            <button class="btn btn-xl btn-warning" id="download-btn"><em class="icon ni ni-download"></em><span>Tải xuống</span></button>
                                                            @else
                                                            <a href="/login" class="btn btn-xl btn-warning"><em class="icon ni ni-download"></em><span>Tải xuống</span></a>
            
                                                            @endif
                                                        </li>

                                                        <li class="ms-n1">
                                                            @if(Auth::check())
                                                                @if(!$isMark)
                                                                <button class="btn btn-xl btn-outline-secondary" id="document-mark-btn"><em class="icon ni ni-bookmark"></em><span id="span-text">Đánh dấu</span></button>
                                                                @else
                                                                <button class="btn btn-xl btn-outline-secondary" id="document-mark-btn" disabled><em class="icon ni ni-bookmark"></em><span id="span-text">Đã đánh dấu</span></button>
                                                                @endif
                                                            @else
                                                            <a href="/login" class="btn btn-xl btn-outline-secondary"><em class="icon ni ni-bookmark"></em><span id="span-text">Đánh dấu</span></a>
                                                            @endif
                                                        </li>
                                                      
                                                    </ul>
                                                </div><!-- .product-meta -->
                                            </div><!-- .product-info -->
                                            
                                            
                                        </div><!-- .col -->
                                    </div>
                                </div>

                                <div class="col-12">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#tabItem5"><span>Giới thiệu</span></a>
                                        </li>                            
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#tabItem7"><span>Bình luận
                                                <span class="badge badge-dim bg-orange total-comment-span">{{ $document->totalComments }}</span> </span>
                                            </a>
                                        </li>   
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#tabItem8"><span>Xem trước</span>
                                                <span class="badge badge-dim bg-orange">{{ $previewImages->count() }}</span> </span>
                                            </a>
                                        </li>                             
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tabItem5">
                                            <div class="row">                      
                                                <div class="col-lg-8">
                                                    <div class="product-details entry me-xxl-3">
                                                        {!! clean($document->description) !!}
                                                    </div>
                                                </div><!-- .col -->
                                                <div class="col-lg-4 col-xl-4 col-xxl-3">
                                                    <div class="card card-bordered" style="background-color:#f5f4f2;">
                                                        <div class="card-inner-group">
                                                            <div class="card-inner">
                                                                <div class="user-card user-card-s2">
                                                                    <div class="user-avatar lg bg-primary">
                                                                        <img src="{{ $document->users->profile->url }}" alt="">
                                                                    </div>
                                                                    <div class="user-info">
                                                                        {{-- <div class="badge bg-light rounded-pill ucap">Platinam</div> --}}
                                                                        <h5>
                                                                            <a class="text-dark" href="/thanh-vien/{{ $document->users->id }}"> {{ $document->users->profile->displayName }}</a>
                                                                        </h5>
                                                                        {{-- <span class="sub-text">info@softnio.com</span> --}}
                                                                    </div>
                                                                </div>
                                                            </div>                                                   
                                                            <div class="card-inner">
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
                                
                                        <div class="tab-pane" id="tabItem7">
                                            <div class="row g-gs flex-lg-row-reverse">                      
                                                <div class="col-lg-12">
                                                    <div class="product-details entry me-xxl-3">
                                                        <div class="d-flex justify-content-between">
                                                            <h5><span class="total-comment-span">{{ $document->totalComments }} </span>bình luận</h5>
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
                                                                                                    
    
                                                                                                    <div class="timeComment">
                                                                                                        <dfn data-info="{{ $comment->created_at }}">

                                                                                                            <em class="icon ni ni-clock"></em>
                                                                                                            <span class="text-muted">{{ $comment->time }}</span>
                                                                                                        </dfn>
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
                                                                                                                    <span class="report-comment-btn me-2" data-id={{ $comment->id }} data-type=7 data-user="{{ $comment->users->profile->displayName  }}" data-bs-toggle="modal" data-bs-target="#reportFormComment">
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
                                                                                                                <span class="report-comment-btn me-2" data-id={{ $comment->id }} data-type=7 data-user="{{ $comment->users->profile->displayName  }}" data-bs-toggle="modal" data-bs-target="#reportFormComment">
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
                                                                                                    
                                                                                                   
                                                                                                        <div class="timeComment">
                                                                                                            <dfn data-info="{{ $reply->created_at }}">

                                                                                                                <em class="icon ni ni-clock"></em>
                                                                                                                <span class="text-muted">{{ $reply->time }}</span>
                                                                                                            </dfn>
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
                                            <div class="nk-block">
                                                <div class="row g-gs">

                                                    @foreach ($previewImages as $previewImage)
                                                        <div class="col-sm-6 col-lg-4 col-xxl-3">
                                                            <div class="gallery card card-bordered">
                                                                <a class="gallery-image popup-image" href="{{ $previewImage->url }}">
                                                                    <img class="w-100 rounded-top" src="{{ $previewImage->url }}" alt="image">
                                                                </a>                                                     
                                                            </div>
                                                        </div> 
                                                    @endforeach
                                                   
                                                  
                                                </div>
                                            </div><!-- .nk-block --> 
                                         
                                           
                                        </div>
                                    </div>
                                </div>    
                            
                        </div>                  
                    </div>

                    @if(isset($documentsWithSameType))
                        @if($documentsWithSameType->count() > 0)
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h5 class="nk-block-title">Tài liệu cùng thể loại</h5>
                                    </div><!-- .nk-block-head-content -->                           
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <hr>
                        
                            <div class="nk-block">
                                <div class="slider-init" data-slick='{"slidesToShow": 4, "slidesToScroll": 2, "infinite":false, "responsive":[ {"breakpoint": 992,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}} ]}'>
                                    @foreach ($documentsWithSameType as $document)
                                    <div class="col high_rating_books" >
                                        <div class="card card-bordered product-card shadow">
                                            <div class="product-thumb shine">
                                                <a href="/tai-lieu/{{$document->id}}/{{$document->slug}}">
                                                    <img class="card-img-top" src="{{ $document->url }}" alt="" width="300px" height="350px">
                                                </a>                                
                                                
                                                <ul class="product-actions d-flex h-100 align-items-center" >
                                                    <li >
                                                        <a href="#" class="preview-book-btn" data-id ={{ $document->id }} data-option="2">
                                                            <em class="icon icon-circle bg-success ni ni-book-read"></em>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="card-inner text-center">
                                                <ul class="product-tags">
    
                                                    <li  data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $document->author }}">
                                                        @foreach(explode(",",$document->author) as $author)
                                                        @if($loop->iteration == 1)                                                                
                        
                                                        <a href="/tac-gia/tac-gia-tai-lieu/{{ $author }}">{{ $author }}</a>
                                                        @else
                                                        <span>,...</span>
                                                        @endif
                                                        @endforeach
                                                    </li>        
                                                </ul>
    
                                                <h3 class="product-title fs-13px" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $document->name }}"><a href="/tai-lieu/{{$document->id}}/{{$document->slug}}"> {{ Str::limit($document->name,25) }}</a></h3>
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
            </div>
          
        </div>
    </div>
</div>
@section('modal')
@if(Auth::check())

<div class="modal fade" id="reportForm">
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
                    <input type="hidden" class="form-control" id="identifier_id" name="identifier_id" value={{ $document_id }}>

                    <div class="form-group">
                        <label class="form-label" for="book-name">Tên tài liệu</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="book-name" required="" value='{{ $document_name }}' readonly>
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

<div class="modal fade" id="reportFormComment" >
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


<div class="modal fade" id="editCommentForm">
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
                            <button class="btn btn-round btn-warning btn-icon" id="submitEditCommentForm"><em class="icon ni ni-send-alt"></em></button>
                        </li>
                    </ul>
                </div>
            
            </div>
           
        </div>
    </div>
</div>
@endif
<div class="modal fade" id="previewItemModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-left">
            
                
            </div>
        </div>
    </div>
</div>
@endsection

@endsection
@section('additional-scripts')
<script src="{{ asset('assets/js/emojionearea.min.js') }}" aria-hidden="true"></script>
<script src="{{ asset('js/pagination/pagination.min.js') }}" ></script>

<script>
    
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    
    $(function () {

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

        $('#comment-btn').attr('disabled', true);
        $('.replies-item').css('display', 'none');

    })

    

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
    $("#download-btn").click(function(e){  

        const id = {!! $document_id !!};

        $.ajax({
            url:'/generation-link',
            type:"GET",
            data:{
                'id':id,
                'option':2
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


   

 

  
    //report Document
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

                            $("#document-info").load(" #document-info > *");

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
        
        var item_id = {!! $document_id !!};

        $.ajax({
                url:'/binh-luan',
                type:"POST",
                data:{
                    'item_id': item_id,
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
                    $('.total-comment-span').text(res.totalComments + " ");

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

    $(document).on('click','.create-reply-btn',function(){

        var comment_id = $(this).data('id');
        var avatar = $('#comment_avatar img').attr('src')


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

    $(document).on('click','#reply-btn',function(){
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
    
    $(document).on('click','.like-comment-btn',function(){

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


    $(document).on('click','.like-reply-btn',function(){

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

    $(document).on('click','#submitEditCommentForm',function(){

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
    $(document).on('click','#document-mark-btn',function(){
        var document_id = {!! $document_id !!};
        
        $(this).attr("disabled", 'disabled');
        $('#span-text').text('Đã theo dõi');

             $.ajax({
                url:'/theo-doi',
                type:"POST",
                data:{
                    'item_id': document_id,
                    'type_id':1
                }
            })
            .done(function(res) {
              
                Swal.fire({
                        icon: 'success',
                        title: `${res.success}`,
                        showConfirmButton: false,
                        timer: 2500
                    });      
            
                $('#totalMarking').text(res.totalMarking);
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