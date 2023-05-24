@extends('admin/layouts.app')
@section('pageTitle', 'Danh sách bình luận đã xóa')
@section('additional-style')
<style>
  .sorting_disabled:after{
    content: none !important;
  }
  .sorting_disabled:before{
    content: none !important;
    }
</style>
@endsection
@section('content')
<div class="nk-block nk-block-lg">
    <div class="card card-bordered card-preview">
        <div class="card-inner">
            <div class="filter-box">
                <div class="form-group">
                    <label class="form-label">
                      <em class="icon ni ni-calendar-alt"></em>
                      <span>Lọc theo ngày xóa</span>
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
                      <a class="btn btn-dim btn-info" href="/admin/deleted/comment">
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
            <table class="datatable-init-export nowrap nk-tb-list nk-tb-ulist mt-2" data-auto-responsive="false" data-export-title="Export">
                <thead>
                    <tr class="nk-tb-item nk-tb-head">
                      
                        <th class="nk-tb-col"><span class="sub-text">Ngày bình luận</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Người bình luận</span></th>
    
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Bình luận về</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Số lượt phản hồi</span></th>
                        {{-- <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ngày thêm</span></th> --}}
                        <th class="nk-tb-col nk-tb-col-tools text-end">

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comments as $comment)

                    <tr class="nk-tb-item" id ="row-{{ $comment->id }}">
        
                        <td class="nk-tb-col">
                          <span>{{  $comment->created_at  }}</span>
                        </td>
                        <td class="nk-tb-col tb-col-lg">
                          <span>{{  $comment->users->name  }}</span>
                        </td>
                        <td class="nk-tb-col tb-col-lg">
                          @switch($comment->type_id)
                            @case(1)

                              <a href="/admin/document/detail/{{$comment->identifier_id}}/{{ \Carbon\Carbon::now()->year }}">
                                <span class="badge rounded-pill bg-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $comment->identifier->name }}">
                                  {{ Str::limit($comment->identifier->name,30) }}
                                </span>
                              </a>
                            
                              @break

                            @case(2)
                              <a href="/admin/book/detail/{{$comment->identifier_id}}/{{ \Carbon\Carbon::now()->year }}">
                              <span class="badge rounded-pill bg-outline-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $comment->identifier->name }}">
                                {{ Str::limit($comment->identifier->name,30) }}
                              </span>
                              </a>
                              @break

                            @case(3)
                              <a href="/admin/forum/post/{{$comment->id}}/detail">
                                <span class="badge rounded-pill bg-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $comment->identifier->topic }}">
                                  {{ Str::limit($comment->identifier->topic,30) }}
                                </span>
                                @break
                              </a>
                            @default
                              <span class="badge rounded-pill bg-outline-success"></span>
                          @endswitch
                        </td>
                        <td class="nk-tb-col tb-col-lg">
                          <span>{{  $comment->totalReplies  }}</span>
                        </td>
                        <td class="nk-tb-col nk-tb-col-tools">
                          <ul class="nk-tb-actions gx-1">                       
                              <li>
                                  <div class="drodown">
                                      <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                      <div class="dropdown-menu dropdown-menu-end">
                                          <ul class="link-list-opt no-bdr">
                                              <li><a href="#" class="delete-button-book" data-id="{{ $comment->id }}">
                                                <em class="icon ni ni-trash"></em><span>Xóa</span>
                                              </a>
                                              <li>
                                                <a href="#" class="content-btn" data-id={{ $comment->id }}>
                                                  <em class="icon ni ni-notice"></em><span>Nội dung</span>
                                                </a>
        
                                                <button class="d-none" data-bs-toggle="modal" data-bs-target="#modalContent" ></button>
                                              </li>
                                              <li><a href="/admin/comment/replies/{{ $comment->id }}"><em class="icon ni ni-reply-all"></em><span>Xem phản hồi</span></a></li>
                                          
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
</div> <!-- nk-block -->
                <!-- .components-preview -->
   
@endsection
@section('modal')
<div class="modal fade" tabindex="-1" id="modalContent">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Nội dung</h5>
              <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <em class="icon ni ni-cross"></em>
              </a>
          </div>
          <div class="modal-body">
              <p></p>
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
                    columns: [0,1,2,3]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0,1,2,3]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [0,1,2,3]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [0,1,2,3]
                }
            },
            
        ],
    
    });

    $('#DataTables_Table_0_wrapper').addClass('d-flex row');
    $('#DataTables_Table_0_length').addClass('mt-2');
    $('#DataTables_Table_0_filter').addClass('mt-2');

    $('#DataTables_Table_0 tbody').on('click','.content-btn',function(e){
        e.preventDefault();
        var comment_id = $(this).data('id');
        $('#modalContent').find('.modal-body').empty();

        $.ajax({
            type:"GET",
            url:`/admin/comment/getContent/` + comment_id,     
            })
            .done(function(res) {
            // If successful
                const content = res.content;

                $('#modalContent').find('.modal-body').append(content);

                setTimeout(function(){ 
                $(`#row-${comment_id}`).find('.content-btn').next().click();
                },500);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
        });
  
      });
  });



    
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
      window.location.href = `/admin/deleted/comment/filter/${customFormatDate(fromDate)}/${customFormatDate(toDate)}`;
    }
    

  })



</script>
@endsection