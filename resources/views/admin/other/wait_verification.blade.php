@extends('admin/layouts.app')
@section('pageTitle', 'Danh sách sách điện tử')
@section('content')
                    <div class="nk-block nk-block-lg">       
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">

                            <button class="btn btn-outline-primary" id="verification_item_button">
                              <em class="icon ni ni-file-check-fill"></em>
                              <span>Duyệt tài liệu</span>
                            </button>

                            <button class="btn btn-outline-danger" id="reject_item_button">
                              <em class="icon ni ni-file-remove-fill"></em>
                              <span>Từ chối tài liệu</span>
                            </button>

                            </div>
                        </div>         
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false" data-export-title="Export">
                                    <thead>
                                        <tr class="nk-tb-item nk-tb-head">
                                            <th class="nk-tb-col nk-tb-col-check">
                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                    <input type="checkbox" class="custom-control-input" id="uid">
                                                    <label class="custom-control-label" for="uid"></label>
                                                </div>
                                            </th>
                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ảnh đại diện</span></th>
                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Tiêu đề</span></th>
                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Tác giả</span></th>
                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Danh mục</span></th>
                                            <th class="nk-tb-col tb-col-mb"><span class="sub-text">Người thêm</span></th>
                                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Ngày thêm</span></th>

                                            {{-- <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ngày thêm</span></th> --}}
                                         

                                            <th class="nk-tb-col nk-tb-col-tools text-end">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($books as $book)
                                        <tr class="nk-tb-item" id ="row-book-{{ $book->id }}">             
                                            <td class="nk-tb-col nk-tb-col-check">
                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                    <input type="checkbox" name='selection' class="custom-control-input" id="uid-book-{{ $book->id }}" data-id="{{ $book->id }}" data-option="1">
                                                    <label class="custom-control-label" for="uid-book-{{ $book->id }}"></label>
                                                </div>
                                            </td>                             
                                            <td class="nk-tb-col tb-col-lg">
                                              <img class="image-fluid" src={{$book->url}} alt="..." style="width:100px" />
                                            </td>
                                            <td class="nk-tb-col">
                                                <div class="user-card">                                           
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ Str::limit($book->name,30) }}<span class="dot dot-success d-md-none ms-1"></span></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col tb-col-lg">
                                              <span>{{  $book->author }}</span>
                                            </td>
                                            <td class="nk-tb-col tb-col-lg">
                                              <span>{{ $book->types->name }}</span>

                                            </td>
                                            <td class="nk-tb-col tb-col-lg">
                                                <span>{{ $book->users->name }}</span>
                                              </td>
                                              <td class="nk-tb-col tb-col-lg">
                                                <span>{{ $book->created_at }}</span>
                                              </td>
                                            <td class="nk-tb-col nk-tb-col-tools">
                                              <ul class="nk-tb-actions gx-1">                                                
                                                  <li>
                                                      <div class="drodown">
                                                          <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                          <div class="dropdown-menu dropdown-menu-end">
                                                              <ul class="link-list-opt no-bdr">
                                                                  <li><a href="/admin/book/{{ $book->id }}">
                                                                    <em class="icon ni ni-eye"></em><span>Thông tin chi tiết</span>
                                                                  </a>

                                                                  </li>
                                                                  <li><a href="/thanh-vien/{{ $book->users->id }}"><em class="icon ni ni-user"></em><span>Thông tin người đăng</span></a></li>
                                                                  <li class="divider"></li>
                                                                  <li><a href="#"><em class="icon ni ni-check"></em><span>Duyệt sách</span></a></li>

                                                              </ul>
                                                          </div>
                                                      </div>
                                                  </li>
                                              </ul>
                                          </td>
                                        </tr><!-- .nk-tb-item  -->
                                      @endforeach
                                      @foreach ($documents as $document)
                                      <tr class="nk-tb-item" id ="row-document-{{ $document->id }}">             
                                          <td class="nk-tb-col nk-tb-col-check">
                                              <div class="custom-control custom-control-sm custom-checkbox notext">
                                                  <input type="checkbox" name='selection' class="custom-control-input" id="uid-document-{{ $document->id }}" data-id="{{ $document->id }}"  data-option="0">
                                                  <label class="custom-control-label" for="uid-document-{{ $document->id }}"></label>
                                              </div>
                                          </td>                             
                                          <td class="nk-tb-col tb-col-lg">
                                            <img class="image-fluid" src={{$document->url}} alt="..." style="width:100px" />
                                          </td>
                                          <td class="nk-tb-col">
                                              <div class="user-card">                                           
                                                  <div class="user-info">
                                                      <span class="tb-lead">{{ Str::limit($document->name,30) }}<span class="dot dot-success d-md-none ms-1"></span></span>
                                                  </div>
                                              </div>
                                          </td>
                                          <td class="nk-tb-col tb-col-lg">
                                            <span>{{  $document->author }}</span>
                                          </td>
                                          <td class="nk-tb-col tb-col-lg">
                                            <span>{{ $document->types->name }}</span>

                                          </td>
                                          <td class="nk-tb-col tb-col-lg">
                                              <span>{{ $document->users->name }}</span>
                                            </td>
                                            <td class="nk-tb-col tb-col-lg">
                                              <span>{{ $document->created_at }}</span>
                                            </td>
                                          <td class="nk-tb-col nk-tb-col-tools">
                                            <ul class="nk-tb-actions gx-1">                                                
                                                <li>
                                                    <div class="drodown">
                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <ul class="link-list-opt no-bdr">
                                                                <li><a href="/admin/document/{{ $document->id }}">
                                                                  <em class="icon ni ni-eye"></em><span>Thông tin chi tiết</span>
                                                                </a>

                                                                </li>
                                                                <li><a href="/thanh-vien/{{ $document->users->id }}"><em class="icon ni ni-user"></em><span>Thông tin người đăng</span></a></li>
                                                               

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
                <!-- .components-preview -->
   
@endsection


@section('additional-scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/js/bootstrap5-toggle.jquery.min.js"></script>
<script src="{{ asset('assets/js/example-sweetalert.js?ver=3.1.2') }}" aria-hidden="true"></script>

<script>
  //custom datatable

  $(document).ready(function () {
    $('#DataTables_Table_0 thead').on('change','#uid',function(){
        var checkBoxes = $("input[name=selection]");
        checkBoxes.prop("checked", !checkBoxes.prop("checked"));
        
    });
  });

  $('#verification_item_button').click(function(){
      var checkBoxes = $("input[type='checkbox'][name=selection]:checked");

      var data = [];
      checkBoxes.each(function(i,item){

          var element = {};
          element.id = $(item).data('id');
          element.option = $(item).data('option');
          data.push(element);
      });

      $.ajax({ 
        type:"GET",
        url:'/admin/wait-verification/update/changeStatus/verification',
        data: {'data':data}   
        })
        .done(function() {
        // If successful
        $("input[type='checkbox']#uid").prop("checked", false);

        var ListTrChecked = $('tbody tr').has("input[type='checkbox'][name=selection]:checked");
          ListTrChecked.each(function (i,item) {
            $(item).fadeOut("slow");
          })

          Swal.fire({
            icon: 'success',
            title: `Duyệt tài liệu thành công!!!`,
            showConfirmButton: false,
            timer: 2500
          });



        })
        .fail(function(jqXHR, textStatus, errorThrown) {
        // If fail
          Swal.fire({
                      icon: 'error',
                      title: `Đổi trạng thái không thành công`,
                      showConfirmButton: false,
                      timer: 2500
                  });
        })

    

    })
    
    $('#reject_item_button').click(function(){
      var checkBoxes = $("input[type='checkbox'][name=selection]:checked");

      var data = [];
      checkBoxes.each(function(i,item){

          var element = {};
          element.id = $(item).data('id');
          element.option = $(item).data('option');
          data.push(element);
      });

      $.ajax({ 
        type:"GET",
        url:'/admin/wait-verification/update/changeStatus/rejection',
        data: {'data':data}   
        })
        .done(function() {
        // If successful
        $("input[type='checkbox']#uid").prop("checked", false);

        var ListTrChecked = $('tbody tr').has("input[type='checkbox'][name=selection]:checked");
          ListTrChecked.each(function (i,item) {
            $(item).fadeOut("slow");
          })

          Swal.fire({
            icon: 'success',
            title: `Từ chối tài liệu thành công!!!`,
            showConfirmButton: false,
            timer: 2500
          });



        })
        .fail(function(jqXHR, textStatus, errorThrown) {
        // If fail
          Swal.fire({
                      icon: 'error',
                      title: `Đổi trạng thái không thành công`,
                      showConfirmButton: false,
                      timer: 2500
                  });
        })

    

    })

  

</script>
@endsection