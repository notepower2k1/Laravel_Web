@extends('client/manage.layouts.app')
@section('pageTitle', 'Bình luận của bạn')

@section('content')
  <div class="nk-fmg-body">
    <div class="nk-fmg-body-head d-none d-lg-flex">
        <div class="nk-fmg-actions">
            <ul class="nk-block-tools g-3">
                <li>
                    <a class="btn btn-light" href="/quan-ly/binh-luan"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a>
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
                                <a href="/quan-ly/binh-luan" class="btn btn-trigger btn-icon"><em class="icon ni ni-arrow-left"></em></a>                            
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
                    <th class="nk-tb-col"><span class="sub-text">Ngày phản hồi</span></th>

                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Bình luận của</span></th>
                    <th class="nk-tb-col nk-tb-col-tools text-end">
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($replies as $reply)

                <tr class="nk-tb-item" id ="row-{{ $reply->id }}">

                    <td class="nk-tb-col">
                        <span>{{  $reply->created_at  }}</span>
                    </td>
                    <td class="nk-tb-col tb-col-lg">
                        <span>{{  $reply->comments->users->profile->displayName  }}</span>
                    </td>                
                    <td class="nk-tb-col nk-tb-col-tools">
                        <ul class="nk-tb-actions gx-1">                       
                            <li>
                                <div class="drodown">
                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <ul class="link-list-opt no-bdr">
                                            <li><a href="#" class="delete-button-book" data-id="{{ $reply->id }}">
                                            <em class="icon ni ni-trash"></em><span>Xóa</span>
                                            </a>

                                            </li>
                                            <li>
                                                <a href="#" class="content-btn" data-id={{ $reply->id }}>
                                                <em class="icon ni ni-notice"></em><span>Nội dung</span>
                                                </a>
                                            </li>                                        
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
        </div>
      </div>
  </div> 
   
</div>
   
 
        
   
@endsection
@section('modal')
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
    $('#DataTables_Table_0 tbody').on('click','.delete-button-book',function(){
        
            var reply_id = $(this).data('id');

            Swal.fire({
                title: "Bạn muốn xóa phản hồi này?",
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
                    url:'/xoa-phan-hoi/' + reply_id,
                    data : {
                    },
                    })
                    .done(function(res) {
                    // If successful
                    Swal.fire({
                            icon: 'success',
                            title: `Xóa thành công`,
                            showConfirmButton: false,
                            timer: 2500
                    });

                    $("#row-" + reply_id).fadeOut();
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                    // If fail
                    console.log(textStatus + ': ' + errorThrown);
                    });
                
                }
            })

  


    })


    $('#DataTables_Table_0 tbody').on('click','.content-btn',function(){
      
      var reply_id = $(this).data('id');
      $('#modalContent').find('.modal-body').empty();

      $.ajax({
          type:"GET",
          url:`/quan-ly/binh-luan/phan-hoi/getContent/` + reply_id,     
          })
          .done(function(res) {
          // If successful
              const content = res.content;

              $('#modalContent').find('.modal-body').append(content);

              setTimeout(function(){ 
                  $('#modalContent').modal('show');
              },500);
          })
          .fail(function(jqXHR, textStatus, errorThrown) {
          // If fail
          console.log(textStatus + ': ' + errorThrown);
      });

    });
});
    


    





</script>
@endsection