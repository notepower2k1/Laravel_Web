@extends('client/manage.layouts.app')
@section('pageTitle', 'Trang quản lý')

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
                        <h6 class="nk-block-title title">Tài liệu điện tử đang duyệt</h6>
                    </div>
                    <div class="nk-block-head-content">
                        <a href="#" class="link link-primary toggle-opt active" data-target="quick-access1">
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
            <div class="toggle-expand-content expanded" data-content="quick-access1">
                <div class="card card-bordered card-preview">
                    <div class="card-inner">
                        <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false" data-export-title="Export">
                            <thead>
                                <tr class="nk-tb-item nk-tb-head">                                 
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ảnh đại diện</span></th>
                                    <th class="nk-tb-col"><span class="sub-text">Tiêu đề</span></th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Tác giả</span></th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Thể loại</span></th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Tình trạng</span></th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ngày thêm</span></th>

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
                                    
                                    <td class="nk-tb-col tb-col-lg status" >                                    
                                        @if ($book->status == 0)
                                            <span class="badge badge-dim rounded-pill bg-outline-primary">Đang duyệt</span>
                                        @endif 

                                        @if ($book->status == -1)                                     
                                            <span class="badge badge-dim rounded-pill bg-outline-danger">Từ chối</span>
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
                                                            <li>
                                                                <a href="/quan-ly/chi-tiet-sach/{{ $book->id }}">
                                                                    <em class="icon ni ni-eye"></em><span>Thông tin chi tiết</span>
                                                                </a>
                                                            </li>
                                                            
                                                            <li>
                                                                @if($notes->where('identifier_id','=',$book->id)->where('type_id','=',1)->count()>0)           
                                                                    <a href="#" class="getReasonbtn" data-type = "1" data-identifier = {{ $book->id }}>
                                                                        <em class="icon ni ni-clipboard"></em><span>Xem lý do</span>
                                                                    </a>                                                                                
                                                                @endif
                                                            </li>
                                                            <li class="divider"></li>

                                                            @if($book->status == -1)
                                                            <li>
                                                                <a href="/quan-ly/cap-nhat-sach/{{ $book->id }}">
                                                                <em class="icon ni ni-edit"></em><span>Cập nhật</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="re-verified" data-id="{{ $book->id }}" data-name="{{ $book->name }}" data-option="2">
                                                                <em class="icon ni ni-regen"></em><span>Gửi xét duyệt lại</span>
                                                                </a>
                                                            </li>    
                                                            @endif
                                                            <li>
                                                                <a href="#" class="delete-button" data-id="{{ $book->id }}" data-name="{{ $book->name }}" data-option="2">
                                                                    <em class="icon ni ni-trash"></em><span>Xóa</span>
                                                                </a>
                                                            </li>
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
                                    <td class="nk-tb-col tb-col-lg status" >                                    
                                        @if ($document->status == 0)
                                        <span class="badge badge-dim rounded-pill bg-outline-primary">Đang duyệt</span>
                                        @endif 
                                        @if ($document->status == -1)                                          
                                            <span class="badge badge-dim rounded-pill bg-outline-danger">Từ chối</span>
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

                                                        <li>
                                                            @if($notes->where('identifier_id','=',$document->id)->where('type_id','=',2)->count()>0)           
                                                                <a href="#" class="getReasonbtn" data-type = "2" data-identifier = {{ $document->id }}>
                                                                    <em class="icon ni ni-clipboard"></em><span class="badge badge-dim rounded-pill bg-outline-danger">Xem lý do</span>
                                                                </a>                                                                                
                                                            @endif
                                                        </li>
                                                        <li class="divider"></li>
                                                        @if($document->status == -1)
                                                        <li><a href="/quan-ly/cap-nhat-tai-lieu/{{ $document->id }}">
                                                            <em class="icon ni ni-edit"></em><span>Cập nhật</span>
                                                        </a>
                                                        </li>
                                                        <li><a href="#" class="re-verified" data-id="{{ $document->id }}" data-name="{{ $document->name }}" data-option="1">
                                                            <em class="icon ni ni-regen"></em><span>Gửi xét duyệt lại</span>
                                                          </a>
                                                        </li>     
                                                             
                                                        @endif                                    
                                                        <li>
                                                            <a href="#" class="delete-button" data-id="{{ $document->id }}" data-name="{{ $document->name }}" data-option="2">
                                                                <em class="icon ni ni-trash"></em><span>Xóa</span>
                                                            </a>
                                                        </li>
                                                      
                                                      
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
        <div class="nk-fmg-quick-list nk-block">  
            <div class="nk-block-head-xs">
                <div class="nk-block-between g-2">
                    <div class="nk-block-head-content">
                        <h6 class="nk-block-title title">Tài liệu điện tử bị khóa bởi quản trị viên</h6>
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
                                    <th class="nk-tb-col"><span class="sub-text">Tiêu đề</span></th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Tác giả</span></th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Thể loại</span></th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ngày thêm</span></th>

                                    {{-- <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ngày thêm</span></th> --}}
                                 

                                    <th class="nk-tb-col nk-tb-col-tools text-end">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($lock_books as $book)
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
                                    <span>{{ $book->created_at }}</span>
                                    </td>
                                    <td class="nk-tb-col nk-tb-col-tools">
                                        <ul class="nk-tb-actions gx-1">                                                
                                            <li>
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li>
                                                                <a href="/quan-ly/chi-tiet-sach/{{ $book->id }}">
                                                                    <em class="icon ni ni-eye"></em><span>Thông tin chi tiết</span>
                                                                </a>
                                                            </li>
                                                                                                          
                                                            <li>
                                                                @if($notes->where('identifier_id','=',$book->id)->where('type_id','=',4)->count()>0)           
                                                                    <a href="#" class="getReasonbtn" data-type = "4" data-identifier = {{ $book->id }}>
                                                                        <em class="icon ni ni-clipboard"></em><span>Xem lý do</span>
                                                                    </a>                                                                                
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </td>
                                </tr><!-- .nk-tb-item  -->
                            @endforeach
                            @foreach ($lock_documents as $document)
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
                                                        <li>
                                                            @if($notes->where('identifier_id','=',$document->id)->where('type_id','=',5)->count()>0)           
                                                                <a href="#" class="getReasonbtn" data-type = "5" data-identifier = {{ $document->id }}>
                                                                    <em class="icon ni ni-clipboard"></em><span>Xem lý do</span>
                                                                </a>                                                                                
                                                            @endif
                                                        </li>
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

</div>

@endsection

@section('modal')
<div class="modal fade" id="reasonModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lý do từ chối</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <div class="bq-note">
                    <div class="bq-note-item" id="note-reason-render">

                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <span class="sub-text">Liên hệ với quản trị viên qua nguyenthach617@gmail.com để biết thêm chi tiết</span>
            </div>
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
    

  

  

    $('.getReasonbtn').on('click', function(e) {
        e.preventDefault();

        const type_id = $(this).data('type');
        const identifier_id = $(this).data('identifier');
        $.ajax({
            type:"GET",
            url:'/quan-ly/get-reject-reason',
            data : {
                "type_id": type_id,
                'identifier_id': identifier_id,
            },
            })
            .done(function(res) {
            // If successful     

                const listItem = res.res;
            
                $('#reasonModal').find('#note-reason-render').empty().append(listItem);

                $('#reasonModal').modal('show');
                
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
        });
    })
</script>
@endsection