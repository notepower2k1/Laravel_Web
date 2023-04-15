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
                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Bình luận về</span></th>
                    <th class="nk-tb-col nk-tb-col-tools text-end">
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($book_comment_replies as $reply)

                <tr class="nk-tb-item" id ="row-book-{{ $reply->id }}">

                    <td class="nk-tb-col">
                        <span>{{  $reply->created_at  }}</span>
                    </td>
                    <td class="nk-tb-col tb-col-lg">
                        <span>{{  $reply->comments->users->profile->displayName  }}</span>
                    </td>
                    <td class="nk-tb-col tb-col-lg">
                        <span class="badge bg-outline-primary">Sách</span>
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
                                            <li><a href="/sach/{{ $reply->comments->books->id }}/{{ $reply->comments->books->slug }}"><em class="icon ni ni-edit"></em><span>Xem</span></a></li>
                                        
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </td>
                </tr><!-- .nk-tb-item  -->
                @endforeach

                @foreach ($document_comments_replies as $reply)

                <tr class="nk-tb-item" id ="row-document-{{ $reply->id }}">

                    <td class="nk-tb-col">
                    <span>{{  $reply->created_at  }}</span>
                    </td>
                    <td class="nk-tb-col tb-col-lg">
                    <span>{{  $reply->comments->users->profile->displayName  }}</span>
                    </td>
                    <td class="nk-tb-col tb-col-lg">
                    <span class="badge bg-outline-secondary">Tài liệu</span>
                    </td>
                    <td class="nk-tb-col nk-tb-col-tools">
                    <ul class="nk-tb-actions gx-1">                       
                        <li>
                            <div class="drodown">
                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="#" class="delete-button-document" data-id="{{ $reply->id }}">
                                            <em class="icon ni ni-trash"></em><span>Xóa</span>
                                        </a>

                                        </li>
                                        <li><a href="/tai-lieu/{{ $reply->comments->documents->id }}/{{ $reply->comments->documents->slug }}"><em class="icon ni ni-edit"></em><span>Xem</span></a></li>
                                    
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </td>
                </tr><!-- .nk-tb-item  -->
                @endforeach

                @foreach ($post_comments_replies as $reply)

                <tr class="nk-tb-item" id ="row-post-{{ $reply->id }}">

                    <td class="nk-tb-col">
                    <span>{{  $reply->created_at  }}</span>
                    </td>
                    <td class="nk-tb-col tb-col-lg">
                    <span>{{  $reply->comments->users->profile->displayName  }}</span>
                    </td>
                    <td class="nk-tb-col tb-col-lg">
                    <span class="badge bg-outline-info">Bài viết</span>
                    </td>
                    <td class="nk-tb-col nk-tb-col-tools">
                    <ul class="nk-tb-actions gx-1">                       
                        <li>
                            <div class="drodown">
                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="#" class="delete-button-post" data-id="{{ $reply->id }}">
                                            <em class="icon ni ni-trash"></em><span>Xóa</span>
                                        </a>

                                        </li>
                                        <li><a href="/dien-dan/{{ $reply->comments->posts->forums->slug }}/{{ $reply->comments->posts->slug }}/{{ $reply->comments->posts->id  }}"><em class="icon ni ni-edit"></em><span>Xem</span></a></li>
                                    
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
                    url:'/xoa-phan-hoi/1/' + reply_id,
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

                    $("#row-book-" + reply_id).fadeOut();
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                    // If fail
                    console.log(textStatus + ': ' + errorThrown);
                    });
                
                }
            })

  


    })

    $('#DataTables_Table_0 tbody').on('click','.delete-button-document',function(){
        
        var reply_id = $(this).data('id');

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
                url:'/xoa-phan-hoi/0/' + reply_id,
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

                $("#row-document-" + reply_id).fadeOut();
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                });
            
            }
        })




    })


    $('#DataTables_Table_0 tbody').on('click','.delete-button-post',function(){
        
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
                url:'/xoa-phan-hoi/2/' + reply_id,
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

                $("#row-post-" + reply_id).fadeOut();
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