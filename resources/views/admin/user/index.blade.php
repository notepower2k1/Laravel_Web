@extends('admin/layouts.app')
@section('pageTitle', 'Danh sách người dùng')
@section('content')
                    <div class="nk-block nk-block-lg">             
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false" data-export-title="Export">
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
                                                <span>10 Feb 2020</span>                                            
                                            </td>   
                                            <td class="nk-tb-col tb-col-md" id ="status-{{ $user->id }}">
                                                @if($user->status == 0)
                                                <span class="tb-status text-success">Active</span>      
                                                @else
                                                <span class="tb-status text-danger">Suspend</span>      
                                                @endif                          
                                            </td>                                                   
                                            <td class="nk-tb-col nk-tb-col-tools">
                                              <ul class="nk-tb-actions gx-1">                                            
                                                  <li class="nk-tb-action-hidden">
                                                      <button class="btn btn-trigger btn-icon btn-email" data-email={{ $user->email }}  data-name="{{ $user->name }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Send Email">
                                                          <em class="icon ni ni-mail-fill"></em>
                                                      </button>
                                                  </li>
                                                  <li class="nk-tb-action-hidden">
                                                      <button class="btn btn-trigger btn-icon btn-suspend" data-id={{ $user->id }} data-value={{ $user->status }} data-bs-toggle="tooltip" data-bs-placement="top" title="Suspend">
                                                          <em class="icon ni ni-user-cross-fill"></em>
                                                      </button>
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
                                                                  <li><a href="#"  data-id={{ $user->id }} class="recovery-password-a-tag"><em class="icon ni ni-edit"></em><span>Đổi mật khẩu</span></a>
                                                                
                                                                  <li class="divider"></li>
                                                                  <li><a href="/thanh-vien/{{ $user->id }}"><em class="icon ni ni-eye"></em><span>Xem thông tin</span></a></li>

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
                                <button class="d-none" id="open-modal-btn" data-bs-toggle='modal' data-bs-target='#passwordModalForm'></button></li>
                            </div>
                        </div><!-- .card-preview -->
                    </div> <!-- nk-block -->
                <!-- .components-preview -->
   
@endsection

@section('modal')
<div class="modal fade" id="passwordModalForm" style="display: none;" aria-hidden="true">
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
            <div class="modal-footer bg-light">
                <span class="sub-text">Modal Footer Text</span>
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

    $('.btn-suspend').click(function(){

        var user_id = $(this).data('id');
        var status = $(this).data('value');

        var message = (status == 0) ? 'Bạn có chắc muốn khóa tài khoản của người dùng này?' : 'Bạn có chắc muốn mở khóa tài khoản của người dùng này?'
        
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

                
                if(res.status == 0){
                    contentHTML = '<span class="tb-status text-success">Active</span>' 
                }
                else if (res.status == 1){
                    contentHTML = '<span class="tb-status text-danger">Suspend</span>' 
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
   
  


    })


    $('.recovery-password-a-tag').click(function(){

        var user_id = $(this).data('id');
        
        $('#passwordForm').attr('action', `/admin/user/${user_id}`);



        $('#open-modal-btn').click();

        $('#passwordForm').submit(function() {
            Swal.fire({
                    icon: 'success',
                    title: `Đổi mật khẩu thành công!!!`,
                    showConfirmButton: false,
                    timer: 2000
            });
        });
    })

    $('.delete-button').click(function(){
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
   
  
     

  })
        $('.btn-email').click(function(){

        var email = $(this).data('email');
        var subject = 'Đây là email gửi từ quản trị viên!!!';
        var emailBody = 'Xin chào ' + $(this).data('name');
        window.location = "mailto:"+email+"?subject="+subject+"&body="+emailBody;
        // window.location =  `https://mail.google.com/mail/?view=cm&fs=1&to=${email}&su=${subject}&body=${emailBody}`;

        })
</script>
@endsection