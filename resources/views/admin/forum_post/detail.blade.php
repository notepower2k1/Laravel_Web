@extends('admin/layouts.app')
@section('pageTitle', 'Chi tiết bài đăng')



@section('content')

<div class="nk-block-head-sub"><a class="back-to" href="{{ url()->previous() }}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>



<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="nk-block">
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
        
                    
                    </div>
                </div>
        
            </div>
        </div>
    </div>
 
</div>
@endsection