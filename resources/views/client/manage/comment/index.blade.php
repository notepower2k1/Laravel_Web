@extends('client/manage/layouts.app')
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
              <ul class="nav nav-tabs nav-tabs-s2">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tabItem5"><em class="icon ni ni-book"></em><span>Sách</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tabItem6"><em class="icon ni ni-file-docs"></em><span>Tài liệu</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tabItem7"><em class="icon ni ni-list-fill"></em><span>Bài viết</span></a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tabItem5">
                  <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false" data-export-title="Export">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col"><span class="sub-text">Ngày bình luận</span></th>
    
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Sách</span></th>
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Số lượt phản hồi</span></th>
                            {{-- <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ngày thêm</span></th> --}}
                            <th class="nk-tb-col nk-tb-col-tools text-end">
                          </th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($book_comments as $comment)
    
                        <tr class="nk-tb-item" id ="row-book-{{ $comment->id }}">
    
                            <td class="nk-tb-col">
                              <span>{{  $comment->created_at  }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                              <span>{{  $comment->books->name  }}</span>

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
    
                                                  </li>
                                                  <li><a href="/sach/{{ $comment->books->id }}/{{ $comment->books->slug }}"><em class="icon ni ni-edit"></em><span>Xem</span></a></li>
                                              
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
                <div class="tab-pane" id="tabItem6">
                  <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false" data-export-title="Export">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col"><span class="sub-text">Ngày bình luận</span></th>
    
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Tài liệu</span></th>
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Số lượt phản hồi</span></th>
                            {{-- <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ngày thêm</span></th> --}}
                            <th class="nk-tb-col nk-tb-col-tools text-end">
                          </th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($document_comments as $comment)
    
                        <tr class="nk-tb-item" id ="row-document-{{ $comment->id }}">
    
                            <td class="nk-tb-col">
                              <span>{{  $comment->created_at  }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                              <span>{{  $comment->documents->name  }}</span>

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
                                                  <li><a href="#" class="delete-button-document" data-id="{{ $comment->id }}">
                                                    <em class="icon ni ni-trash"></em><span>Xóa</span>
                                                  </a>
    
                                                  </li>
                                                  <li><a href="/tai-lieu/{{ $comment->documents->id }}/{{ $comment->documents->slug }}"><em class="icon ni ni-edit"></em><span>Xem</span></a></li>
                                              
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
                <div class="tab-pane" id="tabItem7">
                  <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false" data-export-title="Export">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col"><span class="sub-text">Ngày bình luận</span></th>
    
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Bài viết</span></th>
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Số lượt phản hồi</span></th>
                            {{-- <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ngày thêm</span></th> --}}
                            <th class="nk-tb-col nk-tb-col-tools text-end">
                          </th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($post_comments as $comment)
    
                        <tr class="nk-tb-item" id ="row-post-{{ $comment->id }}">
    
                            <td class="nk-tb-col">
                              <span>{{  $comment->created_at  }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                              <span>{{  $comment->posts->topic  }}</span>

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
                                                  <li><a href="#" class="delete-button-post" data-id="{{ $comment->id }}">
                                                    <em class="icon ni ni-trash"></em><span>Xóa</span>
                                                  </a>
    
                                                  </li>
                                                  <li><a href="/dien-dan/{{ $comment->posts->forums->slug }}/{{ $comment->posts->slug }}/{{ $comment->posts->id  }}"><em class="icon ni ni-edit"></em><span>Xem</span></a></li>
                                              
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
                    url:'/xoa-binh-luan/1/' + comment_id,
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

                    $("#row-book-" + comment_id).fadeOut();
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                    // If fail
                    console.log(textStatus + ': ' + errorThrown);
                    });
                
                }
            })

  


    })

    $('#DataTables_Table_1 tbody').on('click','.delete-button-document',function(){
        
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
                url:'/xoa-binh-luan/0/' + comment_id,
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

                $("#row-document-" + comment_id).fadeOut();
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                });
            
            }
        })




    })


    $('#DataTables_Table_2 tbody').on('click','.delete-button-post',function(){
        
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
                url:'/xoa-binh-luan/2/' + comment_id,
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

                $("#row-post-" + comment_id).fadeOut();
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