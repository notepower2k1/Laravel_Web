@extends('admin/layouts.app')
@section('pageTitle', 'Chi tiết tài liệu')
@section('content')

<div class="container">
    <div class="nk-block-head-sub"><a class="back-to" href="{{ url()->previous() }}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>

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
                                        <h2 class="product-title">{{ $document->name }}                               
                                        </h2>    
                                      
                                        
                                    <p class="product-title">Tác giả: {{ $document->author }}</p>                                                           
                                    <div class="product-meta">
                                        <ul class="d-flex g-3 gx-5">                                          
                                            <li>
                                                <div class="fs-14px text-muted">Số trang</div>
                                                <div class="fs-16px fw-bold text-secondary">{{ $document->numberOfPages }}</div>
                                            </li>
                                            <li>
                                                <div class="fs-14px text-muted">Định dạng</div>
                                                <div class="fs-16px fw-bold text-secondary">.{{ $document->extension }}</div>
                                            </li>
                                      
                                            
                                        </ul>
                                    </div>
                                    <div class="product-meta">
                                        <h6 class="title">Ngôn ngữ: 
                                            @if ($document->language === 1)
                                            <span class="text-success fs-14px">Tiếng việt</span>
                                            @else
                                            <span class="text-info fs-14px">Tiếng anh</span>

                                            @endif 
                                        </h6>
                                      
                                    </div><!-- .product-meta -->
                                
                                    <div class="product-meta">
                                        <h6 class="title">Thể loại</h6>
                                        <ul class="d-flex flex-wrap ailgn-center g-2 pt-1">                                     
                                            <li class="ms-n1">
                                                <a href="/the-loai/the-loai-tai-lieu/{{$document->types->slug}}" class="btn btn-primary">{{ $document->types->name }}</a>
                                            </li>         
                                        </ul>
                                    </div><!-- .product-meta -->
                                    <div class="product-meta">

                                        <h6 class="title">Flle đính kèm</h6>
                                        <a href="{{ $document->documentUrl }}" class="btn btn-primary">File</a>
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
            </div>
          
        </div>
    </div>
</div>
@endsection
@section('additional-scripts')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>


@endsection