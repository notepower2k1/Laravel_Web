@extends('admin/layouts.app')
@section('pageTitle', 'Chi tiết sách điện tử')
@section('content')
<div class="container">
    <div class="nk-block-head-sub"><a class="back-to" href="{{ url()->previous() }}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>

    <div class="nk-content-inner">
        <div class="nk-content-body">
            </div><!-- .nk-block-head -->
            <div class="nk-block">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="product-gallery" >    
                                    <img src="{{ $book->url }}" class="w-100" alt="">                                     
                               </div>
                            </div><!-- .col -->
                            <div class="col-lg-6 d-flex align-items-end">
                                <div class="product-info mb-5 me-xxl-5">
                                        <h2 class="product-title">{{ $book->name }}
                                         
                                        </h2>                                        
                                    <p class="product-title"><strong>Tác giả: </strong>{{ $book->author }}</p>                 
                                    <div class="product-rating">                                                                      
                                        <p><strong>Đánh giá: </strong>(<span id="score">{{$book->ratingScore}}</span>/5)</p>
                                    </div><!-- .product-rating -->                                   
                                    <div class="product-meta">
                                        <ul class="d-flex g-3 gx-5">
                                            <li>
                                                <div class="fs-14px text-muted">Số chương</div>
                                                <div class="fs-16px fw-bold text-secondary">{{ $book->numberOfChapter }}</div>
                                            </li>
                                            <li>
                                                <div class="fs-14px text-muted">Lượt đọc</div>
                                                <div class="fs-16px fw-bold text-secondary">{{ $book->totalReading }}</div>
                                            </li>
                                            <li>
                                                <div class="fs-14px text-muted">Đánh dấu</div>
                                                <div class="fs-16px fw-bold text-secondary" id="totalBookMarking">{{ $book->totalBookMarking }}</div>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                    
                                    <div class="product-meta">
                                        <h6 class="title">Ngôn ngữ: 
                                            @if ($book->language === 1)
                                            <span class="text-success fs-14px">Tiếng việt</span>
                                            @else
                                            <span class="text-info fs-14px">Tiếng anh</span>

                                            @endif 
                                        </h6>
                                        
                                    </div><!-- .product-meta -->
                                    <div class="product-meta">
                                        <h6 class="title">Tình trạng: 

                                            @if ($book->isCompleted === 1)
                                            <span class="text-success fs-14px fw-bold">Đã hoàn thành</span>
                                            @else
                                            <span class="text-info fs-14px fw-bold">Chưa hoàn thành</span>

                                            @endif 
                                        </h6>
                                        
                                    </div><!-- .product-meta -->
                                    <div class="product-meta">
                                        <h6 class="title">Thể loại</h6>
                                        <ul class="d-flex flex-wrap ailgn-center g-2 pt-1">                                     
                                            <li class="ms-n1">
                                                <a href="/the-loai/the-loai-sach/{{$book->types->slug}}" class="btn btn-primary">{{ $book->types->name }}</a>
                                            </li>         
                                        </ul>
                                    </div><!-- .product-meta -->
                                    
                                </div><!-- .product-info -->
                               
                              
                            </div><!-- .col -->
                        </div><!-- .row -->
                        <div class="row g-gs flex-lg-row-reverse">                      
                            <div class="col-lg-12">
                                <div class="product-details entry me-xxl-3">
                                    <hr class="hr">
                                    <h3>Giới thiệu</h3>
                                    {!! clean($book->description ) !!}

                                </div>
                            </div><!-- .col -->
                        </div><!-- .row -->  


                     
                    </div>
                </div>

                <div class="card card-bordered">

                    <div class="card-inner">
                        <h4>Lịch sử đọc sách</h4>

                        <table class="datatable-init-export nowrap nk-tb-list nk-tb-ulist mt-2" data-auto-responsive="false" data-export-title="Export">
                            <thead>
                                <tr class="nk-tb-item nk-tb-head">

                                    <th class="nk-tb-col"><span class="sub-text">Thời gian</span></th>
                                    <th class="nk-tb-col"><span class="sub-text">Tài khoản</span></th>
                                    <th class="nk-tb-col"><span class="sub-text">Lượt đọc</span></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($reading_history as $item)
                                <tr class="nk-tb-item">                
                                    <td class="nk-tb-col">
                                        <span>{{  $item->created_at }}</span>
                                    </td>
                                    <td class="nk-tb-col">
                                    <span>{{  $item->users->name }}</span>
                                    </td>
                                    <td class="nk-tb-col">
                                    <span>{{ $item->total }}</span>
                                    </td>                  
                                </tr>
                            @endforeach

                            </tbody>
                        </table>     
                    </div>
                </div>
                        
                <div class="card card-bordered">

                    <div class="card-inner">
                    <h4>Lịch sử đánh giá</h4>

                    <table class="datatable-init-export nowrap nk-tb-list nk-tb-ulist mt-2" data-auto-responsive="false" data-export-title="Export">
                        <thead>
                            <tr class="nk-tb-item nk-tb-head">

                                <th class="nk-tb-col"><span class="sub-text">Thời gian</span></th>
                                <th class="nk-tb-col"><span class="sub-text">Tài khoản</span></th>
                                <th class="nk-tb-col"><span class="sub-text">Số điểm</span></th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($rating_books as $item)
                            <tr class="nk-tb-item">                
                                <td class="nk-tb-col">
                                    <span>{{  $item->created_at }}</span>
                                  </td>
                                <td class="nk-tb-col">
                                  <span>{{  $item->users->name }}</span>
                                </td>
                                <td class="nk-tb-col">
                                  <span>{{ $item->score }}</span>
                                </td>                  
                            </tr>
                          @endforeach

                        </tbody>
                    </table>     
                    </div>
                </div>
            </div>
           
        </div>
    </div>
</div>



@endsection
@section('additional-scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/js/bootstrap5-toggle.jquery.min.js"></script>
<script src="{{ asset('assets/js/example-sweetalert.js?ver=3.1.2') }}" aria-hidden="true"></script>

<script>
  //custom datatable

  $(document).ready(function () {
    $('#DataTables_Table_0').DataTable().destroy();
    
    $('#DataTables_Table_0').DataTable( {
      dom: 'Blfrtip',
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Tất cả"] ],
      "language": {
          "lengthMenu": "Hiển thị: _MENU_ đối tượng",
          "search": "Tìm kiếm _INPUT_",
          'info':"",
          "zeroRecords": "Không tìm thấy dữ liệu",
          "infoEmpty": "Không có dữ liệu hợp lệ",
          "infoFiltered": "(Lọc từ _MAX_ dữ liệu)",
          "paginate": {
            "first":      "Đầu tiên",
            "last":       "Cuối cùng",
            "next":       "Tiếp theo",
            "previous":   "Trước đó"
        },
       buttons: {
            colvis: 'Thay đổi số cột'
        }
      },
      buttons: [
            
            {
                extend: 'colvis',
                columns: ':not(.noVis)'
            },
      
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [0,1,2]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0,1,2]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [0,1,2]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [0,1,2]
                }
            },
            
        ],
    
    });

    $('#DataTables_Table_0_wrapper').addClass('d-flex row');
    $('#DataTables_Table_0_length').addClass('mt-2');
    $('#DataTables_Table_0_filter').addClass('mt-2');



    $('#DataTables_Table_1').DataTable().destroy();
    
    $('#DataTables_Table_1').DataTable( {
      dom: 'Blfrtip',
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Tất cả"] ],
      "language": {
          "lengthMenu": "Hiển thị: _MENU_ đối tượng",
          "search": "Tìm kiếm _INPUT_",
          'info':"",
          "zeroRecords": "Không tìm thấy dữ liệu",
          "infoEmpty": "Không có dữ liệu hợp lệ",
          "infoFiltered": "(Lọc từ _MAX_ dữ liệu)",
          "paginate": {
            "first":      "Đầu tiên",
            "last":       "Cuối cùng",
            "next":       "Tiếp theo",
            "previous":   "Trước đó"
        },
       buttons: {
            colvis: 'Thay đổi số cột'
        }
      },
      buttons: [
            
            {
                extend: 'colvis',
                columns: ':not(.noVis)'
            },
      
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [0,1,2]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0,1,2]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [0,1,2]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [0,1,2]
                }
            },
            
        ],
    
    });

    $('#DataTables_Table_1_wrapper').addClass('d-flex row');
    $('#DataTables_Table_1_length').addClass('mt-2');
    $('#DataTables_Table_1_filter').addClass('mt-2');

});


</script>
@endsection