@extends('client/homepage.layouts.app')
@section('pageTitle')
{{$chapter->books->name}}
@endsection
@section('additional-style')
<link href="{{ asset('js/pagination/pagination.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('assets/css/infohelper.css') }}">

<style>

@media (min-width: 1200px){
.container-xl, .container-lg, .container-md, .container-sm, .container {
    max-width: 1300px;
}
}

.btn2top .sticky-btn {
  position: fixed;
  bottom: 36px;
  right: 60px;
  background: dodgerblue;
  opacity: .6;
  border-radius: 50%;
  transition: all 0.9s ease;
}
.btn2top .sticky-btn img {
  width: 36px;
  height: 36px;
}

.btn2top a.sticky-btn {
  font-family: sans-serif;
  padding: 9px;
  display: block;
  transition: all 0.3s ease;
  color: #fff;
  text-decoration: none;
}
.btn2top a.sticky-btn:hover {
  color: yellow;
  cursor: pointer;
}

@media screen and (max-width: 768px) {
  .btn2top .sticky-btn {
    right: 21px;
    bottom: 21px;

  }  

}



.btn2contact .sticky-btn {
  position: fixed;
  bottom: -96px;
  left: 33px;
  background: #F9FBE7;
  padding: 12px;
  border-radius: 50%;
  transition: all 0.8s ease;
  bottom: 36px;

}
.btn2contact .sticky-btn:hover {
  cursor: pointer;

  background: rgba(255, 255, 255, 0.81);
  transform: translateY(-3px);
}
.btn2contact .sticky-btn img {
  width: 45px;

}


@media screen and (max-width: 768px) {
  .btn2contact .sticky-btn {
    bottom: 21px;

    left: 21px;
  } 
  .btn2contact .sticky-btn img {
    width: 36px;
  }
  
}
 
.nk-content{
  background-color:#e5e5e5 !important;
}

.delete-reply-btn,.create-reply-btn,.delete-comment-btn,.report-comment-btn,.like-reply-btn,.like-comment-btn,.edit-comment-btn:hover,.open-relies-btn:hover{
        cursor: pointer;
}
</style>
@endsection
@section('content')

<div>
  <div class="nk-block" id="content-box-detail">
    <div class="container">
    <div class="card card-bordered">
        
        <div class="">
            <div class="d-flex justify-content-between">
                <div class="p-2 ">
                    @if($previous)
                    <a href="{{ $previous->slug }}" class="btn btn-lg btn-outline-secondary">
                      <em class="icon ni ni-arrow-long-left"></em>
                      <span>Chương trước</span>
                      </a>
                    @else
                    <button class="btn btn-lg  btn-outline-secondary" disabled>
                      <em class="icon ni ni-arrow-long-left"></em>
                      <span>Chương trước</span>
              
                    </button>
                    @endif
                </div>
          
                <div class="p-2">
                   
                    <a href="/sach-noi/{{ $chapter->books->slug }}/{{  $chapter->slug }}" class="btn btn-lg btn-outline-secondary" >
                      <em class="icon ni ni-headphone"></em><span>Sách nói</span>
                    </a>
                  
                </div>
              <div class="p-2">
              
                @if($next)
                <a href="{{ $next->slug }}" class="btn btn-lg btn-outline-secondary">
                  <span>Chương sau</span>
                  <em class="icon ni ni-arrow-long-right"></em>
          
          
                </a>
                @else
                <button class="btn btn-lg  btn-outline-secondary" disabled>
                  <span>Chương sau</span>
                  <em class="icon ni ni-arrow-long-right"></em>
          
                </button>
                @endif
              </div>
            </div>
        </div>
      
        <div class="card-inner">
            
           
        
        
            <div class="title mb-2">
                @if($chapter->name)
                <h3 class="text-left">       
                {{$chapter->code}}: {{ $chapter->name }}
                </h3>
                @else
                <h3 class="text-left">       
                    {{$chapter->code}}
                </h3>
                @endif 
            </div>

            <div class="d-flex bg-light">
                <div class="p-2 flex-fill bg-light">
                    <em class="icon ni ni-book"></em>
                    <a class="text-dark" href="/sach/{{$chapter->books->id  }}/{{ $chapter->books->slug  }}">{{ $chapter->books->name }}</a>
                </div>
                <div class="p-2 flex-fill bg-light">
                    <em class="icon ni ni-edit"></em>          
                    <a class="text-dark" href="/thanh-vien/{{ $chapter->books->users->id }}">{{ $chapter->books->users->profile->displayName }}</a>
                </div>
                <div class="p-2 flex-fill bg-light">
                    <em class="icon ni ni-text"></em>
                    <span>{{ $chapter->numberOfWords }} chữ</span>
                </div>
                <div class="p-2 flex-fill bg-light">
                    <em class="icon ni ni-clock"></em>          
                    <span>{{ $chapter->updated_at }}</span>
                </div>

                
            </div>
            <div class="border px-4 pt-3" id="divhtmlContent" style="font-size: 16px;line-height:30px">

                {!! clean($chapter->content) !!}

            </div>  

        
        </div>
    </div>
        
    <div class="card card-bordered rounded">
      <div class="">
          <div class="d-flex justify-content-between">
            <div class="p-2 ">
              @if($previous)
              <a href="{{ $previous->slug }}" class="btn btn-lg btn-outline-secondary">
                <em class="icon ni ni-arrow-long-left"></em>
                <span>Chương trước</span>
                </a>
              @else
              <button class="btn btn-lg  btn-outline-secondary" disabled>
                <em class="icon ni ni-arrow-long-left"></em>
                <span>Chương trước</span>
        
              </button>
              @endif
            </div>
        

            <div id="report-render-div" class="d-flex align-items-center">
                    @if(Auth::check())
            
                    @if($reportChapter)
                        @if($reportChapter->isEnabled)
                            <button type="button" class="btn btn-lg btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#reportForm">
                                <em class="icon ni ni-flag" ></em>
                            </button>
                        @else
    
                        <dfn data-info="Đã có người báo cáo">
                            <button type="button" class="btn btn-lg btn-outline-secondary" disabled>
                                <em class="icon ni ni-flag"></em>
                            </button>
                        </dfn>
                        
                        @endif
                    @else
                        <button type="button" class="btn btn-lg btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#reportForm">
                            <em class="icon ni ni-flag" ></em>
                        </button>
                    @endif
                
                
                @endif
            </div>
           
            <div class="p-2">
            
              @if($next)
              <a href="{{ $next->slug }}" class="btn btn-lg btn-outline-secondary">
                <span>Chương sau</span>
                <em class="icon ni ni-arrow-long-right"></em>
        
        
              </a>
              @else
              <button class="btn btn-lg  btn-outline-secondary" disabled>
                <span>Chương sau</span>
                <em class="icon ni ni-arrow-long-right"></em>
        
              </button>
              @endif
            </div>
          </div>
        </div>
      </div>
  
        
      <div class="card card-bordered rounded">
        <div class="p-3">
          <div class="row g-gs"> 
            
            @if(Auth::check())
            <div class="col-lg-8">
                <div class="product-details entry me-xxl-3">
                    <div class="d-flex justify-content-between">
                        <h5><span class="total-comment-span">{{ $chapter->books->totalComments }} </span>bình luận</h5>
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
                                                                        <dfn data-info="{{ $comment->created_at }}">

                                                                            <em class="icon ni ni-clock"></em>
                                                                            <span class="text-muted">{{ $comment->time }}</span>
                                                                        </dfn>
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
                                                                        <dfn data-info="{{ $reply->created_at }}">

                                                                            <em class="icon ni ni-clock"></em>
                                                                            <span class="text-muted">{{ $reply->time }}</span>
                                                                        </dfn>
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
                                                                            <span class="report-comment-btn" data-id={{ $reply->id }} data-type=7 data-user="{{ $reply->users->profile->displayName  }}" data-bs-toggle="modal" data-bs-target="#reportFormComment">
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

                                                                        <span class="report-comment-btn" data-id={{ $reply->id }} data-type=7 data-user="{{ $reply->users->profile->displayName  }}" data-bs-toggle="modal" data-bs-target="#reportFormComment">
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

            
            <div class="col-lg-4" style="background-color:#f7f5f0">
                <h5><span class="total-comment-span">Gợi ý cho bạn</h5>

                <div class="text-center">
                  <div class="slider-init" data-slick='{"arrows": false, "dots": false, "slidesToShow": 1, "slidesToScroll": 1, "infinite":false, "responsive":[ {"breakpoint": 992,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 2}} ]}'>
                    @foreach ($recommened_books as $book)
            
                    <div class="col">
                        
                        <div class="shine">
                            <img src="{{ $book->url }}" class="card-img-top shine" alt="" style="width:500px;height:400px">
    
                        </div>
                        <div class="info mt-2">
                            <h5 class="card-title">{{ $book->name }}</h5>
                            <p class="card-text">{{ Str::limit($book->description,100) }}</p>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted fs-13px"><em class="icon ni ni-user-list"></em><span>{{ $book->author }}</span></span>
                                
                                <a href="the-loai/the-loai-sach/{{$book->types->slug}}" class="fs-13px"><span class="badge badge-dim bg-outline-danger">{{$book->types->name }}</span></a>
    
    
                            </div>
                            <a href="/sach/{{$book->id}}/{{$book->slug}}" class="btn btn-danger rounded-pill mt-2 px-4 ">Đọc ngay</a>
                        </div>
                                
                            
                    </div>
                    @endforeach
                  </div>
                </div>
               
            </div>

            @else
            <div class="col-lg-12">
                <div class="product-details entry me-xxl-3">
                    <div class="d-flex justify-content-between">
                        <h5><span class="total-comment-span">{{ $chapter->books->totalComments }} </span>bình luận</h5>
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
                                                                        <dfn data-info="{{ $comment->created_at }}">

                                                                            <em class="icon ni ni-clock"></em>
                                                                            <span class="text-muted">{{ $comment->time }}</span>
                                                                        </dfn>
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
                                                                        <dfn data-info="{{ $reply->created_at }}">

                                                                            <em class="icon ni ni-clock"></em>
                                                                            <span class="text-muted">{{ $reply->time }}</span>
                                                                        </dfn>
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
                                                                            <span class="report-comment-btn" data-id={{ $reply->id }} data-type=7 data-user="{{ $reply->users->profile->displayName  }}" data-bs-toggle="modal" data-bs-target="#reportFormComment">
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

                                                                        <span class="report-comment-btn" data-id={{ $reply->id }} data-type=7 data-user="{{ $reply->users->profile->displayName  }}" data-bs-toggle="modal" data-bs-target="#reportFormComment">
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
            @endif
          </div><!-- .row -->
        </div>
       
      </div>
    </div>
  
    <div class="btn2top">
        <a class="sticky-btn">
        <img src="https://byjaris.com/code/icons/chevron-up.svg">
        </a>
    </div>
  
  
    <div class="btn2contact">
      <a target="blank" class="toggle sticky-btn" data-target="addProduct"> 
        <img src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/svg/config.png">
      </a>
    </div>
  </div>


  <div class="nk-add-product toggle-slide toggle-slide-right toggle-screen-any" data-content="addProduct" data-toggle-screen="any" data-toggle-overlay="true" data-toggle-body="true" data-simplebar="init">
      <div class="simplebar-wrapper" style="margin: -24px;">
          <div class="simplebar-height-auto-observer-wrapper">
            <div class="simplebar-height-auto-observer">
            </div>
          </div>
          <div class="simplebar-mask">
            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
              <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
                <div class="simplebar-content" style="padding: 24px;">
                  <div class="nk-block-head">
                      <div class="nk-block-head-content">
                        <div class="form-group">
                          <label class="form-label" for="product-title">Danh sách chương</label>
                          <div class="form-control-wrap">
                            <select class="form-control" id="change-chapter">
                              @foreach ($chapters as $item)
                              <option value="{{ $item->slug }}" {{ $item->id == $chapter->id ? 'selected' : '' }}>
                                
                                  <span>{{$item->code}}</span>
                                  
                              </option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                          
                        <h5 class="nk-block-title">Cài đặt hiển thị</h5>
  
                      </div>
                  </div><!-- .nk-block-head -->
                  <div class="nk-block">
                      <div class="row g-3">
                          <div class="col-12">
                              <div class="form-group">
                                  <label class="form-label" for="product-title">       
                                    <span>Màu nền
                                    </span>
                                    <em class="icon ni ni-color-palette"></em>
                                  </label>
                                  <div class="form-control-wrap">                  
                                    <ul class="custom-control-group g-1">
                                      <li>
                                          <div class="custom-control color-control border rounded-circle">
                                              <input type="radio" class="custom-control-input" id="productColor1" name="productColor">
                                              <label class="custom-control-label dot dot-xl" data-bg="#fff" for="productColor1" style="background:#fff"></label>
                                          </div>
                                      </li>
                                      <li>
                                          <div class="custom-control color-control border rounded-circle">
                                              <input type="radio" class="custom-control-input" id="productColor2" name="productColor">
                                              <label class="custom-control-label dot dot-xl" data-bg="#ddd" for="productColor2" style="background:#ddd"></label>
                                          </div>
                                      </li>
                                      <li>
                                          <div class="custom-control color-control border rounded-circle">
                                              <input type="radio" class="custom-control-input" id="productColor3" name="productColor">
                                              <label class="custom-control-label dot dot-xl" data-bg="#f4f4f4" for="productColor3" style="background:#f4f4f4"></label>
                                          </div>
                                      </li>
                                      <li>
                                          <div class="custom-control color-control border rounded-circle">
                                              <input type="radio" class="custom-control-input" id="productColor4" name="productColor">
                                              <label class="custom-control-label dot dot-xl" data-bg="#e9ebee" for="productColor4" style="background:#e9ebee"></label>
                                          </div>
                                      </li>
                                      <li>
                                          <div class="custom-control color-control border rounded-circle">
                                              <input type="radio" class="custom-control-input" id="productColor5" name="productColor">
                                              <label class="custom-control-label dot dot-xl" data-bg="#E1E4F2" for="productColor5" style="background:#E1E4F2"></label>
                                          </div>
                                      </li>
                                      <li>
                                          <div class="custom-control color-control border rounded-circle">
                                              <input type="radio" class="custom-control-input" id="productColor6" name="productColor">
                                              <label class="custom-control-label dot dot-xl" data-bg="#F4F4E4" for="productColor6" style="background:#F4F4E4"></label>
                                          </div>
                                      </li>
                                      <li>
                                          <div class="custom-control color-control border rounded-circle">
                                              <input type="radio" class="custom-control-input" id="productColor7" name="productColor">
                                              <label class="custom-control-label dot dot-xl" data-bg="#EAE4D3"  for="productColor7" style="background:#EAE4D3"></label>
                                          </div>
                                      </li>
                                      <li>
                                          <div class="custom-control color-control border rounded-circle">
                                              <input type="radio" class="custom-control-input" id="productColor8" name="productColor">
                                              <label class="custom-control-label dot dot-xl" data-bg="#FAFAC8" for="productColor8" style="background:#FAFAC8"></label>
                                          </div>
                                      </li>
                                      <li>
                                          <div class="custom-control color-control border rounded-circle">
                                              <input type="radio" class="custom-control-input" id="productColor9" name="productColor">
                                              <label class="custom-control-label dot dot-xl"  data-bg="#EFEFAB" for="productColor9" style="background:#EFEFAB"></label>
                                          </div>
                                      </li>
                                  
                                      <li>
                                        <div class="custom-control color-control border rounded-circle">
                                            <input type="radio" class="custom-control-input" id="productColor10" name="productColor">
                                            <label class="custom-control-label dot dot-xl" data-bg="#111111" for="productColor10" style="background:#111111"></label>
                                        </div>
                                      </li>
                                    </ul>
                                  </div>
                              </div>
                          </div>
                          <div class="col-12">
                              <div class="form-group">
                                  <label class="form-label" for="regular-price">
                                    <span>Font chữ
                                    </span>
                                    <em class="icon ni ni-text"></em>
                                  </label>
                                  <div class="form-control-wrap">
                                    <select class="form-control" id="change-font">
                                      <option value="Roboto" selected="selected">Mặc định</option>
                                      <option value="Segoe UI">Segoe UI</option>
                                      <option value="Palatino Linotype" >Palatino Linotype</option>
                                      <option value="Bookerly">Bookerly</option>
                                      <option value="Patrick Hand">Patrick Hand</option>
                                      <option value="Times New Roman">Times New Roman</option>
                                      <option value="Verdana">Verdana</option>
                                      <option value="Tahoma">Tahoma</option>
                                      <option value="Arial">Arial</option>
                                    </select>
                                  </div>
                              </div>
                          </div>
                          <div class="col-12">
                              <div class="form-group">
                                  <label class="form-label" for="sale-price">
                                    <span>Độ cao dòng
                                    </span>
                                    <em class="icon ni ni-view-x7"></em>
                                  </label>
                                  <div class="form-control-wrap">
                                    <select class="form-control" id="change-lineheight">
                                      <option value="30" selected="selected">Mặc định</option>
                                      <option value="40">40</option>
                                      <option value="50">50</option>
                                      <option value="60">60</option>
                                    </select>
                                  </div>
                              </div>
                          </div>
                          <div class="col-12">
                              <div class="form-group">
                                  <label class="form-label" for="stock">
                                    <span>Cỡ chữ
                                    </span>
                                    <em class="icon ni ni-text2"></em>
                                  </label>
                                  <div class="form-control-wrap number-spinner-wrap">
                                    {{-- <input type="hidden" class="fontsize" id="change-fontsize" value=16>
                                    <button type="button" class="btn btn-primary size-increment">Tăng</button>
                                    <button type="button" class="btn btn-info size-orig">Ban đầu</button>
                                    <button type="button" class="btn btn-secondary size-decrement">Giảm</button> --}}
                                    <button class="btn btn-icon btn-outline-light number-spinner-btn number-minus size-decrement" data-number="minus"><em class="icon ni ni-minus"></em></button>
                                    <input type="number" class="form-control number-spinner fontsize" value="16" id="change-fontsize" step="1" min="10" max="30">
                                    <button class="btn btn-icon btn-outline-light number-spinner-btn number-plus size-increment" data-number="plus"><em class="icon ni ni-plus"></em></button>
                                  </div>
                              </div>
                          </div>
                          {{-- <div class="col-12">
                              <div class="form-group">
                                  <label class="form-label" for="SKU">SKU</label>
                                  <div class="form-control-wrap">
                                      <input type="text" class="form-control" id="SKU">
                                  </div>
                              </div>
                          </div>
                      
                          <div class="col-12">
                              <div class="upload-zone small bg-lighter my-2 dropzone dz-clickable">
                                  <div class="dz-message">
                                      <span class="dz-message-text">Drag and drop file</span>
                                  </div>
                              </div>
                          </div> --}}
                          <div class="col-12">
                              <button class="btn btn-primary" id="save-setting"><em class="icon ni ni-plus"></em><span>Lưu cài đặt</span></button>
                          </div>
  
                          
                      </div>
                  </div><!-- .nk-block -->
                </div>
              </div>
            </div>
          </div>
      <div class="simplebar-placeholder" style="width: auto; height: 697px;"></div>
    </div>
    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
      <div class="simplebar-scrollbar" style="width: 0px; display: none;">
      </div>
    </div>
    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
      <div class="simplebar-scrollbar" style="height: 636px; display: block; transform: translate3d(0px, 0px, 0px);">
      </div>
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
                <h5 class="modal-title">Báo cáo chương</h5>
                <button id="close-btn" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-validate is-alter" novalidate="novalidate">
                    @csrf
                    <input type="hidden" class="form-control" id="type_id" name="type_id" value=2>
                    <input type="hidden" class="form-control" id="identifier_id" name="identifier_id" value={{ $chapter->id }}>

                    <div class="form-group">
                        <label class="form-label" for="chapter-code">Tên chương</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="chapter-code" required="" value='{{ $chapter->code }}' readonly>
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


<div class="modal fade" id="reportFormComment" style="display: none;" aria-hidden="true">
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


<div class="modal fade" id="editCommentForm" style="display: none;" aria-hidden="true">
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
@endif
@section('additional-scripts')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script src="{{ asset('assets/js/example-sweetalert.js?ver=3.1.2') }}" aria-hidden="true"></script>
<script src="{{ asset('assets/js/emojionearea.min.js') }}" aria-hidden="true"></script>
<script src="{{ asset('js/pagination/pagination.min.js') }}" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.4/moment-with-locales.js"></script>

<script>

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

  
    
    $(function() {
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

      $('#comment-btn').attr('disabled', true);
     
     

      
      $('.btn2top').on('click', function() {
          window.scrollTo({top: 0})
      });

        $(window).scroll(function(){
          var $this = $(window);


          if( $this.scrollTop() > ($('#content-box-detail').height() - 600) ) { 
            $('.sticky-btn').hide();


          }
          else{
            $('.sticky-btn').show();

          }
        
          

        
         

          });
          
          $('#change-chapter').select2({});

      const settingLog = window.localStorage.getItem('setting');
     
      if(settingLog){
        var setting = JSON.parse(settingLog);

        var color = setting.color;
        var font = setting.font;
        var lightheight = setting.lightheight;
        var textColor = setting.textColor;
        var currentFontSize = parseInt(setting.fontsize);

        // $(`#change-color option[value=${color}]`).attr('selected','selected');
        $(`label[data-bg='${color}']`).parent().addClass('checked');
        $(`label[data-bg='${color}']`).prev().attr('checked', true);


        $(`#change-font option[value='${font}']`).attr('selected','selected');
        $(`#change-lineheight option[value=${lightheight}]`).attr('selected','selected');

        $("#divhtmlContent").css("background-color",color);
        $("#divhtmlContent").css("color",textColor);

        $("#divhtmlContent").css("font-family",font);
        $("#divhtmlContent").css("line-height",lightheight+'px');
        $("#divhtmlContent").css("font-size",currentFontSize+'px');
        $(".fontsize").val(currentFontSize);
      }
      else{
        $(`label[data-bg='#fff']`).prev().attr('checked', true);

      }

   
      const current_book_id = {!! $chapter->books->id !!}
      var current_chapter_id =  {!! $chapter->id !!}

      var readingLog = window.localStorage.getItem('readingLog');

      var log = JSON.parse(readingLog);


      //update cookie
      if(log){             
          objIndex = log.findIndex((obj => obj.book_id === current_book_id));
          //book exist

          if(objIndex > -1){
            
                const now = moment().format('llll');
                var chapterList = log[objIndex].chapterList;



                var chapterIndex = chapterList.findIndex(e => e.chapter_id === current_chapter_id);

                if(chapterIndex > -1){
                    chapterList[chapterIndex].time = now;
                    window.localStorage.setItem('readingLog',JSON.stringify(log));
                }
                else{
                    const logObject = {
                        "chapter_id":current_chapter_id,
                        "time":now
                    }

                    const updateChapterList = [...chapterList,logObject]
                    log[objIndex].chapterList = updateChapterList;

                    window.localStorage.setItem('readingLog',JSON.stringify(log));
                }    
          }
          //book not exist
          else{

            const time = moment().format('llll');
            const logObject = {
                "chapter_id":current_chapter_id,
                "time":time
            }
            var chapterList = [];
            chapterList.push(logObject)

            var reading_object = {
                'book_id' : current_book_id,
                'chapterList' : chapterList        
            };            
       
            const updateLog = [...log,reading_object]
            window.localStorage.setItem('readingLog',JSON.stringify(updateLog));
          }        
      }
      //create new cookie
      else{

        const time = moment().format('llll');
        const logObject = {
            "chapter_id":current_chapter_id,
            "time":time
        }
        var chapterList = [];
        chapterList.push(logObject)
        var reading_object = {
        'book_id' : current_book_id,
        'chapterList' : chapterList        
        };            
        var reading_log = [];
        reading_log.push(reading_object);
        window.localStorage.setItem('readingLog',JSON.stringify(reading_log));

      }

      
    });

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
        
        var book_id = {!! $chapter->books->id !!};

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

    $(document).on('click','.open-relies-btn',function() {
      const comment_id = $(this).data('id');

      $(`.replies-item-${comment_id}`).fadeToggle();
    });

    $('#save-setting').click(function(){


      window.localStorage.removeItem("setting");

      var color = $('.color-control.checked').find('label').data('bg');
      var font = $('#change-font').val();
      var lightheight = $('#change-lineheight').val();
      var currentFontSize = $(".fontsize").val();

      var textColor = '#526484'
      if(color === '#111111'){
          textColor = 'white'
      }
      var setting ={
        'color':color,
        'font':font,
        'lightheight':lightheight,
        'fontsize':currentFontSize,
        'textColor': textColor
      }
      // createCookie('setting',setting);
      window.localStorage.setItem("setting", JSON.stringify(setting));

      Swal.fire({
                        icon: 'success',
                        title: `Lưu cài đặt thành công!!!`,
                        showConfirmButton: false,
                        timer: 2500
          })


    })

    $('.color-control').change(function(){

      var color = $(this).find('label').data('bg');

      if(color === '#111111'){
        $("#divhtmlContent").css("background-color",color);
        $("#divhtmlContent").css("color",'white');

      }
      else{
        $("#divhtmlContent").css("background-color",color);
        $("#divhtmlContent").css("color",'#526484');

      }

    })


    $("#change-font").change(function(){ //2 step
      var font = $(this).val();
      $("#divhtmlContent").css("font-family",font);
    });


    $("#change-lineheight").change(function(){ //2 step
      var lightheight = $(this).val();
      $("#divhtmlContent").css("line-height",lightheight+'px');
    });

    $("#change-chapter").change(function(){ //2 step
      var chapter_slug = $(this).val();  


      var chapter_id = $(this).find('option:selected').data('id')


      $(location).prop('href', chapter_slug);
    });


    $(".size-increment").on("click", function(){
        var currentFontSize = parseInt($(".fontsize").val());

        if(currentFontSize === 30){
          Swal.fire({
                      icon: 'info',
                      title: `Không thể tăng cỡ chữ`,
                      showConfirmButton: false,
                      timer: 2500
        })
      }
        else{
          $("#divhtmlContent").css("font-size",(currentFontSize + 1) +'px');
        }

    

    })

    $(".size-orig").on("click", function(){
        $("#divhtmlContent").css("font-size",'16px');
        $(".fontsize").val(16);

    })

    $(".size-decrement").on("click", function(){
        var currentFontSize = parseInt($(".fontsize").val());

        if(currentFontSize === 10){
          Swal.fire({
                      icon: 'info',
                      title: `Không thể giảm cỡ chữ`,
                      showConfirmButton: false,
                      timer: 2500
        });
        }
        else{
          $("#divhtmlContent").css("font-size",(currentFontSize - 1) +'px');
        }
      

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
                                $('#close-btn').click();
                            }, 2500);
                            $("#report-render-div").load(" #report-render-div > *");

                            
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