@extends('client/homepage.layouts.app')
@section('pageTitle', 'Thông tin cá nhân')
@section('additional-style')
<link href="{{ asset('js/cropper/cropper.min.css') }}" rel="stylesheet" type="text/css">
<link href="
https://cdn.jsdelivr.net/npm/jquery-ui-slider@1.12.1/jquery-ui.min.css
" rel="stylesheet">
<style>
   
#cropModal > img{
    width:100% !important;
}

    h1, h2 {
    font-family: Lato;
  }

  .hidden {
    display: none;
  }

  .container {
    max-width: 640px;
    margin: 20px auto;
  }

  img {
    max-width: 100%;
  }

  .slider-val-area {
    width: 50%;
    padding: 10px 15px 0 10px
  }

  .slider-val-area #min-zoom-val {
    float: left;
  }

  .slider-val-area #max-zoom-val {
    float: right;
  }
</style>
@endsection
@section('content')

<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-aside-wrap">
         
            <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                <div class="card-inner-group" data-simplebar>
                    <div class="card-inner">
                        <div class="user-card">
                            <div class="user-avatar bg-primary">
                                    <img src={{ Auth::user()->profile->url}} alt="..." />

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
                                                @if($updateFlag)
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#profile-edit"><em class="icon ni ni-camera-fill"></em><span>Thay đổi ảnh</span></a>

                                                @else
                                                <a href="#" class="fail-update-btn" ><em class="icon ni ni-camera-fill"></em><span>Thay đổi ảnh</span></a>

                                                @endif

                                            </li>
                                            <li>
                                                @if($updateFlag)
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#profile-edit"><em class="icon ni ni-edit-fill"></em><span>Thay đổi thông tin</span></a>

                                                @else
                                                <a href="#"  class="fail-update-btn" ><em class="icon ni ni-edit-fill"></em><span>Thay đổi thông tin</span></a>

                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .user-card -->
                    </div><!-- .card-inner -->
                    
                    <div class="card-inner p-0">
                        <ul class="link-list-menu">
                            <li><a href="#"><em class="icon ni ni-user-fill-c"></em><span>Thông tin cá nhân</span></a></li>
                            <li><a href="/quan-ly/binh-luan"><em class="icon ni ni-activity-round-fill"></em><span>Lịch sử hoạt động</span></a></li>
                            <li>
                                @if($updateFlag)
                                <a href="#" data-bs-toggle="modal" data-bs-target="#profile-edit"><em class="icon ni ni-lock-alt-fill"></em><span>Cài đặt bảo mật</span></a>

                                @else
                                <a href="#" class="fail-update-btn" ><em class="icon ni ni-lock-alt-fill"></em><span>Cài đặt bảo mật</span></a>

                                @endif
                            </li>
                        </ul>
                    </div><!-- .card-inner -->
                </div><!-- .card-inner-group -->
            </div><!-- card-aside -->
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
                                <span class="data-label">Tên tài khoản</span>
                                <span class="data-value">{{Auth::user()->name}}</span>
                            </div>
                            <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>

                        </div><!-- data-item -->
                        <div class="data-item">
                            <div class="data-col">
                                <span class="data-label">Biệt danh</span>
                                <span class="data-value">{{Auth::user()->profile->displayName}}</span>
                            </div>
                            @if($updateFlag)
                            <div class="data-col data-col-end">
                                <span class="data-more" data-bs-toggle="modal" data-bs-target="#profile-edit"><em class="icon ni ni-forward-ios"></em></span>
                            </div>
                            @else
                            <div class="data-col data-col-end">
                                <span class="data-more fail-update-btn"><em class="icon ni ni-forward-ios"></em></span>
                            </div>
                            @endif
                        </div><!-- data-item -->
                        <div class="data-item">
                            <div class="data-col">
                                <span class="data-label">Email</span>
                                <span class="data-value">{{Auth::user()->email}}</span>
                            </div>
                            <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
                        </div><!-- data-item -->                                                                                                    
                        <div class="data-item">
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
                            @if($updateFlag)
                            <div class="data-col data-col-end">
                                <span class="data-more" data-bs-toggle="modal" data-bs-target="#profile-edit"><em class="icon ni ni-forward-ios"></em></span>
                            </div>
                            @else
                            <div class="data-col data-col-end">
                                <span class="data-more fail-update-btn"><em class="icon ni ni-forward-ios"></em></span>
                            </div>
                            @endif
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
                    @if($errors->any())
                    <div class="alert alert-warning">
                        @foreach ($errors->all() as $error)
                            <div class="">{{ $error }}</div>
                        @endforeach
        
                    </div>
                    @endif
                    <ul class="nk-nav nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personal">Thông tin cá nhân</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#avatar" aria-selected="false" tabindex="-1" role="tab">Ảnh đại diện</a>
                        </li>   

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#password" aria-selected="false" tabindex="-1" role="tab">Đổi mật khẩu</a>
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
                                <input name="oldImage" type="hidden" value="{{  Auth::user()->profile->avatar }}">

                                <div class="row gy-4">
                                    <div class="col-md-12">
                                        <div class="user-avatar sq xl">       
                                            <img src={{ Auth::user()->profile->url }} alt="..."  id="showNewImage"/>                                    
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="form-label" for="customFileLabel">Upload ảnh đại diện</label>
                                            <div class="form-control-wrap">
                                                <div class="form-file">
                                                    <input type="file" class="form-file-input" id="avatarUpload" name="image" required>
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

                        <div class="tab-pane" id="password" role="tabpanel">
                            <form method="POST" action="/user/{{ Auth::user()->id }}">
                                @csrf
                                @method('PUT')
                                 <div class="form-group">
                                    <label for="password" class="form-label">{{ __('Mật khẩu') }}</label>
                                
                                    <div class="form-control-wrap">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="password-confirm" class="form-label">{{ __('Xác nhận mật khẩu') }}</label>
                                
                                    <div class="form-control-wrap">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
                                
                                
                                <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                                </form>
                        </div>
                    </div><!-- .tab-content -->

                   
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div><!-- .modal -->

    <div class="modal fade modal-fullscreen" role="dialog" id="cropModal"  data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">Crop avatar 128 x 128</h5>
                </div>
                <div class="modal-body modal-body-lg">
                    <div class="d-flex justify-content-center">
                        <div class="border">
                            <img src="" id="cropper-img" />
                        </div>
                        {{-- <img class="border" src="" alt="" id="result" style="width:128px;height:128px" > --}}
                    </div>

                    {{-- <input id="zoom-slider" step=".05" min="0.1" max="5.45" value="1" type="range"> --}}
                    <div id="zoom-slider" class="mt-2"></div>
                    {{-- <div class="row">
                        <div class="slider-val-area">
                            <span id="min-zoom-val" class="pull-left">0</span>
                        </div>
                        <div class="slider-val-area">
                            <span id="max-zoom-val" class="pull-right">1</span>
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn btn-outline-primary" id="cropImageBtn">Bắt đầu crop</button>
                    <button class="btn btn-outline-warning" id="acceptCropBtn">Xuất ảnh</button>
                </div>
            </div>
        </div>
    </div>

@endsection 
@section('additional-scripts')
<script src="{{ asset('js/cropper/cropper.min.js') }}" ></script>
<script src="
https://cdn.jsdelivr.net/npm/jquery-ui-slider@1.12.1/jquery-ui.min.js
"></script>

<script>
    var isInitialized = false;
    var cropper = '';
    var updatedImage = '';

    var _URL = window.URL || window.webkitURL;
    // Initialize Slider

    $(document).ready(function () {

        $("#zoom-slider").slider({
            orientation: "horizontal",
            range: "min",
            max: 1,
            min: 0,
            value: 0,
            step: 0.0001,
            slide: function () {
                if (isInitialized == true) {
                  
                    var currentValue = $("#zoom-slider").slider("value");
                    var zoomValue = parseFloat(currentValue);
                    cropper.zoomTo(zoomValue.toFixed(4));
                    
                }
            }
        });
    });


       


    $('.fail-update-btn').click(function(){
        Swal.fire({
                    icon: 'info',
                    title: `Bạn vừa cập nhật thông tin trong hôm nay, hãy đợi hôm sau!!!`,
                    showConfirmButton: false,
                    timer: 2500
                });
    })

    $('#btn-profile-edit').click(function(e){
        e.preventDefault();

        Swal.fire({
            icon: 'success',
            title: `Cập nhật thông tin cá nhân thành công`,
            showConfirmButton: false,
            timer: 2500
        });
        $('#form-profile-edit').submit();
    })

    $("#avatarUpload").change(function() {

        const file = this.files[0]
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event){

                var image = new Image();

                //Set the Base64 string return from FileReader as source.
                image.src = event.target.result;

                image.onload = function () {
                var height = this.height;
                var width = this.width;

                if (height > 128 || width > 128) {
                    $('#cropModal').modal('show');
                    // $('#firstCropImage').attr('src', event.target.result);
                    $("#cropImageBtn").removeAttr('disabled');
                    // $('#result').attr('src', event.target.result);
                    $("#cropper-img").attr('src',event.target.result);
                    $('#cropper-img').addClass('ready');
                    if (isInitialized == true) {
                        $('#zoom-slider').val(0);
                        cropper.destroy();
                    }
                }
                else{
                    $('#showNewImage').attr('src', event.target.result)
                }

                };
             
            }
            reader.readAsDataURL(file);
        }
    })
    
    function initCropper() {
        var vEl = document.getElementById('cropper-img');
        cropper = new Cropper(vEl, {
            autoCropArea: 1,
            viewMode: 1,
            dragMode: 'move',
            aspectRatio: 128/128,
            minCropBoxWidth: 128,
            minCropBoxHeight: 128,
            checkOrientation: false,
            cropBoxMovable: false,
            cropBoxResizable: false,
            zoomOnTouch: false,
            zoomOnWheel: false,
            guides: false,
            highlight: false,
            
            ready: function (e) {
                var cropper = this.cropper;
                cropper.zoomTo(0);

                var imageData = cropper.getImageData();
                console.log("imageData ", imageData);
                var minSliderZoom = imageData.width / imageData.naturalWidth;

                $('#min-zoom-val').html(minSliderZoom.toFixed(4));

                $(".cr-slider-wrap").show();
                $("#zoom-slider").slider("option", "max", 1);
                $("#zoom-slider").slider("option", "min", minSliderZoom);
                $("#zoom-slider").slider("value", minSliderZoom);
            },
            crop: () => {
                const canvas = cropper.getCroppedCanvas();
                updatedImage = canvas.toDataURL('image/jpeg');
            },
        });
        isInitialized = true;
    }

    $('#cropImageBtn').click(function(e){
        e.preventDefault();

        $(this).attr('disabled','disabled');

        initCropper();
    })

    $('#acceptCropBtn').click(function(e) {
            e.preventDefault();
            $('#showNewImage').attr('src', updatedImage)

            const file = base64ToFile(updatedImage);

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);

            const fileInput = document.getElementById('avatarUpload');

            fileInput.files = dataTransfer.files;
            $('#cropModal').modal('hide');

            console.log(file);
    })

    $('#cropModal').on('hidden.bs.modal', function(event) {
        cropper.destroy();
       
    })
 
    $('#zoom-slider').on("input",function(event) {

        if (isInitialized == true) {    
            var currentValue = $(this).val();
            var zoomValue = parseFloat(currentValue);
            cropper.zoomTo(zoomValue.toFixed(4));
            
        }
    })

    $('#btn-avatar-edit').click(function(e){
        e.preventDefault();

        Swal.fire({
                    icon: 'success',
                    title: `Cập nhật thông tin ảnh đại diện thành công`,
                    showConfirmButton: false,
                    timer: 2500
                });
        $('#form-avatar-edit').submit();
     

    })

    base64ToFile = (url) => {
        let arr = url.split(',');
        // console.log(arr)
        let mime = arr[0].match(/:(.*?);/)[1];
        let data = arr[1];

        let dataStr = atob(data);
        let n = dataStr.length;
        let dataArr = new Uint8Array(n);

        while (n--) {
        dataArr[n] = dataStr.charCodeAt(n);
        }

        let file = new File([dataArr], 'image.jpeg', { type: mime });


        return file;

    };
</script>

@endsection