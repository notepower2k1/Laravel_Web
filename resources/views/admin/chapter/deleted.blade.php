@extends('admin/layouts.app')
@section('pageTitle', 'Danh sách chương đã xóa')
@section('content')
    
<div class="nk-block nk-block-lg">
    <div class="nk-block-head">
        <div class="nk-block-head-content">

            <button class="btn btn-outline-primary" id="verification_item_button">
                <em class="icon ni ni-file-check-fill"></em>
                <span>Khôi phục dữ liệu</span>
            </button>
        </div>
    </div>    
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
                      <a class="btn btn-dim btn-info" href="/admin/deleted/chapter">
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
                        <th class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                <input type="checkbox" class="custom-control-input" id="uid">
                                <label class="custom-control-label" for="uid"></label>
                            </div>
                        </th>
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
                        <td class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                <input type="checkbox" name='selection' class="custom-control-input" id="uid-chapter-{{ $chapter->id }}" data-id="{{ $chapter->id }}">
                                <label class="custom-control-label" for="uid-chapter-{{ $chapter->id }}"></label>
                            </div>
                        </td> 
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
                                                <li><a href="/admin/book/chapter/{{$chapter->id}}/detail"><em class="icon ni ni-eye"></em><span>Chi tiết</span></a></li>

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
      columnDefs: [
          {
              targets: [0],
              orderable: false     
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
                    columns: [1,2,3,4,5]
                }
            },
            
        ],
    
    });

    $('#DataTables_Table_0_wrapper').addClass('d-flex row');
    $('#DataTables_Table_0_length').addClass('mt-2');
    $('#DataTables_Table_0_filter').addClass('mt-2');
    $('#DataTables_Table_0 thead').on('change','#uid',function(){
        var checkBoxes = $("input[name=selection]");
        checkBoxes.prop("checked", !checkBoxes.prop("checked"));
        
    });
});

$('#verification_item_button').click(function(){
      var checkBoxes = $("input[type='checkbox'][name=selection]:checked");

      var data = [];
      checkBoxes.each(function(i,item){
        var element = $(item).data('id');  
          data.push(element);
      });

      $.ajax({ 
        type:"GET",
        url:'/admin/deleted/chapter/recovery',
        data: {'data':data}   
        })
        .done(function() {
        // If successful
        $("input[type='checkbox']#uid").prop("checked", false);

        var ListTrChecked = $('tbody tr').has("input[type='checkbox'][name=selection]:checked");
          ListTrChecked.each(function (i,item) {
            $(item).fadeOut("slow");
          })

          Swal.fire({
            icon: 'success',
            title: `Khôi phục thành công!!!`,
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
        window.location.href = `/admin/deleted/chapter/filter/${customFormatDate(fromDate)}/${customFormatDate(toDate)}`;
        }
        

    })
</script>
@endsection