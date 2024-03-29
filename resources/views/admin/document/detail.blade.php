@extends('admin/layouts.app')
@section('pageTitle', 'Chi tiết tài liệu')
@section('additional-style')
<style>
    .title{
        font-weight: bold;
    }
</style>
@endsection
@section('content')

<div class="container">
    <ul class="breadcrumb breadcrumb-arrow">
        <li class="breadcrumb-item"><a href="/admin/document">Tài liệu</a></li>
        <li class="breadcrumb-item active"><a href="#">Chi tiết</a></li>
      </ul>
      <hr>   

      <div class="d-flex justify-content-end mb-2"  id ="document-render-div">

        @if($document->deleted_at == null)
            <a href="#" class="btn btn-outline-danger delete-button" data-id="{{ $document->id }}" data-name="{{ $document->name }}">
                <em class="icon ni ni-trash"></em><span>Xóa</span>
            </a>
        @else
            <button class="btn btn-outline-primary" id="verification_item_button" data-id="{{ $document->id }}" data-name="{{ $document->name }}">
                <em class="icon ni ni-file-check-fill"></em>
                <span>Khôi phục dữ liệu</span>
            </button>
        @endif

        <div class="ms-1"></div>


        @if($document->users->id != 1)
            @if($document->status == -2)
                <a href="#" class="btn btn-outline-primary lock-button" data-id="{{ $document->id }}" data-name="{{ $document->name }}" data-status ="{{ $document->status }}">
                    <em class="icon ni ni-unlock"></em><span>Mở khóa tài liệu</span>
                </a>
            @else
                <a href="#" class="btn btn-outline-warning lock-button" data-id="{{ $document->id }}" data-name="{{ $document->name }}"  data-status ="{{ $document->status }}">
                    <em class="icon ni ni-lock"></em><span>Khóa tài liệu</span>
                </a>
            @endif
        @endif
      </div>

    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="product-gallery" >    
                                    <img src="{{ $document->url }}" class="w-100" alt="">                                     
                                </div>
                            </div><!-- .col -->
                            <div class="col-lg-6 d-flex align-items-end">
                                <div class="product-info mb-5 me-xxl-5">
                                    <h3 class="product-title">{{ $document->name }} </h3>     
                                    @if ($document->deleted_at == null)
                                    <h5 class="text-success">Đang hiển thị</h5>
                                    @else
                                    <h5 class="text-danger">Đã xóa</h5>

                                    @endif 
                                    <div class="product-meta">
                                        <ul class="d-flex g-3 gx-5">
                                            <li>
                                                <div class="fs-14px text-muted">Số trang</div>
                                                <div class="fs-16px fw-bold text-secondary">{{ $document->numberOfPages }}</div>
                                            </li>
                                            <li>
                                                <div class="fs-14px text-muted">Lượt tải</div>
                                                <div class="fs-16px fw-bold text-secondary">{{ $document->totalDownloading }}</div>
                                            </li>
                                            <li>
                                                <div class="fs-14px text-muted">Đánh dấu</div>
                                                <div class="fs-16px fw-bold text-secondary" id="totalBookMarking">{{ $document->totalDocumentMarking }}</div>
                                            </li>
                                            <li>
                                                <div class="fs-14px text-muted">Số bình luận</div>
                                                <div class="fs-16px fw-bold text-secondary" id="totalBookMarking">{{ $document->totalComments }}</div>
                                            </li>
                                        
                                        </ul>
                                    </div>
                                    
                                    <div class="product-meta">
                                        <span class="title">Tác giả:                                          
                                        </span>
                                        <span>{{ $document->author }}</span>                      

                                    </div><!-- .product-meta -->
  
                                    <div class="product-meta">
                                        <span class="title">Ngôn ngữ:                                
                                        </span>
                                        @if ($document->language === 1)
                                        <span class="text-success fs-14px">Tiếng việt</span>
                                        @else
                                        <span class="text-info fs-14px">Tiếng anh</span>

                                        @endif 
                                    </div><!-- .product-meta -->
                                    <div class="product-meta">
                                        <span class="title">Tình trạng:    
                                        </span>
                                        @if ($document->isCompleted === 1)
                                        <span class="text-success fs-14px fw-bold">Đã hoàn thành</span>
                                        @else
                                        <span class="text-info fs-14px fw-bold">Chưa hoàn thành</span>

                                        @endif 
                                    </div><!-- .product-meta -->
                                    <div class="product-meta">
                                        <span class="title">Thể loại:

                                        </span>
                                        <span class="text-warning fs-14px fw-bold">{{ $document->types->name }}</span>

                                    </div><!-- .product-meta -->

                                    <div class="product-meta">
                                        <span class="title">File đính kèm: 
                                        </span>
                                        <a href="{{ $document->documentUrl }}">file.{{ $document->extension }}</a>       
                                   
                                    </div>

                                    <div class="product-meta">
                                        <span class="title">Ngày thêm: 
                                        </span>
                                        <span>{{ $document->created_at }}</span>                  
                                    </div><!-- .product-meta -->

                                    <div class="product-meta">
                                        <span class="title">Lần cập nhật cuối: 

                                        </span>
                                        <span>{{ $document->updated_at }}</span>                       

                                    </div><!-- .product-meta -->
                                    <div class="product-meta">
                                        <span class="title">Người thêm: 

                                        </span>
                                        <a href="/admin/user/{{ $document->users->id }}">{{ $document->users->name }}</a>                       

                                    </div><!-- .product-meta -->
                                </div><!-- .product-info -->
                                
                                
                            </div><!-- .col -->
                        </div><!-- .row -->
                        <div class="row g-gs flex-lg-row-reverse">                      
                            <div class="col-lg-12">
                                <div class="product-details entry me-xxl-3">
                                    <hr class="hr">
                                    <h3>Giới thiệu</h3>
                                    {!! clean($document->description ) !!}
                                </div>
                            </div><!-- .col -->
                        </div><!-- .row -->

                        @if($notes->count() > 0)
                        <div class="nk-divider divider md"></div>
                        <div class="nk-block">
                            <div class="nk-block-head nk-block-head-sm nk-block-between">
                                <h5 class="title">Ghi chú của quản trị viên</h5>
                            </div><!-- .nk-block-head -->
                            <div class="bq-note">

                                @foreach ($notes as $note)
                                    <div class="bq-note-item" id="note-{{ $note->id }}">
                                        <div class="bq-note-text">
                                            <p>{{ $note->content }}</p>
                                        </div>
                                        <div class="bq-note-meta">
                                            <span class="bq-note-added">Thêm vào lúc <span class="date">{{ Carbon\Carbon::parse($note->created_at) }}</span></span>
                                            <span class="bq-note-sep sep">|</span>
                                            <a href="#" class="link link-sm link-danger" id="deleteUserNote" data-id="{{$note->id}}">Xóa ghi chú</a>
                                        </div>
                                    </div><!-- .bq-note-item -->
                                @endforeach
                             
                            
                            </div><!-- .bq-note -->
                        </div><!-- .nk-block -->
                        @endif
                    </div>
                </div>

                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="row g-gs">

                            @foreach ($previewImages as $previewImage)
                                <div class="col-sm-6 col-lg-4 col-xxl-3">
                                    <div class="gallery card card-bordered">
                                        <a class="gallery-image popup-image" href="{{ $previewImage->url }}">
                                            <img class="w-100 rounded-top" src="{{ $previewImage->url }}" alt="image">
                                        </a>                                                     
                                    </div>
                                </div> 
                            @endforeach
                           
                          
                        </div>
                    </div>
                </div>

                
                <div class="mt-5 d-flex justify-content-center">
                    <div class="dropdown ">
                        <a href="#" class="btn btn-primary btn-lg d-none d-sm-inline-flex" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em><span>Chọn năm</span></a>
                        <a href="#" class="btn btn-icon  btn-lg btn-primary d-sm-none" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <ul class="link-list-opt no-bdr">
                                @foreach ($allYears as $year)
                                    <li><a href="/admin/document/detail/{{ $document->id }}/{{ $year->year }}"><em class="icon ni ni-calendar"></em><span>Năm {{ $year->year }} </span></a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tabItem1">Số lượt tải tài liệu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tabItem2">Thống kê số lượt tải tài liệu</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabItem1">
                            <div class="card card-bordered">
    
                                <div class="card-inner">
            
                                    <table class="datatable-init-export nowrap nk-tb-list nk-tb-ulist mt-2" data-auto-responsive="false" data-export-title="Export">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head">
            
                                                <th class="nk-tb-col"><span class="sub-text">Thời gian</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">Tài khoản</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">Lượt tải</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($downloadHistory as $item)
                                            <tr class="nk-tb-item">                
                                                <td class="nk-tb-col">
                                                    <span>{{  $item->created_at }}</span>
                                                </td>
                                                <td class="nk-tb-col">
                                                <span>{{  $item->users->name }}</span>
                                                </td>
                                                <td class="nk-tb-col">
                                                <span>{{ $item->total }}</span>
                                                </td>                  
                                            </tr>
                                        @endforeach
            
                                        </tbody>
                                    </table>     
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabItem2">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="row g-gs">
                                        <div class="col-12" id="statistics-4">
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner">
                                                    <div class="card-title-group align-start gx-3 mb-3">
                                                        <div class="card-title">
                                                            <h6 class="title">Thống kê số lượt tải tài liệu</h6>
                                                            <p>Thống kê tổng số lượt tải tài liệu trong vòng 12 tháng</p>
                                                        </div>
                                                        <div class="card-tools">
                                                            <div id="report-total-downloading-btn">
                                                                <a href="#" class="btn btn-danger btn-dim d-none d-sm-inline-flex"><em class="icon ni ni-reports"></em><span>Xuất báo cáo</span></a>
                                                                <a href="#" class="btn btn-icon btn-danger btn-dim d-sm-none"><em class="icon ni ni-reports"></em></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-sale-data-group align-center justify-between gy-3 gx-5">
                                                        <div class="nk-sale-data">
                                                            <span class="amount">Tổng lượt tải: {{ $totalDownloadingInYear }}</span>
                                                        </div>
                                                        <div class="nk-sale-data">
                                                            <span class="amount sm">Năm: {{ $statisticsYear }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="" style="height:400px">
                                                        <canvas id="chart4"></canvas>
                                                    </div>
                                                </div>
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                    
                                        <div class="col-12" id="statistics-5">
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner">
                                                    <div class="card-title-group align-start gx-3 mb-3">
                                                        <div class="card-title">
                                                            <h6 class="title">Thống kê số lượt tải tài liệu</h6>
                                                            <p>Thống kê tổng số lượt tải tài liệu theo ngày trong tháng</p>
                                                        </div>
                                                        <div class="card-tools">
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-primary btn-dim d-none d-sm-inline-flex" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em><span>Chọn tháng</span></a>
                                                                <a href="#" class="btn btn-icon btn-primary btn-dim d-sm-none" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        @for ($i = 1 ; $i < 13 ; $i++)
                                                                            <li class="month-selection-li-5" data-value="{{ $i }}"><a style="cursor: pointer;"><span>Tháng {{ $i }}</span></a></li>
                                                                        @endfor
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="analytic-ov">
                                                        <div class="analytic-data-group analytic-ov-group g-3">
                                                            <div class="analytic-data analytic-ov-data d-flex flex-column  align-items-center">
                                                                <div class="title">Tổng</div>
                                                                <div class="amount">
                                                                    <span id="total-5"></span>
                                                                </div>
                                                            </div>
                                                            <div class="analytic-data analytic-ov-data d-flex flex-column align-items-center">
                                                                <div class="title">Min</div>
                                                                <div class="amount">                               
                                                                    <span id="min-5"></span>
                                
                                                                </div>
                                                            </div>
                                                            <div class="analytic-data analytic-ov-data d-flex flex-column align-items-center">
                                                                <div class="title">Max</div>
                                                                <div class="amount">
                                                                    <span id="max-5"></span>
                                
                                                                </div>
                                                            </div>
                                                            <div class="analytic-data analytic-ov-data d-flex flex-column align-items-center">
                                                                <div class="title">Tháng</div>
                                                                <div class="amount">
                                                                    <span id="month-selection-span-5"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="analytic-ov-ck" style=" height: 300px;">
                                                            <canvas id="chart5"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tabItem7">Số bình luận</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tabItem8">Thống kê số lượt bình luận</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabItem7">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <table class="datatable-init-export nowrap nk-tb-list nk-tb-ulist mt-2" data-auto-responsive="false" data-export-title="Export">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head">
                                                <th class="nk-tb-col"><span class="sub-text">Ngày bình luận</span></th>
                                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">Người bình luận</span></th>
                                
                                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">Số lượt phản hồi</span></th>
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
                                                  <span>{{  $comment->users->name  }}</span>
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
                                                                      <li>
                                                                        <a href="#" class="content-btn" data-id={{ $comment->id }}>
                                                                          <em class="icon ni ni-notice"></em><span>Nội dung</span>
                                                                        </a>
                                
                                                                      </li>
                                                                      <li><a href="/admin/comment/replies/{{ $comment->id }}"><em class="icon ni ni-reply-all"></em><span>Xem phản hồi</span></a></li>
                                                                  
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
                        <div class="tab-pane" id="tabItem8">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="row g-gs">
                                        <div class="col-12" id="statistics-7">
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner">
                                                    <div class="card-title-group align-start gx-3 mb-3">
                                                        <div class="card-title">
                                                            <h6 class="title">Thống kê số bình luận & phản hồi</h6>
                                                            <p>Thống kê tổng số lượt bình luận trong vòng 12 tháng</p>
                                                        </div>
                                                        <div class="card-tools">
                                                            <div class="dropdown">
                                                                <div id="report-total-comment-btn">
                                                                    <a href="#" class="btn btn-danger btn-dim d-none d-sm-inline-flex"><em class="icon ni ni-reports"></em><span>Xuất báo cáo</span></a>
                                                                    <a href="#" class="btn btn-icon btn-danger btn-dim d-sm-none"><em class="icon ni ni-reports"></em></a>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="nk-sale-data-group align-center justify-between gy-3 gx-5">
                                                        <div class="nk-sale-data">
                                                            <span class="amount sm">Tổng lượt bình luận: {{ $totalCommentsInYear }}</span>
                                                            <span class="amount sm">Tổng lượt phản hồi: {{ $totalRepliesInYear->total }}</span>

                                                            
                                                        </div>
                                                        <div class="nk-sale-data">
                                                            <span class="amount sm">Năm: {{ $statisticsYear }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="" style="height:400px">
                                                        <canvas id="chart7"></canvas>
                                                    </div>
                                                </div>
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                    
                                        <div class="col-12" id="statistics-8">
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner">
                                                    <div class="card-title-group align-start gx-3 mb-3">
                                                        <div class="card-title">
                                                            <h6 class="title">Thống kê số lượt bình luận & phản hồi</h6>
                                                            <p>Thống kê tổng số lượt bình luận theo ngày trong tháng</p>
                                                        </div>
                                                        <div class="card-tools">
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-primary btn-dim d-none d-sm-inline-flex" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em><span>Chọn tháng</span></a>
                                                                <a href="#" class="btn btn-icon btn-primary btn-dim d-sm-none" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        @for ($i = 1 ; $i < 13 ; $i++)
                                                                            <li class="month-selection-li-8" data-value="{{ $i }}"><a style="cursor: pointer;"><span>Tháng {{ $i }}</span></a></li>
                                                                        @endfor
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="analytic-ov">
                                                        <div class="analytic-data-group analytic-ov-group g-3">
                                                            <div class="analytic-data analytic-ov-data d-flex flex-column  align-items-center">
                                                                <div class="title">Tổng</div>
                                                                <div class="amount">
                                                                    <span id="total-8"></span>
                                                                </div>
                                                            </div>
                                                            <div class="analytic-data analytic-ov-data d-flex flex-column align-items-center">
                                                                <div class="title">Min</div>
                                                                <div class="amount">                               
                                                                    <span id="min-8"></span>
                                
                                                                </div>
                                                            </div>
                                                            <div class="analytic-data analytic-ov-data d-flex flex-column align-items-center">
                                                                <div class="title">Max</div>
                                                                <div class="amount">
                                                                    <span id="max-8"></span>
                                
                                                                </div>
                                                            </div>
                                                            <div class="analytic-data analytic-ov-data d-flex flex-column align-items-center">
                                                                <div class="title">Tháng</div>
                                                                <div class="amount">
                                                                    <span id="month-selection-span-8"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="analytic-ov-ck" style=" height: 300px;">
                                                            <canvas id="chart8"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
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
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.4/moment-with-locales.js"></script>
<script>
    $(function(){
        $('#DataTables_Table_1 tbody').on('click','.content-btn',function(e){
            e.preventDefault();

            
            var comment_id = $(this).data('id');
            $('#modalContent').find('.modal-body').empty();


            $.ajax({
            type:"GET",
            url:'/admin/comment/getContent/' + comment_id,     
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
        })
    });

    var yearSelected = {!! $statisticsYear !!};

    var temp = {!! \Carbon\Carbon::now()->format('YmdH') !!};

    var currentMonth = temp.toString().substring(4,6);

    defaultRenderChart5(currentMonth);
    defaultRenderChart8(currentMonth)
    })
    function defaultRenderChart5(currentMonth){
        $('#statistics-5').find('#month-selection-span-5').text(currentMonth);

            const result = {!! json_encode($totalDownloadingPerDate) !!};

            const filterByMonth = result.map((obj)=>{
                const temp = new Date(obj.date).toISOString().slice(5,7);
                if (temp === currentMonth){
                    return obj;
                }
            }).filter(item =>  item !== undefined );



            var min = 0;
            var max = 0;
            var sum = 0;
            if(filterByMonth.length){
                min = Math.min(...filterByMonth.map(object => object.total));
                    
                max = Math.max(...filterByMonth.map(object => object.total));

                sum = filterByMonth.reduce((accumulator, object) => {
                    return accumulator + parseInt(object.total);
                }, 0);
            }



            $('#statistics-5').find('#total-5').text(sum);
            $('#statistics-5').find('#min-5').text(min);
            $('#statistics-5').find('#max-5').text(max);

            

    }

    function defaultRenderChart8(currentMonth){
            $('#statistics-8').find('#month-selection-span-8').text(currentMonth);

            var comments = {!! json_encode($totalCommentsPerDate) !!};
            var replies = {!! json_encode($totalRepliesPerDate) !!};

          
            const filterByMonth1 = comments.map((obj)=>{
                const temp = new Date(obj.date).toISOString().slice(5,7);
                if (temp === currentMonth){
                    return obj;
                }
            }).filter(item =>  item !== undefined );


            const filterByMonth2 = replies.map((obj)=>{
                const temp = new Date(obj.date).toISOString().slice(5,7);
                if (temp === currentMonth){
                    return obj;
                }
            }).filter(item =>  item !== undefined );



            var min1 = 0;
            var max1 = 0;
            var sum1 = 0;
            if(filterByMonth1.length){
                min1 = Math.min(...filterByMonth1.map(object => object.total));
                    
                max1 = Math.max(...filterByMonth1.map(object => object.total));

                sum1 = filterByMonth1.reduce((accumulator, object) => {
                    return accumulator + parseInt(object.total);
                }, 0);
            }

            var min2 = 0;
            var max2 = 0;
            var sum2 = 0;

            if(filterByMonth2.length){
                min2 = Math.min(...filterByMonth2.map(object => object.total));
                    
                max2 = Math.max(...filterByMonth2.map(object => object.total));

                sum2 = filterByMonth2.reduce((accumulator, object) => {
                    return accumulator + parseInt(object.total);
                }, 0);
            }

            

            $('#statistics-8').find('#total-8').text(`${sum1} & ${sum2}`);
            $('#statistics-8').find('#min-8').text(`${min1} & ${min2}`);
            $('#statistics-8').find('#max-8').text(`${max1} & ${max2}`);


            

    }

    function createChart4(){
        const ctx = document.getElementById('chart4');

        var result = {!! json_encode($totalDownloadingPerMonth) !!};

        const data = {
        labels: Object.keys(result[0]),
        datasets: [{
            label: 'Số lượt tải tài liệu',
            data: Object.values(result[0]),
            fill: true,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1,
            backgroundColor: 'rgba(235,238,255,0.6)'
        }]
        };

        new Chart(ctx, {
            type: 'line',
            data: data,

            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                    ticks: {
                        precision: 0,
                        beginAtZero: true,

                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },  
                    tooltip: {
                        displayColors:false
                    },

                }
            }
        });
        
    }

    function createChart5(){
        const ctx = document.getElementById('chart5');
        var yearSelected = {!! $statisticsYear !!};

        var temp = {!! \Carbon\Carbon::now()->format('YmdH') !!};

        var currentMonth = temp.toString().substring(4,6);

        const lastDate  = new Date(yearSelected,currentMonth,0).getDate();

        var result = {!! json_encode($totalDownloadingPerDate) !!};


        const data = {
            labels: result.map(object => object.date),
            datasets: [{
                label: 'Số lượt tải tài liệu',
                data: result.map(object => object.total),         
                borderWidth: 1
            }]
        };

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: data,

            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x:{
                        min:`${yearSelected}-${currentMonth}-01`,
                        max:`${yearSelected}-${currentMonth}-${lastDate}`,
                        type: 'time',
                        time:{
                            displayFormats: {
                                day: 'dd'
                            }
                        }
                    },
                    y: {
                    ticks: {
                        precision: 0,
                        beginAtZero: true,         
                        }
                    } 
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        displayColors:false,
                        callbacks:{
                            title: function(tooltipItem, data) {

                                var date = tooltipItem[0].label;
                                var dateObj = new Date(date.substring(0, date.length - 15));


                                var vietnameseDate = moment(dateObj).locale('vi').format('LLLL').toString();

                                //clear
                                var vietnameseDate = vietnameseDate.substring(0, vietnameseDate.length - 6);

                                //upppercase
                                var vietnameseDate = vietnameseDate.charAt(0).toUpperCase() + vietnameseDate.slice(1)

                                // return date;
                        

                                return vietnameseDate;
                            },
                        }
                    },

                }
            },
            });

            $('#statistics-5').find('.month-selection-li-5').click(function () {

            const year = {!! $statisticsYear !!};

            var month = $(this).data('value');

            if(month < 10){
                month = '0' + month;
            }
            const lastDay = (y,m)=>{
            return new Date(y,m,0).getDate();
            }


            const startDate = `${year}-${month}-01`;
            const endDate = `${year}-${month}-${lastDay(year,month)}`;

            myChart.config.options.scales.x.min = startDate;
            myChart.config.options.scales.x.max = endDate;

            myChart.update();

            $('#statistics-5').find('#month-selection-span-5').text(month);


            const filterByMonth = result.map((obj)=>{
                const temp = new Date(obj.date).toISOString().slice(5,7);
                if (temp === month){
                    return obj;
                }
            }).filter(item =>  item !== undefined );



            var min = 0;
            var max = 0;
            var sum = 0;
            if(filterByMonth.length){
                min = Math.min(...filterByMonth.map(object => object.total));
                    
                max = Math.max(...filterByMonth.map(object => object.total));

                sum = filterByMonth.reduce((accumulator, object) => {
                    return accumulator + parseInt(object.total);
                }, 0);
            }



            $('#statistics-5').find('#total-5').text(sum);
            $('#statistics-5').find('#min-5').text(min);
            $('#statistics-5').find('#max-5').text(max);

            })

    }
    createChart4();
    createChart5();

    function createChart7(){
        const ctx = document.getElementById('chart7');

        var comments = {!! json_encode($totalCommentsPerMonth) !!};

        var replies  = {!! json_encode($totalRepliesPerMonth) !!};

        const data = {
        labels: Object.keys(comments[0]),
        datasets: [{
            label: 'Số lượt bình luận',
            data: Object.values(comments[0]),
            borderColor: 'rgb(255,139,142)',
            tension: 0.1,
            backgroundColor: 'rgb(255,139,142)',
            yAxisID: 'y',
        },{
            label: 'Số lượt phản hồi',
            data: Object.values(replies[0]),
            borderColor: 'blue',
            tension: 0.1,
            backgroundColor: 'blue',
            yAxisID: 'y1',
        }]
        };

        new Chart(ctx, {
            type: 'line',
            data: data,

            options: {
                responsive: true,
                maintainAspectRatio: false,
                    interaction: {
                    mode: 'index',
                    intersect: false,
                },
                stacked: false,
                scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',

                    // grid line settings
                    grid: {
                    drawOnChartArea: false, // only want the grid lines for one axis to show up
                    },
                },
                }
            }
        });
        
    }

    function createChart8(){
        const ctx = document.getElementById('chart8');

      

        var yearSelected = {!! $statisticsYear !!};

        var temp = {!! \Carbon\Carbon::now()->format('YmdH') !!};

        var currentMonth = temp.toString().substring(4,6);

        const lastDate  = new Date(yearSelected,currentMonth,0).getDate();

        var comments = {!! json_encode($totalCommentsPerDate) !!};
        var replies = {!! json_encode($totalRepliesPerDate) !!};

        
        const data = {
            // labels: comments.map(object => object.date),
            datasets: [
            {
                label: 'Số lượt bình luận',
                data: comments,         
                borderWidth: 1,
                backgroundColor: 'rgb(255,139,142)',
                parsing:{
                    xAxisKey:'date',
                    yAxisKey:'total'
                }

            },
            {
                label: 'Số lượt phản hồi',
                data: replies,         
                borderWidth: 1,
                backgroundColor: 'blue',
                parsing:{
                    xAxisKey:'date',
                    yAxisKey:'total'
                }

            },
        ]
        };

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: data,

            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x:{
                        min:`${yearSelected}-${currentMonth}-01`,
                        max:`${yearSelected}-${currentMonth}-${lastDate}`,
                        type: 'time',
                        time:{
                            displayFormats: {
                                day: 'dd'
                            }
                        },
                        stacked: true,

                    },
                    y: {
                    ticks: {
                        precision: 0,
                        beginAtZero: true,         
                        },
                        stacked: true,

                    } 
                },
                plugins: {
                   
                    tooltip: {
                        displayColors:false,
                        callbacks:{
                            title: function(tooltipItem, data) {

                                var date = tooltipItem[0].label;
                                var dateObj = new Date(date.substring(0, date.length - 15));


                                var vietnameseDate = moment(dateObj).locale('vi').format('LLLL').toString();

                                //clear
                                var vietnameseDate = vietnameseDate.substring(0, vietnameseDate.length - 6);

                                //upppercase
                                var vietnameseDate = vietnameseDate.charAt(0).toUpperCase() + vietnameseDate.slice(1)

                                // return date;
                        

                                return vietnameseDate;
                            },
                        }
                    },

                }
            },
            });

            $('#statistics-8').find('.month-selection-li-8').click(function () {

            const year = {!! $statisticsYear !!};

            var month = $(this).data('value');

            if(month < 10){
                month = '0' + month;
            }
            const lastDay = (y,m)=>{
            return new Date(y,m,0).getDate();
            }


            const startDate = `${year}-${month}-01`;
            const endDate = `${year}-${month}-${lastDay(year,month)}`;

            myChart.config.options.scales.x.min = startDate;
            myChart.config.options.scales.x.max = endDate;

            myChart.update();

            $('#statistics-8').find('#month-selection-span-5').text(month);


            const filterByMonth1 = comments.map((obj)=>{
                const temp = new Date(obj.date).toISOString().slice(5,7);
                if (temp === month){
                    return obj;
                }
            }).filter(item =>  item !== undefined );


            const filterByMonth2 = replies.map((obj)=>{
                const temp = new Date(obj.date).toISOString().slice(5,7);
                if (temp === month){
                    return obj;
                }
            }).filter(item =>  item !== undefined );



            var min1 = 0;
            var max1 = 0;
            var sum1 = 0;
            if(filterByMonth1.length){
                min1 = Math.min(...filterByMonth1.map(object => object.total));
                    
                max1 = Math.max(...filterByMonth1.map(object => object.total));

                sum1 = filterByMonth1.reduce((accumulator, object) => {
                    return accumulator + parseInt(object.total);
                }, 0);
            }

            var min2 = 0;
            var max2 = 0;
            var sum2 = 0;

            if(filterByMonth2.length){
                min2 = Math.min(...filterByMonth2.map(object => object.total));
                    
                max2 = Math.max(...filterByMonth2.map(object => object.total));

                sum2 = filterByMonth2.reduce((accumulator, object) => {
                    return accumulator + parseInt(object.total);
                }, 0);
            }

            

          
            $('#statistics-8').find('#total-8').text(`${sum1} & ${sum2}`);
            $('#statistics-8').find('#min-8').text(`${min1} & ${min2}`);
            $('#statistics-8').find('#max-8').text(`${max1} & ${max2}`);

            })

    }

    createChart7();
    createChart8();

    function arrayToCsv(data){
        return data.map(row =>
            row
            .map(String)  // convert every value to String
            .map(v => v.replaceAll('"', '""'))  // escape double colons
            .map(v => `"${v}"`)  // quote it
            .join(',')  // comma-separated
        ).join('\r\n');  // rows starting on new lines
    }

    function downloadBlob(content, filename, contentType) {
    // Create a blob
        var blob = new Blob(["\ufeff",content], { type: 'text/csv;charset=utf-8;' });
        var url = URL.createObjectURL(blob);

        // Create a link to download it
        var pom = document.createElement('a');
        pom.href = url;
        pom.setAttribute('download', filename);
        pom.click();
    }

    $('#report-total-downloading-btn').on('click', function (e) {
        e.preventDefault();
        var yearSelected = {!! $statisticsYear !!};

        var result = {!! json_encode($totalDownloadingPerMonth) !!};
        let title = [`Tổng lượt tải từng tháng trong năm ${yearSelected}`];

        let header = ['Tháng','Số lượt']    

        let entries = Object.entries(result[0]);


        let temp = [];
        temp.push(title)
        temp.push(header);
 
        entries.forEach(i => temp.push(i));

        let csv = arrayToCsv(temp);

        downloadBlob(csv, `tong-so-luot-tai-theo-thang-nam-${yearSelected}.csv`);

        var result2 = {!! json_encode($totalDownloadingPerDate) !!};
        let title2 = [`Tổng lượt tải theo ngày trong năm ${yearSelected}`];

        let header2 = ['Ngày','Số lượt']    

        const obj = {};
        result2.forEach(function(item) {
           
            obj[item.date] = item.total;
        })

       
 
        let entries2 = Object.entries(obj);
      
        let temp2 = [];
        temp2.push(title2)
        temp2.push(header2);

        entries2.forEach(i => temp2.push(i));

        let csv2 = arrayToCsv(temp2);

        downloadBlob(csv2, `tong-so-luot-tai-theo-ngay-nam-${yearSelected}.csv`);


    })

    $('#report-total-comment-btn').on('click', function (e) {
        e.preventDefault();
        var yearSelected = {!! $statisticsYear !!};

        var comments = {!! json_encode($totalCommentsPerMonth) !!};
        var replies = {!! json_encode($totalRepliesPerMonth) !!};

        let title = [`Tổng số lượt bình luận và phản hồi từng tháng trong năm ${yearSelected}`];

        let header = ['Tháng','Số lượt bình luận','Số lượt phản hồi']    

        let commentEntries = Object.entries(comments[0]);

        
        var repliesTotal = Object.values(replies[0]);


        for (var i = 0; i < commentEntries.length; i++){
            commentEntries[i].push(repliesTotal[i]);

        }

        

        let temp = [];
        temp.push(title)
        temp.push(header);
 
        commentEntries.forEach(i => temp.push(i));


        
        let csv = arrayToCsv(temp);
        
        downloadBlob(csv, `tong-so-luot-binh-luan-theo-thang-nam-${yearSelected}.csv`);

        var comments2 = {!! json_encode($totalCommentsPerDate) !!};

        let title2 = [`Tổng số bình luận theo ngày trong năm ${yearSelected}`];

        let header2 = ['Ngày','Số lượt bình luận']    

        const obj1 = {};

        comments2.forEach(function(item) {
            obj1[item.date] = item.total;
        })

        let commentEntries2 = Object.entries(obj1);

    
        let temp2 = [];
        temp2.push(title2)
        temp2.push(header2);


        commentEntries2.forEach(i => temp2.push(i));

        let csv2 = arrayToCsv(temp2);

    
        downloadBlob(csv2, `tong-so-luot-binh-luan-theo-ngay-nam-${yearSelected}.csv`);
 

        ////
        var replies2 = {!! json_encode($totalRepliesPerDate) !!};

        const obj2 = {};

        replies2.forEach(function(item) {
            obj2[item.date] = item.total;
        })

        let replyEntries2 = Object.entries(obj2);

        temp2 = [];
        temp2.push(title2)
        temp2.push(header2);

        replyEntries2.forEach(i => temp2.push(i));

        csv2 = arrayToCsv(temp2);

    
        downloadBlob(csv2, `tong-so-luot-phan-hoi-theo-ngay-nam-${yearSelected}.csv`);

    })

    $('#deleteUserNote').on('click', function(e){
        e.preventDefault();
        const note_id = $(this).data('id');
        Swal.fire({
            title: `Bạn muốn xóa ghi chú này?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Muốn',
            cancelButtonText: 'Không'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
            type:"DELETE",
            url:'/admin/delete-note/' +note_id,
            data : {     
            },
            })
            .done(function(res) {
            // If successful
              Swal.fire({
                    icon: 'success',
                    title: `${res.success}`,
                    showConfirmButton: false,
                    timer: 2500
                });

                $(`#note-${note_id}`).fadeOut();
                

            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
            })
         
        }
      })
    })

    $(document).on('click','.delete-button',function(){
      var document_id = $(this).data('id');
      var name = $(this).data('name');
      var token = $("meta[name='csrf-token']").attr("content");

      Swal.fire({
          title: "Bạn muốn xóa tài liệu "+ name,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Xóa tài liệu',
          cancelButtonText: 'Không'
          }).then((result) => {
          if (result.isConfirmed) {
            
            $.ajax({
              type:"GET",
              url:'/admin/document/customDelete/' + document_id,
              data : {
              },
              })
              .done(function() {
              // If successful
                Swal.fire({
                      icon: 'success',
                      title: `Xóa tài liệu ${name} thành công`,
                      showConfirmButton: false,
                      timer: 2500
                });

                $('#document-render-div').load(' #document-render-div > *');

              })
              .fail(function(jqXHR, textStatus, errorThrown) {
              // If fail
              console.log(textStatus + ': ' + errorThrown);
              })
          
          }
        })

   

  })

  $(document).on('click','#verification_item_button',function(){
        const document_id = $(this).data('id');
        var data = [];
        data.push(document_id);
        

        $.ajax({ 
            type:"GET",
            url:'/admin/deleted/document/recovery',
            data: {'data':data}   
            })
            .done(function() {
            // If successful
       

            Swal.fire({
                icon: 'success',
                title: `Khôi phục thành công!!!`,
                showConfirmButton: false,
                timer: 2500
            });

            $('#document-render-div').load(' #document-render-div > *');

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

    $(document).on('click','.lock-button',function(e){
      e.preventDefault();

      var document_id = $(this).data('id');
      var name = $(this).data('name');
      var status = $(this).data('status');

      
      var token = $("meta[name='csrf-token']").attr("content");

      Swal.fire({
          title: status === -2 ? "Bạn muốn mở khóa tài liệu " + name : "Bạn muốn khóa tài liệu " + name,
          html:status === -2 ?  '<em class="icon icon-circle bg-success-dim ni ni-unlock"></em>':  '<em class="icon icon-circle bg-warning-dim ni ni-lock"></em>',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Đồng ý',
          cancelButtonText: 'Không'
          }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
              type:"GET",
              url:'/admin/document/lock/' + document_id,
              data : {
              },
              })
              .done(function(res) {
              // If successful

                if(res.status == 1){
                  Swal.fire({
                      icon: 'success',
                      title: `Mở khóa thành công`,
                      showConfirmButton: false,
                      timer: 2500
                  });

                  $('#document-render-div').load(' #document-render-div > *')


                }
                else{
                  Swal.fire({
                      icon: 'success',
                      title: `Khóa thành thành công`,
                      showConfirmButton: false,
                      timer: 2500
                  });

                  $('#document-render-div').load(' #document-render-div > *')



                  $("#note-type").select2().select2('val',[`5`]);

                  setTimeout(() => {

                      $('#note-object').select2().select2('val',[`${document_id}`]);
                      $('#modalNote').modal('show');
                    }, 2500);
                }



           

              })
              .fail(function(jqXHR, textStatus, errorThrown) {
              // If fail
              console.log(textStatus + ': ' + errorThrown);
              })
          
          }
        })
      })
    
</script>

@endsection