@if(Auth::check())

    @if($listUserNotReadBookByRating->count() > 0)
    <section class="mt-4">
        <div class="card card-bordered">
            <div class="card-inner">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h5 class="nk-block-title">Có thể bạn sẽ thích</h5>
                        </div><!-- .nk-block-head-content -->
                
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <hr>
            
                <div class="nk-block">
                    <div class="slider-init" data-slick='{"slidesToShow": 4, "slidesToScroll": 2, "infinite":false, "responsive":[ {"breakpoint": 992,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}} ]}'>
                        @foreach ($listUserNotReadBookByRating as $book)
                            <div class="col high_rating_books" >
                                <div class="card card-bordered product-card shadow">
                                    <div class="product-thumb">                             
                                        <img class="card-img-top" src="{{ $book->url }}" alt="" width="300px" height="400px">    
                                                                
                                        <div class="product-actions book_sameType w-100 h-100">
                                            <div class="pricing-body w-100 h-100  d-flex text-center align-items-center">      
                                                <div class="row">
                                                    <div class="pricing-amount">
                                                        <h6 class="bill text-white">{{ $book->name }}</h6>
                                                        <p class="text-white">Tác giả: {{ $book->author }}</p>
                                                        <p class="text-white">Số chương: {{ $book->numberOfChapter }}</p>
                                                        <p class="text-white">Lượt đọc: {{ $book->totalReading }}</p>
                                                    </div>
                                                    <div class="pricing-action">
                                                        <a href="/sach/{{$book->id}}/{{$book->slug}}" class="btn btn-outline-light">Chi tiết</a>
                                                    </div>
                                                </div>                                      
                                                
                                            </div>
                                        </div>
                                    </div>                                 
                                </div>
                            </div>
                        @endforeach
            
            
                    </div>
                </div><!-- .nk-block -->  
            </div>    
        </div>

    </section>
    @endif

    @if($listUserNotReadBookByTypeRank->count() > 0)
    <section class="mt-4">
        <div class="card card-bordered">
            <div class="card-inner">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h5 class="nk-block-title">Sách cùng thể loại bạn hay đọc</h5>
                        </div><!-- .nk-block-head-content -->
                
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <hr>
            
                <div class="nk-block">
                    <div class="slider-init" data-slick='{"slidesToShow": 4, "slidesToScroll": 2, "infinite":false, "responsive":[ {"breakpoint": 992,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}} ]}'>
                        @foreach ($listUserNotReadBookByTypeRank as $book)
                            <div class="col high_rating_books" >
                                <div class="card card-bordered product-card shadow">
                                    <div class="product-thumb">                             
                                        <img class="card-img-top" src="{{ $book->url }}" alt="" width="300px" height="400px">    
                                                                
                                        <div class="product-actions book_sameType w-100 h-100">
                                            <div class="pricing-body w-100 h-100  d-flex text-center align-items-center">      
                                                <div class="row">
                                                    <div class="pricing-amount">
                                                        <h6 class="bill text-white">{{ $book->name }}</h6>
                                                        <p class="text-white">Tác giả: {{ $book->author }}</p>
                                                        <p class="text-white">Số chương: {{ $book->numberOfChapter }}</p>
                                                        <p class="text-white">Lượt đọc: {{ $book->totalReading }}</p>
                                                    </div>
                                                    <div class="pricing-action">
                                                        <a href="/sach/{{$book->id}}/{{$book->slug}}" class="btn btn-outline-light">Chi tiết</a>
                                                    </div>
                                                </div>                                      
                                                
                                            </div>
                                        </div>
                                    </div>                                 
                                </div>
                            </div>
                        @endforeach
            
            
                    </div>
                </div><!-- .nk-block -->  
            </div>    
        </div>

    </section>
    @endif

@endif