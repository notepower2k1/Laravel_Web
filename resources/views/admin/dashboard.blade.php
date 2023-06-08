@extends('admin/layouts.app')
@section('content')

<div class="p-2">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Dashboard</h3>
                <div class="nk-block-des text-soft">
                    <p id="moment-today-span"></p>
                </div>
            </div><!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            <li>
                                <div class="drodown">
                                    <a href="#" class="dropdown-toggle btn btn-white btn-dim btn-outline-primary" data-bs-toggle="dropdown"><em class="icon ni ni-reports"></em><span>Xuất báo cáo</span></a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <ul class="link-list-opt no-bdr">
                                            <li><a class="export-csv-btn" data-option=1 href="#"><span>Thống kê sách được thêm trong tuần</span></a></li>
                                            <li><a class="export-csv-btn" data-option=2 href="#"><span>Thống kê tài liệu được thêm trong tuần</span></a></li>
                                            <li><a class="export-csv-btn" data-option=3 href="#"><span>Thống kê thành viên tham gia trong tuần</span></a></li>
                                            <li><a class="export-csv-btn" data-option=4 href="#"><span>Thống kê bài viết được đăng trong tuần</span></a></li>
                                            <li><a class="export-csv-btn" data-option=5 href="#"><span>Khung giờ đăng nhập</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block nk-block-lg">
        <div class="row g-gs">  
            <div class="col-xxl-3 col-sm-3">
                <div class="card card-full overflow-hidden">
                    <div class="nk-ecwg nk-ecwg7 h-100">
                        <div class="card-inner flex-grow-1">
                            <h6 class="title">Sách mới trong ngày</h6>
    
                            <div class="">
                                <em class="icon icon-circle bg-success-dim ni ni-book-fill"></em>
                                <span>{{ $book_today_info['todayValue'] }}</span>
    
                            </div>
                            <div class="balance mt-2">
                                <div class="info">    
                                    @if ($book_today_info['todayValue'] == 0 && $book_today_info['yestedayValue'] == 0)
                                        <span></span>
                                    @endif   
                                    
                                    @if($book_today_info['todayValue'] > 0 && $book_today_info['yestedayValue'] > 0)
                                        @if($book_today_info['percentGrowth'] > 0)
                                            <em class="icon ni ni-arrow-long-up"></em><span class="change up text-success">{{ $book_today_info['percentGrowth'] }}%</span><span> so với hôm qua</span>
                                        @endif
                                        @if($book_today_info['percentGrowth'] < 0)
                                            <em class="icon ni ni-arrow-long-down"></em><span class="change down text-danger">{{ $book_today_info['percentGrowth'] }}%</span><span> so với hôm qua</span>
                                        @endif
                                        @if($book_today_info['percentGrowth'] == 0)
                                            <em class="icon ni equal"></em><span class="text-info">Không đổi</span><span> so với hôm qua</span>
                                        @endif
                                    @endif
    
                                    @if ($book_today_info['todayValue'] > 0 Xor $book_today_info['yestedayValue'] > 0)
                                        @if ($book_today_info['todayValue'] > 0 && $book_today_info['yestedayValue'] == 0)
                                            <em class="icon ni ni-arrow-long-up"></em><span class="change up text-success">{{ $book_today_info['todayValue'] }}</span><span> so với hôm qua</span>
                                        @endif
                                        @if ($book_today_info['todayValue'] == 0 && $book_today_info['yestedayValue'] > 0)
                                            <em class="icon ni ni-arrow-long-down"></em><span class="change down text-success">{{ $book_today_info['yestedayValue'] }}</span><span> so với hôm qua</span>
                                        @endif
                                    @endif
    
                                    
                                    
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-3">
                <div class="card card-full overflow-hidden">
                    <div class="nk-ecwg nk-ecwg7 h-100">
                        <div class="card-inner flex-grow-1">
                            <h6 class="title">Tài liệu mới trong ngày</h6>
    
                            <div class="">
                                <em class="icon icon-circle bg-secondary-dim ni ni-file-text"></em>
                                <span>{{ $document_today_info['todayValue'] }}</span>
    
                            </div>
                            <div class="balance mt-2">
                                <div class="info">
                                    @if ($document_today_info['todayValue'] == 0 && $document_today_info['yestedayValue'] == 0)
                                    <span></span>
                                @endif   
                                
                                @if($document_today_info['todayValue'] > 0 && $document_today_info['yestedayValue'] > 0)
                                    @if($document_today_info['percentGrowth'] > 0)
                                        <em class="icon ni ni-arrow-long-up"></em><span class="change up text-success">{{ $document_today_info['percentGrowth'] }}%</span><span> so với hôm qua</span>
                                    @endif
                                    @if($document_today_info['percentGrowth'] < 0)
                                        <em class="icon ni ni-arrow-long-down"></em><span class="change down text-danger">{{ $document_today_info['percentGrowth'] }}%</span><span> so với hôm qua</span>
                                    @endif
                                    @if($document_today_info['percentGrowth'] == 0)
                                        <em class="icon ni equal"></em><span class="text-info">Không đổi</span><span> so với hôm qua</span>
                                    @endif
                                @endif
    
                                @if ($document_today_info['todayValue'] > 0 Xor $document_today_info['yestedayValue'] > 0)
                                    @if ($document_today_info['todayValue'] > 0 && $document_today_info['yestedayValue'] == 0)
                                        <em class="icon ni ni-arrow-long-up"></em><span class="change up text-success">{{ $document_today_info['todayValue'] }}</span><span> so với hôm qua</span>
                                    @endif
                                    @if ($document_today_info['todayValue'] == 0 && $document_today_info['yestedayValue'] > 0)
                                        <em class="icon ni ni-arrow-long-down"></em><span class="change down text-success">{{ $document_today_info['yestedayValue'] }}</span><span> so với hôm qua</span>
                                    @endif
                                @endif
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-3">
                <div class="card card-full overflow-hidden">
                    <div class="nk-ecwg nk-ecwg7 h-100">
                        <div class="card-inner flex-grow-1">
                            <h6 class="title">Bài viết mới trong ngày </h6>
    
                            <div class="">
                                <em class="icon icon-circle bg-info-dim ni ni-list-fill"></em>
                                <span>{{ $post_today_info['todayValue'] }}</span>
    
                            </div>
                            <div class="balance mt-2">
                                <div class="info">
                                    @if ($post_today_info['todayValue'] == 0 && $post_today_info['yestedayValue'] == 0)
                                    <span></span>
                                @endif   
                                
                                @if($post_today_info['todayValue'] > 0 && $post_today_info['yestedayValue'] > 0)
                                    @if($post_today_info['percentGrowth'] > 0)
                                        <em class="icon ni ni-arrow-long-up"></em><span class="change up text-success">{{ $post_today_info['percentGrowth'] }}%</span><span> so với hôm qua</span>
                                    @endif
                                    @if($post_today_info['percentGrowth'] < 0)
                                        <em class="icon ni ni-arrow-long-down"></em><span class="change down text-danger">{{ $post_today_info['percentGrowth'] }}%</span><span> so với hôm qua</span>
                                    @endif
                                    @if($post_today_info['percentGrowth'] == 0)
                                        <em class="icon ni equal"></em><span class="text-info">Không đổi</span><span> so với hôm qua</span>
                                    @endif
                                @endif
    
                                @if ($post_today_info['todayValue'] > 0 Xor $post_today_info['yestedayValue'] > 0)
                                    @if ($post_today_info['todayValue'] > 0 && $post_today_info['yestedayValue'] == 0)
                                        <em class="icon ni ni-arrow-long-up"></em><span class="change up text-success">{{ $post_today_info['todayValue'] }}</span><span> so với hôm qua</span>
                                    @endif
                                    @if ($post_today_info['todayValue'] == 0 && $post_today_info['yestedayValue'] > 0)
                                        <em class="icon ni ni-arrow-long-down"></em><span class="change down text-success">{{ $post_today_info['yestedayValue'] }}</span><span> so với hôm qua</span>
                                    @endif
                                @endif
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-3">
                <div class="card card-full overflow-hidden">
                    <div class="nk-ecwg nk-ecwg7 h-100">
                        <div class="card-inner flex-grow-1">
                            <h6 class="title">Thành viên mới trong ngày</h6>
    
                            <div class="">
                                <em class="icon icon-circle bg-warning-dim ni ni-users"></em>
                                <span>{{ $user_today_info['todayValue'] }}</span>
    
                            </div>
                            <div class="balance mt-2">
                                <div class="info">
                                    @if ($user_today_info['todayValue'] == 0 && $user_today_info['yestedayValue'] == 0)
                                    <span></span>
                                @endif   
                                
                                @if($user_today_info['todayValue'] > 0 && $user_today_info['yestedayValue'] > 0)
                                    @if($user_today_info['percentGrowth'] > 0)
                                        <em class="icon ni ni-arrow-long-up"></em><span class="change up text-success">{{ $user_today_info['percentGrowth'] }}%</span><span> so với hôm qua</span>
                                    @endif
                                    @if($user_today_info['percentGrowth'] < 0)
                                        <em class="icon ni ni-arrow-long-down"></em><span class="change down text-danger">{{ $user_today_info['percentGrowth'] }}%</span><span> so với hôm qua</span>
                                    @endif
                                    @if($user_today_info['percentGrowth'] == 0)
                                        <em class="icon ni equal"></em><span class="text-info">Không đổi</span><span> so với hôm qua</span>
                                    @endif
                                @endif
    
                                @if ($user_today_info['todayValue'] > 0 Xor $user_today_info['yestedayValue'] > 0)
                                    @if ($user_today_info['todayValue'] > 0 && $user_today_info['yestedayValue'] == 0)
                                        <em class="icon ni ni-arrow-long-up"></em><span class="change up text-success">{{ $user_today_info['todayValue'] }}</span><span> so với hôm qua</span>
                                    @endif
                                    @if ($user_today_info['todayValue'] == 0 && $user_today_info['yestedayValue'] > 0)
                                        <em class="icon ni ni-arrow-long-down"></em><span class="change down text-success">{{ $user_today_info['yestedayValue'] }}</span><span> so với hôm qua</span>
                                    @endif
                                @endif
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card">
                    <div class="nk-ecwg nk-ecwg6">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Thống kê sách được thêm trong tuần</h6>
                                </div>
                            </div>
                            <div class="data mt-2">
                                <div class="data-group">
                                    <div class="nk-ecwg6-ck">
                                        <canvas id="weekBookBar"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .card-inner -->
                    </div><!-- .nk-ecwg -->
                </div><!-- .card -->
            </div><!-- .col -->
            <div class="col-xxl-3 col-sm-6">
                <div class="card">
                    <div class="nk-ecwg nk-ecwg6">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Thống kê tài liệu được thêm trong tuần</h6>
                                </div>
                            </div>
                            <div class="data mt-2">
                                <div class="data-group">
                                    <div class="nk-ecwg6-ck">
                                        <canvas id="weekDocumentBar"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .card-inner -->
                    </div><!-- .nk-ecwg -->
                </div><!-- .card -->
            </div><!-- .col -->
            <div class="col-xxl-3 col-sm-6">
                <div class="card">
                    <div class="nk-ecwg nk-ecwg6">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Thống kê bài viết được đăng trong tuần</h6>
                                </div>
                            </div>
                            <div class="data mt-2">
                                <div class="data-group">
                                    <div class="nk-ecwg6-ck">
                                        <canvas id="weekPostBar"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .card-inner -->
                    </div><!-- .nk-ecwg -->
                </div><!-- .card -->
            </div><!-- .col -->
            <div class="col-xxl-3 col-sm-6">
                <div class="card">
                    <div class="nk-ecwg nk-ecwg6">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Thống kê thành viên tham gia trong tuần</h6>
                                </div>
                            </div>
                            <div class="data mt-2">
                                <div class="data-group">
                                    <div class="nk-ecwg6-ck">
                                        <canvas id="weekUserBar"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .card-inner -->
                    </div><!-- .nk-ecwg -->
                </div><!-- .card -->
            </div><!-- .col -->
            
            <div class="col-xxl-12">
                <div class="card card-full">
                    <div class="nk-ecwg nk-ecwg8 h-100">
                        <div class="card-inner">
                            <div class="card-title-group mb-3">
                                <div class="card-title">
                                    <h6 class="title">Thống kê trong tuần</h6>
                                </div>                     
                            </div>
                            <div style=" height: 500px;">
                                <canvas id="groupBar"></canvas>
    
                            </div>
                        </div><!-- .card-inner -->
                    </div>
                </div><!-- .card -->
            </div>
           
            <div class="col-xxl-6 col-md-12 col-lg-6">
                <div class="card card-full overflow-hidden">
                    <div class="nk-ecwg nk-ecwg7 h-100">
                            
                        <div class="d-flex flex-column justify-content-center align-items-center h-100">
                            <div class="card-title-group mb-4">
                                <div class="card-title">
                                    <h6 class="title">Biểu đồ phần trăm tài liệu điện tử trong tuần</h6>
                                </div>
                            </div>
                            <div class="nk-ecwg7-ck ms-auto me-auto" style="width:300px;height:300px">
                                <canvas id="doughnutChart"></canvas>
                            </div>
                        
                        </div><!-- .card-inner -->
                    </div>
                </div><!-- .card -->
            </div>
           
            <div class="col-xxl-6 col-md-12 col-lg-6">
                <div class="card card-full overflow-hidden">
                    <div class="nk-ecwg nk-ecwg7 h-100">
                            
                        <div class="d-flex flex-column justify-content-center align-items-center h-100">
                            <div class="card-title-group mb-4">
                                <div class="card-title">
                                    <h6 class="title">Biểu đồ tổng số lượng các tài nguyên trong tuần</h6>
                                </div>
                            </div>
                            <div class="nk-ecwg7-ck ms-auto me-auto" style="width:300px;height:300px">
                                <canvas id="polarAreaChart"></canvas>
                            </div>
                        
                        </div><!-- .card-inner -->
                    </div>
                </div><!-- .card -->
            </div>

            <div class="col-xxl-12">
                <div class="card card-full">
                    <div class="nk-ecwg nk-ecwg8 h-100">
                        <div class="card-inner">
                            <div class="card-title-group mb-3">
                                <div class="card-title">
                                    <h6 class="title">Biểu đồ khung giờ đăng nhập</h6>
                                </div>
                                <div class="card-tools">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle link link-light link-sm dropdown-indicator" data-bs-toggle="dropdown">Lựa chọn</a>
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="" class="active loginChartChange" data-option="0"><span>Hôm nay</span></a></li>
                                                <li><a href="" class="loginChartChange" data-option="1"><span>Hôm qua</span></a></li>
                                                <li><a href="" class="loginChartChange" data-option="2"><span>Tuần này</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style=" height: 400px;">
                                <canvas id="loginBar"></canvas>
    
                            </div>
                        </div><!-- .card-inner -->
                    </div>
                </div><!-- .card -->
            </div>
            <div class="col-xxl-12">
                <div class="card card-full">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Tài liệu điện tử được thêm hôm nay</h6>
                            </div>
                        </div>
                    </div>
                    <div class="p-2">
                        <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                            <thead>
                                <tr class="nk-tb-item nk-tb-head">      
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ảnh bìa</span></th>                        
                                    <th class="nk-tb-col"><span class="sub-text">Tiêu đề</span></th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Tác giả</span></th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Danh mục</span></th>
                                    <th class="nk-tb-col tb-col-mb"><span class="sub-text">Người thêm</span></th>
                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">Ngày thêm</span></th>
                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">Tình trạng</span></th>
    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($today_book as $book)
                                <tr class="nk-tb-item" id ="row-book-{{ $book->id }}">                                                                  
                                    
                                    <td class="nk-tb-col tb-col-lg">
                                        <img class="image-fluid" src={{$book->url}} alt="..." style="width:100px" />
                                    </td>
    
                                    <td class="nk-tb-col">
                                        <div class="user-card">                                           
                                            <div class="user-info">
                                                <span class="tb-lead" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $book->name }}">{{ Str::limit($book->name,30) }}<span class="dot dot-success d-md-none ms-1"></span></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        <span>{{ Str::limit($book->author,30) }}</span>
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        <span>{{ $book->types->name }}</span>
    
                                    </td>
                                    <td class="nk-tb-col tb-col-mb">
                                        <span>{{ $book->users->name }}</span>
                                    </td>
    
                                    <td class="nk-tb-col tb-col-md">
                                        <span>{{ $book->created_at }}</span>
                                    </td>
    
                                    <td class="nk-tb-col tb-col-md">
                                        @if($book->status == 1)
                                        <span class="badge badge-dot badge-dot-xs bg-success">
                                            Đã duyệt
                                        </span>
                                        @endif
                                        @if($book->status == 0)
                                        <span class="badge badge-dot badge-dot-xs bg-info">
                                            Đang duyệt
                                        </span>
                                        @endif
                                        @if($book->status == -1)
                                        <span class="badge badge-dot badge-dot-xs bg-danger">
                                            Từ chối
                                        </span>
                                        @endif
                                    </td>
                                </tr><!-- .nk-tb-item  -->
                                @endforeach
                                @foreach ($today_document as $document)
                                <tr class="nk-tb-item" id ="row-document-{{ $document->id }}">             
                                                            
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
                                    <span>{{ Str::limit($document->author,30) }}</span>
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                    <span>{{ $document->types->name }}</span>
    
                                    </td>
                                    <td class="nk-tb-col tb-col-mb">
                                        <span>{{ $document->users->name }}</span>
                                    </td>
                                    <td class="nk-tb-col tb-col-md">
                                        <span>{{ $document->created_at }}</span>
                                    </td>
                                    <td class="nk-tb-col tb-col-md">
                                        @if($document->status == 1)
                                        <span class="badge badge-dot badge-dot-xs bg-success">
                                            Đã duyệt
                                        </span>
                                        @endif
                                        @if($document->status == 0)
                                        <span class="badge badge-dot badge-dot-xs bg-info">
                                            Đang duyệt
                                        </span>
                                        @endif
                                        @if($document->status == -1)
                                        <span class="badge badge-dot badge-dot-xs bg-danger">
                                            Từ chối
                                        </span>
                                        @endif
                                    </td>
                                </tr><!-- .nk-tb-item  -->
                            @endforeach
                            
                            
                            </tbody>
                        </table>
                    </div>
                    
                </div><!-- .card -->
            </div>
        </div><!-- .row -->
    </div><!-- .nk-block -->
</div>


@endsection
@section('additional-scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.4/moment-with-locales.js"></script>


<script>
    var loginBarDataset = [];
    var loginBarLabels = [];

    $(function() {

        const today = {!! json_encode($today) !!};
        var dateObj = new Date(today);

        var vietnameseDate = moment(dateObj).locale('vi').format('LLLL').toString();
        //clear
        var vietnameseDate = vietnameseDate.substring(0, vietnameseDate.length - 6);

        //upppercase
        var vietnameseDate = vietnameseDate.charAt(0).toUpperCase() + vietnameseDate.slice(1)

        $('#moment-today-span').text(vietnameseDate);
    })
    
    function createLoginBar(){
        const loginBarCanvas = document.getElementById('loginBar');
        var today =  {!! json_encode($today) !!}
        var result = {!! json_encode($today_logins) !!}
        
        var all_hour = [];
        for (var i = 0; i < 24 ; i++){
            
            all_hour.push({
                'hour':i,
                'total':0
            })
        }
        all_hour.forEach(item1 => {
            
            result.forEach(item2=>{
                if(item1.hour === item2.hour){
                    item1.hour = item2.hour;
                    item1.total = item2.total
                }
            })
        });


        var newArray = all_hour.map(object=>{

            
            var hour = object.hour;
            
            if(hour < 10){

                object.hour = today + 'T0'+ object.hour + ':00:00'
            }else{
                object.hour = today + 'T'+ object.hour + ':00:00'

            }

            return object
        });

        var labelArray = newArray.map(object =>object.hour);

        
        var data = {
            labels: labelArray,
            datasets: [{
                label: 'Lượt đăng nhập',
                data:  newArray.map(object =>object.total),
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(235,238,255,0.6)',
                tension: 0.2,


            }]
        };
        const loginBar = new Chart(loginBarCanvas, {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x:{  

                            min:`${today}T00:00:00`,
                            max:`${today}T23:59:00`,

                            type: 'time',
                            time: {
                                    unit:'hour'  
                                },

                        },
                        y: {
                            ticks: {
                                precision: 0,
                                beginAtZero: true,         
                                },
                            display: false,
                        } 
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            displayColors:false,
                            callbacks:{
                                title: function(tooltipItems, data) {
                                    var tooltipItem = tooltipItems[0];
                                    if (tooltipItem.dataIndex == 23) {

                                        const temp = new Date(labelArray[tooltipItem.dataIndex])

                                        var hour1 = moment(temp).locale('en').format('LT');

                                        return "Sau " + hour1;
                                    } else {

                                        const temp = new Date(labelArray[tooltipItem.dataIndex]);
                                        const temp2 = new Date(labelArray[(tooltipItem.dataIndex) + 1]);

                                        var hour1 = moment(temp).locale('en').format('LT');
                                        var hour2 = moment(temp2).locale('en').format('LT');

                                        return hour1 + " - " + hour2;
                                    }
                                },
                            }
                        },

                    }
                },  
                
        });

        loginBarDataset = loginBar.data.datasets[0].data;
        loginBarLabels = loginBar.data.labels;

        
        $('.loginChartChange').click(function(e) {
            e.preventDefault();
            
            $('.loginChartChange').removeClass('active');

            $(this).addClass('active');
            var option = $(this).data('option');
            $.ajax({
                type:"GET",
                url:'/admin/dashboard/get/LoginHistory',
                data : {
                    "option":option
                },
                })
                .done(function(res) {
                // If successful           
                    
                    var result = res.res;
                    var today =  {!! json_encode($today) !!}

                    var all_hour = [];
                    for (var i = 0; i < 24 ; i++){
                        
                        all_hour.push({
                            'hour':i,
                            'total':0
                        })
                    }
                    all_hour.forEach(item1 => {
                        
                        result.forEach(item2=>{
                            if(item1.hour === item2.hour){
                                item1.hour = item2.hour;
                                item1.total = item2.total
                            }
                        })
                    });


                    var newArray = all_hour.map(object=>{

                        
                        var hour = object.hour;
                        
                        if(hour < 10){

                            object.hour = today + 'T0'+ object.hour + ':00:00'
                        }else{
                            object.hour = today + 'T'+ object.hour + ':00:00'

                        }

                        return object
                    });


                    loginBar.data.datasets[0].data = newArray.map(object =>object.total);

                    loginBarDataset = loginBar.data.datasets[0].data;
                    loginBarLabels = loginBar.data.labels

          

                    loginBar.update();                 

                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                })
        
        })
    
    }
    createLoginBar();


    function createWeekBookBar(){
        const weekBookCanvas = document.getElementById('weekBookBar');

        var result = {!! json_encode($week_books) !!};


        var data = {
            labels:  Object.keys(result[0]),
            datasets: [{
                label: 'Số lượng sách',
                data:   Object.values(result[0]),
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                backgroundColor: "#1ee0ac",
            }]
        };
        const weekBookBar = new Chart(weekBookCanvas, {
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

    createWeekBookBar();

    function createWeekDocumentBar(){
        const weekDocumentCanvas = document.getElementById('weekDocumentBar');

        var result = {!! json_encode($week_documents) !!};


        var data = {
            labels:  Object.keys(result[0]),
            datasets: [{
                label: 'Số lượng tài liệu',
                data:   Object.values(result[0]),
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                backgroundColor: "#364a63",
            }]
        };
        const weekDocumentBar = new Chart(weekDocumentCanvas, {
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

    createWeekDocumentBar();

    function createWeekUserBar(){
        const weekUserCanvas = document.getElementById('weekUserBar');

        var result = {!! json_encode($week_members) !!};

        var data = {
            labels:  Object.keys(result[0]),
            datasets: [{
                label: 'Số lượng thành viên',
                data:   Object.values(result[0]),
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                backgroundColor: "#f4bd0e",
            }]
        };
        const weekUserBar = new Chart(weekUserCanvas, {
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

    createWeekUserBar();

    function createWeekPostBar(){
        const weekPostCanvas = document.getElementById('weekPostBar');

        var result = {!! json_encode($week_posts) !!};
      

        var data = {
            labels:  Object.keys(result[0]),
            datasets: [{
                label: 'Số lượng bài viết',
                data:   Object.values(result[0]),
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                backgroundColor: "#09c2de",
            }]
        };
        const weekPostBar = new Chart(weekPostCanvas, {
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

    createWeekPostBar();

    function createDonutChart() {

        const ctx = document.getElementById('doughnutChart');


        var books = {!! ($total_books) !!};
        var documents = {!! ($total_documents) !!};

        const data = {

            labels:['Sách','Tài liệu'],
            datasets: [{
                label: 'Số lượng',
                data: [books,documents],
                hoverOffset: 4,
                backgroundColor: [
                "#1ee0ac",
                "#364a63"
            ],

            }]
        };

        new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: {  
                responsive: true,
                maintainAspectRatio: false,
                cutout: 70,

                plugins: {
                
                    legend: {
                        position: 'bottom',
                        labels: {
                            textAlign: 'left',
                        }
                    }
                },
            },

        });

    }
    createDonutChart();


    function createPolarAreaChart() {

    const ctx = document.getElementById('polarAreaChart');


    var books = {!! $total_books !!};
    var documents = {!! $total_documents !!};
    var posts = {!! $total_posts !!};
    var users = {!! $total_users !!};

    const data = {

        labels:['Sách','Tài liệu','Bài viết','Thành viên'],
        datasets: [{
            label: 'Số lượng',
            data: [books,documents,posts,users],
            hoverOffset: 4,
            backgroundColor: [
                "#1ee0ac",
                "#364a63",
                "#09c2de",
                "#f4bd0e"
            ],

        }]
    };

    new Chart(ctx, {
        type: 'polarArea',
        data: data,
        options: {  
            responsive: true,
            maintainAspectRatio: false,
            


            plugins: {
            
                legend: {
                    position: 'bottom',
                    labels: {
                        textAlign: 'left',
                    }
                }
            },
        },

    });

    }
    createPolarAreaChart();


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

    $('.export-csv-btn').on('click', function(){
        var currentDate = moment();
        var weekStart = currentDate.clone().startOf('week');
        var weekEnd = currentDate.clone().endOf('week');

        var days = [];
        for (let i = 1; i <= 7; i++) {

            days.push(moment(weekStart).add(i, 'days').locale('vi').format("L"));

        };

        const option = $(this).data('option');

        let title = '';
        let result = null;

        
        if(option === 5){
            title = ['Khung giờ đăng nhập'];
            header = ['Khung giờ','Số lượng']    

            timeArea = loginBarLabels.map(function(i,index){
                if (index == 23) {
                    const temp = new Date(i)

                    var hour1 = moment(temp).locale('en').format('LT');

                    return "Sau " + hour1;
                    
                    } else {

                    const temp = new Date(i)
                    const temp2 = new Date(loginBarLabels[index + 1])

                    var hour1 = moment(temp).locale('en').format('LT');
                    var hour2 = moment(temp2).locale('en').format('LT');

                    return hour1 + " - " + hour2;
                }
            });

            total = loginBarDataset;

            const obj = {};

            timeArea.forEach((element, index) => {
                obj[element] = total[index];
            });
            
            let entries = Object.entries(obj);
            
            let temp = [];
            temp.push(title)
            temp.push(header);
            entries.forEach(i => temp.push(i));

            let csv = arrayToCsv(temp);
            downloadBlob(csv, `bao-cao-${option}.csv`);
        }

        else{

            if (option === 1){
                result = {!! json_encode($week_books) !!};
                title = ['Số lượng sách'];

            }
            if(option === 2){
                result = {!! json_encode($week_documents) !!};
                title = ['Số lượng tài liệu'];

            }     
            if (option === 3){
                result = {!! json_encode($week_members) !!};
                title = ['Số lượng thành viên'];
            }
            if(option === 4){
                result = {!! json_encode($week_posts) !!};
                title = ['Số lượng bài viết'];
            }

        


            let header = ['Thứ','Ngày','Số lượng']    

            let entries = Object.entries(result[0]);

            entries.forEach(function (item,index) {
                item.unshift(days[index]);
            })
        
            let temp = [];
            temp.push(title)
            temp.push(header);
         
            entries.forEach(i => temp.push(i));

            let csv = arrayToCsv(temp);
            downloadBlob(csv, `bao-cao-${option}.csv`);
        }
       



        // const csvData = json2csv.parse(result);

      
    })
    

    function groupBar(){

        const books = {!! json_encode($week_books) !!};
        const documents = {!! json_encode($week_documents) !!};
        const posts = {!! json_encode($week_posts) !!};
        const members = {!! json_encode($week_members) !!};

        var ctx = document.getElementById("groupBar");

        var data = {
        labels:  Object.keys(books[0]),
        datasets: [{
            label: "Số lượng sách",
            backgroundColor: "#1ee0ac",
            data: Object.values(books[0]),
        }, {
            label: "Số lượng tài liệu",
            backgroundColor: "#364a63",
            data: Object.values(documents[0]),

        }, {
            label: "Số lượng bài viết",
            backgroundColor: "#09c2de",
            data: Object.values(posts[0]),

        },{
            label: "Số lượng thành viên",
            backgroundColor: "#f4bd0e",
            data: Object.values(members[0]),
        }]
        };

        var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                    
                        y: {
                        ticks: {
                            precision: 0,
                            beginAtZero: true,

                            }
                        }
                    },
                    plugins: {
                       
                        tooltip: {
                            displayColors:false
                        },

                    }
                }
        });

    }

    groupBar();
</script>
@endsection
