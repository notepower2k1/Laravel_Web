@extends('client/manage.layouts.app')
@section('pageTitle', 'Chi tiết tài liệu')

@section('content')
<div class="nk-fmg-body">
    <div class="nk-fmg-body-head d-none d-lg-flex">
        <div class="nk-fmg-actions">
            <ul class="nk-block-tools g-3">
                <li>
                    <a href="{{ url()->previous() }}" class="btn btn-light"><em class="icon ni ni-arrow-left"></em> <span>Quay lại</span></a>                    
                </li>
            </ul>
        </div>
  </div>
    <div class="nk-fmg-body-content">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between position-relative">               
                <div class="nk-block-head-content">
                    <ul class="nk-block-tools g-1">           
                        <li class="d-lg-none">
                            <div class="dropdown">
                                <a href="{{ url()->previous() }}" class="btn btn-light"><em class="icon ni ni-arrow-left"></em> <span>Quay lại</span></a>                    
                            </div>
                        </li>
                        <li class="d-lg-none me-n1"><a href="#" class="btn btn-trigger btn-icon toggle" data-target="files-aside"><em class="icon ni ni-menu-alt-r"></em></a></li>
                    </ul>
                </div>             
            </div>
        </div>
        <div class="nk-fmg-quick-list nk-block">
            <div class="card card-bordered shadow">
                <div class="card-inner">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="product-gallery" >    
                                <img src="{{ $document->url }}" class="w-100" alt="">                                     
                            </div>
                        </div><!-- .col -->
                        <div class="col-lg-6 d-flex align-items-end">
                            <div class="product-info mb-5 me-xxl-5">
                                    <h3 class="product-title">{{ $document->name }}                               
                                    </h3>    
                                  
                                    
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
                 
                </div>
            </div>
           
        </div>
    </div>
</div>



@endsection
@section('additional-scripts')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

@endsection