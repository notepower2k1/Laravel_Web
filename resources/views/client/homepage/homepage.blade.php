@extends('client/homepage.layouts.app')
@section('content')
@section('additional-style')
<style>
    
    .high_reading_books{
        margin-top: 80px;
        
    }
    .high_rating_books:hover{
        cursor: pointer;
    }
    .new_books:hover{
        cursor: pointer;

    }


   
    .high-reading-book-images{
        max-width: none !important;
        position: absolute;
        top: -50px;
        left:20px;
        width:120px;
        height:176px;
        box-shadow: rgba(0, 0, 0, 0.09) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
                }
    .high-reading-book-images:hover{
        animation: taadaa 2s;

    }
    @keyframes taadaa { 
        0% {
            opacity: 0.6;
        }

        100% {
            opacity: 1;
        }
    }
    .document-card-image{
        border: 5px solid black;
    }

    #document-section{
        background-image: url('https://ebook.waka.vn/themes/desktop/reactjs/images/bg/bg-box-comic.jpg');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;

    }
    .high_downloading_documents:hover{
        background-color:#062788;
    }
</style>
@endsection

<div class="container">

    <div id="carouselExFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/carousel/carousel1.jpg" class="d-block w-100" style="height: 400px" alt="carousel">
            </div>
            <div class="carousel-item">
                <img src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/carousel/carousel2.jpg" class="d-block w-100" style="height: 400px" alt="carousel">
            </div>
            <div class="carousel-item">
                <img src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/carousel/carousel3.jpg" class="d-block w-100" style="height: 400px" alt="carousel">
            </div>
            <div class="carousel-item">
                <img src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/carousel/carousel4.jpg" class="d-block w-100" style="height: 400px" alt="carousel">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExFade" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExFade" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </a>
    </div> 
    <div class="mt-4">
        <img alt="đọc gì hôm nay" src="https://ebook.waka.vn/themes/desktop/reactjs//images/bannerButton.jpg" class="img-fluid"> 
    </div>
    <section class="mt-4">
        <div class="card card-bordered">
            <div class="card-inner">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h5 class="nk-block-title">Sách hay nên đọc</h5>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        <li class="nk-block-tools-opt">
                                            <a href="/sach/all/sach-hay-nen-doc" class="d-md-none">Xem thêm</a>
                                            <a href="/sach/all/sach-hay-nen-doc" class="d-none d-md-inline-flex"><span>Xem thêm</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <hr>
            
                <div class="nk-block">
                    <div class="slider-init" data-slick='{"slidesToShow": 4, "slidesToScroll": 2, "infinite":false, "responsive":[ {"breakpoint": 992,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}} ]}'>
                        @foreach ($high_rating_books as $book)
                            <div class="col high_rating_books" >
                                <div class="card card-bordered product-card shadow">
                                    <div class="product-thumb shine">
                                        <a href="/sach/{{$book->id}}/{{$book->slug}}">
                                            <img class="card-img-top" src="{{ $book->url }}" alt="" width="300px" height="350px">
                                        </a>
                                    
                                        <ul class="product-badges">
                                            <li><span class="badge bg-success">{{ $book->ratingScore }}/5</span></li>
                                        </ul>    
                                    
                                        
                                        <ul class="product-actions d-flex h-100 align-items-center" >
                                            <li ><a href="/sach/{{$book->id}}/{{$book->slug}}" >
                                                <em class="icon icon-circle bg-success ni ni-book-read"></em>
                                            </a></li>
                                        </ul>
                                    </div>
                                    <div class="card-inner text-center">
                                        <ul class="product-tags">
                                            <li><a href="#">{{ $book->author }}</a></li>
                                        </ul>
                                        <h3 class="product-title fs-13px" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $book->name }}"><a href="/sach/{{$book->id}}/{{$book->slug}}"> {{ Str::limit($book->name,25) }}</a></h3>
                                        <small class="text-muted fs-13px"><em class="icon ni ni-book-read"></em> {{ $book->numberOfChapter }} Chương</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
            
            
                    </div>
                </div><!-- .nk-block -->  
            </div>    
        </div>
    
    </section>

    <section class="mt-4">
       
        <div class="card card-bordered" style="background-color:#8bd0de">
            
            <div class="card-inner">
                <div class="nk-block-between mb-2">
                    <div class="nk-block-head-content">
                        <h5 class="nk-block-title">Sách mới cập nhật</h5>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu1"><em class="icon ni ni-more-v"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu1">
                                <ul class="nk-block-tools g-3">
                                    <li class="nk-block-tools-opt">
                                        <a href="/sach/all/sach-moi-cap-nhat" class="d-md-none">Xem thêm</a>
                                        <a href="/sach/all/sach-moi-cap-nhat" class="d-none d-md-inline-flex"><span>Xem thêm</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->

                <div class="nk-block">
                    <div class="row g-gs">
                        <div class="col-2">
                           <a href="/sach/{{ $new_books->first()->id }}/{{ $new_books->first()->slug }}"><img src="{{ $new_books->first()->url }}" alt="image"></a>              
                        </div>
                        <div class="col-10">
                            <div class="slider-init" data-slick='{"arrows": false, "dots": true, "slidesToShow": 3, "slidesToScroll": 3, "infinite":false, "responsive":[ {"breakpoint": 992,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}} ]}'>
                                
                                @foreach ($new_books as $book)
    
                                <div class="col new_books" data-id="{{ $book->id }}" data-slug="{{ $book->slug }}">
                                    <div class="card card-bordered ">
                                        <div class="card-inner">
                                            <div class="row">
                                                <div class="col-5 text-white text-center p-2" style="background-color:#8bd0de">
                                                    <p class="fw-bold">{{ Str::title(\Carbon\Carbon::parse($book->created_at)->locale('vi')->translatedFormat('l') ) }}</p>
                                                    <p class="fw-bold">Ngày {{ \Carbon\Carbon::parse($book->created_at)->locale('vi')->translatedFormat('d M') }}</p>
                                                </div>
                                                <div class="col-7 text-center">
                                                    <p class="card-text">{{ $book->name }}</p>
    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            
                            </div>
                        </div>
                    
                    </div>
                </div>
               
            
            </div>
        </div>  
        
    </section>
    <section class="mt-4">
        <div class="nk-block">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h5 class="nk-block-title">Sách hay xem nhiều</h5>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu2"><em class="icon ni ni-more-v"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu2">
                                <ul class="nk-block-tools g-3">
                                    <li class="nk-block-tools-opt">
                                        <a href="/sach/all/sach-hay-xem-nhieu" class="d-md-none">Xem thêm</a>
                                        <a href="/sach/all/sach-hay-xem-nhieu" class="d-none d-md-inline-flex"><span>Xem thêm</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class="row g-gs">
                @foreach ($high_reading_books as $book)

                    <div class="col-xxl-3 col-lg-4 col-sm-6 high_reading_books">
                        <div class="card card-bordered shadow">
                            <div class="d-flex">
                                <div class="flex-fill" style="position: relative; width:140px">    
                                    <a href="/sach/{{$book->id}}/{{$book->slug}}">
                                        <img class="high-reading-book-images" src="{{ $book->url }}" alt="">                            
                                    </a>                                                     
                                </div>
                                <div class="flex-fill">
                                    <div class="p-2 text-center">
                                        <ul class="product-tags">
                                            <li><a href="#">{{ $book->author }}</a></li>
                                        </ul>
                                        <h3 class="product-title fs-13px" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $book->name }}"><a href="/sach/{{$book->id}}/{{$book->slug}}"> {{ Str::limit($book->name,20) }}</a></h3>
                                        <small class="text-muted fs-13px"><em class="icon ni ni-book-read"></em> {{ $book->numberOfChapter }} Chương</small>
                                    </div>
                                </div>          
                            </div>
                            <hr>
                            <p class="text-muted ms-2">{{ $book->totalReading }} Lượt xem</p>
                        </div>
                    </div>
                @endforeach
            </div>   
        </div>
    </section>
</div>


    <section class="mt-4" id="document-section">
        <div class="container p-5">
            <div class="nk-block-head nk-block-head-sm mb-5">
                <div class="nk-block-between">
                    <div class="nk-block-head-content border border-dark p-4">
                        <a href="/tai-lieu/all" class="nk-block-title text-white ff-mono fw-bold">Tài liệu tham khảo</a>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class="slider-init" data-slick='{"slidesToShow": 4 , "slidesToScroll": 2, "infinite":false, "responsive":[ {"breakpoint": 992,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}} ]}'>
                @foreach ($documents as $document)
                    <div class="col document-card d-flex justify-content-center">
                        <div class="card card-bordered product-card shadow ">
                            <div class="product-thumb shine">
                                <a href="/tai-lieu/{{$document->id}}/{{$document->slug}}">
                                    <img class=" document-card-image" src="{{ $document->url }}" alt="" width="300px" height="350px">
                                </a>                       
                            </div>            
                        </div>
                    </div>
                @endforeach
            </div>
        </div><!-- .nk-block -->  

    </section>

    <section class="mt-4">
        <div class="container">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="nk-block-head nk-block-head-sm">
                            <div class="nk-block-between">
                                <div class="nk-block-head-content">
                                    <h5 class="nk-block-title">Tài liệu hay</h5>
                                </div><!-- .nk-block-head-content -->
                                <div class="nk-block-head-content">
                                    <div class="toggle-wrap nk-block-tools-toggle">
                                        <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu3"><em class="icon ni ni-more-v"></em></a>
                                        <div class="toggle-expand-content" data-content="pageMenu3">
                                            <ul class="nk-block-tools g-3">
                                                <li class="nk-block-tools-opt">
                                                    <a href="/tai-lieu/all/tai-lieu-hay-nhat" class="d-md-none">Xem thêm</a>
                                                    <a href="/tai-lieu/all/tai-lieu-hay-nhat" class="d-none d-md-inline-flex"><span>Xem thêm</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head-content -->
                            </div><!-- .nk-block-between -->
                        </div><!-- .nk-block-head -->
                        <hr>
                    
                        <div class="nk-block">
                            <div class="slider-init" data-slick='{"slidesToShow": 4, "slidesToScroll": 2, "infinite":false, "responsive":[ {"breakpoint": 992,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}} ]}'>
                                @foreach ($high_downloading_documents as $document)


                                    <div class="col" >
                                        <div class="card card-bordered product-card shadow">
                                            <div class="product-thumb">                                  
                                                <img class="card-img-top" src="{{ $document->url }}" alt=""  width="300px" height="350px">          
                                                <div class="product-actions high_downloading_documents h-100 w-100">
                                                    <div class="pricing-body text-center w-100 h-100">   
                                                        <div class="h-100 d-flex flex-column justify-content-center">
                                                            <div class="pricing-amount">
                                                                <h6 class="text-white">{{ $document->name }}</h6>
                                                                <p class="text-white">Tác giả: {{ $document->author }}</p>
                                                                <p class="text-white">Số trang: {{ $document->numberOfPages }}</p>
                                                                <p class="text-white">Lượt tải: {{ $document->totalDownloading }}</p>
                                                            </div>
                                                            <div class="pricing-action">
                                                                <a href="/tai-lieu/{{$document->id}}/{{$document->slug}}" class="btn btn-outline-light">Chi tiết</a>
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
        </div>
    </section>

   
@endsection
@section('additional-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

<script>    
   
   function Pointer(threshold = 10) {
        let x = 0;
        let y = 0;

        return {
            start(e) {
            x = e.clientX;
            y = e.clientY;
            },

            isClick(e) {
            const deltaX = Math.abs(e.clientX - x);
            const deltaY = Math.abs(e.clientY - y);
            return deltaX < threshold && deltaY < threshold;
            }
        }
    }
    const pointer = new Pointer();

    $('.new_books').on('mousedown', (e) => pointer.start(e))
    $(document).on('mouseup','.new_books',function(e){
    const id = $(this).data('id');
    const slug = $(this).data('slug'); 

   
    const operation = pointer.isClick(e) 
        ?window.location.href =  `/sach/${id}/${slug}`
        :"";
            
        
    })
   

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
