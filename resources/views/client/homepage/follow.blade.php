@extends('client/homepage.layouts.app')
@section('additional-style')
<style>
    .nk-content{
        background-image:url('https://raw.githubusercontent.com/notepower2k1/MyImage/main/banner/main-banner-1.png') !important;
        background-repeat: no-repeat;
        background-position: left top;

    }
    .container{
        margin-top:250px  !important;
    }
</style>
@endsection
@section('content')
<div class="container">
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
          
        </div>
        <div class="card card-bordered card-preview" id="mark-book-box" >
            <ul class="nav nav-tabs nav-tabs-s2">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tabItem9">Đang xem</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tabItem10">Đã xem xong</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tabItem9">
                    
                        <table class="table table-ulogs">
                            <thead class="table-light">
                                <tr>
                                    <th class="nk-tb-col"><span class="overline-title">Sách/Tài liệu</span></th>
                                    <th class="nk-tb-col tb-col-mb"><span class="overline-title">Số trang/chương</span></th>
                                    <th class="nk-tb-col tb-col-mb"><span class="overline-title">Lần cập nhật cuối</span></th>
                                    <th class="nk-tb-col nk-tb-col-tools text-end"><span class="overline-title">#</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($follow_notDone as $follow)
                                <tr id ="row-{{ $follow->id }}">
                                    <td class="nk-tb-col">
                
                                        <div class="user-card">
                                            <div class="avatar bg-primary">
                
                                                @if($follow->type_id ==1)
                                                <a href="/tai-lieu/{{$follow->identifier->id}}/{{$follow->identifier->slug}}">
                                                    <img class="image-fluid" src={{ $follow->identifier->url }} alt="..." style="width:100px" />
                                                </a>
                                                @endif
                                                @if($follow->type_id ==2)
                                                <a href="/sach/{{$follow->identifier->id}}/{{$follow->identifier->slug}}">
                                                    <img class="image-fluid" src={{ $follow->identifier->url }} alt="..." style="width:100px" />
                                                </a>
                                                @endif
                                            </div>
                                            <div class="ms-2">
                                                <span class="tb-lead text-">{{ $follow->identifier->name }}<span class="dot dot-success d-md-none ms-1"></span></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col tb-col-mb">
                                        @if($follow->type_id == 1)
            
                                            <span>{{ $follow->identifier->numberOfPages }} trang</span>
            
                                        @endif
                
                                        @if($follow->type_id == 2)
                                            @if ($follow->identifier->file == null)
                                                <span>{{ $follow->identifier->numberOfChapter }} chương</span>
                                            @else
                                                <span>PDF</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="nk-tb-col tb-col-mb">
                
                                        @if($follow->type_id == 1)
                                        <span class="badge badge-dot bg-primary">{{ $follow->time }}</span>
                                        @endif
                
                                        @if($follow->type_id == 2)
                                        <span class="badge badge-dot bg-success">{{ $follow->time }}</span>
                                        @endif
                
                                   
                                    </td>
                                    
                                    <td class="nk-tb-col nk-tb-col-tools text-end">
                                        <ul class="nk-tb-actions gx-1">                             
                                          
                                            <li class="me-2">
                
                                                <button class="btn btn-info me-sm-n1 check-book-mark" data-id="{{ $follow->id }}" data-name="{{ $follow->identifier->name }}">
                                                    <em class="icon ni ni-check-thick"></em>
                                                </button>
                                               
                                            </li>
                                            <li>
                                                <button class="btn btn-danger me-sm-n1 remove-book-mark" data-id="{{ $follow->id }}" data-name="{{ $follow->identifier->name }}">
                                                    <em class="icon ni ni-cross"></em></button>
                                            </li>
                                                      
                                                    
                                            
                                        </ul>
                                        
                                    </td>
                                </tr>
                                @endforeach
                
                
                            </tbody>
                        </table>
                
                        
                </div>
                <div class="tab-pane" id="tabItem10">
                        <table class="table table-ulogs">
                            <thead class="table-light">
                                <tr>
                                    <th class="nk-tb-col"><span class="overline-title">Sách/Tài liệu</span></th>
                                    <th class="nk-tb-col tb-col-mb"><span class="overline-title">Số trang/chương</span></th>
                                    <th class="nk-tb-col tb-col-mb"><span class="overline-title">Lần cập nhật cuối</span></th>
                                    <th class="nk-tb-col nk-tb-col-tools text-end"><span class="overline-title">#</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($follow_isDone as $follow)
                                <tr id ="row-{{ $follow->id }}">
                                    <td class="nk-tb-col">
                
                                        <div class="user-card">
                                            <div class="avatar bg-primary">
                
                                                @if($follow->type_id ==1)
                                                <a href="/tai-lieu/{{$follow->identifier->id}}/{{$follow->identifier->slug}}">
                                                    <img class="image-fluid" src={{ $follow->identifier->url }} alt="..." style="width:100px" />
                                                </a>
                                                @endif
                                                @if($follow->type_id ==2)
                                                <a href="/sach/{{$follow->identifier->id}}/{{$follow->identifier->slug}}">
                                                    <img class="image-fluid" src={{ $follow->identifier->url }} alt="..." style="width:100px" />
                                                </a>
                                                @endif
                                            </div>
                                            <div class="ms-2">
                                                <span class="tb-lead text-">{{ $follow->identifier->name }}<span class="dot dot-success d-md-none ms-1"></span></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col tb-col-mb">
                                        @if($follow->type_id == 1)
            
                                            <span>{{ $follow->identifier->numberOfPages }} trang</span>
            
                                        @endif
                
                                        @if($follow->type_id == 2)
                                            @if ($follow->identifier->file == null)
                                                <span>{{ $follow->identifier->numberOfChapter }} chương</span>
                                            @else
                                                <span>PDF</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="nk-tb-col tb-col-mb">
                
                                        @if($follow->type_id == 1)
                                        <span class="badge badge-dot bg-primary">{{ $follow->time }}</span>
                                        @endif
                
                                        @if($follow->type_id == 2)
                                        <span class="badge badge-dot bg-success">{{ $follow->time }}</span>
                                        @endif
                
                                   
                                    </td>
                                    
                                    <td class="nk-tb-col nk-tb-col-tools text-end">
                                        <ul class="nk-tb-actions gx-1">                             
                                          
                                            <li class="me-2">
                
                                                <button class="btn btn-info me-sm-n1 check-book-mark" data-id="{{ $follow->id }}" data-name="{{ $follow->identifier->name }}">
                                                    <em class="icon ni ni-check-thick"></em>
                                                </button>
                                                
                                               
                                            </li>
                                            <li>
                                                <button class="btn btn-danger me-sm-n1 remove-book-mark" data-id="{{ $follow->id }}" data-name="{{ $follow->identifier->name }}">
                                                    <em class="icon ni ni-cross"></em></button>
                                            </li>
                                                      
                                                    
                                            
                                        </ul>
                                        
                                    </td>
                                </tr>
                                @endforeach
                
                
                            </tbody>
                        </table>
                
                        
                </div>
              
            </div>
        </div>
      
      
    </div>
</div>


@endsection
@section('additional-scripts')
<script src="{{ asset('assets/js/example-sweetalert.js?ver=3.1.2') }}" aria-hidden="true"></script>

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    $(function() {
        updateStatus();
    })

    function updateStatus(){
            $.ajax({
                url:'/following-status-all-update',
                type:"GET",
                data:{            
                }
            })
            .done(function(res) {
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
            });    
    }

$('.remove-book-mark').click(function(){
    var id = $(this).attr("data-id");
    var name = $(this).attr("data-name");


    Swal.fire({
        title: "Bạn muốn bỏ theo dõi "+ name,
        text: "Bạn sẽ không còn được nhận thông báo khi có cập nhật mới!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Bỏ theo dõi',
        cancelButtonText: 'Không'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type:"DELETE",
                url:'/sach-theo-doi/' + id,
                data : {
                    "id": id
                },
                })
                .done(function(res) {
                // If successful
                        Swal.fire({
                        icon: 'success',
                        title: `${res.success}`,
                        showConfirmButton: false,
                        timer: 2500
                    });
                    $("#row-" + id).fadeOut();
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                })
         
        }
        })
   
})


$(document).on('click','.check-book-mark',function() {
    var book_mark_id = $(this).attr("data-id");
    var book_mark_name = $(this).attr("data-name");

    Swal.fire({
        title: "Bạn muốn đổi trạng thái "+ book_mark_name,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Không'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type:"GET",
                url:'/following-isDone-update',
                data : {
                    "id": book_mark_id,
                    },
                })
                .done(function(res) {
                // If successful
                        Swal.fire({
                        icon: 'success',
                        title: `${res.success}`,
                        showConfirmButton: false,
                        timer: 2500
                    });
                    $("#row-" + book_mark_id).fadeOut();
                    $("#mark-book-box").load(" #mark-book-box > *");

                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                })
         
        }
        })
})
</script>
@endsection