@extends('client/layouts.app')
@section('content')
@section('additional-style')

@endsection
<section>
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Sách hay xem nhiều</h3>
            </div><!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            <li class="nk-block-tools-opt">
                                <a href="/sach/all/sach-hay-xem-nhieu" class="btn btn-icon btn-primary d-md-none"><em class="icon ni ni-eye"></em></a>
                                <a href="/sach/all/sach-hay-xem-nhieu" class="btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-eye"></em><span>Xem thêm</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="slider-init" data-slick='{"slidesToShow": 6, "slidesToScroll": 2, "infinite":false, "responsive":[ {"breakpoint": 992,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}} ]}'>
            @foreach ($high_reading_books as $book)

                <div class="col">
                    <div class="card card-bordered product-card">
                        <div class="product-thumb">
                            <a href="/sach/{{$book->id}}/{{$book->slug}}">
                                <img class="card-img-top" src="{{ $book->url }}" alt="" width="400px" height="300px">
                            </a>
                            @if(\Carbon\Carbon::parse($book->created_at)->isToday())
                            <ul class="product-badges">
                                <li><span class="badge bg-success">Mới</span></li>
                            </ul>    
                            @endif         
                        </div>
                        <div class="card-inner text-center">
                            <ul class="product-tags">
                                <li>
                                <div class="rateYo" data-rateyo-read-only="true" data-rateyo-rating='{{ $book->ratingScore }}'></div>
                                </li>
                            </ul>
                            <h5 class="product-title" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $book->name }}"><a href="/sach/{{$book->id}}/{{$book->slug}}"> {{ Str::limit($book->name,12)}}</a></h5>
                            <small class="text-muted fs-13px"><em class="icon ni ni-book-read"></em> {{ $book->numberOfChapter }} Chương</small>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div><!-- .nk-block -->
</section>

<section class="mt-4">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Sách hay nên đọc</h3>
            </div><!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            <li class="nk-block-tools-opt">
                                <a href="/sach/all/sach-hay-nen-doc" class="btn btn-icon btn-primary d-md-none"><em class="icon ni ni-eye"></em></a>
                                <a href="/sach/all/sach-hay-nen-doc" class="btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-eye"></em><span>Xem thêm</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="slider-init" data-slick='{"slidesToShow": 6, "slidesToScroll": 2, "infinite":false, "responsive":[ {"breakpoint": 992,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}} ]}'>
            @foreach ($high_rating_books as $book)

                <div class="col">
                    <div class="card card-bordered product-card">
                        <div class="product-thumb">
                            <a href="/sach/{{$book->id}}/{{$book->slug}}">
                                <img class="card-img-top" src="{{ $book->url }}" alt="" width="400px" height="300px">
                            </a>
                            @if(\Carbon\Carbon::parse($book->created_at)->isToday())
                            <ul class="product-badges">
                                <li><span class="badge bg-success">Mới</span></li>
                            </ul>    
                            @endif          
                        </div>
                        <div class="card-inner text-center">
                            <ul class="product-tags">
                                <li>
                                <div class="rateYo" data-rateyo-read-only="true" data-rateyo-rating='{{ $book->ratingScore }}'></div>
                                </li>
                            </ul>
                            <h5 class="product-title" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $book->name }}"><a href="/sach/{{$book->id}}/{{$book->slug}}"> {{ Str::limit($book->name,10)}}</a></h5>
                            <small class="text-muted fs-13px"><em class="icon ni ni-book-read"></em> {{ $book->numberOfChapter }} Chương</small>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div><!-- .nk-block -->
</section>

<section class="mt-4">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Sách mới cập nhật</h3>
            </div><!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            <li class="nk-block-tools-opt">
                                <a href="/sach/all/sach-moi-cap-nhat" class="btn btn-icon btn-primary d-md-none"><em class="icon ni ni-eye"></em></a>
                                <a href="/sach/all/sach-moi-cap-nhat" class="btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-eye"></em><span>Xem thêm</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="slider-init" data-slick='{"slidesToShow": 6, "slidesToScroll": 2, "infinite":false, "responsive":[ {"breakpoint": 992,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}} ]}'>
            @foreach ($new_books as $book)

                <div class="col">
                    <div class="card card-bordered product-card">
                        <div class="product-thumb">
                            <a href="/sach/{{$book->id}}/{{$book->slug}}">
                                <img class="card-img-top" src="{{ $book->url }}" alt="" width="400px" height="300px">
                            </a>
                            @if(\Carbon\Carbon::parse($book->created_at)->isToday())
                            <ul class="product-badges">
                                <li><span class="badge bg-success">Mới</span></li>
                            </ul>    
                            @endif    
         
                        </div>
                        <div class="card-inner text-center">
                            <ul class="product-tags">
                                <li>
                                <div class="rateYo" data-rateyo-read-only="true" data-rateyo-rating='{{ $book->ratingScore }}'></div>
                                </li>
                            </ul>
                            <h5 class="product-title" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $book->name }}" ><a href="/sach/{{$book->id}}/{{$book->slug}}"> {{ Str::limit($book->name,10)}}</a></h5>
                            <small class="text-muted fs-13px"><em class="icon ni ni-book-read"></em> {{ $book->numberOfChapter }} Chương</small>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div><!-- .nk-block -->
</section>

<section class="mt-4">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Thể loại sách</h3>
            </div><!-- .nk-block-head-content -->
            
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="card card-bordered product-card">
            <div class="p-2">
                    <ul class="preview-list" id="book-type-menu">
                    @foreach ($types as $type)
                    <li class="preview-item">
                        <button class="type-option badge rounded-pill badge-md bg-outline-primary" data-value={{ $type->slug  }} data-id={{ $type->id }} >{{ $type->name }}</button>
                    </li>
                    @endforeach   
                    </ul>
                <span>
            </div>   
        </div>
    </div>
   
</section>
@endsection
@section('additional-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

<script>
    $(function () {
        $(".rateYo").rateYo({   
            starWidth: "20px"
        });
    });
    
    $('.type-option').click(function(){

        var type_slug = $(this).attr('data-value');
        var option = 'the-loai-sach';
        
        $.ajax({
            url:'/the-loai-ket-qua',
            type:"GET",
            data : {
                "type_slug": type_slug,
                "option":option
            },
            })
            .done(function(res) {

                if(res.res.length > 0 ){        
                    window.location.href=`/the-loai/${option}/${type_slug}`;
                }       
                else{
                    Swal.fire({
                        icon: 'error',
                        title: `Thể loại chưa có tài liệu`,
                        showConfirmButton: false,
                        timer: 2500
                    });
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
            })
            
    });

    


</script>
@endsection
