@extends('client/layouts.app')
@section('pageTitle', 'Danh sách chương')

@section('content')

<div class="nk-block nk-block-lg">
    <div class="nk-block-head">
        <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/quan-ly/sach"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>
                <a href="/quan-ly/them-chuong/{{$book_id}}" class="btn btn-primary">Thêm chương</a>
        </div>
    </div>
    <div class="card card-bordered card-preview">
        <div class="card-inner">
            <table class="datatable-init-export nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false" data-export-title="Export">
                <thead>
                    <tr class="nk-tb-item nk-tb-head">
                        
                        <th class="nk-tb-col"><span class="sub-text">Chương số</span></th>
                        <th class="nk-tb-col tb-col-mb"><span class="sub-text">Chương tên</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Lần cập nhật cuối</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ngày thêm</span></th>
                        <th class="nk-tb-col nk-tb-col-tools text-end">
                        </th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($chapters as $chapter)

                    <tr class="nk-tb-item" id ="row-{{ $chapter->id }}">
                        
                        <td class="nk-tb-col">
                            <div class="user-card">                                             
                                <div class="user-info">
                                    <span class="tb-lead">{{ $chapter->code }}<span class="dot dot-success d-md-none ms-1"></span></span>
                                    <span>{{ $chapter->slug }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="nk-tb-col tb-col-mb">
                            <span>{{  $chapter->name }}</span>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <span>{{ $chapter->updated_at }}</span>

                        </td>
                        
                        <td class="nk-tb-col tb-col-lg">
                            <span>{{ $chapter->created_at }}</span>
                        </td>
                        
                        <td class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1">
                                {{-- <li class="nk-tb-action-hidden">
                                    <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Wallet">
                                        <em class="icon ni ni-wallet-fill"></em>
                                    </a>
                                </li>
                                <li class="nk-tb-action-hidden">
                                    <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Send Email">
                                        <em class="icon ni ni-mail-fill"></em>
                                    </a>
                                </li>
                                <li class="nk-tb-action-hidden">
                                    <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Suspend">
                                        <em class="icon ni ni-user-cross-fill"></em>
                                    </a>
                                </li> --}}
                                <li>
                                    <div class="drodown">
                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="#" class="delete-button" data-id="{{ $chapter->id }}" data-name="{{ $chapter->code }}">
                                                <em class="icon ni ni-trash"></em><span>Xóa</span>
                                                </a>

                                                </li>
                                                <li><a href="/quan-ly/cap-nhat-chuong/{{ $chapter->id }}"><em class="icon ni ni-edit"></em><span>Cập nhật</span></a></li>
                                            

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


@section('additional-scripts')

<script src="{{ asset('assets/js/libs/datatable-btns.js?ver=3.1.2') }}"></script>

<script>
$(document).ready(function() {

  table = $('#DataTables_Table_0').DataTable();

  table.destroy();


  table = $('#DataTables_Table_0').DataTable( {
      dom: 'Blfrtip',
      columnDefs: [
          {
              targets: 4, 
              className: 'noVis'           
          }    
      ],
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
                  columns: [ 0,1,2,3]
              }
          },
          {
              extend: 'excelHtml5',
              exportOptions: {
                  columns: [ 0,1,2,3]
              }
          },
          {
              extend: 'pdfHtml5',
              exportOptions: {
                  columns: [ 0,1,2,3]
              }
          },
          {
              extend: 'csvHtml5',
              exportOptions: {
                  columns: [ 0,1,2,3]
              }
          },
          
      ],


    } );
    $('#DataTables_Table_0_wrapper').addClass('d-flex row');
    $('#DataTables_Table_0_length').addClass('mt-2');
    $('#DataTables_Table_0_filter').addClass('mt-2');

  } );

$(function(){
  $('.delete-button').click(function(){
    var chapter_id = $(this).data('id');
    var name = $(this).data('name');
    var token = $("meta[name='csrf-token']").attr("content");

    if (confirm("Xóa "+name) == true) {
        $.ajax({
          type:"DELETE",
          url:'/quan-ly/chuong/' + chapter_id,
          data : {
            "id": chapter_id,
            "_token": token,
          },
          })
          .done(function() {
          // If successful
            alert("Xóa chương thành công");
            $("#row-" + chapter_id).fadeOut();
          })
          .fail(function(jqXHR, textStatus, errorThrown) {
          // If fail
          console.log(textStatus + ': ' + errorThrown);
          })
    } else {

    }
  })
});



</script>
@endsection