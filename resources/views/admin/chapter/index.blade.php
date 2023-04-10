@extends('admin/layouts.app')
@section('pageTitle', 'Danh sách chương')
@section('content')
    {{-- <a href="/admin/book/chapter/create/{{$book_id}}" class="btn btn-primary">Thêm chương</a>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">Chương số</th>
            <th >Tên</th>
            <th >Lasted Update</th>
            <th >Actions</th>
          </tr>
        </thead>
        <tbody>
         @foreach ($chapters as $chapter)
          <tr id ="row-{{ $chapter->id }}">
            <td>{{ $chapter->code }}</td>
            <td>{{ $chapter->name }}</td>
            <td>{{ $chapter->updated_at }}</td>
            <td>
              <a href="/admin/book/chapter/{{$chapter->id}}/edit" class="btn btn-primary">Edit</a>
              <button href="" class="btn btn-primary delete-button" data-id="{{ $chapter->id }}" data-name="{{ $chapter->code }}">Delete</button>
            </td>
          
          

          </tr>
          @endforeach

        </tbody>
      </table> --}}


                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                        </div>
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <table class="datatable-init nowrap nk-tb-list nk-tb-ulist mt-2" data-auto-responsive="false" data-export-title="Export">
                                    <thead>
                                        <tr class="nk-tb-item nk-tb-head">
                                            <th class="nk-tb-col"><span class="sub-text">Sách</span></th>
                                            <th class="nk-tb-col tb-col-mb"><span class="sub-text">Chương số</span></th>
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
                                                <span>{{  $chapter->books->name }}</span>
                                              </td>
                                            <td class="nk-tb-col tb-col-mb">
                                                <div class="user-card">                                             
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ $chapter->code }}<span class="dot dot-success d-md-none ms-1"></span></span>
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
                                                                  <li><a href="/admin/book/chapter/{{$chapter->id}}/edit"><em class="icon ni ni-edit"></em><span>Cập nhật</span></a></li>
                                                               


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

<script src="{{ asset('assets/js/example-sweetalert.js?ver=3.1.2') }}" aria-hidden="true"></script>

<script>
$(function(){
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
                    columns: [0,1,2,3,4]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0,1,2,3,4]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [0,1,2,3,4]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [0,1,2,3,4]
                }
            },
            
        ],
    
    });

    $('#DataTables_Table_0_wrapper').addClass('d-flex row');
    $('#DataTables_Table_0_length').addClass('mt-2');
    $('#DataTables_Table_0_filter').addClass('mt-2');
    $('#DataTables_Table_0 tbody').on('click','.delete-button',function(){
        var chapter_id = $(this).data('id');
        var name = $(this).data('name');
        var token = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
            title: "Bạn muốn xóa chương "+ name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xóa chương',
            cancelButtonText: 'Không'
            }).then((result) => {
            if (result.isConfirmed) {
            
                $.ajax({
                    type:"GET",
                    url:'/admin/book/chapter/customDelete/' + chapter_id,
                    data : {
                    },
                    })
                    .done(function() {
                    // If successful
                        Swal.fire({
                            icon: 'success',
                            title: `Xóa chương ${name} thành công`,
                            showConfirmButton: false,
                            timer: 2500
                        });
                        $("#row-" + chapter_id).fadeOut();
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                    // If fail
                    console.log(textStatus + ': ' + errorThrown);
                    })
            
            }
        })
  })
});



</script>
@endsection