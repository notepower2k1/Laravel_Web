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
                                            {{-- <li><a href="/sach/{{ $reply->comments->books->id }}/{{ $reply->comments->books->slug }}"><em class="icon ni ni-edit"></em><span>Xem</span></a></li> --}}
                                        
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

    


    

});



</script>
@endsection