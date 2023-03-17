@extends('admin/layouts.app')
@section('pageTitle', 'Danh sách bài đăng')

@section('content')
    {{-- <a href="/admin/forum/post/create/{{$forum_id}}" class="btn btn-primary">Thêm bài đăng</a>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">Topic</th>
            <th >Created by</th>
            <th>Created At</th>
            <th >Last Update</th>
            <th> Actions</th>
          </tr>
        </thead>
        <tbody>
         @foreach ($forum_posts as $forum_post)
          <tr id ="row-{{ $forum_post->id }}">
            <td>{{  $forum_post->topic  }}</td>
            <td>{{  $forum_post->userCreatedID  }}</td>
            <td>{{ $forum_post->created_at }}</td>
            <td>{{ $forum_post->updated_at}}</td>
            <td>
              <a href="/admin/forum/post/{{$forum_post->id}}/edit" class="btn btn-primary">Edit</a>
              <button class="btn btn-primary delete-button" data-id="{{ $forum_post->id }}" data-name="{{ $forum_post->topic }}">Delete</button>
            </td>
           

          </tr>
          @endforeach

        </tbody>
      </table> --}}

   <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">

                        <a href="/admin/forum/post/create/{{$forum_id}}" class="btn btn-primary">Thêm bài đăng</a>

                               
                            </div>
                        </div>
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false" data-export-title="Export">
                                    <thead>
                                        <tr class="nk-tb-item nk-tb-head">
                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ảnh đại diện</span></th>

                                            <th class="nk-tb-col"><span class="sub-text">Chủ đề</span></th>
                                            <th class="nk-tb-col tb-col-mb"><span class="sub-text">Người đăng</span></th>
                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ngày đăng</span></th>
                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Lần cập nhật cuối</span></th>                                        
                                            <th class="nk-tb-col nk-tb-col-tools text-end">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($forum_posts as $forum_post)

                                        <tr class="nk-tb-item" id ="row-{{ $forum_post->id }}">

                                            <td class="nk-tb-col tb-col-lg">
                                              <img class="image-fluid" src={{ $forum_post->url }} alt="..." style="width:100px" />
                                            </td>
                                            <td class="nk-tb-col">
                                                <div class="user-card">                                           
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ $forum_post->topic }}<span class="dot dot-success d-md-none ms-1"></span></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col tb-col-mb">
                                              <span>{{  $forum_post->users->name }}</span>
                                            </td>
                                            <td class="nk-tb-col tb-col-lg">
                                              <span>{{ $forum_post->created_at }}</span>

                                            </td>
                                           
                                            <td class="nk-tb-col tb-col-lg">
                                              <span>{{ $forum_post->updated_at }}</span>
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
                                                                  <li><a href="#" class="delete-button" data-id="{{ $forum_post->id }}" data-name="{{ $forum_post->topic }}">
                                                                    <em class="icon ni ni-trash"></em><span>Xóa</span>
                                                                  </a>

                                                                  </li>
                                                                  <li><a href="/admin/forum/post/{{$forum_post->id}}/edit"><em class="icon ni ni-edit"></em><span>Cập nhật</span></a></li>
                                                                  
                                                              </ul>
                                                          </div>
                                                      </div>
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
@endsection



@section('additional-scripts')
<script src="{{ asset('assets/js/libs/datatable-btns.js?ver=3.1.2') }}"></script>
<script src="{{ asset('assets/js/example-sweetalert.js?ver=3.1.2') }}" aria-hidden="true"></script>

<script>
    

  $(function(){

    $('#DataTables_Table_0 tbody').on('click','.delete-button',function(){
    var forum_postID = $(this).data('id');
    var name = $(this).data('name');
    var token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
        title: "Bạn muốn bài đăng "+ name,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa bài đăng',
        cancelButtonText: 'Không'
        }).then((result) => {
        if (result.isConfirmed) {
           
            $.ajax({
                type:"DELETE",
                url:'/admin/forum/post/' + forum_postID,
                data : {
                    "id": forum_postID,
                    "_token": token,
                },
                })
                .done(function() {
                // If successful
                    Swal.fire({
                        icon: 'success',
                        title: `Xóa bài đăng thành công`,
                        showConfirmButton: false,
                        timer: 2500
                    });
                    $("#row-" + forum_postID).fadeOut();
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