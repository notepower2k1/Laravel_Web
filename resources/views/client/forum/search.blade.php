@extends('client/forum.layouts.app')
@section('pageTitle', `Tìm kiếm`)

@section('navbar-Footer')
<div class="card card-bordered shadow">
    <nav class="ms-4">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dien-dan">Diễn đàn</a></li>
            <li class="breadcrumb-item active"><span class="text-dark fw-bold">Tìm kiếm</span></li>
        </ul>
    </nav>
    <div class="card-inner">   
        <div class="nk-block-head nk-block-head-sm">
           
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Tìm kiếm kết quả cho '{{ $topic }}'</h3>   
                    <div class="nk-block-des text-soft">
                        <p>Kết quả tìm được {{$total}} bài viết</p>
                    </div>           
                </div><!-- .nk-block-head-content -->
             
            </div><!-- .nk-block-between -->
        </div>
    </div>
</div>
@endsection
@section('content')

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
     
        <div class="row">        
            <div class="col-lg-8">
                <div class="row g-gs">
                    @foreach ( $forums_posts as $post )
                    <div class="col-lg-12" id="post-{{ $post->id }}">
                        <div class="card card-bordered text-soft">
                           <div class="p-2">
                                <div class="d-flex">
                                    <div class="">
                                        <div class="nk-tnx-type-icon bg-success-dim text-success">                                      
                                            <em class="icon ni ni-folders-fill"></em>                                    
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">                                
                                            <div class="forum-topic d-flex justify-between mb-2">
                                                <a class="text-dark fw-bold" href="/dien-dan/{{ $post->forums->slug }}/{{ $post->slug }}/{{ $post->id }}">{{$post->topic }}</a>

                                                @if (Auth::check() && Auth::user()->id === $post->users->id)
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger mt-n1 me-n1" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="/cap-nhat-bai-viet/{{ $post->forums->slug }}/{{ $post->id }}"><em class="icon ni ni-edit"></em><span>Chỉnh sửa bài viết</span></a></li>
                                                            <li><a href="#" data-id={{ $post->id }} class="delete-btn"><em class="icon ni ni-check-round-cut"></em><span>Xóa bài viết</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>  
                                                @endif
                                            </div>
                                        
                                            <div class="d-flex justify-between">
                                                <span class="badge badge-dim bg-azure-dim text-azure"><em class="icon ni ni-user"></em><span>{{ $post->users->profile->displayName }}</span></span>
                                                <span class="badge badge-dim bg-info"><em class="icon ni ni-comments"></em><span>{{ $post->totalComments }}</span></span>
                                                <span class="badge badge-dim bg-success" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $post->created_at }}"><em class="icon ni ni-clock"></em><span>{{ $post->time }}</span></span>
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
                            <div class="nk-tnx-type-icon bg-info-dim text-info">                                      
                                <em class="icon ni ni-chat-fill"></em>                                    
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
</div>

@endsection 



@section('additional-scripts')
<script>
    
    $('.delete-btn').click(function(){
        var forum_post_id = $(this).attr('data-id');
        
        Swal.fire({
        title: "Bạn muốn bài đăng",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa bài đăng',
        cancelButtonText: 'Không'
        }).then((result) => {
        if (result.isConfirmed) {
            console.log(forum_post_id);

        $.ajax({
                type:"GET",
                url:'/xoa-bai-viet',
                data: {
                    'post_id':forum_post_id
                }
                })
                .done(function(res) {
                // If successful

                var result = res.message;
                // console.log(res.message);
                $(`#post-${forum_post_id}`).hide( "slow", function() {
                    Swal.fire({
                    icon: 'success',
                    title: `${result}`,
                    showConfirmButton: false,
                    timer: 2500
                    });
                })
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
            })
         
        }
      })

      

       
    })
    
</script>

@endsection