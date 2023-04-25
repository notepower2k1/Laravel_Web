@extends('client/homepage.layouts.app')
@section('additional-style')
<style>
    .item-search:hover{
        background-color:#062788;
    }
 
    </style>
@endsection
@section('content')
<div class="container">
    <div class="nk-block mt-4">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between position-relative">
                <div class="nk-block-head-content">
                        
                    <h3 class="nk-block-title page-title">Tìm kiếm: {{ $total }} kết quả</h3>    
                </div>             
            </div>
        </div>
        <div class="nk-content">
            @if(isset($items))
            @if($items)
                <div class="content">
                    @if($option_id == 0)
                        <div class="row">
                            @foreach ($items as $item)
                                <div class="col-lg-4 col-md-6 mt-4">
                                    <div class="card card-bordered product-card shadow">
                                        <div class="product-thumb">                             
                                                <img class="card-img-top" src="{{ $item->url }}" alt="">    
                                                                        
                                                <div class="product-actions book_sameType w-100 h-100">
                                                    <div class="pricing-body w-100 h-100 text-center">      
                                                        <div class="h-100 d-flex flex-column justify-content-center">
                                                            <div class="pricing-amount">
                                                                <h6 class="bill text-white">{{ $item->name }}</h6>
                                                                <p class="text-white">Tác giả: {{ $item->author }}</p>
                                                                <p class="text-white">Số chương: {{ $item->numberOfChapter }}</p>
                                                                <p class="text-white">Lượt đọc: {{ $item->totalReading }}</p>
                                                            </div>
                                                            <div class="pricing-action">
                                                                <a href="/sach/{{$item->id}}/{{$item->slug}}" class="btn btn-outline-light">Chi tiết</a>
                                                            </div>
                                                        </div>                                      
                                                        
                                                    </div>
                                                </div>
                                        </div>
                                    
                                    </div>
                                </div>                         
                            @endforeach
                        </div>
                    @else
                        <div class="row">
                            @foreach ($items as $item)
                                <div class="col-lg-4 col-md-6 mt-4">
                                    <div class="card card-bordered product-card shadow">
                                        <div class="product-thumb">                             
                                                <img class="card-img-top" src="{{ $item->url }}" alt="">                                                                                    
                                                <div class="product-actions book_sameType  w-100 h-100">
                                                    <div class="pricing-body w-100 h-100 text-center">      
                                                        <div class="h-100 d-flex flex-column justify-content-center">
                                                            <div class="pricing-amount">
                                                                <h6 class="bill text-white">{{ $item->name }}</h6>
                                                                <p class="text-white">Tác giả: {{ $item->author }}</p>
                                                                <p class="text-white">Số trang: {{ $item->numberOfPages }}</p>
                                                                <p class="text-white">Lượt tải: {{ $item->totalDownloading }}</p>
                                                            </div>
                                                            <div class="pricing-action">
                                                                <a href="/tai-lieu/{{$item->id}}/{{$item->slug}}" class="btn btn-outline-light">Chi tiết</a>
                                                            </div>
                                                        </div>                                      
                                                        
                                                    </div>
                                                </div>
                                        </div>
                                    
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="col-md-12 d-flex justify-content-end mt-4">                          
                        {{ $items->links('vendor.pagination.custom',['elements' => $items]) }}
                    </div>
                        
                </div>
            @else
                <strong>Không có kết quả mong muốn !!!</strong>
            @endif
        @endif
        </div>
    </div> 
 
</div>
                               
@endsection

@section('additional-scripts')
@endsection
