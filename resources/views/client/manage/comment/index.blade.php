@extends('client/manage.layouts.app')
@section('pageTitle', 'Bình luận của bạn')

@section('content')
  <div class="nk-fmg-body">
      <div class="nk-fmg-body-content">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between position-relative">               
                <div class="nk-block-head-content">
                    <ul class="nk-block-tools g-1">           
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
                          <th class="nk-tb-col"><span class="sub-text">Ngày bình luận</span></th>
  
                          <th class="nk-tb-col tb-col-lg"><span class="sub-text">Bình luận về</span></th>
                          <th class="nk-tb-col tb-col-lg"><span class="sub-text">Số lượt phản hồi</span></th>
                          {{-- <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ngày thêm</span></th> --}}
                          <th class="nk-tb-col nk-tb-col-tools text-end">
                        </th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($comments as $comment)
  
                      <tr class="nk-tb-item" id ="row-{{ $comment->id }}">
  
                          <td class="nk-tb-col">
                            <span>{{  $comment->created_at  }}</span>
                          </td>
                          <td class="nk-tb-col tb-col-lg">
                            @switch($comment->type_id)
                            @case(1)

                              <a href="/quan-ly/chi-tiet-tai-lieu/{{$comment->identifier_id}}">
                                <span class="badge rounded-pill bg-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Nhấn vào để xem bình luận">
                                  {{ Str::limit($comment->identifier->name,30) }}
                                </span>
                              </a>
                            
                              @break

                            @case(2)
                              <a href="/quan-ly/chi-tiet-sach/{{$comment->identifier_id}}">
                              <span class="badge rounded-pill bg-outline-primary" data-bs-toggle="tooltip" data-bs-placement="top"  title="Nhấn vào để xem bình luận">
                                {{ Str::limit($comment->identifier->name,30) }}
                              </span>
                              </a>
                              @break

                            @case(3)
                              <a href="/dien-dan/{{ $comment->identifier->forums->slug }}/{{ $comment->identifier->slug }}/{{ $comment->identifier->id }}">
                                <span class="badge rounded-pill bg-outline-success" data-bs-toggle="tooltip" data-bs-placement="top"  title="Nhấn vào để xem bình luận">
                                  {{ Str::limit($comment->identifier->topic,30) }}
                                </span>
                                @break
                              </a>
                            @default
                              <span class="badge rounded-pill bg-outline-success"></span>
                          @endswitch

                          </td>
                          <td class="nk-tb-col tb-col-lg">
                            <span>{{  $comment->totalReplies  }}</span>
                          </td>
                          <td class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1">                       
                                <li>
                                    <div class="drodown">
                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="#" class="delete-button-book" data-id="{{ $comment->id }}">
                                                  <em class="icon ni ni-trash"></em><span>Xóa</span>
                                                </a>
  
                                                <li>
                                                  <a href="#" class="content-btn" data-id={{ $comment->id }}>
                                                    <em class="icon ni ni-notice"></em><span>Nội dung</span>
                                                  </a>
          
                                                </li>

                                                </li>
                                                <li><a href="/quan-ly/binh-luan/phan-hoi/{{ $comment->id }}"><em class="icon ni ni-reply-all"></em><span>Xem phản hồi</span></a></li>
                                            
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
        
            var comment_id = $(this).data('id');

            Swal.fire({
                title: "Bạn muốn xóa bình luận này?",
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
                    url:'/xoa-binh-luan/' + comment_id,
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

                    $("#row-" + comment_id).fadeOut();
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                    // If fail
                    console.log(textStatus + ': ' + errorThrown);
                    });
                
                }
            })

  


    })

    $('#DataTables_Table_0 tbody').on('click','.content-btn',function(e){
          e.preventDefault();

        
          var comment_id = $(this).data('id');
          $('#modalContent').find('.modal-body').empty();


          $.ajax({
          type:"GET",
          url:'/quan-ly/binh-luan/getContent/' + comment_id,     
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