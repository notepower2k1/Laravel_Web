@extends('client/manage.layouts.app')
@section('pageTitle', 'Chi tiết sách điện tử')
@section('content')

<div class="nk-fmg-body">
    <div class="nk-fmg-body-head d-none d-lg-flex">
        <div class="nk-fmg-actions">
            <ul class="nk-block-tools g-3">
                <li>
                    <a class="btn btn-light" href="{{route('sach.index')}}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a>
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
                                <a href="{{route('sach.index')}}" class="btn btn-trigger btn-icon"><em class="icon ni ni-arrow-left"></em></a>                            
                            </div>
                        </li>
                        <li class="d-lg-none me-n1"><a href="#" class="btn btn-trigger btn-icon toggle" data-target="files-aside"><em class="icon ni ni-menu-alt-r"></em></a></li>
                    </ul>
                </div>             
            </div>
        </div>
        <div class="nk-fmg-quick-list nk-block">
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="product-gallery" >    
                                    <img src="{{ $book->url }}" class="w-100" alt="">                                     
                               </div>
                            </div><!-- .col -->
                            <div class="col-lg-6 d-flex align-items-end">
                                <div class="product-info mb-5 me-xxl-5">
                                        <h3 class="product-title">{{ $book->name }}
                                         
                                        </h3>                                        
                                        <div class="product-meta">
                                            <ul class="d-flex g-3 gx-5">
                                                <li>
                                                    <div class="fs-14px text-muted">Số chương</div>
                                                    <div class="fs-16px fw-bold text-secondary">{{ $book->numberOfChapter }}</div>
                                                </li>
                                                <li>
                                                    <div class="fs-14px text-muted">Lượt đọc</div>
                                                    <div class="fs-16px fw-bold text-secondary">{{ $book->totalReading }}</div>
                                                </li>
                                                <li>
                                                    <div class="fs-14px text-muted">Đánh dấu</div>
                                                    <div class="fs-16px fw-bold text-secondary" id="totalBookMarking">{{ $book->totalBookMarking }}</div>
                                                </li>
                                                <li>
                                                    <div class="fs-14px text-muted">Số bình luận</div>
                                                    <div class="fs-16px fw-bold text-secondary" id="totalBookMarking">{{ $book->totalComments }}</div>
                                                </li>
                                            
                                            </ul>
                                        </div>
                                        
                                        <div class="product-meta">
                                            <span class="title">Tác giả:                                          
                                            </span>
                                            <span>{{ $book->author }}</span>                      
    
                                        </div><!-- .product-meta -->
    
                                        <div class="product-meta">
                                            <span class="title">Đánh giá: 
                                            </span>
                                            <span>{{ $book->ratingScore }}/5</span>                      
    
                                        </div><!-- .product-meta -->
    
                                        <div class="product-meta">
                                            <span class="title">Ngôn ngữ:                                
                                            </span>
                                            @if ($book->language === 1)
                                            <span class="text-success fs-14px">Tiếng việt</span>
                                            @else
                                            <span class="text-info fs-14px">Tiếng anh</span>
    
                                            @endif 
                                        </div><!-- .product-meta -->
                                        <div class="product-meta">
                                            <span class="title">Tình trạng:    
                                            </span>
                                            @if ($book->isCompleted === 1)
                                            <span class="text-success fs-14px fw-bold">Đã hoàn thành</span>
                                            @else
                                            <span class="text-info fs-14px fw-bold">Chưa hoàn thành</span>
    
                                            @endif 
                                        </div><!-- .product-meta -->
                                        <div class="product-meta">
                                            <span class="title">Thể loại:
    
                                            </span>
                                            <span class="text-warning fs-14px fw-bold">{{ $book->types->name }}</span>
    
                                        </div><!-- .product-meta -->
    
                                        @if($book->file)
                                        <div class="product-meta">
                                            <h6 class="title">File đính kèm</h6>
                                            <ul class="d-flex flex-wrap ailgn-center g-2 pt-1">                                     
                                                <li class="ms-n1">
                                                    <a href="{{ $book->bookUrl }}" class="btn btn-primary">File</a>
                                                </li>         
                                            </ul>
                                       
                                        </div>
                                        @endif
    
                                        <div class="product-meta">
                                            <span class="title">Ngày thêm: 
                                            </span>
                                            <span>{{ $book->created_at }}</span>                  
                                        </div><!-- .product-meta -->
    
                                        <div class="product-meta">
                                            <span class="title">Lần cập nhật cuối: 
    
                                            </span>
                                            <span>{{ $book->updated_at }}</span>                       
    
                                        </div><!-- .product-meta -->         
                                </div><!-- .product-info -->
                               
                              
                            </div><!-- .col -->
                        </div><!-- .row -->
                        <div class="row g-gs flex-lg-row-reverse">                      
                            <div class="col-lg-12">
                                <div class="product-details entry me-xxl-3">
                                    <hr class="hr">
                                    <h3>Giới thiệu</h3>
                                    {!! clean($book->description ) !!}
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


@endsection