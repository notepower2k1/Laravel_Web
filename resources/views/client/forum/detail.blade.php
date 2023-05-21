@extends('client/forum.layouts.app')
@section('pageTitle', `{{$forum->name}}`)
@section('additional-style')
<link href="{{ asset('js/pagination/pagination.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('assets/css/infohelper.css') }}">

@endsection

@section('navbar-Footer')
<div class="card card-bordered shadow">
    <nav class="ms-4">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dien-dan">Diễn đàn</a></li>
            <li class="breadcrumb-item active"><span class="text-dark fw-bold">{{ $forum->name }}</span></li>
        </ul>
    </nav>
    <div class="card-inner">   
        <div class="nk-block-head nk-block-head-sm">
           
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">{{ $forum->name }}</h3>
                    <div class="nk-block-des text-soft">
                        <p>Số bài viết: {{$forum->numberOfPosts}}</p>
                    </div>
                </div><!-- .nk-block-head-content -->
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                {{-- <li>
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
                                </li> --}}
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
                                                
                                                <li class="divider"></li>

                                                <li>
                                                    <div class="filter-box p-2">
                                                        <div class="form-group">
                                                            <span>Lọc theo ngày thêm</span>
                                                            <div class="form-control-wrap">
                                                                <div class="input-daterange date-picker-range input-group">  
                                                                    @if(isset($fromDate))                                                                  
                                                                    <input type="text" class="form-control" name="from-date" value="{{ $fromDate }}"/>
                                                                    @else
                                                                    <input type="text" class="form-control" name="from-date"/>
                                                                    @endif
                                                                    <div class="input-group-addon">
                                                                      <em class="icon ni ni-arrow-long-right"></em>
                                                                    </div>       
                                                                    @if(isset($toDate))             
                                                                    <input type="text" class="form-control" name="to-date" value="{{ $toDate }}"/>
                                                                    @else
                                                                    <input type="text" class="form-control" name="to-date"/>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="button-box d-flex flex-row-reverse">
                                                            <button class="btn btn-warning" id="filter-btn">
                                                              <em class="icon ni ni-filter"></em>
                                                            </button>                                                                              
                                                        </div>
                                                      </div>

                                                </li>
                                                <li class="divider"></li>                                              
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                @if (Auth::check())
                                    @if($forum->status == 0)
                                    
                                    @else
                                        <li class="nk-block-tools-opt d-none d-sm-block">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalForm" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Thêm bài viết</span></a>
                                        </li>
                                        
                                        <li class="nk-block-tools-opt d-block d-sm-none">
                                            <a href="#" class="btn btn-icon btn-primary"><em class="icon ni ni-plus"></em></a>
                                        </li>
                                    @endif
                             
                                @endif
                            </ul>
                        </div>
                    </div><!-- .toggle-wrap -->
                </div><!-- .nk-block-head-content -->
            </div><!-- .nk-block-between -->
        </div>
    </div>
</div>
@endsection
@section('content')

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
     
        <div class="row g-gs">        
            <div class="col-lg-8 mb-2">
                
                <div class="col-md-12 d-flex justify-content-end mb-4">                          
                    <div id="pagination"></div>
                </div>
                <div class="data-container"></div>
                <div class="row g-gs" id="render-div">

                    @foreach ( $forums_posts as $post )
                    <div class="col-lg-12" id="post-{{ $post->id }}">
                        <div class="card card-bordered text-soft shadow">
                           <div class="p-2">
                                <div class="d-flex">
                                    <div class="">
                                            @if($post->firstImage)
                                            <div class="me-2">                                      

                                                <img src="{{ $post->firstImage }}" alt=""  class="rounded-circle" style="width:50px;height:50px">
                                            </div>
            
                                            @else
                                            <div class="nk-tnx-type-icon bg-info-dim text-info" style="width:50px;height:50px">                                      
                                                <em class="icon ni ni-chat-fill" style="font-size:30px"></em>                                    
                                            </div>
                                        @endif
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
                                                <dfn data-info="{{ $post->created_at }}">
                                                    <span class="badge badge-dim bg-success"><em class="icon ni ni-clock"></em><span>{{ $post->time }}</span></span>
                                                </dfn>

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
            {{-- <div class="col-lg-8 d-flex justify-content-end">                          

                {{ $forums_posts->links('vendor.pagination.custom',['elements' => $forums_posts]) }}
            </div> --}}
            
        </div>
    </div>    
</div>

@endsection 

@section('modal')
<div class="modal fade" id="modalForm" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm bài đăng</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                @if($errors->any())
                <div class="alert alert-warning">
                    @foreach ($errors->all() as $error)
                        <div class="">{{ $error }}</div>
                    @endforeach
    
                </div>
                @endif
                <form action="/bai-viet" method="POST" id="addForm">
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
                        <label class="form-label" for="content">Nội dung</label>
                        <div class="form-control-wrap">
                            <textarea name="content" class="form-control" id="mytextarea"></textarea>
                        </div>
                    </div>
                 
                    
                </form>
                <div class="form-group">
                    <button id="add-btn" class="btn btn-lg btn-primary">Thêm bài viết</button>
                </div>
            </div>
           
        </div>
    </div>
</div>
@endsection

@section('additional-scripts')
<script src="{{ asset('js/pagination/pagination.min.js') }}" ></script>

<script>

    

    
    $(function () {

        postRender();


        tinymce.init({
        entity_encoding : "raw",
        selector: '#mytextarea',
        branding: false,
        statusbar: false,
        height: 800,
        resize: false,
        menubar: false,
        plugins: [
            "advlist", "anchor", "autolink", "charmap", "code", "fullscreen", 
            "help", "image", "insertdatetime", "link", "lists", "media", 
            "preview", "searchreplace", "table", "visualblocks",
        ],
        toolbar: "undo redo |  bold italic underline strikethrough | link image | forecolor ",
        image_title: true,
        /* enable automatic uploads of images represented by blob or data URIs*/
        images_upload_url: '/upload',
        automatic_uploads: false,
        file_picker_types: 'image',
        /* and here's our custom image picker*/
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function () {
            var file = this.files[0]; 
            var reader = new FileReader();
            reader.onload = function () {
                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);

                /* call the callback and populate the Title field with the file name */
                cb(blobInfo.blobUri(), { title: file.name });
            };
            reader.readAsDataURL(file);
            };

            input.click();
        },
        content_style: 'body { font-size: 16px; font-family: Roboto; }' 
        });

    })


    
    $(document).on('click','#add-btn',function(){
        var content = tinymce.activeEditor.getContent("myTextarea");
        if(content){

        tinymce.activeEditor.uploadImages().then((response)=>{
        var update_content = tinymce.activeEditor.getContent("myTextarea");
            $('#addForm').submit();

        })
            
        }
        else{
        Swal.fire({
                icon: 'error',
                title: `Vui lòng điền nội dung`,
                showConfirmButton: false,
                timer: 2500
            });    
        }
    })

    $(document).on('click','.delete-btn',function(){
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
    
    function postRender(){
        const container = $('#pagination');


        if (!container.length) return;
            var sources = function () {
            var result = [];

            $('#render-div').children().each(function(item){

                result.push($(this).get(0).outerHTML);

            })
        return result;
        }();

        var options = {
            dataSource: sources,
            pageSize: 8,

            callback: function (response, pagination) {
                var dataHtml = '<div class="row g-gs">';

                $.each(response, function (index, item) {
                    dataHtml += item;
                });

                dataHtml += '</div>';

                container.parent().next().html(dataHtml);
                $('#render-div').remove();
            }
        };


  
        container.pagination(options);
    }

    function customFormatDate(date){
        const month = date.slice(0,2);
        const day = date.slice(3,5);
        const year = date.slice(6,10)
    
        return year+month+day;
    }

    $('#filter-btn').click(function() {
        
        const fromDate = $('.filter-box').find('input[type="text"][name="from-date"]').val();
        const toDate = $('.filter-box').find('input[type="text"][name="to-date"]').val();

        const forum_slug = @json($forum->slug);
        if(fromDate == '' || toDate == '') {
        Swal.fire({
            icon: 'error',
            title: `Không thể để trống!!!`,
            showConfirmButton: false,
            timer: 2500
        });
        }
        if(fromDate && toDate){
            window.location.href = `/dien-dan/${forum_slug}/all/${customFormatDate(fromDate)}/${customFormatDate(toDate)}`;
        }
        

    })


    
</script>

@endsection