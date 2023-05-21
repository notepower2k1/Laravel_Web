@extends('admin/layouts.app')
@section('pageTitle', 'Danh sách phản hồi')
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
    <nav>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/comment">Bình luận</a></li>
            <li class="breadcrumb-item active">Phản hồi</li>
        </ul>
    </nav>
    <div class="card card-bordered card-preview">
        <div class="card-inner">
           
               
            <table class="datatable-init-export nowrap nk-tb-list nk-tb-ulist mt-2" data-auto-responsive="false" data-export-title="Export">
                <thead>
                    <tr class="nk-tb-item nk-tb-head">
                      
                        <th class="nk-tb-col"><span class="sub-text">Ngày bình luận</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Người phản hồi</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Tình trạng</span></th>
                        <th class="nk-tb-col nk-tb-col-tools text-end">

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($replies as $reply)

                        <tr class="nk-tb-item" id ="row-reply-{{ $reply->id }}">       
                            <td class="nk-tb-col">
                            <span>{{  $reply->created_at  }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <span>{{ $reply->users->name }}</span>
                            </td>

                            <td class="nk-tb-col tb-col-lg" id="status">

                                @if($reply->deleted_at)
                                    <span class="badge rounded-pill bg-outline-danger">Đã xóa</span>

                                @else
                                    <span class="badge rounded-pill bg-outline-success">Đang hiển thị</span>

                                @endif
                            </td>
                          
                            <td class="nk-tb-col nk-tb-col-tools">
                                <ul class="nk-tb-actions gx-1">                       
                                    <li>
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">

                                                    @if($reply->deleted_at)


                                                    @else
                                                    <li>
                                                        <a href="#" class="delete-button-book" data-id="{{ $reply->id }}">
                                                        <em class="icon ni ni-trash"></em><span>Xóa</span>
                                                        </a>
            
                                                    </li>
                                                    @endif
                                                    <li>
                                                        <a href="#" class="content-btn" data-id={{ $reply->id }}>
                                                        <em class="icon ni ni-notice"></em><span>Nội dung</span>
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
                    columns: [0,1]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0,1]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [0,1]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [0,1]
                }
            },
            
        ],
    
    });

    $('#DataTables_Table_0_wrapper').addClass('d-flex row');
    $('#DataTables_Table_0_length').addClass('mt-2');
    $('#DataTables_Table_0_filter').addClass('mt-2');

    $('#DataTables_Table_0 tbody').on('click','.delete-button-book',function(){
        
        var reply_id = $(this).data('id');

        Swal.fire({ 
            title: "Bạn muốn xóa phản hồi này?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Không'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                type:"GET",
                url:`/admin/comment/replies/delete/` + reply_id,
                data : {
                },
                })
                .done(function(res) {
                // If successful
                Swal.fire({
                        icon: 'success',
                        title: `Xóa thành công`,
                        showConfirmButton: false,
                        timer: 2500
                });

                $("#row-reply-" + reply_id).find('#status').empty();
                
                $("#row-reply-" + reply_id).find('#status').append('<span class="badge rounded-pill bg-outline-danger">Đã xóa</span>');
              

                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                });
            
            }
        })




    })
    $('#DataTables_Table_0 tbody').on('click','.content-btn',function(){
      
        var reply_id = $(this).data('id');
        $('#modalContent').find('.modal-body').empty();

        $.ajax({
            type:"GET",
            url:`/admin/comment/replies/getContent/` + reply_id,     
            })
            .done(function(res) {
            // If successful
                const content = res.content;

                $('#modalContent').find('.modal-body').append(content);

                setTimeout(function(){ 
                    $('#modalContent').modal('show');
                },500);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
        });
  
      });
  });


</script>
@endsection