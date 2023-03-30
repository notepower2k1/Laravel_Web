@extends('client/manage/layouts.app')
@section('pageTitle', 'Bài viết đã đăng')

@section('content')
<div class="nk-fmg-body">
  <div class="nk-fmg-body-content">
      <div class="nk-fmg-quick-list nk-block" style="min-height:100vh">
        <div class="card card-bordered card-preview">
          <div class="card-inner">
              <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false" data-export-title="Export">
                  <thead>
                      <tr class="nk-tb-item nk-tb-head">
                          <th class="nk-tb-col"><span class="sub-text">Ngày đăng</span></th>
  
                          <th class="nk-tb-col tb-col-lg"><span class="sub-text">Topic</span></th>
                          <th class="nk-tb-col tb-col-lg"><span class="sub-text">Diễn đàn</span></th>
                          <th class="nk-tb-col tb-col-lg"><span class="sub-text">Tổng bình luận</span></th>
                          {{-- <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ngày thêm</span></th> --}}
                          <th class="nk-tb-col nk-tb-col-tools text-end">
                        </th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($posts as $post)
  
                      <tr class="nk-tb-item" id ="row-{{ $post->id }}">
  
                          <td class="nk-tb-col">
                            <span>{{  $post->created_at  }}</span>
                          </td>
                          <td class="nk-tb-col tb-col-lg">
                            <span>{{  $post->topic  }}</span>

                          </td>
                          <td class="nk-tb-col tb-col-lg">
                            <span>{{  $post->forums->name  }}</span>
                          </td>
                          <td class="nk-tb-col tb-col-lg">
                            <span>{{ $post->totalComments }}</span>
  
                          </td>
                      
                          <td class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1">                       
                                <li>
                                    <div class="drodown">
                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="#" class="delete-button" data-id="{{ $post->id }}" data-name="{{ $post->topic }}">
                                                  <em class="icon ni ni-trash"></em><span>Xóa</span>
                                                </a>
  
                                                </li>
                                                <li><a href="/dien-dan/{{$post->forums->slug}}/{{$post->slug}}/{{$post->id}}"><em class="icon ni ni-edit"></em><span>Xem</span></a></li>
                                            
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
   
 
        
   
@endsection


@section('additional-scripts')
<script src="{{ asset('assets/js/libs/datatable-btns.js?ver=3.1.2') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/js/bootstrap5-toggle.jquery.min.js"></script>
<script src="{{ asset('assets/js/example-sweetalert.js?ver=3.1.2') }}" aria-hidden="true"></script>

<script>

  $(function(){
    $('#DataTables_Table_0 tbody').on('click','.delete-button',function(){
        var post_id = $(this).data('id');
        var topic = $(this).data('name');

        
        Swal.fire({
        title: "Bạn muốn bài đăng " + topic,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa bài đăng',
        cancelButtonText: 'Không'
        }).then((result) => {
        if (result.isConfirmed) {

        $.ajax({
                type:"GET",
                url:'/xoa-bai-viet',
                data: {
                    'post_id':post_id
                }
                })
                .done(function(res) {
                // If successful

                var result = res.message;
                // console.log(res.message);
                $("#row-" + post_id).fadeOut();

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