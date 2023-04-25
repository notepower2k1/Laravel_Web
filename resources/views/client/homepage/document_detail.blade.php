@extends('client/homepage.layouts.app')
@section('pageTitle', `${{$document->name}}`)
@section('additional-style')
<style>
   .doc {
    width: 100%;
    height: 500px;
}
    .open-relies-btn:hover{
        cursor: pointer;
    }
    .delete-reply-btn,.create-reply-btn,.delete-comment-btn:hover{
        cursor: pointer;
    }
</style>  
@endsection
@section('content')

<div class="container">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="row">
                    <div class="card card-bordered">
                        <div class="card-inner">
                        
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mt-4">
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
                                        <div class="col-lg-6 d-flex align-items-end">
                                            <div class="product-info mb-5 me-xxl-5">
                                                    <h3 class="product-title">{{ $document->name }}
                                                    
                                                        @if(Auth::check())
            
                                                        <button type="button" class="btn btn-icon btn-lg ms-1" data-bs-toggle="modal" data-bs-target="#reportForm">
                                                            <em class="icon ni ni-alert" style="color:red"></em>
                                                        </button>
            
                                                        @endif
                                                    </h3>    
                                                
                                                
                                                <h6 class="title">Tác giả: 
                                                @foreach(explode(",",$document->author) as $author)                                                                       
                                                    <span class="badge rounded-pill bg-outline-success"><a class="text-success" href="/tac-gia/tac-gia-tai-lieu/{{ $author }}">{{ $author }}</a></span>
                                                @endforeach        
                                                </h6>                                              
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
                                                        
                                                        <li class="ms-n1">
                                                            @if(Auth::check())
                                                            <button class="btn btn-xl btn-primary" id="download-btn"><em class="icon ni ni-download"></em><span>Tải xuống</span></button>
                                                            @else
                                                            <a href="/login" class="btn btn-xl btn-primary"><em class="icon ni ni-download"></em><span>Tải xuống</span></a>
            
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
                                                <span id="total-comment-span" class="badge badge-dim bg-primary">{{ $document->totalComments }}</span> </span>
                                            </a>
                                        </li>   
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#tabItem8"><span>Xem trước</span>
                                                <span class="badge badge-dim bg-primary">{{ $previewImages->count() }}</span> </span>
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
                                                    <div class="card card-bordered">
                                                        <div class="card-inner-group">
                                                            <div class="card-inner">
                                                                <div class="user-card user-card-s2">
                                                                    <div class="user-avatar lg bg-primary">
                                                                        <img src="{{ $document->users->profile->url }}" alt="">
                                                                    </div>
                                                                    <div class="user-info">
                                                                        {{-- <div class="badge bg-light rounded-pill ucap">Platinam</div> --}}
                                                                        <h5>{{ $document->users->profile->displayName }}</h5>
                                                                        {{-- <span class="sub-text">info@softnio.com</span> --}}
                                                                    </div>
                                                                </div>
                                                            </div>                                                   
                                                            <div class="card-inner">
                                                                <div class="row text-center">
                                                                    <div class="col-6">
                                                                        <div class="profile-stats">
                                                                            <span class="amount">{{ $user_books->count() }}</span>
                                                                            <span class="sub-text">Số sách</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="profile-stats">
                                                                            <span class="amount">{{ $user_documents->count() }}</span>
                                                                            <span class="sub-text">Số tài liệu</span>
                                                                        </div>
                                                                    </div>                                                        
                                                                </div>
                                                            </div><!-- .card-inner -->
                                                            <div class="card-inner">
                                                                <div class="slider-init" data-slick='{"arrows": true, "dots": false, "slidesToShow": 1, "slidesToScroll": 1, "infinite":false, "responsive":[ {"breakpoint": 992,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}} ]}'>                                                               
                                                                    @foreach ( $user_books as $user_book)
                                                                        @if($loop->index <3)
                                                                            <div class="col">
                                                                                <div class="card card-bordered">
                                                                                    <img src="{{ $user_book->url }}" class="card-img-top" style="width:360px;height:300px">
                                                                                    <div class="card-inner">
                                                                                        <a href="/sach/{{ $user_book->id }}/{{ $user_book->slug }}" class="card-title text-dark fw-bold">{{ $user_book->name }}</a>
                                                                                        <p class="card-text">
                                                                                            <span class="badge bg-outline-primary">{{ $user_book->types->name }}</span>
        
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>     
                                                                        @endif 
                                                                    @endforeach
                                                                    @foreach ( $user_documents as $user_document)
                                                                        @if($loop->index <3)
                                                                            <div class="col">
                                                                                <div class="card card-bordered">
                                                                                    <img src="{{ $user_document->url }}" class="card-img-top" style="width:360px;height:300px">
                                                                                    <div class="card-inner">
                                                                                        <a href="/tai-lieu/{{ $user_document->id }}/{{ $user_document->slug }}" class="card-title text-dark fw-bold" >{{ $user_document->name }}</a>
                                                                                        <p class="card-text">
                                                                                            <span class="badge bg-outline-primary">{{ $user_document->types->name }}</span>
                                                                                        </p>
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
                                                        <h5>{{ $document->totalComments }} bình luận</h5>
                                                        <div class="list-group mt-3">
                                                            @if(Auth::check())
                    
                                                            <div class="d-flex">                                                     
                                                                <img class="rounded-circle shadow me-2" src="{{ Auth::user()->profile->url }}" width="100" id="comment_avatar">
    
                                                                <div class="nk-chat-editor border rounded-pill flex-grow-1 bg-light">
                                                                    <div class="nk-chat-editor-form">
                                                                        <div class="form-control-wrap">
                                                                            <textarea class="form-control form-control-simple no-resize bg-light textarea" id="comment_area" placeholder="Viết bình luận của bạn..."></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="nk-chat-editor-tools g-2">
                                                                        <li>
                                                                            <a href="#" class="btn btn-sm btn-icon btn-trigger text-primary"><em class="icon ni ni-happyf-fill"></em></a>
                                                                        </li>
                                                                        <li>
                                                                            <button class="btn btn-round btn-primary btn-icon" id="comment-btn"><em class="icon ni ni-send-alt"></em></button>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            @endif
                                                            @if ($comments)
                                                            <div id="comment-box">
                    
                                                                @foreach ($comments as $comment)
                                                                    <div id="comment-{{ $comment->id }}">
                                                                            <div class="d-flex flex-column comment-section">
                                                                                <div class="bg-white p-2">
                                                                                        <div class="d-flex user-info">
                                                                                            <img class="rounded-circle" src="{{ $comment->users->profile->url }}" width="60px">
                                                                                            <div class="">
                                                                                                <span class="d-block font-weight-bold name">{{ $comment->users->profile->displayName }}</span>
                                                                                                <div class="date text-black-50">
                                                                                                    <em class="icon ni ni-clock"></em>
                                                                                                    <span>{{ $comment->time }}</span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        
                                                                                    
                                                                                    
                                                                                    <div class="mt-2">
                                                                                        <p contenteditable="false" id="comment-text-{{ $comment->id }}">
                                                                                            {{ $comment->content }}
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                    
                                                                                
                                                                                    <div class="bg-white">
                                                                                        <div class="d-flex flex-row justify-content-between">
                                                                                            @if($comment->totalReplies > 0)
                                                                                                <div class="ms-2">
                                                                                                    <p class="open-relies-btn fw-bold" data-id="{{ $comment->id }}">Xem {{ $comment->totalReplies }} phản hồi</p>
                                                                                                </div>
                                                                                            @endif
                                                                                            @if(Auth::check())
                                                                                            <div class="ms-2">
                                                                                                <span class="create-reply-btn" data-id={{ $comment->id }}>
                                                                                                    <em class="icon ni ni-reply fs-16px me-2"></em>
                                                                                                </span>
                                                                                                @if(Auth::user()->id == $comment->users->id)
                            
                                                                                                <span class="delete-comment-btn" data-id={{ $comment->id }}>
                                                                                                    <em class="icon ni ni-trash fs-16px me-2 "></em>
                                                                                                </span>
    
                                                                                                <span class="report-comment-btn" data-id={{ $comment->id }} data-type=8 data-user="{{ $comment->users->profile->displayName  }}" data-bs-toggle="modal" data-bs-target="#reportFormComment">
                                                                                                    <em class="icon ni ni-flag fs-16px me-2 "></em>
                                                                                                </span>
                                                                                                
                                                                                                <div class="custom-control custom-checkbox custom-control-pro custom-control-pro-icon no-control">
                                                                                                    <input type="checkbox" class="custom-control-input edit-comment-btn" name="edit-comment-btn" id="edit-comment-btn-{{ $comment->id }}" value={{ $comment->id }}>
                                                                                                    <label class="" name="edit-comment-btn" for="edit-comment-btn-{{ $comment->id }}">
                                                                                                        <em class="icon ni ni-edit fs-16px"></em>
                                                                                                    </label>
                                                                                                </div>
                                                                                                
                                                                                                @endif
                                                                                            </div>
                                                                                            
                                                                                            @endif
                                                                                        </div>
                                                                                        
                                                                                                
                                                                                        
                                                                                    </div>
                                                                                
                                                                            </div> 
                                                                            <hr>
                                                                            @foreach ($comment->replies as $reply)
                                                                            @if(is_null($reply->deleted_at))
                                                                            <div class="ms-5 replies-item replies-item-{{ $reply->commentID }}" id="reply-{{ $reply->id }}">
                                                                                <div class="d-flex flex-column comment-section">
                                                                                    <div class="bg-white p-2">
                                                                                        <div class="d-flex flex-row user-info"><img class="rounded-circle" src="{{ $reply->users->profile->url }}" width="40">
                                                                                            <div class="d-flex flex-column justify-content-start ms-2">
                                                                                                <span class="d-block font-weight-bold name">{{ $reply->users->profile->displayName }}</span>
                                                                                                <div class="date text-black-50">
                                                                                                    <em class="icon ni ni-clock"></em>
                                                                                                    <span>{{ $reply->time }}</span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="mt-2">
                                                                                            <p contenteditable="false" id="reply-text-{{ $reply->id }}">
                                                                                                {{ $reply->content }}
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                    
                                                                                    @if(Auth::check() && Auth::user()->id == $reply->users->id)
                    
                                                                                    <div class="ms-2">
                                                                                        <div class="d-flex flex-row">
                                                                                            <span class="delete-reply-btn" data-id={{ $reply->id }}>
                                                                                                <em class="icon ni ni-trash fs-16px me-2"></em>
                                                                                            </span>
                                                                                            <span class="report-comment-btn" data-id={{ $reply->id }} data-type=9 data-user="{{ $reply->users->profile->displayName  }}" data-bs-toggle="modal" data-bs-target="#reportFormComment">
                                                                                                <em class="icon ni ni-flag fs-16px me-2 "></em>
                                                                                            </span>
                                                                                            <div class="custom-control custom-checkbox custom-control-pro custom-control-pro-icon no-control">
                                                                                                <input type="checkbox" class="custom-control-input edit-reply-btn" name="edit-reply-btn" id="edit-reply-btn-{{ $reply->id }}" value={{ $reply->id }}>
                                                                                                <label class="" name="edit-reply-btn" for="edit-reply-btn-{{ $reply->id }}">
                                                                                                    <em class="icon ni ni-edit fs-16px">
                                                                                                    </em>
                                                                                                    </label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    @endif
                                                                                </div> 
                                                                                <hr>
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
                                    @foreach ($documentsWithSameType as $documentWithSameType)
                                        <div class="col" >
                                            <div class="card card-bordered product-card shadow">
                                                <div class="product-thumb">                                  
                                                    <img class="card-img-top" src="{{ $documentWithSameType->url }}" alt=""  width="300px" height="350px">          
                                                    <div class="product-actions book_sameType h-100 w-100">
                                                        <div class="pricing-body d-flex text-center align-items-center w-100 h-100">   
                                                            <div class="row">
                                                                <div class="pricing-amount">
                                                                    <h6 class="text-white">{{ $documentWithSameType->name }}</h6>
                                                                    <p class="text-white">Tác giả: {{ $documentWithSameType->author }}</p>
                                                                    <p class="text-white">Số trang: {{ $documentWithSameType->numberOfPages }}</p>
                                                                </div>
                                                                <div class="pricing-action">
                                                                    <a href="/tai-lieu/{{$documentWithSameType->id}}/{{$documentWithSameType->slug}}" class="btn btn-outline-light">Chi tiết</a>
                                                                </div>
                                                            </div>                                        
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            
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

        </div>
    </div>
</div>

<div class="modal fade" id="reportFormComment" style="display: none;" aria-hidden="true">
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
                        <label class="form-label" for="description">Lý do</label>
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

@endsection
@section('additional-scripts')
<script src="{{ asset('js/ViewerJS/viewer.js') }}"></script>
<script>
    
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    
    $(function () {
        $('#comment-btn').attr('disabled', true);
        $('.replies-item').css('display', 'none');

    })

    


    $("#download-btn").click(function(e){  

        const id = {!! $document->id !!};

        const file = @json($document->file);
        window.location.href = `/tai-lieu/download/${file}/${id}`;
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
                                form.find('#close-btn').click();
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

    $(document).on('click','.open-relies-btn',function() {

    const comment_id = $(this).data('id');

    $(`.replies-item-${comment_id}`).fadeToggle();
    });

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

                $("#tabItem7").load(" #tabItem7 > *");
                $("#total-comment-span").load(" #total-comment-span > *");
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
                    .done(function() {
                    // If successful
                    Swal.fire({
                            icon: 'success',
                            title: `Xóa thành công`,
                            showConfirmButton: false,
                            timer: 2500
                    });

                    $("#comment-" + comment_id).fadeOut();
                    $("#tabItem7").load(" #tabItem7 > *");
                    $("#total-comment-span").load(" #total-comment-span > *");

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
                    $("#tabItem7").load(" #tabItem7 > *");
                    $("#total-comment-span").load(" #total-comment-span > *")

                   
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
        `<div class="nk-chat-editor border rounded-pill bg-light" id="reply-box">
                <div class="nk-chat-editor-form">
                    <div class="form-control-wrap">
                        <textarea class="form-control form-control-simple no-resize bg-light" id="reply_area" placeholder="Viết phản hồi của bạn..."></textarea>
                    </div>
                </div>
                <ul class="nk-chat-editor-tools g-2">
                    <li>
                        <a href="#" class="btn btn-sm btn-icon btn-trigger text-primary"><em class="icon ni ni-happyf-fill"></em></a>
                    </li>
                    <li>
                        <button class="btn btn-round btn-primary btn-icon" id="reply-btn" data-id=${comment_id}><em class="icon ni ni-send-alt"></em></button>
                    </li>
                </ul>
        </div>`;
       

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

                }
            })
            .done(function(res) {
 
                Swal.fire({
                        icon: 'success',
                        title: `${res.success}`,
                        showConfirmButton: false,
                        timer: 2500
                    });      

                $("#tabItem7").load(" #tabItem7 > *");
                $("#total-comment-span").load(" #total-comment-span > *")

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

                    }
                })
                .done(function(res) {
    
                    Swal.fire({
                            icon: 'success',
                            title: `${res.success}`,
                            showConfirmButton: false,
                            timer: 2500
                        });      

                    $("#tabItem7").load(" #tabItem7 > *");
                    $("#total-comment-span").load(" #total-comment-span > *")

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

                $("#tabItem7").load(" #tabItem7 > *");
                $("#total-comment-span").load(" #total-comment-span > *")

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
                    }
                })
                .done(function(res) {
    
                    Swal.fire({
                            icon: 'success',
                            title: `${res.success}`,
                            showConfirmButton: false,
                            timer: 2500
                        });      

                    $("#tabItem7").load(" #tabItem7 > *");
                    $("#total-comment-span").load(" #total-comment-span > *")

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

                $("#tabItem7").load(" #tabItem7 > *");
                $("#total-comment-span").load(" #total-comment-span > *")

            }
        }

    })
</script>
@endsection