@extends('admin/layouts.app')
@section('pageTitle', 'Danh sách người dùng')
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
        <div class="">
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <div class="filter-box">
                        <div class="form-group">
                            <label class="form-label">
                                <em class="icon ni ni-calendar-alt"></em>
                                <span>Lọc theo ngày</span>
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
                                <a class="btn btn-dim btn-info" href="/admin/user/">
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
                                <th class="nk-tb-col"><span class="sub-text">Người dùng</span></th>
    
                                <th class="nk-tb-col tb-col-md"><span class="sub-text">Xác thực</span></th>
                                <th class="nk-tb-col tb-col-md"><span class="sub-text">Lần đăng nhập cuối</span></th>   
                                <th class="nk-tb-col tb-col-md"><span class="sub-text">Tình trạng</span></th>                     
                                <th class="nk-tb-col nk-tb-col-tools text-end">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
    
                            <tr class="nk-tb-item" id ="row-{{ $user->id }}">
    
                                <td class="nk-tb-col">
                                    <a href="#">
                                        <div class="user-card">
                                            <div class="user-avatar bg-primary">
                                                <img src="{{ $user->profile->url }}" alt="">
                                            </div>
                                            <div class="user-info">
                                                <span class="tb-lead">{{ $user->name }} <span class="dot dot-success d-md-none ms-1"></span></span>
                                                <span>{{ $user->email }}</span>
                                            </div>
                                        </div>
                                    </a>                                            
                                </td>
                                <td class="nk-tb-col tb-col-md">
                                    <ul class="list-status">
                                        @if($user->email_verified_at)
                                        <li><em class="icon text-success ni ni-check-circle"></em> <span>Email</span></li>
                                        @else
                                        <li><em class="icon text-danger ni ni-alarm"></em> <span>Email</span></li>
                                        @endif
                                    </ul>
                                </td>
                                <td class="nk-tb-col tb-col-md">
                                    <span>{{ $user->lastLogin }}</span>                                            
                                </td>   
                                <td class="nk-tb-col tb-col-md" id ="status-{{ $user->id }}">
                                    @if($user->status == 1)
                                    <span class="tb-status text-success">Hoạt động</span>      
                                    @else
                                    <span class="tb-status text-danger">Đình chỉ</span>      
                                    @endif                          
                                </td>                                                   
                                <td class="nk-tb-col nk-tb-col-tools">
                                    <ul class="nk-tb-actions gx-1">                                            
                                        <li class="nk-tb-action-hidden">
                                            <a href="#" class="btn btn-trigger btn-icon btn-email" data-email={{ $user->email }}  data-name="{{ $user->name }}" >
                                                <em class="icon ni ni-mail-fill"></em>
                                            </a>
                                            
                                        </li>
                                        <li class="nk-tb-action-hidden">
                                            <a href="#" class="btn btn-trigger btn-icon btn-suspend" data-id={{ $user->id }} data-value={{ $user->status }}>
                                                <em class="icon ni ni-user-cross-fill"></em>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="#" class="delete-button" data-id={{ $user->id }}>
                                                        <em class="icon ni ni-trash"></em><span>Xóa người dùng</span>
                                                        </a>
    
                                                        </li>
                                                    <li><a href="#" data-id={{ $user->id }} class="recovery-password-a-tag"><em class="icon ni ni-edit"></em><span>Đổi mật khẩu</span></a>
                                                    <li><a href="/admin/user/{{ $user->id }}"><em class="icon ni ni-eye"></em><span>Chi tiết</span></a>
    
                                                
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
        
    </div> <!-- nk-block -->
                <!-- .components-preview -->
   
@endsection

@section('modal')
<div class="modal fade" id="passwordModalForm" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Khôi phục mật khẩu: </h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-validate is-alter" novalidate="novalidate" id="passwordForm">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="form-label" for="password">Mật khẩu mới</label>
                        <div class="form-control-wrap">
                            <input id="password" type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                    </div>
                </form>
            </div>
          
        </div>
    </div>
</div>
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
                
            </div>
        </div>
    </div>
  </div>
@endsection
@section('additional-scripts')
<script src="{{ asset('assets/js/libs/datatable-btns.js?ver=3.1.2') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/js/bootstrap5-toggle.jquery.min.js"></script>
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


    $('#DataTables_Table_0 tbody').on('click','.btn-suspend',function(e){
        e.preventDefault();
        var user_id = $(this).data('id');
        var status = $(this).data('value');

        var message = (status == 0) ? 'Bạn có chắc muốn mở khóa tài khoản của người dùng này?' : 'Bạn có chắc muốn khóa tài khoản của người dùng này?'
        
        
        Swal.fire({
        title: `${message}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Muốn',
        cancelButtonText: 'Không'
        }).then((result) => {
        if (result.isConfirmed) {

            Swal.fire({
                title: 'Đang xử lý',
                text: 'Vui lòng đợi xử lý xong!',
                imageUrl: 'https://raw.githubusercontent.com/notepower2k1/MyImage/main/gif/codevember-day-6-bookshelf-loader.gif',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'Custom image',
                showConfirmButton: false
            })

            $.ajax({
                type:"GET",
                url:'/admin/user/update/changeStatus',
                data : {
                "id": user_id,
                "status": status,
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

                var contentHTML = '';

                
                if(res.status == 1){
                    contentHTML = '<span class="tb-status text-success">Hoạt động</span>' 
                }
                else if (res.status == 0){

                    const option = 3;

                    $("#note-type").select2().select2('val',[`${option}`]);

                    setTimeout(() => {
                        $('#note-object').select2().select2('val',[`${user_id}`]);
                        $('#modalNote').modal('show');
                    }, 2500);

                    contentHTML = '<span class="tb-status text-danger">Đình chỉ</span>' 
                }

                $("#status-" + user_id).empty();
                $("#status-" + user_id).append(contentHTML);

                $(`.btn-suspend[data-id="${user_id}"]`).data('value',`${res.status}`);



            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
            })
         
        }
      })
   
    });

    $('#DataTables_Table_0 tbody').on('click','.recovery-password-a-tag',function(e){
        e.preventDefault();

        var user_id = $(this).data('id');
        
        $('#passwordForm').attr('action', `/admin/user/${user_id}`);



        $('#passwordModalForm').modal('show');

        $('#passwordForm').submit(function() {
            Swal.fire({
                    icon: 'success',
                    title: `Đổi mật khẩu thành công!!!`,
                    showConfirmButton: false,
                    timer: 2000
            });
        });
    })

    $('#DataTables_Table_0 tbody').on('click','.delete-button',function(e){
        e.preventDefault();

        var user_id = $(this).data('id');

        Swal.fire({
            title: "Bạn muốn xóa người dùng này",
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
                url:'/admin/user/deleteUser',
                data : {
                "id": user_id,
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

                $("#row-" + user_id).fadeOut();
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                })
            
            }
        })
    });

    $('#DataTables_Table_0 tbody').on('click','.btn-email',function(e){
        e.preventDefault();

        var email = $(this).data('email');
        var subject = 'Đây là email gửi từ quản trị viên!!!';
        var emailBody = 'Xin chào ' + $(this).data('name');
        window.location = "mailto:"+email+"?subject="+subject+"&body="+emailBody;
        // window.location =  `https://mail.google.com/mail/?view=cm&fs=1&to=${email}&su=${subject}&body=${emailBody}`;
    });

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
      window.location.href = `/admin/user/filter/${customFormatDate(fromDate)}/${customFormatDate(toDate)}`;
    }
    

  })


  
</script>
@endsection