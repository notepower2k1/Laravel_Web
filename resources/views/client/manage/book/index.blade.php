@extends('client/manage/layouts.app')
@section('pageTitle', 'Danh sách sách điện tử')
@section('content')
<div class="nk-fmg-body">
  <div class="nk-fmg-body-head d-none d-lg-flex">
        <div class="nk-fmg-actions">
            <ul class="nk-block-tools g-3">
                <li>
                    <a href="/quan-ly/them-sach" class="btn btn-light"><em class="icon ni ni-plus"></em> <span>Thêm</span></a>                   
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
                                <a href="/quan-ly/them-sach" class="btn btn-trigger btn-icon"><em class="icon ni ni-plus"></em></a>                            
                            </div>
                        </li>
                        <li class="d-lg-none me-n1"><a href="#" class="btn btn-trigger btn-icon toggle" data-target="files-aside"><em class="icon ni ni-menu-alt-r"></em></a></li>
                    </ul>
                </div>             
            </div>
      </div>
       

      <div class="nk-fmg-quick-list nk-block">
          <div class="card card-bordered card-preview">
            <div class="card-inner">
              <table class="datatable-init-export nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false" data-export-title="Export">
                  <thead>
                      <tr class="nk-tb-item nk-tb-head">
                          <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ảnh đại diện</span></th>

                          <th class="nk-tb-col"><span class="sub-text">Tiêu đề</span></th>
                          <th class="nk-tb-col tb-col-lg"><span class="sub-text">Tác giả</span></th>
                          <th class="nk-tb-col tb-col-lg"><span class="sub-text">Danh mục</span></th>
                          {{-- <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ngày thêm</span></th> --}}
                          <th class="nk-tb-col tb-col-mb"><span class="sub-text">Tiến độ</span></th>
                          <th class="nk-tb-col tb-col-md"><span class="sub-text">Ngôn ngữ</span></th>
                          <th class="nk-tb-col tb-col-md"><span class="sub-text">Tình trạng</span></th>

                          <th class="nk-tb-col nk-tb-col-tools text-end">
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($books as $book)

                      <tr class="nk-tb-item" id ="row-{{ $book->id }}">

                          <td class="nk-tb-col tb-col-lg">
                            <img class="image-fluid" src={{$book->url}} alt="..." style="width:100px" />
                          </td>
                          <td class="nk-tb-col">
                              <div class="user-card">                                           
                                  <div class="user-info">
                                      <span class="tb-lead">{{ $book->name }}<span class="dot dot-success d-md-none ms-1"></span></span>
                                      <span>{{ $book->slug }}</span>
                                  </div>
                              </div>
                          </td>
                          <td class="nk-tb-col tb-col-lg">
                            <span>{{  $book->author }}</span>
                          </td>
                          <td class="nk-tb-col tb-col-lg">
                            <span>{{ $book->types->name }}</span>

                          </td>
                          
                          {{-- <td class="nk-tb-col tb-col-lg">
                            <span>{{ $book->created_at }}</span>
                          </td> --}}
                          <td class="nk-tb-col tb-col-md">
                          @if ($book->isCompleted === 1)
                            <span class="tb-status text-success">Đã hoàn thành</span>
                            @else
                            <span class="tb-status text-info">Chưa hoàn thành</span>

                            @endif 
                          </td>


                          <td class="nk-tb-col tb-col-md">
                          @if ($book->language === 1)
                            <span class="tb-status text-danger">Tiếng việt</span>
                            @else
                            <span class="tb-status text-info">Tiếng anh</span>

                            @endif 
                          </td>
                          <td class="nk-tb-col tb-col-mb">
                            {{-- @if ($book->status === 1)
                            <span class="tb-status text-success">Public</span>
                            @else
                            <span class="tb-status text-info">Private</span>

                            @endif --}}
                            {{-- <div class="form-check form-switch">
                              <input class="form-check-input" 
                              type="checkbox" role="switch" 
                              id="flexSwitchCheckChecked" 
                              data-id="{{ $book->id }}"
                              {{ $book->status? 'checked':'' }}/>
                            </div> --}}

                            {{-- <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input form-check-input" id="customSwitch1" data-id="{{ $book->id }}"
                              {{ $book->isPublic ? 'checked':'' }}>
                            </div> --}}

                            <input type="checkbox" 
                            class="form-check-input"
                            data-toggle="toggle" 
                            data-onlabel="Công khai" 
                            data-offlabel="Riêng tư" 
                            data-size="sm"
                            data-id="{{ $book->id }}"
                            {{ $book->isPublic ? 'checked':'' }}   />

                          </td>
                    
                          <td class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1">                             
                                <li>
                                    <div class="drodown">
                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="#" class="delete-button" data-id="{{ $book->id }}" data-name="{{ $book->name }}">
                                                  <em class="icon ni ni-trash"></em><span>Xóa</span>
                                                </a>
                                                </li>
                                                <li>
                                                  <a href="/quan-ly/cap-nhat-sach/{{$book->id}}"><em class="icon ni ni-edit"></em><span>Cập nhật</span></a>
                                                </li>
                                                <li>
                                                  <a href="{{ route('sach.show', $book->id) }}"><em class="icon ni ni-maximize-alt"></em><span>Chi tiết</span></a>
                                                </li>
                                                <li class="divider"></li>
                                                <li><a href="/quan-ly/chuong/{{$book->id}}"><em class="icon ni ni-eye"></em><span>Xem chương</span></a></li>

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
          </div>
      </div><!-- .card-preview -->
  </div> <!-- nk-block -->
  <!-- .components-preview -->
</div>
@endsection


@section('additional-scripts')
<script src="{{ asset('assets/js/libs/datatable-btns.js?ver=3.1.2') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/js/bootstrap5-toggle.jquery.min.js"></script>
<script src="{{ asset('assets/js/example-sweetalert.js?ver=3.1.2') }}" aria-hidden="true"></script>

<script>
  //custom datatable
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
                  columns: [1,2,3,4,5]
              }
          },
          {
              extend: 'excelHtml5',
              exportOptions: {
                  columns: [1,2,3,4,5]
              }
          },
          {
              extend: 'pdfHtml5',
              exportOptions: {
                  columns: [1,2,3,4,5]
              }
          },
          {
              extend: 'csvHtml5',
              exportOptions: {
                  columns:[1,2,3,4,5]
              }
          },
          
      ],
  

    } );
    $('#DataTables_Table_0_wrapper').addClass('d-flex row');
    $('#DataTables_Table_0_length').addClass('mt-2');
    $('#DataTables_Table_0_filter').addClass('mt-2');

} );
  $(function(){
    $('.form-check-input').change(function() {
      
      var status = $(this).prop('checked') == true ? 1 : 0;
      var book_id = $(this).data('id');

      
      $.ajax({
        type:"GET",
        url:'/quan-ly/sach/update/changeStatus',
        data: {'isPublic':status,'id':book_id}   
        })
        .done(function() {
        // If successful
          console.log("Success");

        })
        .fail(function(jqXHR, textStatus, errorThrown) {
        // If fail
        console.log(textStatus + ': ' + errorThrown);
        })
  })

  $('.delete-button').click(function(){
    var book_id = $(this).data('id');
    var name = $(this).data('name');
    var token = $("meta[name='csrf-token']").attr("content");

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
            type:"DELETE",
            url:'/quan-ly/sach/' + book_id,
            data : {
              "id": book_id,
              "_token": token,
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

              $("#row-" + book_id).fadeOut();
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