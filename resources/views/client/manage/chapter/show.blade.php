@extends('client/manage.layouts.app')
@section('pageTitle', 'Danh sách chương')
@section('content')

<div class="nk-fmg-body">
    <div class="nk-fmg-body-head d-none d-lg-flex">
          <div class="nk-fmg-actions">
              <ul class="nk-block-tools g-3">
                  <li>
                    <a href="{{ route('sach.index') }}" class="btn btn-light"><em class="icon ni ni-arrow-left"></em> <span>Quay lại</span></a>                    
                  </li>
                  <li>
                    <a href="/quan-ly/them-chuong/{{ $book_id }}" class="btn btn-primary"><em class="icon ni ni-plus"></em> <span>Thêm chương</span></a>
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
                                  <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                  <div class="dropdown-menu dropdown-menu-end">
                                      <ul class="link-list-opt no-bdr">
                                          <li><a href="{{ route('sach.index') }}"><em class="icon ni ni-arrow-left"></em> <span>Quay lại</span></a></li>
                                          <li><a href="/quan-ly/them-chuong/{{ $book_id }}"><em class="icon ni ni-plus"></em> <span>Thêm chương</span></a>                                     </li>
                                      </ul>
                                  </div>
                              </div>
                          </li>
                          <li class="d-lg-none me-n1"><a href="#" class="btn btn-trigger btn-icon toggle" data-target="files-aside"><em class="icon ni ni-menu-alt-r"></em></a></li>
                      </ul>
                  </div>             
              </div>
        </div>
        <div class="nk-fmg-quick-list nk-block" style="min-height:100vh">
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false" data-export-title="Export">
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
        </div>
  
    </div>
</div> <!-- nk-block -->
<!-- .components-preview -->
    
@endsection


@section('additional-scripts')

<script src="{{ asset('assets/js/libs/datatable-btns.js?ver=3.1.2') }}"></script>
<script src="{{ asset('assets/js/example-sweetalert.js?ver=3.1.2') }}" aria-hidden="true"></script>

<script>
$(function(){
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
                url:'/quan-ly/chuong/customDelete/' + chapter_id,
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