@extends('client/layouts.app')
@section('pageTitle', 'Diễn đàn')
@section('content')
<div class="nk-block nk-block-lg">
    <div class="row">
        <div class="col-lg-8">
            <div class="row g-gs">
                @foreach ( $forums as $forum )
                <div class="col-lg-12">
                    <a class="card card-bordered text-soft">
                        <div class="p-2">
                                <div class="row g-gs">
                                    <div class="col-1">
                                        <div class="nk-tnx-type-icon bg-success-dim text-success">                                      
                                                <em class="icon ni ni-folders-fill"></em>                                    
                                        </div>
                                    </div>
                                    <div class="col-11 ps-0">
                                        <div class="d-flex flex-column">
                                            <h6 class="title" data-slug ={{ $forum->slug }}>
                                                {{ $forum->name }}
                                    
                                            </h6>
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
                    </a>
                </div><!-- .col -->
                @endforeach
            
             
            </div><!-- .row -->
        </div>  
        <div class="col-lg-4">
            <div class="card card-bordered card-full">
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
                        <div class="nk-activity-media user-avatar bg-success">
                            <a href="/thanh-vien/{{ $lastPost->users->id }}"><img src={{ $lastPost->users->profile->url }} alt="image" /></a>
                        </div>
                        <div class="nk-activity-data">
                            <div class="label">
                                <a href="/dien-dan/{{ $lastPost->forums->slug }}/{{ $lastPost->slug }}/{{ $lastPost->id }}">{{ $lastPost->topic }}</a>
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

$('.title').hover(
    
    function () {
        $(this).css('cursor','pointer');
    }, 
     
    function () {
        $(this).css('cursor','normal');
    }
 );
 
    $('.title').click(function(){

        var slug = $(this).attr('data-slug');

        window.location.href="/dien-dan/" + slug;

    })
</script>

@endsection

