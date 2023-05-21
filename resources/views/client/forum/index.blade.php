@extends('client/forum.layouts.app')
@section('pageTitle', 'Diễn đàn')

@section('content')
<div class="nk-block nk-block-lg">
    <div class="row g-gs">
        <div class="col-lg-8">
            <div class="row g-gs">
                @foreach ( $forums as $forum )
                <div class="col-lg-12">
                    <div class="card card-bordered text-soft shadow">
                        <div class="p-2">
                                <div class="d-flex">
                                    
                                    @if($forum->status == 0)
                                    <div class="nk-tnx-type-icon bg-danger-dim text-danger" style="width:50px;height:50px">                                      
                                            <em class="icon ni ni-folders-fill" style="font-size:30px"></em>                                    
                                    </div>
                                    @else
                                    <div class="nk-tnx-type-icon bg-success-dim text-success" style="width:50px;height:50px">                                      
                                        <em class="icon ni ni-folders-fill" style="font-size:30px"></em>                                    
                                    </div>
                                    @endif
                                    <div class="flex-grow-1 ">
                                        <div class="d-flex flex-column">
                                            <a class="title text-dark fw-bold" href="/dien-dan/{{ $forum->slug }}">
                                                {{ $forum->name }}
                                    
                                            </a>
                                            <p>{{ $forum->description }}</p>
                                            <div class="d-flex justify-between">
                                                <p>{{ $forum->numberOfPosts	 }} bài viết</p>
                                                @foreach ($forum->forumPosts as $posts)
                                                    @if($loop->last)
                                                    <p>Bài viết mới nhất: <span class="fw-bold">{{ $posts->topic }}</span> </p>
                                                    @endif
                                                @endforeach
                                                <p>{{ $forum -> created_at->format('d/m/Y') }}</p>
                                            </div>
                                      
                                        </div>
                                </div>
                            
                        </div>
                            
                        </div>
                    </div>
                </div><!-- .col -->
                @endforeach
            
             
            </div><!-- .row -->
        </div>  
        <div class="col-lg-4">
            <div class="card card-bordered card-full shadow">
                <div class="card-inner border-bottom">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title">Bài viết mới nhất</h6>
                        </div>
                       
                    </div>
                </div>
                <ul class="nk-activity">
                    @foreach ($lastPosts as $lastPost)
                    <li class="nk-activity-item">
                        <div class="">
                            @if($lastPost->firstImage)
                                <div class="me-2">                                      

                                    <img src="{{ $lastPost->firstImage }}" alt=""  class="rounded-circle" style="width:50px;height:50px">
                                </div>

                                @else
                                <div class="nk-tnx-type-icon bg-info-dim text-info" style="width:50px;height:50px">                                      
                                    <em class="icon ni ni-chat-fill" style="font-size:30px"></em>                                    
                                </div>
                            @endif
                        </div>
                        <div class="nk-activity-data">
                            <div class="label">
                                <a class="title text-dark fw-bold" href="/dien-dan/{{ $lastPost->forums->slug }}/{{ $lastPost->slug }}/{{ $lastPost->id }}">{{ $lastPost->topic }}</a>
                            </div>                            
                            <span class="time">{{ $lastPost->time }}</span>
                        </div>
                    </li>
                    @endforeach
                  
                 
                </ul>
            </div><!-- .card -->
        </div>
    </div>
</div>
@endsection
@section('additional-scripts')

<script>


</script>

@endsection

