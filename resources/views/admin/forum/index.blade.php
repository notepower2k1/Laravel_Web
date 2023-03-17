@extends('admin/layouts.app')
@section('pageTitle', 'Danh sách diễn đàn')

@section('content')
    {{-- <a href="{{ route('forum.create') }}" class="btn btn-primary">Thêm diễn đàn</a>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th >Create At</th>
            <th >Last update</th>
            <th>Actions</th>
            <th >Status</th>
            <th> Post in Forums </th>
          </tr>
        </thead>
        <tbody>
         @foreach ($forums as $forum)
          <tr id ="row-{{ $forum->id }}">
            <td>{{  $forum->name  }}</td>
            <td>{{ $forum->created_at }}</td>
            <td>{{ $forum->updated_at}}</td>
            <td>
              <a href="/admin/forum/{{$forum->id}}/edit" class="btn btn-primary">Edit</a>
              <button href="" class="btn btn-primary delete-button" data-id="{{ $forum->id }}" data-name="{{ $forum->name }}">Delete</button>
            </td>
            <td>
              <div class="form-check form-switch">
                <input class="form-check-input" 
                type="checkbox" role="switch" 
                id="flexSwitchCheckChecked" 
                data-id="{{ $forum->id }}"
                {{ $forum->status? 'checked':'' }}/>
              </div>
            </td>
            <td> <a href="/admin/forum/post/{{ $forum->id }}" class="btn btn-primary">Posts</a></td>

          </tr>
          @endforeach

        </tbody>
      </table> --}}

      <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">

                                    <a href="{{ route('forum.create') }}" class="btn btn-primary">Thêm diễn đàn</a>

                               
                            </div>
                        </div>
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false" data-export-title="Export">
                                    <thead>
                                        <tr class="nk-tb-item nk-tb-head">

                                            <th class="nk-tb-col"><span class="sub-text">Tên diễn đàn</span></th>
                                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Ngày tạo</span></th>
                                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Lần cập nhật cuối</span></th>
                                            {{-- <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ngày thêm</span></th> --}}
                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Mô tả</span></th>
                                            <th class="nk-tb-col tb-col-mb"><span class="sub-text">Tình trạng</span></th>

                                            <th class="nk-tb-col nk-tb-col-tools text-end">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($forums as $forum)

                                        <tr class="nk-tb-item" id ="row-{{ $forum->id }}">

                                        
                                            <td class="nk-tb-col">
                                                <div class="user-card">                                           
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ $forum->name }}<span class="dot dot-success d-md-none ms-1"></span></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col tb-col-lg">
                                              <span>{{  $forum->created_at }}</span>
                                            </td>
                                            <td class="nk-tb-col tb-col-lg">
                                              <span>{{ $forum->updated_at }}</span>

                                            </td>
                                           
                                            {{-- <td class="nk-tb-col tb-col-lg">
                                              <span>{{ $book->created_at }}</span>
                                            </td> --}}
                                            <td class="nk-tb-col tb-col-md">
                                              <span>{{ $forum->description }}</span>

                                            </td>                                
                                            <td class="nk-tb-col tb-col-mb">
                                           

                                              <input type="checkbox" 
                                              class="form-check-input"
                                              data-toggle="toggle" 
                                              data-onlabel="Công khai" 
                                              data-offlabel="Riêng tư" 
                                              data-size="sm"
                                              data-id="{{ $forum->id }}"
                                              {{ $forum->status ? 'checked':'' }}   />

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
                                                                  <li><a href="#" class="delete-button" data-id="{{ $forum->id }}" data-name="{{ $forum->name }}">
                                                                    <em class="icon ni ni-trash"></em><span>Xóa</span>
                                                                  </a>

                                                                  </li>
                                                                  <li><a href="/admin/forum/{{$forum->id}}/edit"><em class="icon ni ni-edit"></em><span>Cập nhật</span></a></li>
                                                                  <li class="divider"></li>
                                                                  <li><a href="/admin/forum/post/{{ $forum->id }}"><em class="icon ni ni-eye"></em><span>Xem bài đăng của diễn đàn</span></a></li>

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
                    </div> <!-- nk-block -->
@endsection
@section('additional-scripts')
<script src="{{ asset('assets/js/libs/datatable-btns.js?ver=3.1.2') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/js/bootstrap5-toggle.jquery.min.js"></script>
<script src="{{ asset('assets/js/example-sweetalert.js?ver=3.1.2') }}" aria-hidden="true"></script>

<script>

  $(function(){
    $('#DataTables_Table_0 tbody').on('change','.form-check-input',function(){
      var status = $(this).prop('checked') == true ? 1 :0;
      var forum_id = $(this).data('id');

      $.ajax({
        type:"GET",
        url:'/admin/forum/update/changeStatus',
        data: {'status':status,'id':forum_id}   
        })
        .done(function() {
        // If successful
          console.log("Success");

        })
        .fail(function(jqXHR, textStatus, errorThrown) {
        // If fail
        console.log(textStatus + ': ' + errorThrown);
        })
  })

  $('#DataTables_Table_0 tbody').on('click','.delete-button',function(){
    var forum_id = $(this).data('id');
    var name = $(this).data('name');
    var token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
        title: "Bạn muốn xóa diễn đàn "+ name,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa diễn đàn',
        cancelButtonText: 'Không'
        }).then((result) => {
        if (result.isConfirmed) {
           
          $.ajax({
            type:"DELETE",
            url:'/admin/forum/' + forum_id,
            data : {
              "id": forum_id,
              "_token": token,
            },
            })
            .done(function() {
            // If successful
            Swal.fire({
                    icon: 'success',
                    title: `Xóa diễn đàn ${name} thành công`,
                    showConfirmButton: false,
                    timer: 2500
              });
              
              $("#row-" + forum_id).fadeOut();
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