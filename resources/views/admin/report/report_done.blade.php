@extends('admin/layouts.app')
@section('pageTitle', 'Báo cáo đã xử lý')
@section('content')

<div class="nk-block nk-block-lg">
    <div class="nk-block-head">
        <div class="nk-block-head-content">
                <a href="/admin/report" class="btn btn-lg btn-success">Quay lại</a>    
        </div>
    </div>
    <div class="card card-bordered card-preview">
        <div class="card-inner">
            <div class="filter-box">
                <div class="form-group">
                    <label class="form-label">
                      <em class="icon ni ni-calendar-alt"></em>
                      <span>Lọc theo ngày xử lý</span>
                    </label>
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
                <div class="button-box">
                    <button class="btn btn-dim btn-warning" id="filter-btn">
                      <em class="icon ni ni-filter"></em>
                      <span>Lọc</span>̣</button>
                    
                      @if(isset($fromDate))
                      <a class="btn btn-dim btn-info" href="/admin/report/done">
                        <em class="icon ni ni-reload"></em>
                        <span>Reset</span></a>
                      @else
                      <button class="btn btn-dim btn-info" disabled>
                        <em class="icon ni ni-reload"></em>
                      <span>Reset</span></a>
                      @endif

                </div>
              </div>
              <hr>
            <table class="datatable-init nowrap nk-tb-list nk-tb-ulist mt-2" data-auto-responsive="false" data-export-title="Export">
                <thead>
                    <tr class="nk-tb-item nk-tb-head">
                        <th class="nk-tb-col"><span class="sub-text">Báo cáo về</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Đối tượng</span></th>
                        <th class="nk-tb-col"><span class="sub-text">Ngày báo cáo</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Người báo cáo</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Lý do</span></th>

                        <th class="nk-tb-col nk-tb-col-tools text-end">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)

                    <tr class="nk-tb-item" id ="row-{{ $report->id }}">

                    
                        <td class="nk-tb-col">
                            @switch ($report->type_id)
                                @case(1)
                                    <span class="badge rounded-pill bg-outline-primary">
                                        Sách
                                    </span>
                                    @break;
                                @case(2)
                                    <span class="badge rounded-pill bg-outline-secondary">
                                        Chương của sách 
                                    </span>
                                    @break;
                                @case(3)
                                    <span class="badge rounded-pill bg-outline-warning">
                                        Tài liệu
                                    </span>
                    
                                    @break;
                                @case(4)
                                    <span class="badge rounded-pill bg-outline-info">
                                        Bài viết
                                    </span>
                                    @break;
                                @case(5)
                                    <span class="badge rounded-pill bg-outline-danger">
                                        Người dùng
                                    </span>
                                    @break;
                                @case(6)
                                    <span class="badge rounded-pill bg-outline-gray">
                                        Bình luận
                                    </span>

                                    @break;
                              
                                @case(7)
                                    <span class="badge rounded-pill bg-outline-light">
                                        Phản hồi bình luận
                                    </span>
                                   
                                    @break;   
                        
                                @case(8)

                                    <span class="badge rounded-pill bg-outline-dark">
                                        Đánh giá của sách                                 
                                    </span>
                                @break;   
                                @default:
                                    <span class="">
                                        Lỗi
                                    </span>
                            
                            @endswitch
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            @switch ($report->type_id)
                                @case(1)
                    
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $report->identifier->name }}">
                                    {{ Str::limit($report->identifier->name,30) }}
                                    </span>

                                    @break;
                                @case(2)
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $report->identifier->code }}">
                                        {{ Str::limit($report->identifier->code,30) }}
                                    </span>
                                    @break;
                                @case(3)
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $report->identifier->name }}">
                                        {{ Str::limit($report->identifier->name,30) }}
                                    </span>
                    
                                    @break;
                                @case(4)
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $report->identifier->topic }}">
                                    {{ Str::limit($report->identifier->topic,30) }}
                                    </span>             
                                    @break;
                                @case(5)
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $report->identifier->name }}">
                                    {{ Str::limit($report->identifier->name,30) }}
                                    </span>
                                    @break;
                                @case(6)

                                    @if($report->identifier->type_id == 1)
                                    <span>
                                        Bình luận về tài liệu
                                    </span>
                                    @endif
                                    
                                    @if($report->identifier->type_id == 2)
                                    <span>
                                        Bình luận về sách
                                    </span>
                                    @endif

                                    
                                    @if($report->identifier->type_id == 3)
                                    <span>
                                        Bình luận về bài viết
                                    </span>
                                    @endif
                                    @break;
                              
                                @case(7)

                                    <span>
                                        Phản hồi của bình luận

                                    </span>
                                    @break;   
                        
                                @case(8)

                                    <span>
                                        Đánh giá của sách
                                    </span>
                                @break;   
                                @default:
                                    <a href="#"></a>
                            
                            @endswitch
                        </td>
                        <td class="nk-tb-col">
                            <div class="user-card">                                           
                                <div class="user-info">
                                    <span class="tb-lead">{{ $report->created_at}}</span>
                                </div>
                            </div>
                        </td>
                     
                        <td class="nk-tb-col tb-col-md">
                            <span>{{ $report->users->email  }}</span>

                        </td>   
                        <td class="nk-tb-col tb-col-md">
                            <span class="text-danger">{{ $report->reasons->name  }}</span>

                        </td>                                                                                                                                                                                                                            
                        <td class="nk-tb-col nk-tb-col-tools">
                            <button class="btn btn-icon btn-lg ni ni-eye detail-btn" data-id="{{ $report->id }}"></button>
                            <button class="d-none" id="show-modal-btn"  data-bs-toggle="modal" data-bs-target="#modalTabs"></button>
                        </td>
                    </tr><!-- .nk-tb-item  -->
                    @endforeach

                </tbody>
            </table>
        </div>
    </div><!-- .card-preview -->
</div> <!-- nk-block --> 
                
@endsection
@section('modal')
<div class="modal fade" tabindex="-1" id="modalTabs" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-xl">
                <h4 class="title">Chi tiết báo cáo</h4>
                <ul class="nk-nav nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#tabItem1" aria-selected="true" role="tab">Nội dung báo cáo</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#tabItem2" aria-selected="false" role="tab" tabindex="-1">Người báo cáo</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active show" id="tabItem1" role="tabpanel">
                        <h5><strong>Lý do báo cáo: </strong><span id="report-reason"></span></h5>
                        <h5><strong>Ghi chú: </strong><span id="report-description"></span></h5>
                        <hr>
                        <h4 class="title" id="report-title">Báo cáo về sách</h4>
                        <hr class="shadow hr">
                        <div id="item-detail-ul">
                        </div>         
                        <hr class="shadow hr">
                        <hr class="shadow hr">
                        <a href="#" class="btn btn-dim btn-danger" id="item-detail-url">Thông tin chi tiết</a>
                    </div>
                    <div class="tab-pane" id="tabItem2" role="tabpanel">
                        <h6 class="title">Thông tin người báo cáo</h6>
                        <hr class="shadow hr">
                        <div id="user-detail-ul">
                        </div>             
                        <hr class="shadow hr">
                        <a href="#" class="btn btn-dim btn-danger" id="user-detail-url">Thông tin chi tiết</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('additional-scripts')
<script src="{{ asset('assets/js/libs/datatable-btns.js?ver=3.1.2') }}"></script>
<script src="{{ asset('assets/js/example-sweetalert.js?ver=3.1.2') }}" aria-hidden="true"></script>

<script>
  //custom datatable
  $(function(){
    $('#DataTables_Table_0').DataTable().destroy();

    $('#DataTables_Table_0').DataTable( {
        dom: 'Blfrtip',
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Tất cả"] ],
        "language": {
            "lengthMenu": "Hiển thị: _MENU_ đối tượng",
            "search": "Tìm kiếm _INPUT_",
            'info':"_PAGE_ - _PAGES_ của _MAX_",
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
  $('#DataTables_Table_0 tbody').on('click','.detail-btn',function(){

    var report_id = $(this).data('id');
    var renderArea = $('#item-detail-ul');
    var renderArea2 = $('#user-detail-ul');

    $.ajax({
        type:"GET",
        url:'/admin/report/detail',
        data: {'id':report_id}   
        })
        .done(function(res) {
        // If successful
            renderArea.empty(); 
            renderArea2.empty(); 


            $('#report-title').text(`${res.title}`);
            $("#item-detail-url").attr("href", `${res.itemUrl}`);

                
            
            $("#user-detail-url").attr("href", `${res.userUrl}`);

            renderArea.append(`${res.content}`);
            renderArea2.append(`${res.userContent}`);

            $('#report-reason').text(`${res.reason}`);
            $('#report-description').text(`${res.description}`);
            $('#modalTabs').modal('show');



        })
        .fail(function(jqXHR, textStatus, errorThrown) {
        // If fail
        console.log(textStatus + ': ' + errorThrown);
        })
  })
 
  })


  function customFormatDate(date){
        const month = date.slice(0,2);
        const day = date.slice(3,5);
        const year = date.slice(6,10)
    
        return year+month+day;
    }

  $('#filter-btn').click(function() {
    
    const fromDate = $('.filter-box').find('input[type="text"][name="from-date"]').val();
    const toDate = $('.filter-box').find('input[type="text"][name="to-date"]').val();

    if(fromDate == '' || toDate == '') {
      Swal.fire({
        icon: 'error',
        title: `Không thể để trống!!!`,
        showConfirmButton: false,
        timer: 2500
      });
    }
    if(fromDate && toDate){
      window.location.href = `/admin/report/done/filter/${customFormatDate(fromDate)}/${customFormatDate(toDate)}`;
    }
    

  })

</script>
@endsection