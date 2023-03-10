@extends('client/layouts.app')
@section('pageTitle', 'Thông tin cá nhân')

@section('content')

<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-aside-wrap">
            <div class="card-inner card-inner-lg">
                <div class="nk-block-head nk-block-head-lg">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h4 class="nk-block-title">Thông tin cá nhân</h4>
                            
                        </div>
                        <div class="nk-block-head-content align-self-start d-lg-none">
                            <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                        </div>
                    </div>
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="nk-data data-list">
                        <div class="data-head">
                            <h6 class="overline-title">Thông tin cơ bản</h6>
                        </div>
                        <div class="data-item">
                            <div class="data-col">
                                <span class="data-label">Họ và tên</span>
                                <span class="data-value">{{Auth::user()->name}}</span>
                            </div>
                            <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>

                        </div><!-- data-item -->
                        <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                            <div class="data-col">
                                <span class="data-label">Biệt danh</span>
                                <span class="data-value">{{Auth::user()->profile->displayName}}</span>
                            </div>
                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                        </div><!-- data-item -->
                        <div class="data-item">
                            <div class="data-col">
                                <span class="data-label">Email</span>
                                <span class="data-value">{{Auth::user()->email}}</span>
                            </div>
                            <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
                        </div><!-- data-item -->                                                                                                    
                        <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                            <div class="data-col">
                                <span class="data-label">Giới tính</span>
                                <span class="data-value">
                                @switch(Auth::user()->profile->gender)
                                @case(0)
                                    Nam
                                    @break

                                @case(1)
                                    Nữ
                                    @break

                                @default
                                    Không công khai
                                @endswitch
                                </span>
                            </div>
                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                        </div><!-- data-item -->
                    </div><!-- data-list -->
                    <div class="nk-data data-list">
                        <div class="data-head">
                            <h6 class="overline-title">Thông tin khác</h6>
                        </div>
                        <div class="data-item">
                            <div class="data-col">
                                <span class="data-label">Ngày tham gia</span>
                                <span class="data-value">{{Auth::user()->created_at->format('d/m/Y')}}</span>
                            </div>
                            <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>

                        </div><!-- data-item -->
                    
                    </div><!-- data-list -->
                </div><!-- .nk-block -->
            </div>
            <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                <div class="card-inner-group" data-simplebar>
                    <div class="card-inner">
                        <div class="user-card">
                            <div class="user-avatar bg-primary">
                                    <img src={{ asset ('storage/avatar/'.Auth::user()->profile->avatar) }} alt="..." />

                            </div>
                            <div class="user-info">
                                <span class="lead-text">{{Auth::user()->name}}</span>
                                <span class="sub-text">{{Auth::user()->email}}</span>
                            </div>
                            <div class="user-action">
                                <div class="dropdown">
                                    <a class="btn btn-icon btn-trigger me-n2" data-bs-toggle="dropdown" href="#"><em class="icon ni ni-more-v"></em></a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <ul class="link-list-opt no-bdr">
                                            <li>
                                            <a data-bs-toggle="modal" data-bs-target="#profile-edit"><em class="icon ni ni-camera-fill"></em><span>Thay đổi thông tin</span></a>

                                            </li>
                                            <li><a data-bs-toggle="modal" data-bs-target="#profile-edit"><em class="icon ni ni-edit-fill"></em><span>Thay đổi ảnh</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .user-card -->
                    </div><!-- .card-inner -->
                    
                    <div class="card-inner p-0">
                        <ul class="link-list-menu">
                            <li><a class="active" href="/trang-ca-nhan"><em class="icon ni ni-user-fill-c"></em><span>Thông tin cá nhân</span></a></li>
                            <li><a href="html/user-profile-activity.html"><em class="icon ni ni-activity-round-fill"></em><span>Lịch sử hoạt động</span></a></li>
                            <li><a href="/doi-mat-khau"><em class="icon ni ni-lock-alt-fill"></em><span>Cài đặt bảo mật</span></a></li>
                        </ul>
                    </div><!-- .card-inner -->
                </div><!-- .card-inner-group -->
            </div><!-- card-aside -->
        </div><!-- .card-aside-wrap -->
    </div><!-- .card -->
</div><!-- .nk-block -->
@endsection 

@section('modal')
 <div class="modal fade" role="dialog" id="profile-edit">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title">Cập nhật thông tin cá nhân</h5>
                    <ul class="nk-nav nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personal">Thông tin cá nhân</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#avatar" aria-selected="false" tabindex="-1" role="tab">Ảnh đại diện</a>
                        </li>   
                    </ul><!-- .nav-tabs -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="personal">
                            <form id="form-profile-edit" method="POST" action="/profile/{{ Auth::user()->profile->id }}">
                                @csrf
                                @method('PUT')
                                <div class="row gy-4">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="form-label" for="displayName">Biệt danh</label>
                                            <input type="text" class="form-control form-control-lg" name="displayName" id="displayName" value="{{Auth::user()->profile->displayName}}" placeholder="Biệt danh của bạn">
                                        </div>
                                    </div>                      
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="form-label" for="gender">Giới tính</label>
                                            <div class="form-control-wrap">
                                                <ul class="custom-control-group">
                                                    <li>
                                                        <div class="custom-control custom-radio custom-control-pro no-control">
                                                            <input type="radio" class="custom-control-input" name="gender" id="sex-male" required="" value=0 {{Auth::user()->profile->gender === 0 ? 'checked' : ''}}>
                                                            <label class="custom-control-label" for="sex-male">Nam</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="custom-control custom-radio custom-control-pro no-control">
                                                            <input type="radio" class="custom-control-input" name="gender" id="sex-female" required="" value=1 {{Auth::user()->profile->gender === 1 ? 'checked' : ''}}> 
                                                            <label class="custom-control-label" for="sex-female">Nữ</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="custom-control custom-radio custom-control-pro no-control">
                                                            <input type="radio" class="custom-control-input" name="gender" id="sex-other" required="" value=2 {{Auth::user()->profile->gender === 2 ? 'checked' : ''}}>
                                                            <label class="custom-control-label" for="sex-other">Không công khai</label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            <li>
                                                <a href="#" class="btn btn-lg btn-primary" data-id="{{ Auth::user()->profile->id }}" data-bs-dismiss="modal" id="btn-profile-edit">Cập nhật thông tin cá nhân</a>
                                            </li>
                                            <li>
                                                <a href="#" data-bs-dismiss="modal" class="link link-light">Quay lại</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div><!-- .tab-pane -->
                        <div class="tab-pane" id="avatar" role="tabpanel">
                            <form id="form-avatar-edit" method="POST" action="/profile/changeAvatar/{{ Auth::user()->profile->id }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                            <div class="row gy-4">
                                <div class="col-md-12">
                                    <div class="user-avatar sq xl">
                                        <img src={{ asset ('storage/avatar/'.Auth::user()->profile->avatar) }} alt="..."  id="previewImage"/>

                                    </div>
                                </div>
                                  
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="form-label" for="customFileLabel">Upload ảnh đại diện</label>
                                        <div class="form-control-wrap">
                                            <div class="form-file">
                                                <input type="file" class="form-file-input" id="customFile" name="image" required>
                                                <label class="form-file-label" for="customFile">Chọn ảnh</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <a href="#" class="btn btn-lg btn-primary" data-bs-dismiss="modal" id="btn-avatar-edit">Cập nhật ảnh đại diện</a>
                                        </li>
                                        <li>
                                            <a href="#" data-bs-dismiss="modal" class="link link-light">Quay lại</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div><!-- .tab-content -->

                   
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div><!-- .modal -->
@endsection 
@section('additional-scripts')
<script>
    
    $('#btn-profile-edit').click(function(e){
        e.preventDefault();
        $('#form-profile-edit').submit();
    })

    $("#customFile").change(function() {
        const file = this.files[0]
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event){
                $('#previewImage').attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
    })
    $('#btn-avatar-edit').click(function(e){
        e.preventDefault();

        $('#form-avatar-edit').submit();
     

    })
</script>

@endsection