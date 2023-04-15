@extends('client/manage.layouts.app')
@section('content')

<div class="nk-fmg-body">
    <div class="nk-fmg-body-head d-none d-lg-flex">
       
        <div class="nk-fmg-actions">
            <ul class="nk-block-tools g-3">
                <li>
                    <div class="dropdown">
                        <a href="/them-tai-lieu" class="btn btn-light"><em class="icon ni ni-plus"></em> <span>Thêm tài liệu</span></a>                     
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="nk-fmg-body-content">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between position-relative">
               
                <div class="nk-block-head-content">
                    <ul class="nk-block-tools g-1">
                        
                        <li class="d-lg-none">
                            <div class="dropdown">
                                <a href="/them-tai-lieu" class="btn btn-trigger btn-icon"><em class="icon ni ni-plus"></em></a>                          
                            </div>
                        </li>
                        <li class="d-lg-none me-n1"><a href="#" class="btn btn-trigger btn-icon toggle" data-target="files-aside"><em class="icon ni ni-menu-alt-r"></em></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="nk-fmg-quick-list nk-block">  
            <div class="nk-block-head-xs">
                <div class="nk-block-between g-2">
                    <div class="nk-block-head-content">
                        <h6 class="nk-block-title title">Tài liệu đang duyệt</h6>
                    </div>
                    <div class="nk-block-head-content">
                        <a href="#" class="link link-primary toggle-opt active" data-target="quick-access">
                            <div class="inactive-text">
                                <button class="btn btn-small btn-outline-primary">
                                    <em class="icon ni ni-eye"></em>
                                </button>
                            </div>
                            <div class="active-text">
                                <button class="btn btn-small btn-outline-primary">
                                <em class="icon ni ni-eye-off"></em>
                                </button>

                            </div>
                        </a>
                    </div>
                </div>
            </div><!-- .nk-block-head -->            
            <div class="toggle-expand-content expanded" data-content="quick-access">
                <div class="card card-bordered card-preview">
                    <div class="card-inner">
                        <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false" data-export-title="Export">
                            <thead>
                                <tr class="nk-tb-item nk-tb-head">                                 
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ảnh đại diện</span></th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Tiêu đề</span></th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Tác giả</span></th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Danh mục</span></th>
                                    <th class="nk-tb-col tb-col-mb"><span class="sub-text">Tình trạng</span></th>
                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">Ngày thêm</span></th>

                                    {{-- <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ngày thêm</span></th> --}}
                                 

                                    <th class="nk-tb-col nk-tb-col-tools text-end">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($books as $book)
                                <tr class="nk-tb-item" id ="row-book-{{ $book->id }}">                                                                      
                                    <td class="nk-tb-col tb-col-lg">
                                        <img class="image-fluid" src={{$book->url}} alt="..." style="width:100px" />
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">                                           
                                            <div class="user-info">
                                                <span class="tb-lead">{{ Str::limit($book->name,30) }}<span class="dot dot-success d-md-none ms-1"></span></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        <span>{{  $book->author }}</span>
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        <span>{{ $book->types->name }}</span>

                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        @if ($book->status == 0)
                                        <span class="text-success">Đang duyệt</span>
                                        @endif 

                                        @if ($book->status == -1)
                                        <span class="text-danger">Từ chối</span>
                                        @endif 
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                    <span>{{ $book->created_at }}</span>
                                    </td>
                                    <td class="nk-tb-col nk-tb-col-tools">
                                        <ul class="nk-tb-actions gx-1">                                                
                                            <li>
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="/quan-ly/sach/{{ $book->id }}">
                                                            <em class="icon ni ni-eye"></em><span>Thông tin chi tiết</span>
                                                            </a>
                                                            </li>
                                                            <li>
                                                            @if($book->status == -1)

                                                            <a href="#" class="delete-button" data-id="{{ $book->id }}" data-name="{{ $book->name }}" data-option="1">
                                                                <em class="icon ni ni-trash"></em><span>Xóa</span>
                                                              </a>
                                                            </li>
                                                            @endif

                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </td>
                                </tr><!-- .nk-tb-item  -->
                            @endforeach
                            @foreach ($documents as $document)
                                <tr class="nk-tb-item" id ="row-document-{{ $document->id }}">                                                                    
                                    <td class="nk-tb-col tb-col-lg">
                                    <img class="image-fluid" src={{$document->url}} alt="..." style="width:100px" />
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">                                           
                                            <div class="user-info">
                                                <span class="tb-lead">{{ Str::limit($document->name,30) }}<span class="dot dot-success d-md-none ms-1"></span></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                    <span>{{  $document->author }}</span>
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                    <span>{{ $document->types->name }}</span>

                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                    @if ($document->status == 0)
                                    <span class="text-success">Đang duyệt</span>
                                    @endif 
                                    @if ($document->status == -1)
                                    <span class="text-danger">Từ chối</span>
                                    @endif 
                                </td>
                                <td class="nk-tb-col tb-col-lg">
                                    <span>{{ $document->created_at }}</span>
                                </td>
                                    <td class="nk-tb-col nk-tb-col-tools">
                                    <ul class="nk-tb-actions gx-1">                                                
                                        <li>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="/quan-ly/tai-lieu/{{ $document->id }}">
                                                            <em class="icon ni ni-eye"></em><span>Thông tin chi tiết</span>
                                                        </a>

                                                        </li>
                                                        @if($document->status == -1)
                                                        <li><a href="#" class="delete-button" data-id="{{ $document->id }}" data-name="{{ $document->name }}" data-option="0">
                                                            <em class="icon ni ni-trash"></em><span>Xóa</span>
                                                          </a>
                                                        </li>        
                                                        @endif                                    

                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </td>
                                </tr><!-- .nk-tb-item  -->
                            @endforeach
                          
                            
                            </tbody>
                        </table>
                    </div>
                </div><!-- .card-preview -->
            </div>
        </div>
        <div class="nk-fmg-listing nk-block-lg">
            <div class="nk-block-head-xs">
                <div class="nk-block-between g-2">
                    <div class="nk-block-head-content">
                        <h6 class="nk-block-title title">Tài liệu nổi bật</h6>
                    </div>
                    <div class="nk-block-head-content">
                        <ul class="nk-block-tools g-3 nav">
                            <li><a data-bs-toggle="tab" href="#file-grid-view" class="nk-switch-icon active"><em class="icon ni ni-book"></em></a></li>
                            <li><a class="nk-switch-icon"><em class="icon ni ni-swap"></em></a></li>
                            <li><a data-bs-toggle="tab" href="#file-group-view" class="nk-switch-icon"><em class="icon ni ni-file-docs"></em></a></li>
                        </ul>
                    </div>
                </div>
            </div><!-- .nk-block-head -->
            <div class="tab-content">

                <div class="tab-pane active" id="file-grid-view">
                    @if($high_reading_book)

                    <div class="nk-files nk-files-view-grid">                 
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="product-gallery" >    
                                            <img src="{{ $high_reading_book->url }}" class="w-100" alt="">                                     
                                       </div>
                                    </div><!-- .col -->
                                    <div class="col-lg-6 d-flex align-items-end">
                                        <div class="product-info mb-5 me-xxl-5">
                                            <h2 class="product-title">{{ $high_reading_book->name }}                                                
                                            </h2>                                                         
                                            <p class="product-title">Tác giả: {{ $high_reading_book->author }}</p>                 
                                            <div class="product-meta">
                                                <h6 class="title">Ngôn ngữ: 
                                                    @if ($high_reading_book->language === 1)
                                                    <span class="text-success">Tiếng việt</span>
                                                    @else
                                                    <span class="text-info">Tiếng anh</span>
        
                                                    @endif 
                                                </h6>
                                              
                                            </div><!-- .product-meta -->                            
                                            <div class="product-meta">
                                                <h6 class="title">Thể loại</h6>                                     
                                                <span class="text-success">{{ $high_reading_book->types->name }}</span>
                                            </div><!-- .product-meta -->     
                                            <div class="product-meta">
                                                <h6 class="title">Đánh giá</h6>
                                                <span class="text-success">{{ $high_reading_book->ratingScore }}</span>
                                            </div><!-- .product-meta -->         
                                            <div class="product-meta">
                                                <h6 class="title">Lượt đọc</h6>
                                                <span class="text-success">{{ $high_reading_book->totalReading }}</span>
                                            </div><!-- .product-meta -->                        
                                            <div class="product-meta">
                                                <h6 class="title">Số bình luận</h6>
                                                <span class="text-success">{{ $high_reading_book->totalComments }}</span>
                                            </div><!-- .product-meta -->   
                                            <div class="product-meta">
                                                <h6 class="title">Lượt theo dõi</h6>
                                                <span class="text-success">{{ $high_reading_book->totalBookMarking }}</span>
                                            </div><!-- .product-meta -->   
                                        </div><!-- .product-info -->
                                       
                                      
                                    </div><!-- .col -->
                                </div><!-- .row -->                                            
                            </div>
                        </div>
                    </div><!-- .nk-files -->
                    @else
                    <p>Bạn chưa đăng sách nào</p>
                    @endif

                </div><!-- .tab-pane -->
              

                <div class="tab-pane" id="file-group-view">
                    @if($high_downloading_document)

                    <div class="nk-files nk-files-view-group">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="product-gallery" >    
                                            <img src="{{ $high_downloading_document->url }}" class="w-100" alt="">                                     
                                       </div>
                                    </div><!-- .col -->
                                    <div class="col-lg-6 d-flex align-items-end">
                                        <div class="product-info mb-5 me-xxl-5">
                                            <h2 class="product-title">{{ $high_downloading_document->name }}                                                
                                            </h2>                                                         
                                            <p class="product-title">Tác giả: {{ $high_downloading_document->author }}</p>                 
                                            <div class="product-meta">
                                                <h6 class="title">Ngôn ngữ: 
                                                    @if ($high_downloading_document->language === 1)
                                                    <span class="text-success">Tiếng việt</span>
                                                    @else
                                                    <span class="text-info">Tiếng anh</span>
        
                                                    @endif 
                                                </h6>
                                              
                                            </div><!-- .product-meta -->                            
                                            <div class="product-meta">
                                                <h6 class="title">Thể loại</h6>                                     
                                                <span class="text-success">{{ $high_downloading_document->types->name }}</span>
                                            </div><!-- .product-meta -->                                               
                                            <div class="product-meta">
                                                <h6 class="title">Lượt tải</h6>
                                                <span class="text-success">{{ $high_downloading_document->totalDownloading }}</span>
                                            </div><!-- .product-meta -->                        
                                            <div class="product-meta">
                                                <h6 class="title">Số bình luận</h6>
                                                <span class="text-success">{{ $high_downloading_document->totalComments }}</span>
                                            </div><!-- .product-meta -->   
                                            <div class="product-meta">
                                                <h6 class="title">File đỉnh kèm</h6>
                                                <a href="#" id="download-btn" data-id="{{ $high_downloading_document->id }}">
                                                    file.{{ $high_downloading_document->extension }}
                                                </a>
                                            </div><!-- .product-meta -->   
                                        </div><!-- .product-info -->
                                       
                                      
                                    </div><!-- .col -->
                                </div><!-- .row -->                                            
                            </div>
                        </div>
                      
                    </div><!-- .nk-files -->
                    @else
                    <p>Bạn chưa đăng tài liệu nào</p>

                    @endif
                </div><!-- .tab-pane -->
                
            </div><!-- .tab-content -->
        </div><!-- .nk-block -->
    </div><!-- .nk-fmg-body-content -->
</div><!-- .nk-fmg-body -->

@endsection

@section('additional-scripts')
<script>
    $(function(){
        $('#DataTables_Table_0 tbody').on('click','.delete-button',function(){

            var item_id = $(this).data('id');
            var name = $(this).data('name');
            var token = $("meta[name='csrf-token']").attr("content");

            var option = $(this).data('option');

            if(option == '1'){
                Swal.fire({
                    title: "Bạn muốn xóa sách "+ name,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Xóa sách',
                    cancelButtonText: 'Không'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                        type:"GET",
                        url:'/quan-ly/sach/customDelete/' + item_id,
                        data : {
                        },
                        })
                        .done(function() {
                        // If successful
                        Swal.fire({
                                icon: 'success',
                                title: `Xóa sách ${name} thành công`,
                                showConfirmButton: false,
                                timer: 2500
                        });

                        $("#row-book-" + item_id).fadeOut();
                        })
                        .fail(function(jqXHR, textStatus, errorThrown) {
                        // If fail
                        console.log(textStatus + ': ' + errorThrown);
                        })
                
                    }
                }) 
            }
            else{
                Swal.fire({
                title: "Bạn muốn xóa tài liệu "+ name,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xóa tài liệu',
                cancelButtonText: 'Không'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                    type:"GET",
                    url:'/quan-ly/tai-lieu/customDelete/' + item_id,
                    data : {

                    },
                    })
                    .done(function() {
                    // If successful
                    Swal.fire({
                            icon: 'success',
                            title: `Xóa tài liệu ${name} thành công`,
                            showConfirmButton: false,
                            timer: 2500
                    });
                    $("#row-document-" + item_id).fadeOut();
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                    // If fail
                    console.log(textStatus + ': ' + errorThrown);
                    })
            
                    }
                })
            }

        });
    })
    
    $("#download-btn").click(function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
                type:"GET",
                url:'/tai-tai-lieu',
                data : {
                    "id": id
                },
                })
                .done(function() {
                // If successful           
                    window.open(`/tai-tai-lieu?id=${id}`, "_blank");


                    
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                })
       
        
    })

</script>
@endsection