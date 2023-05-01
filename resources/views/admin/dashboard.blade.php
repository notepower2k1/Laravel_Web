@extends('admin/layouts.app')
@section('content')

<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Dashboard</h3>
                <div class="nk-block-des text-soft">
                    <p id="moment-today-span"></p>
                </div>
            </div><!-- .nk-block-head-content -->
            {{-- <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            <li>
                                <div class="drodown">
                                    <a href="#" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-calender-date"></em><span><span class="d-none d-md-inline">Last</span> 30 Days</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <ul class="link-list-opt no-bdr">
                                            <li><a href="#"><span>Last 30 Days</span></a></li>
                                            <li><a href="#"><span>Last 6 Months</span></a></li>
                                            <li><a href="#"><span>Last 1 Years</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="nk-block-tools-opt"><a href="#" class="btn btn-primary"><em class="icon ni ni-reports"></em><span>Reports</span></a></li>
                        </ul>
                    </div>
                </div>
            </div><!-- .nk-block-head-content --> --}}
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
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
            <div class="col-xxl-6">
                <div class="card card-full">
                    <div class="nk-ecwg nk-ecwg8 h-100">
                        <div class="card-inner">
                            <div class="card-title-group mb-3">
                                <div class="card-title">
                                    <h6 class="title">Biểu đồ khung giờ đăng nhập</h6>
                                </div>
                                <div class="card-tools">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle link link-light link-sm dropdown-indicator" data-bs-toggle="dropdown">Option</a>
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="" class="active loginChartChange" data-option="0"><span>Today</span></a></li>
                                                <li><a href="" class="loginChartChange" data-option="1"><span>Yesterday</span></a></li>
                                                <li><a href="" class="loginChartChange" data-option="2"><span>Current week</span></a></li>
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
            <div class="col-xxl-3 col-md-12 col-lg-5">
                <div class="card card-full overflow-hidden">
                    <div class="nk-ecwg nk-ecwg7 h-100">
                         
                        <div class="d-flex flex-column justify-content-center align-items-center h-100">
                            <div class="card-title-group mb-4">
                                <div class="card-title">
                                    <h6 class="title">Thống kê loại tài liệu điện tử</h6>
                                </div>
                            </div>
                            <div class="nk-ecwg7-ck ms-auto me-auto" style="width:300px;height:300px">
                                <canvas id="doughnutChart"></canvas>
                            </div>
                        
                        </div><!-- .card-inner -->
                    </div>
                </div><!-- .card -->
            </div><!-- .col -->
            <div class="col-xxl-3 col-md-12 col-lg-7">
                <div class="card h-100">
                    <div class="card-inner">
                        <div class="nk-fmg-listing nk-block-lg">
                            <div class="nk-block-head-xs">
                                <div class="nk-block-between g-2">
                                    <div class="nk-block-head-content">
                                        <h6 class="nk-block-title title">Tài liệu nổi bật</h6>
                                    </div>
                                    <div class="nk-block-head-content">
                                        <ul class="nk-block-tools g-3 nav">
                                            <li><a data-bs-toggle="tab" href="#file-grid-view" class="nk-switch-icon active"><em class="icon ni ni-book"></em></a></li>
                                            <li><a class="nk-switch-icon"><em class="icon ni ni-swap"></em></a></li>
                                            <li><a data-bs-toggle="tab" href="#file-group-view" class="nk-switch-icon"><em class="icon ni ni-file-docs"></em></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="tab-content">
                
                                <div class="tab-pane active" id="file-grid-view">
                                    @if($high_reading_book)
                
                                    <div class="nk-files nk-files-view-grid">                 
                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="product-gallery" >    
                                                            <img src="{{ $high_reading_book->url }}" class="w-100" alt="">                                     
                                                       </div>
                                                    </div><!-- .col -->
                                                    <div class="col-lg-6 d-flex align-items-end">
                                                        <div class="product-info mb-5 me-xxl-5">
                                                            <h2 class="product-title">{{ $high_reading_book->name }}                                                
                                                            </h2>                                                         
                                                            <p class="product-title">Tác giả: {{ $high_reading_book->author }}</p>                 
                                                            <div class="product-meta">
                                                                <h6 class="title">Ngôn ngữ: 
                                                                    @if ($high_reading_book->language === 1)
                                                                    <span class="text-success">Tiếng việt</span>
                                                                    @else
                                                                    <span class="text-info">Tiếng anh</span>
                        
                                                                    @endif 
                                                                </h6>
                                                              
                                                            </div><!-- .product-meta -->                            
                                                            <div class="product-meta">
                                                                <h6 class="title">Thể loại</h6>                                     
                                                                <span class="text-success">{{ $high_reading_book->types->name }}</span>
                                                            </div><!-- .product-meta -->     
                                                            <div class="product-meta">
                                                                <h6 class="title">Đánh giá</h6>
                                                                <span class="text-success">{{ $high_reading_book->ratingScore }}</span>
                                                            </div><!-- .product-meta -->         
                                                            <div class="product-meta">
                                                                <h6 class="title">Lượt đọc</h6>
                                                                <span class="text-success">{{ $high_reading_book->totalReading }}</span>
                                                            </div><!-- .product-meta -->                        
                                                            <div class="product-meta">
                                                                <h6 class="title">Số bình luận</h6>
                                                                <span class="text-success">{{ $high_reading_book->totalComments }}</span>
                                                            </div><!-- .product-meta -->   
                                                            <div class="product-meta">
                                                                <h6 class="title">Lượt theo dõi</h6>
                                                                <span class="text-success">{{ $high_reading_book->totalBookMarking }}</span>
                                                            </div><!-- .product-meta -->   
                                                        </div><!-- .product-info -->
                                                       
                                                      
                                                    </div><!-- .col -->
                                                </div><!-- .row -->                                            
                                            </div>
                                        </div>
                                    </div><!-- .nk-files -->
                                    @else
                                    <p>Bạn chưa đăng sách nào</p>
                                    @endif
                
                                </div><!-- .tab-pane -->
                              
                
                                <div class="tab-pane" id="file-group-view">
                                    @if($high_downloading_document)
                
                                    <div class="nk-files nk-files-view-group">
                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="product-gallery" >    
                                                            <img src="{{ $high_downloading_document->url }}" class="w-100" alt="">                                     
                                                       </div>
                                                    </div><!-- .col -->
                                                    <div class="col-lg-6 d-flex align-items-end">
                                                        <div class="product-info mb-5 me-xxl-5">
                                                            <h2 class="product-title">{{ $high_downloading_document->name }}                                                
                                                            </h2>                                                         
                                                            <p class="product-title">Tác giả: {{ $high_downloading_document->author }}</p>                 
                                                            <div class="product-meta">
                                                                <h6 class="title">Ngôn ngữ: 
                                                                    @if ($high_downloading_document->language === 1)
                                                                    <span class="text-success">Tiếng việt</span>
                                                                    @else
                                                                    <span class="text-info">Tiếng anh</span>
                        
                                                                    @endif 
                                                                </h6>
                                                              
                                                            </div><!-- .product-meta -->                            
                                                            <div class="product-meta">
                                                                <h6 class="title">Thể loại</h6>                                     
                                                                <span class="text-success">{{ $high_downloading_document->types->name }}</span>
                                                            </div><!-- .product-meta -->                                               
                                                            <div class="product-meta">
                                                                <h6 class="title">Lượt tải</h6>
                                                                <span class="text-success">{{ $high_downloading_document->totalDownloading }}</span>
                                                            </div><!-- .product-meta -->                        
                                                            <div class="product-meta">
                                                                <h6 class="title">Số bình luận</h6>
                                                                <span class="text-success">{{ $high_downloading_document->totalComments }}</span>
                                                            </div><!-- .product-meta -->   
                                                            <div class="product-meta">
                                                                <h6 class="title">File đỉnh kèm</h6>
                                                                <a href="#" id="download-btn">
                                                                    file.{{ $high_downloading_document->extension }}
                                                                </a>
                                                            </div><!-- .product-meta -->   
                                                        </div><!-- .product-info -->
                                                       
                                                      
                                                    </div><!-- .col -->
                                                </div><!-- .row -->                                            
                                            </div>
                                        </div>
                                      
                                    </div><!-- .nk-files -->
                                    @else
                                    <p>Bạn chưa đăng tài liệu nào</p>
                
                                    @endif
                                </div><!-- .tab-pane -->
                                
                            </div><!-- .tab-content -->
                        </div><!-- .nk-block -->
                        
                        
                    </div><!-- .card-inner -->
                </div><!-- .card -->
            </div><!-- .col -->
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
                        <table class="datatable-init nowrap nk-tb-list nk-tb-ulist">
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
                                      <span>{{  $book->author }}</span>
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
                                    <span>{{  $document->author }}</span>
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
                fill: true,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                backgroundColor: 'rgba(235,238,255,0.6)'
            }]
        };
        const weekBookBar = new Chart(weekBookCanvas, {
                type: 'bar',
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
                fill: true,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                backgroundColor: 'rgba(235,238,255,0.6)'
            }]
        };
        const weekDocumentBar = new Chart(weekDocumentCanvas, {
                type: 'bar',
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
                fill: true,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                backgroundColor: 'rgba(235,238,255,0.6)'
            }]
        };
        const weekUserBar = new Chart(weekUserCanvas, {
                type: 'bar',
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
                fill: true,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                backgroundColor: 'rgba(235,238,255,0.6)'
            }]
        };
        const weekPostBar = new Chart(weekPostCanvas, {
                type: 'bar',
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


    var books = {!! count($total_books) !!};
    var documents = {!! count($total_documents) !!};

    const data = {

        labels:['Sách','Tài liệu'],
        datasets: [{
            label: 'Số lượng',
            data: [books,documents],
            hoverOffset: 4,
      

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


    $("#download-btn").click(function(e){
        e.preventDefault();
        var id = {!! $high_downloading_document->id !!}
        $.ajax({
                type:"GET",
                url:'/tai-tai-lieu',
                data : {
                    "id": id
                },
                })
                .done(function(res) {
                // If successful           
                    window.location.assign(res.url);


                    
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                })
       
        
    })

   
</script>
@endsection
