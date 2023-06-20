@extends('admin/layouts.app')
@section('pageTitle', 'Danh sách sách điện tử')
@section('additional-style')
<style>
  #swal2-content em{
    font-size:60px;
  }
  #swal2-content .icon-circle{
    width: 80px;
    height: 80px;
  }
</style>
@endsection
@section('content')
<div class="nk-block nk-block-lg">
    <div class="nk-block-head">
        <div class="nk-block-head-content">

                <a href="/admin/book/create" class="btn btn-primary">Thêm sách</a>

            
        </div>
    </div>
    <div class="card card-bordered card-preview">
        <div class="card-inner">
            <div class="filter-box">
              <div class="form-group">
                  <label class="form-label">
                    <em class="icon ni ni-calendar-alt"></em>
                    <span>Lọc theo ngày thêm</span>
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
                    <a class="btn btn-dim btn-info" href="/admin/book/">
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

                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ảnh đại diện</span></th>

                        <th class="nk-tb-col"><span class="sub-text">Tiêu đề</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Tác giả</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Danh mục</span></th>
                        {{-- <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ngày thêm</span></th> --}}
                        <th class="nk-tb-col tb-col-mb"><span class="sub-text">Tiến độ</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Ngôn ngữ</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Tình trạng</span></th>

                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Người đăng</span></th>

                        <th class="nk-tb-col nk-tb-col-tools text-end">
                        </th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($books as $book)

                    <tr class="nk-tb-item" id ="row-{{ $book->id }}" style="{{ $book->status == -2 ? 'background-color:rgba(220,20,60,0.1)':'' }}">
                     
                        <td class="nk-tb-col tb-col-lg">
                          <img class="image-fluid" src={{$book->url}} alt="..." style="width:100px" />
                        </td>
                        <td class="nk-tb-col">
                            <div class="user-card">                                           
                                <div class="user-info">
                                    <span class="tb-lead"  data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $book->name }}">{{ Str::limit($book->name,30) }}<span class="dot dot-success d-md-none ms-1"></span></span>
                                </div>
                            </div>
                        </td>
                        <td class="nk-tb-col tb-col-lg">
                          <span>{{  Str::limit($book->author,30) }}</span>
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
                          
                          
                          <div class="form-check form-switch">

                            <input type="checkbox" 
                            class="form-check-input"
                            role="switch"
                            data-id="{{ $book->id }}"
                            {{ $book->users->id == 1 ?'':'disabled' }}
                             {{ ($book->file  || $book->numberOfChapter > 0 )  ?  "data-flag = true" : "data-flag = false" }}                          
                            {{ $book->isPublic ? 'checked':'' }}   />
                          </div>

                        </td>
                  
                        <td class="nk-tb-col tb-col-lg">
                          <span>{{  $book->users->name }}</span>
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
                                              <li>
                                                <a href="#" class="delete-button" data-id="{{ $book->id }}" data-name="{{ $book->name }}">
                                                  <em class="icon ni ni-trash"></em><span>Xóa</span>
                                                </a>
                                              </li>
                                              <li><a href="/admin/book/detail/{{$book->id}}/{{ \Carbon\Carbon::now()->year }}"><em class="icon ni ni-eye"></em><span>Chi tiết</span></a></li>

                                              @if($book->users->id != 1)
                                                @if($book->status == -2)
                                                  <li>
                                                    <a href="#" class="lock-button" data-id="{{ $book->id }}" data-name="{{ $book->name }}" data-status ="{{ $book->status }}">
                                                      <em class="icon ni ni-unlock"></em><span>Mở khóa sách</span>
                                                    </a>
                                                  </li>
                                                @else
                                                  <li>
                                                    <a href="#" class="lock-button" data-id="{{ $book->id }}" data-name="{{ $book->name }}"  data-status ="{{ $book->status }}">
                                                      <em class="icon ni ni-lock"></em><span>Khóa sách</span>
                                                    </a>
                                                  </li>
                                                @endif
                                              @endif

                                              @if($book->users->id == 1)
                                              <li><a href="/admin/book/{{$book->id}}/edit"><em class="icon ni ni-edit"></em><span>Cập nhật</span></a></li>
                                              @endif

                                              @if($book->file == null)

                                              <li class="divider"></li>

                                              <li><a href="/admin/book/chapter/{{$book->id}}"><em class="icon ni ni-list-index"></em><span>Xem chương ({{ $book->numberOfChapter }})</span></a></li>
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
</div> <!-- nk-block -->
   
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
      columnDefs: [
          {
              targets: 4, 
              className: 'noVis'           
          },
          {
              targets: [0,8],
              orderable: false     
          }
      ],
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
    
    });

    $('#DataTables_Table_0_wrapper').addClass('d-flex row');
    $('#DataTables_Table_0_length').addClass('mt-2');
    $('#DataTables_Table_0_filter').addClass('mt-2');

    $('#DataTables_Table_0 tbody').on('click','.delete-button',function(e){
      e.preventDefault();
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
              type:"GET",
              url:'/admin/book/customDelete/' + book_id,
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

                $("#row-" + book_id).fadeOut();

              })
              .fail(function(jqXHR, textStatus, errorThrown) {
              // If fail
              console.log(textStatus + ': ' + errorThrown);
              })
          
          }
        })
    })


    $('#DataTables_Table_0 tbody').on('change','.form-check-input',function(e){

      var flag = $(this).data('flag');
      if(flag){
        var status = $(this).prop('checked') == true ? 1 : 0;
        var book_id = $(this).data('id');
 
        $.ajax({ 
          type:"GET",
          url:'/admin/book/update/changeStatus',
          data: {'isPublic':status,'id':book_id}   
        })
        .done(function() {
        // If successful
          Swal.fire({
                      icon: 'success',
                      title: `Đổi trạng thái thành công`,
                      showConfirmButton: false,
                      timer: 2500
                  });

        })
        .fail(function(jqXHR, textStatus, errorThrown) {
        // If fail
          Swal.fire({
                      icon: 'error',
                      title: `Đổi trạng thái không thành công`,
                      showConfirmButton: false,
                      timer: 2500
            });
        })
      }
      else{
        e.target.checked = false        
        Swal.fire({
            icon: 'info',
            title: `Sách phải có ít nhất 1 chương`,
            showConfirmButton: false,
            timer: 2500
          });
      }
     
    })


    $('#DataTables_Table_0 tbody').on('click','.lock-button',function(e){
      e.preventDefault();

      var book_id = $(this).data('id');
      var name = $(this).data('name');
      var status = $(this).data('status');

      var _this = $(this);
      
      console.log(_this);
      var token = $("meta[name='csrf-token']").attr("content");

      Swal.fire({
          title: status === -2 ? "Bạn muốn mở khóa sách " + name : "Bạn muốn khóa sách " + name,
          html:status === -2 ?  '<em class="icon icon-circle bg-success-dim ni ni-unlock"></em>':  '<em class="icon icon-circle bg-warning-dim ni ni-lock"></em>',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Đồng ý',
          cancelButtonText: 'Không'
          }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
              type:"GET",
              url:'/admin/book/lock/' + book_id,
              data : {
              },
              })
              .done(function(res) {
              // If successful

                if(res.status == 1){
                  Swal.fire({
                      icon: 'success',
                      title: `Mở khóa thành công`,
                      showConfirmButton: false,
                      timer: 2500
                  });

                  $("#row-" + book_id).css('background-color','');
                  _this.data('status','1');
                  _this.empty();
                  _this.append('<em class="icon ni ni-lock"></em><span>Khóa sách</span>');


                }
                else{
                  Swal.fire({
                      icon: 'success',
                      title: `Khóa thành thành công`,
                      showConfirmButton: false,
                      timer: 2500
                  });

                  $("#row-" + book_id).css('background-color','rgba(220,20,60,0.1)');
                  _this.data('status','-2');
                  _this.empty();
                  _this.append('<em class="icon ni ni-unlock"></em><span>Mở khóa sách</span>');


                  $("#note-type").select2().select2('val',[`4`]);

                  setTimeout(() => {

                      $('#note-object').select2().select2('val',[`${book_id}`]);
                      $('#modalNote').modal('show');
                    }, 2500);
                }



           

              })
              .fail(function(jqXHR, textStatus, errorThrown) {
              // If fail
              console.log(textStatus + ': ' + errorThrown);
              })
          
          }
        })
      })
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
      window.location.href = `/admin/book/filter/${customFormatDate(fromDate)}/${customFormatDate(toDate)}`;
    }
    

  })

  

</script>
@endsection