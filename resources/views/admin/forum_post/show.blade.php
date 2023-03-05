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
                                <table class="datatable-init-export nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false" data-export-title="Export">
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
                                              <img class="image-fluid" src={{ asset ('storage/'.$forum_post->image) }} alt="..." style="width:100px" />
                                            </td>
                                            <td class="nk-tb-col">
                                                <div class="user-card">                                           
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ $forum_post->topic }}<span class="dot dot-success d-md-none ms-1"></span></span>
                                                        <span>{{ $forum_post->slug }}</span>
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
<script>
    $(document).ready(function() {

    table = $('#DataTables_Table_0').DataTable();

    table.destroy();


    table = $('#DataTables_Table_0').DataTable( {
        dom: 'Blfrtip',
        columnDefs: [
            {
                targets: 4, 
                className: 'noVis'           
            }    
        ],
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Tất cả"] ],
      "language": {
          "lengthMenu": "Hiển thị: _MENU_ đối tượng",
          "search": "Tìm kiếm _INPUT_",
          'info':"",
          "zeroRecords": "Không tìm thấy dữ liệu",
          "infoEmpty": "Không có dữ liệu hợp lệ",
          "infoFiltered": "(Lọc từ _MAX_ dữ liệu)",
          "paginate": {
            "first":      "Đầu tiên",
            "last":       "Cuối cùng",
            "next":       "Tiếp theo",
            "previous":   "Trước đó"
        },
        buttons: {
              colvis: 'Thay đổi số cột'
          }
      },

      buttons: [
            
            {
                extend: 'colvis',
                columns: ':not(.noVis)'
            },
      
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [1,2,3,4]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [1,2,3,4]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [1,2,3,4]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [1,2,3,4]
                }
            },
            
        ],
    

      } );
      $('#DataTables_Table_0_wrapper').addClass('d-flex row');
      $('#DataTables_Table_0_length').addClass('mt-2');
      $('#DataTables_Table_0_filter').addClass('mt-2');

  } );

  $(function(){

  $('.delete-button').click(function(){
    var forum_postID = $(this).data('id');
    var name = $(this).data('name');
    var token = $("meta[name='csrf-token']").attr("content");

    if (confirm("Xóa post "+name) == true) {
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
            alert("Xóa forum thành công");
            $("#row-" + forum_postID).fadeOut();
          })
          .fail(function(jqXHR, textStatus, errorThrown) {
          // If fail
          console.log(textStatus + ': ' + errorThrown);
          })
    } else {

    }
  })
});



</script>
@endsection