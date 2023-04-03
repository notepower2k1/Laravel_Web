@extends('client/layouts.app')
@section('pageTitle', `{{$forum->name}}`)
@section('content')
<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Bài viết</h3>
                    <div class="nk-block-des text-soft">
                        <p>Số bài viết: {{$forum->numberOfPosts}}</p>
                    </div>
                </div><!-- .nk-block-head-content -->
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li>
                                    <div class="drodown">
                                        <a href="#" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Lọc bài viết</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="/dien-dan/{{ $forum->slug }}"><span>Mặc định</span></a></li>
                                                <li><a href="/dien-dan/{{ $forum->slug }}/all/luot-binh-luan-nhieu-nhat"><span>Lượt bình luận nhiều nhất</span></a></li>
                                                <li><a href="/dien-dan/{{ $forum->slug }}/all/bai-dang-cu-nhat"><span>Bài đăng cũ nhất</span></a></li>

                                                @if (Auth::check())
                                                <li><a href="/dien-dan/{{ $forum->slug }}/all/bai-dang-cua-ban"><span>Bài đăng của bạn</span></a></li>

                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li class="nk-block-tools-opt d-none d-sm-block">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalForm" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Thêm bài viết</span></a>
                                </li>
                                <li class="nk-block-tools-opt d-block d-sm-none">
                                    <a href="#" class="btn btn-icon btn-primary"><em class="icon ni ni-plus"></em></a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- .toggle-wrap -->
                </div><!-- .nk-block-head-content -->
            </div><!-- .nk-block-between -->
        </div>
        <div class="row">
            <div class="col-lg-8">
    
                <div class="row g-gs">
                @foreach ( $forums_posts as $post)
                <div class="col-sm-6 col-xl-4" id="post-{{ $post->id }}">
                    <div class="card card-bordered h-100">
                        <div class="card-inner">
                            <div class="project">
                                <div class="project-head">
                                    <a href="/thanh-vien/{{ $post->users->id }}" class="project-title">
                                        <div class="user-avatar sq bg-purple">
                                            <img src={{ $post->users->profile->url }} alt="image" />
                                        </div>
                                        <div class="project-info">
                                            <h6 class="title">
                                                {{ $post->users->profile->displayName }}
                                            </h6>
                                            <span class="sub-text">
                                                @if ($post->users->role == 1)
                                                    Quản trị viên
                                                @else
                                                    Thành viên
                                                @endif
                                            </span>
                                        </div>
                                    </a>
    
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
                                <div class="project-details">
                                    <a href="/dien-dan/{{ $post->forums->slug }}/{{ $post->slug }}/{{ $post->id }}">{{$post->topic }}</a>
                                </div>
                                <div class="project-meta">
                                    <span class="badge badge-dim bg-info"><em class="icon ni ni-comments"></em><span>{{ $post->totalComments }}</span></span>
    
                                    <span class="badge badge-dim bg-success"><em class="icon ni ni-clock"></em><span>{{ $post->time }}</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                
                @endforeach
                <div class="col-md-12">                          

                    {{ $forums_posts->links('vendor.pagination.custom',['elements' => $forums_posts]) }}
                </div>
                </div>
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
</div>

@endsection 

@section('modal')
<div class="modal fade" id="modalForm" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa bài đăng</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="/bai-viet" method="POST" enctype="multipart/form-data">
                    @csrf                     

                    <input type="hidden"
                    name="forum_slug"
                    value="{{ $forum->slug }}">

                    <input type="hidden"
                    name="forum_id"
                    value="{{ $forum->id }}">


                    <div class="form-group">
                        <label class="form-label" for="topic">Chủ đề</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" name="topic" required="">
                        </div>
                    </div>

                 

                    <div class="form-group">
                        <label class="form-label" for="image">Ảnh đại diện</label>
                        <div class="form-control-wrap">
                            <input type="file" class="form-control" required accept="image/*" 
                            name="image">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="content">Nội dung</label>
                        <div class="form-control-wrap">
                            <textarea name="content" class="form-control" id="mytextarea"></textarea>
                        </div>
                    </div>
                 
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-primary">Thêm bài viết</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <span class="sub-text">Modal Footer Text</span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional-scripts')
<script>
    

    
    tinymce.init({
        entity_encoding : "raw",
        selector: '#mytextarea',
        branding: false,
        statusbar: false,
        height: 500,
        resize: false,
        menubar: false,
        plugins: [
            "advlist", "anchor", "autolink", "charmap", "code", "fullscreen", 
            "help", "image", "insertdatetime", "link", "lists", "media", 
            "preview", "searchreplace", "table", "visualblocks", " wordcount",
        ],
        toolbar: "undo redo | styles | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | wordcount"
        
    })


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