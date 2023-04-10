@extends('admin/layouts.app')
@section('pageTitle', 'Báo cáo')
@section('content')

      <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                    <a href="/admin/report/done" class="btn btn-lg btn-success">Đã xử lý</a>    
                                    <a href="/admin/report/waiting" class="btn  btn-lg btn-info">Chưa xử lý</a>                     
                            </div>
                        </div>
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false" data-export-title="Export">
                                    <thead>
                                        <tr class="nk-tb-item nk-tb-head">
                                            <th class="nk-tb-col"><span class="sub-text">Ngày báo cáo</span></th>
                                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Loại báo cáo</span></th>
                                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Người báo cáo</span></th>
                                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Tình trạng</span></th>
                                            <th class="nk-tb-col nk-tb-col-tools text-end">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($reports as $report)

                                        <tr class="nk-tb-item" id ="row-{{ $report->id }}">

                                        
                                            <td class="nk-tb-col">
                                                <div class="user-card">                                           
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ $report->created_at}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col tb-col-md">
                                              <span>{{  $report->types->name }}</span>
                                            </td>
                                            <td class="nk-tb-col tb-col-md">
                                              <span>{{ $report->users->email  }}</span>

                                            </td>   
                                            <td class="nk-tb-col tb-col-md">    
                                                
                                                <div class="form-check form-switch">
                                                    <input type="checkbox" 
                                                    class="form-check-input"
                                                    role="switch"
                                                    data-id="{{ $report->id }}"
                                                    {{ $report->status ? 'checked':'' }}   />
                                                </div>
                                            </td>                                                                                                                                                                                                                  
                                            <td class="nk-tb-col nk-tb-col-tools">
                                                <button class="btn btn-icon btn-lg ni ni-eye detail-btn" data-id="{{ $report->id }}"></button>
                                                <button class="d-none" id="show-modal-btn"  data-bs-toggle="modal" data-bs-target="#modalTabs"></button>
                                            </td>
                                        </tr><!-- .nk-tb-item  -->
                                      @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card-preview -->
                    </div> <!-- nk-block -->
@endsection

@section('modal')
<div class="modal fade" tabindex="-1" id="modalTabs" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h4 class="title">Chi tiết báo cáo</h4>
                <ul class="nk-nav nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#tabItem1" aria-selected="true" role="tab">Nội dung báo cáo</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#tabItem2" aria-selected="false" role="tab" tabindex="-1">Người báo cáo</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active show" id="tabItem1" role="tabpanel">
                        <h6 class="title" id="report-title">Báo cáo về sách</h6>
                        <ul class="link-list" id="item-detail-ul">
                        </ul>
                        <p><strong>Lý do: </strong><span id="report-reason"></span></p>

                        <a href="#" class="btn btn-primary" id="item-detail-url">Chi tiết</a>
                    </div>
                    <div class="tab-pane" id="tabItem2" role="tabpanel">
                        <h6 class="title">Thông tin người báo cáo</h6>
                        <ul class="link-list" id="user-detail-ul">                           
                        </ul>   
                        <a href="#" class="btn btn-primary" id="user-detail-url">Chi tiết</a>
                    </div>
                </div>
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
  //custom datatable

  $(function(){
    $('.form-check-input').change(function() {
      
      var status = $(this).prop('checked') == true ? 1 : 0;
      var report_id = $(this).data('id');

      
      $.ajax({
        type:"GET",
        url:'/admin/report/update/changeStatus',
        data: {'status':status,'id':report_id}   
        })
        .done(function() {
        // If successful
            Swal.fire({
                      icon: 'success',
                      title: `Đổi trạng thái thành công`,
                      showConfirmButton: false,
                      timer: 2500
                  });

        })
        .fail(function(jqXHR, textStatus, errorThrown) {
        // If fail
        console.log(textStatus + ': ' + errorThrown);
        })
  })

  $('.detail-btn').click(function(){

    var report_id = $(this).data('id');
    var renderArea = $('#item-detail-ul');
    var renderArea2 = $('#user-detail-ul');

    $.ajax({
        type:"GET",
        url:'/admin/report/detail',
        data: {'id':report_id}   
        })
        .done(function(res) {
        // If successful
            renderArea.empty(); 
            renderArea2.empty(); 

            var report_detail = res.report_detail;
            var type = report_detail.type_id;
            var item = res.item;
            var subItem = res.subItem;
            var itemUser = res.itemUser;

            var reportUser = res.reportUser;
            var openEnderContent = ""

            switch(type) {
                case 1:
                    $('#report-title').text('Báo cáo về sách');
                    $("#item-detail-url").attr("href", `/sach/${item.id}/${item.slug}`);

                    var created_at = new Date(item.created_at).toLocaleString('en-GB');
                    openEnderContent = 
                    `<li>Tên sách: ${item.name} </li>`+
                    `<li>Thể loại: ${subItem.name}</li>`+
                    `<li>Tác giả: ${item.author} </li>`+
                    `<li>Người thêm: ${itemUser.email} </li>`+
                    `<li>Ngày thêm: ${created_at} </li>`;
                    break;
                case 2:
                    $('#report-title').text('Báo cáo về chương sách');
                    $("#item-detail-url").attr("href",`/doc-sach/${subItem.slug}/${item.slug}`);

                    var created_at = new Date(item.created_at).toLocaleString('en-GB');

                     openEnderContent = 
                    `<li>Sách: ${subItem.name} </li>`+
                    `<li>Chương số: ${item.code} </li>`+
                    `<li>Tên chương: ${item.name}</li>`+
                    `<li>Ngày thêm: ${created_at} </li>`;
                    break;
                case 3:
                    $('#report-title').text('Báo cáo về tài liệu');
                    $("#item-detail-url").attr("href", `/tai-lieu/${item.id}/${item.slug}`);

                    var created_at = new Date(item.created_at).toLocaleString('en-GB');

                    openEnderContent = 
                    `<li>Tên tài liệu: ${item.name} </li>`+
                    `<li>Thể loại: ${subItem.name}</li>`+
                    `<li>Tác giả: ${item.author} </li>`+
                    `<li>Người thêm: ${itemUser.email} </li>`+
                    `<li>Ngày thêm: ${created_at} </li>`;
                    break;
                case 4:
                    $('#report-title').text('Báo cáo về bài viết');
                    $("#item-detail-url").attr("href", `/dien-dan/${subItem.slug}/${item.slug}/${item.id}`)

                    var created_at = new Date(item.created_at).toLocaleString('en-GB');

                     openEnderContent = 
                    `<li>Diễn đàn: ${subItem.name} </li>`+
                    `<li>Chủ đề: ${item.topic} </li>`+
                    `<li>Người thêm: ${itemUser.email} </li>`+
                    `<li>Ngày thêm: ${created_at} </li>`;
                    break;
                case 5:
                    $('#report-title').text('Báo cáo về người dùng');
                    $("#item-detail-url").attr("href", `/thanh-vien/${item.id}`);

                    var created_at = new Date(item.created_at).toLocaleString('en-GB');

                    openEnderContent = 
                    `<li>Họ và tên: ${item.name} </li>`+
                    `<li>Biệt danh: ${subItem.displayName} </li>`+
                    `<li>Email: ${item.email}</li>`+ 
                    `<li>Ngày tham gia: ${created_at} </li>`;
                    break;

                default:
                    openEnderContent = ""
                }
            
                $("#user-detail-url").attr("href", `/thanh-vien/${reportUser.id}`);

                var created_at = new Date(reportUser.created_at).toLocaleString('en-GB');
                var openEnderContent2 = 
                    `<li> 
                    <img src=${res.avatar} alt="..." width='200px' />
                    </li>`+
                    `<li>Họ và tên: ${reportUser.name} </li>`+
                    `<li>Email: ${reportUser.email}</li>`+ 
                    `<li>Ngày tham gia: ${created_at} </li>`;

                renderArea.append(openEnderContent);
                renderArea2.append(openEnderContent2);

                $('#report-reason').text(`${report_detail.description}`)

                $('#show-modal-btn').click();



        })
        .fail(function(jqXHR, textStatus, errorThrown) {
        // If fail
        console.log(textStatus + ': ' + errorThrown);
        })
  })
 
});



</script>
@endsection