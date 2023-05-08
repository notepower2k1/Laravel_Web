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
                                    <td class="nk-tb-col tb-col-lg status">
                                        @if ($book->status == 0)
                                        <span class="text-primary">Đang duyệt</span>
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
                                                            <li><a href="/quan-ly/chi-tiet-sach/{{ $book->id }}">
                                                            <em class="icon ni ni-eye"></em><span>Thông tin chi tiết</span>
                                                            </a>
                                                            </li>
                                                            <li>
                                                            @if($book->status == -1)
                                                            <li><a href="/quan-ly/cap-nhat-sach/{{ $book->id }}">
                                                                <em class="icon ni ni-edit"></em><span>Cập nhật</span>
                                                            </a>
                                                            </li>
                                                            <li><a href="#" class="re-verified" data-id="{{ $book->id }}" data-name="{{ $book->name }}" data-option="2">
                                                                <em class="icon ni ni-regen"></em><span>Gửi xét duyệt lại</span>
                                                              </a>
                                                            </li>     
                                                            <a href="#" class="delete-button" data-id="{{ $book->id }}" data-name="{{ $book->name }}" data-option="2">
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
                                    <td class="nk-tb-col tb-col-lg status">
                                    @if ($document->status == 0)
                                    <span class="text-primary">Đang duyệt</span>
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
                                                        <li><a href="/quan-ly/chi-tiet-tai-lieu/{{ $document->id }}">
                                                            <em class="icon ni ni-eye"></em><span>Thông tin chi tiết</span>
                                                        </a>

                                                        </li>
                                                        @if($document->status == -1)
                                                        <li><a href="/quan-ly/cap-nhat-tai-lieu/{{ $document->id }}">
                                                            <em class="icon ni ni-edit"></em><span>Cập nhật</span>
                                                        </a>
                                                        </li>
                                                        <li><a href="#" class="re-verified" data-id="{{ $document->id }}" data-name="{{ $document->name }}" data-option="1">
                                                            <em class="icon ni ni-regen"></em><span>Gửi xét duyệt lại</span>
                                                          </a>
                                                        </li>     
                                                        <li><a href="#" class="delete-button" data-id="{{ $document->id }}" data-name="{{ $document->name }}" data-option="1">
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
                        <h6 class="nk-block-title title">Thông tin tài liệu</h6>
                    </div>
                    <div class="nk-block-head-content">
                        <ul class="nk-block-tools g-3 nav">
                            <li><a data-bs-toggle="tab" href="#file-grid-view" class="nk-switch-icon active"><em class="icon ni ni-book"></em></a></li>
                            <li><a class="nk-switch-icon"><em class="icon ni ni-swap"></em></a></li>
                            <li><a data-bs-toggle="tab" href="#file-group-view" class="nk-switch-icon"><em class="icon ni ni-file-docs"></em></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-content">

                <div class="tab-pane active" id="file-grid-view">
                    <div class="nk-fmg-body-head d-none d-lg-flex">
                        {{-- <em class="icon ni ni-search"></em>
                        <input type="text" class="form-control border-transparent form-focus-none" placeholder="Search files, folders"> --}}
                        <div class="w-100">
                            <div class="form-group">
                                <label class="form-label" for="book-search-1">Tên sách</label>
                                <div class="form-control-wrap ">
                                    <select class="form-select book-search" id="book-search-1" name="book-search-1" data-placeholder="Chọn tên sách" required>

                                        @foreach ($name_search as $item )
                                        <option value="{{ $item->id }}">{{  $item->name }}</option>
                                        @endforeach                                   
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nk-fmg-body-content">
                        <div class="nk-block-head nk-block-head-sm">
                            <div class="nk-block-between position-relative">
                              
                                <div class="nk-block-head-content">
                                    <ul class="nk-block-tools g-1">
                                        <li class="d-lg-none">
                                            <a href="#" class="btn btn-trigger btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
                                        </li>                          
                                    </ul>
                                </div>
                                <div class="search-wrap px-2 d-lg-none" data-search="search">
                                    <div class="w-100">
                                        <div class="form-group">
                                            <label class="form-label" for="book-search-2">Tên sách</label>
                                            <div class="form-control-wrap ">
                                                <select class="form-select book-search" id="book-search-2" name="book-search-2" data-placeholder="Chọn tên sách" required>

                                                    @foreach ($name_search as $item )
                                                    <option value="{{ $item->id }}">{{  $item->name }}</option>
                                                    @endforeach    
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .search-wrap -->
                            </div>
                        </div>
                        <div class="container" id="book-render">
                            @if($high_reading_book)

                                <div class="nk-files nk-files-view-grid">                 
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="product-gallery" >    
                                                        <img src="{{ $high_reading_book->url }}" class="w-100" alt="">                                     
                                                </div>
                                                </div><!-- .col -->
                                                <div class="col-lg-6">
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
                                                            <h6 class="title">Số chương</h6>                                     
                                                            <span class="text-success">{{ $high_reading_book->numberOfChapter }}</span>
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
                            @endif
                        </div>
                    </div>

                </div><!-- .tab-pane -->
              

                <div class="tab-pane" id="file-group-view">
                    <div class="nk-fmg-body-head d-none d-lg-flex">
                        {{-- <em class="icon ni ni-search"></em>
                        <input type="text" class="form-control border-transparent form-focus-none" placeholder="Search files, folders"> --}}
                        <div class="w-100">
                            <div class="form-group">
                                <label class="form-label" for="document-search-1">Tên tài liệu</label>
                                <div class="form-control-wrap ">
                                    <select class="form-select document-search" id="document-search-1" name="document-search-1" data-placeholder="Chọn tên tài liệu" required>
                                        @foreach ($document_search as $item )
                                        <option value="{{ $item->id }}">{{  $item->name }}</option>
                                        @endforeach    
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nk-fmg-body-content">
                        <div class="nk-block-head nk-block-head-sm">
                            <div class="nk-block-between position-relative">                           
                                <div class="nk-block-head-content">
                                    <ul class="nk-block-tools g-1">
                                        <li class="d-lg-none">
                                            <a href="#" class="btn btn-trigger btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
                                        </li>                          
                                    </ul>
                                </div>
                                <div class="search-wrap px-2 d-lg-none" data-search="search">
                                    <div class="w-100">
                                        <div class="form-group">
                                            <label class="form-label" for="document-search-2">Tên tài liệu</label>
                                            <div class="form-control-wrap ">
                                                <select class="form-select document-search" id="document-search-2" name="document-search-2" data-placeholder="Chọn tên tài liệu" required>
                                                    @foreach ($document_search as $item )
                                                    <option value="{{ $item->id }}">{{  $item->name }}</option>
                                                    @endforeach    
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .search-wrap -->
                            </div>
                        </div>
                        <div class="container" id="document-render">
                            @if($high_downloading_document)

                            <div class="nk-files nk-files-view-group">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="product-gallery" >    
                                                    <img src="{{ $high_downloading_document->url }}" alt="">                                     
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
                                                        <h6 class="title">Số trang</h6>
                                                        <span class="text-success">{{ $high_downloading_document->numberOfPages }}</span>
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
                                                        <a href="{{ $high_downloading_document->documentUrl }}">
                                                            file.{{ $high_downloading_document->extension }}
                                                        </a>
                                                    </div><!-- .product-meta -->  
                                                    <div class="product-meta">
                                                        <h6 class="title">Lượt theo dõi</h6>
                                                        <span class="text-success">{{ $high_downloading_document->totalDocumentMarking }}</span>
                                                    </div><!-- .product-meta -->    
                                                </div><!-- .product-info -->
                                            
                                            
                                            </div><!-- .col -->
                                        </div><!-- .row -->                                            
                                    </div>
                                </div>
                            
                            </div><!-- .nk-files -->
                            @endif
                        
                        </div>
                    </div>
                </div><!-- .tab-pane -->
                
            </div>
       
    </div>
</div>

@endsection

@section('additional-scripts')
<script>
      $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    $(function(){
      
        $('#DataTables_Table_0 tbody').on('click','.delete-button',function(e){
            e.preventDefault();
            var item_id = $(this).data('id');
            var name = $(this).data('name');
            var option = $(this).data('option');

            if(option == '2'){
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
            if(option == '1'){
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

        $('#DataTables_Table_0 tbody').on('click','.re-verified',function(e){   
            e.preventDefault();

            var item_id = $(this).data('id');
            var name = $(this).data('name');
            var option = $(this).data('option');

            Swal.fire({
                icon: 'info',
            html:
                `Bạn nên <b>cập nhật lại</b> ${name} trước khi gửi xét duyệt lại !!!`,
            showCloseButton: true,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Xét duyệt',
            cancelButtonText: `Không xét duyệt`,
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                        type:"PUT",
                        url:'/quan-ly/xet-duyet-lai',
                        data : {
                            'item_id' :item_id,
                            'option' :option,
                        },
                        })
                        .done(function(res) {
                        // If successful
                        Swal.fire({
                                icon: 'success',
                                title: `${res.message}`,
                                showConfirmButton: false,
                                timer: 2500
                        });

                        if(option === 1){
                            $("#row-document-" + item_id).find('.status').empty().append('<span class="text-success">Đang duyệt</span>');

                        }
                        if(option === 2){
                            $("#row-book-" + item_id).find('.status').empty().append('<span class="text-success">Đang duyệt</span>');

                        }

                        })
                        .fail(function(jqXHR, textStatus, errorThrown) {
                        // If fail
                        console.log(textStatus + ': ' + errorThrown);
                        })
                
                    }
                }) 

        })

    })
    

    $('.book-search').change(function() {

        const id = $(this).val();
        var renderArea = $('#book-render');

        $.ajax({
            type:"GET",
            url:'/quan-ly/xem-thong-tin-co-ban',
            data : {
                "option": 2,
                'id': id,
            },
            })
            .done(function(res) {
            // If successful     
              
                renderArea.empty();
                renderArea.append(res.res).hide().show('slow');            
                
                
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
         });
    })

    $('.document-search').change(function() {

        const id = $(this).val();
        var renderArea = $('#document-render');

        $.ajax({
            type:"GET",
            url:'/quan-ly/xem-thong-tin-co-ban',
            data : {
                "option": 1,
                'id': id,
            },
            })
            .done(function(res) {
            // If successful     
            
                renderArea.empty();
                renderArea.append(res.res).hide().show('slow');            
                
                
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
        });
    });
</script>
@endsection