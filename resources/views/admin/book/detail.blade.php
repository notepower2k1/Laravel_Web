@extends('admin/layouts.app')
@section('pageTitle', 'Chi tiết sách điện tử')
@section('content')
<div class="container">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            </div><!-- .nk-block-head -->
            <div class="nk-block">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="product-gallery" >    
                                    <img src="{{ $book->url }}" class="w-100" alt="">                                     
                               </div>
                            </div><!-- .col -->
                            <div class="col-lg-6 d-flex align-items-end">
                                <div class="product-info mb-5 me-xxl-5">
                                        <h2 class="product-title">{{ $book->name }}
                                            <button type="button" class="btn btn-icon btn-lg ms-1" data-bs-toggle="modal" data-bs-target="#reportForm">
                                                <em class="icon ni ni-alert" style="color:red"></em>
                                            </button>
                                        </h2>                                        
                                    <p class="product-title">Tác giả: {{ $book->author }}</p>
                                    <div class="product-rating">                                    
                                        <div id="rateYo" data-rateyo-read-only="true"></div>                                     
                                        <div id="score">({{$book->ratingScore}}/5)</div>
                                    </div><!-- .product-rating -->                                   
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
                                            
                                        </ul>
                                    </div>
                                   
                                    <div class="product-meta">
                                        <h6 class="title">Ngôn ngữ: 
                                            @if ($book->language === 1)
                                            <span class="text-success fs-14px">Tiếng việt</span>
                                            @else
                                            <span class="text-info fs-14px">Tiếng anh</span>

                                            @endif 
                                        </h6>
                                      
                                    </div><!-- .product-meta -->
                                    <div class="product-meta">
                                        <h6 class="title">Tình trạng: 

                                            @if ($book->isCompleted === 1)
                                            <span class="text-success fs-14px fw-bold">Đã hoàn thành</span>
                                            @else
                                            <span class="text-info fs-14px fw-bold">Chưa hoàn thành</span>

                                            @endif 
                                        </h6>
                                      
                                    </div><!-- .product-meta -->
                                    <div class="product-meta">
                                        <h6 class="title">Thể loại</h6>
                                        <ul class="d-flex flex-wrap ailgn-center g-2 pt-1">                                     
                                            <li class="ms-n1">
                                                <a href="/the-loai/the-loai-sach/{{$book->types->slug}}" class="btn btn-primary">{{ $book->types->name }}</a>
                                            </li>         
                                        </ul>
                                    </div><!-- .product-meta -->               
                                </div><!-- .product-info -->
                               
                              
                            </div><!-- .col -->
                        </div><!-- .row -->
                        <div class="row g-gs flex-lg-row-reverse">                      
                            <div class="col-lg-12">
                                <div class="product-details entry me-xxl-3">
                                    <hr class="hr">
                                    <h3>Giới thiệu</h3>
                                    <div id="divhtmlContent" >{{ $book->description }}</div>   

                                </div>
                            </div><!-- .col -->
                        </div><!-- .row -->                   
                    </div>
                </div>
            </div>
           
        </div>
    </div>
</div>



@endsection
@section('additional-scripts')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<script>
          $(function () {
        var value = document.getElementById('divhtmlContent').textContent;
        document.getElementById('divhtmlContent').innerHTML =
        marked.parse(value);

        $("#rateYo").rateYo({
            rating: {!! $book->ratingScore !!},
            maxValue: 5,
            numStars: 5,
            halfStar: true,
            starWidth: "20px"

        });
    });
 </script>
@endsection