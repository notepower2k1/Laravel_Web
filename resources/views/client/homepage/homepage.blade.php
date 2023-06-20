@extends('client/homepage.layouts.app')
@section('pageTitle', 'Kho tài liệu điện tử')

@section('additional-style')
<link rel="stylesheet" href="{{ asset('assets/css/book3d-nohover.css') }}">

<style>
    @media (min-width: 1200px){
        .container-xl, .container-lg, .container-md, .container-sm, .container {
            max-width: 1300px;
        }
    }
    .high_reading_books{
        margin-top: 80px;
        
    }
    .high_rating_books:hover{
        cursor: pointer;
    }

    .title-book{
        text-decoration: none;
        color:#33373a;
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

@section('content')

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
        <div class="card card-bordered shadow">
            <div class="card-inner">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h4 class="nk-block-title">Mới đăng</h4>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li class="nk-block-tools-opt">
                                        <a href="/sach/all/moi-dang" class="d-md-none a-more-button">Xem thêm</a>
                                        <a href="/sach/all/moi-dang" class="d-none d-md-inline-flex a-more-button"><span>Xem thêm</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
          

            <div class="nk-block">
                <div class="slider-init" data-slick='{"slidesToShow": 4, "slidesToScroll": 2, "infinite":false, "responsive":[ {"breakpoint": 992,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}} ]}'>
                    @foreach ($new_books as $book)
                        <div class="col">
                            <div class="card card-bordered product-card shadow">
                                <div class="product-thumb shine">
                                  
                                    <img class="card-img-top border" src="{{ $book->url }}" alt="" width="300px" height="350px">
                                   
                                
                                    <ul class="product-badges">
                                        <li><span class="badge bg-success">{{ $book->ratingScore }}/5</span></li>
                                    </ul>    
                                
                                    
                                    <ul class="product-actions d-flex h-100 align-items-center" >
                                        <li >
                                            <a href="#" class="preview-book-btn" data-id ={{ $book->id }} data-option="1">
                                                <em class="icon icon-circle bg-success ni ni-book-read"></em>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-inner text-center">
                                    <ul class="product-tags">
                                        
                                        <li><a href="/tac-gia/tac-gia-sach/{{ $book->author }}">{{ $book->author }}</a></li>
                                    </ul>
                                    <h3 class="product-title fs-13px" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $book->name }}"><a href="/sach/{{$book->id}}/{{$book->slug}}"> {{ Str::limit($book->name,25) }}</a></h3>
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
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title">Mới cập nhật</h4>
                </div><!-- .nk-block-head-content -->
            </div><!-- .nk-block-between -->
        </div><!-- .nk-block-head -->
        <div class="">
            <table class="table table-striped table-hover">
                <tbody>
                    @foreach ($new_updated_books as $book)
                        <tr>
                            <td> <span class="text-muted">{{ $book->types->name }}</span></td>
                            <td> <a class="title-book " href="/sach/{{$book->id}}/{{$book->slug}}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $book->name }}">{{ Str::limit($book->name,30) }}</a></td>
                            <td>
                                @if($book->file)
                                    <span>PDF file</span>
                                @else
                                    @foreach ($book->chapters as $chapter)
                                        @if($loop->last)                                  
                                            @if($chapter->name)
                                            <a class="text-muted" href="/doc-sach/{{ $chapter->books->slug }}/{{ $chapter->slug }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $chapter->code }}:{{ $chapter->name }}">{{$chapter->code}}: {{ Str::limit($chapter->name, 30) }}</a>
                                            @else    
                                            <a class="text-muted" href="/doc-sach/{{ $chapter->books->slug }}/{{ $chapter->slug }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $chapter->code }}">{{$chapter->code}}</a>                                                 
                                            @endif     
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td>
                               <a class="text-muted" href="/tac-gia/tac-gia-sach/{{ $book->author }}">{{ $book->author }}</a> 
                            </td>
                            <td>
                                
                                <span class="text-muted">{{ $book->timeUpdate }}</span> 
                               
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
    </section>

    <section class="mt-4">  
        <div class="row g-gs">                        
            <div class="col-lg-6 col-md-12">
                
                <div class="card card-bordered shadow">
                    <div class="card-inner">
                        <div class="nk-block-between mb-4">
                            <div class="nk-block-head-content">
                                <h4 class="nk-block-title">Đọc nhiều</h4>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu1"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu1">
                                        <ul class="nk-block-tools g-3">
                                            <li class="nk-block-tools-opt">
                                                <a href="/sach/all/doc-nhieu" class="d-md-none a-more-button">Xem thêm</a>
                                                <a href="/sach/all/doc-nhieu" class="d-none d-md-inline-flex a-more-button"><span>Xem thêm</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                        <div class="nk-block">
                            @foreach ($high_reading_books as $book)

                            @if($loop->iteration == 1)
                                <div class="d-flex mb-3">
                                    <div class="me-2">
                                        <em class="icon icon-circle bg-danger-dim ni ni-eye-alt"></em>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex flex-column">
                                            <h5><a class="title-book" href="/sach/{{$book->id}}/{{$book->slug}}">{{ Str::limit($book->name,50) }}</a></h5>
                                            <span class="fs-12px text-muted"><span>{{ $book->totalReading }}</span><em class="icon ni ni-eye-alt"></em></span>
                                            <span class="fs-12px text-muted"><em class="icon ni ni-user-list"></em><span>{{ $book->author }}</span></span>
                                            <span class="fs-12px text-muted"><em class="icon ni ni-book"></em><span>{{ $book->types->name }}</span></span>
                                            <span ><span>{{ Str::limit($book->description,150) }}</span></span>

                                        </div>
                                    </div>
                                    <div class="item-image">
                                        <a 
                                        class="book-container"
                                        href="/sach/{{$book->id}}/{{$book->slug}}"
                                        target="_blank"
                                        rel="noreferrer noopener"
                                        >
                                        <div class="book">
                                            <img
                                            alt=""
                                            src="{{ $book->url }}"
                                            />
                                        </div>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex border-top p-1">
                                    <div class="me-2">
                                        <span>{{ $loop->iteration  }}</span>
                                    </div>
                                    <div class="flex-grow-1 d-flex justify-content-between">
                                        <a class="title-book" href="/sach/{{$book->id}}/{{$book->slug}}">{{ Str::limit($book->name,100) }}</a>
                                        <span>{{ $book->totalReading }}</span>
                                    </div>
                                </div>
                            @endif
                        
                            @endforeach
                        </div>
                    </div>
                    
                </div>
            </div>  
            <div class="col-lg-6 col-md-12">
                <div class="card card-bordered shadow">
                    <div class="card-inner">
                        <div class="nk-block-between mb-4">
                            <div class="nk-block-head-content">
                                <h4 class="nk-block-title">Đánh giá cao</h4>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu1"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu1">
                                        <ul class="nk-block-tools g-3">
                                            <li class="nk-block-tools-opt">
                                                <a href="/sach/all/danh-gia-cao" class="d-md-none a-more-button">Xem thêm</a>
                                                <a href="/sach/all/danh-gia-cao" class="d-none d-md-inline-flex a-more-button"><span>Xem thêm</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                        <div class="nk-block mt-2">

                            @foreach ($high_rating_books as $book)

                            @if($loop->iteration == 1)
                                <div class="d-flex mb-3">
                                    <div class="me-2">
                                        <em class="icon icon-circle bg-warning-dim ni ni-star-fill"></em>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex flex-column">
                                            <h5><a class="title-book" href="/sach/{{$book->id}}/{{$book->slug}}">{{ Str::limit($book->name,35) }}</a></h5>
                                            <span class="fs-12px text-muted"><span>{{ $book->ratingScore }}</span><em class="icon ni ni-star-fill"></em></span>
                                            <span class="fs-12px text-muted"><em class="icon ni ni-user-list"></em><span>{{ $book->author }}</span></span>
                                            <span class="fs-12px text-muted"><em class="icon ni ni-book"></em><span>{{ $book->types->name }}</span></span>
                                            <span ><span>{{ Str::limit($book->description,150) }}</span></span>

                                        </div>
                                    </div>
                                    <div class="item-image">
                                        <a 
                                        class="book-container"
                                        href="/sach/{{$book->id}}/{{$book->slug}}"
                                        target="_blank"
                                        rel="noreferrer noopener"
                                        >
                                        <div class="book">
                                            <img
                                            alt=""
                                            src="{{ $book->url }}"
                                            />
                                        </div>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex border-top p-1">
                                    <div class="me-2">
                                        <span>{{ $loop->iteration  }}</span>
                                    </div>
                                    <div class="flex-grow-1 d-flex justify-content-between">
                                        <a class="title-book" href="/sach/{{$book->id}}/{{$book->slug}}">{{ Str::limit($book->name,100) }}</a>
                                        <span>{{ $book->ratingScore }}</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        </div>
                    </div>
                    
                </div>
            </div>         
        </div>
    </section>
    <section class="mt-4">
        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-lg-4 col-md-12">
                    <div class="card card-bordered shadow" style="background-color:#f7f5f0">                              
                        <div class="card-inner text-center">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Đã hoàn thành</h4>
                                    </div><!-- .nk-block-head-content -->                                 
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="slider-init" data-slick='{"arrows": false, "dots": true, "slidesToShow": 1, "slidesToScroll": 1, "infinite":false, "responsive":[ {"breakpoint": 992,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 2}} ]}'>
                                @foreach ($completed_books as $book)

                                <div class="col">
                                    
                                            <div class="shine">
                                                <img src="{{ $book->url }}" class="card-img-top shine" alt="" style="width:500px;height:400px">

                                            </div>
                                            <div class="info mt-2">
                                                <h5 class="card-title">{{ $book->name }}</h5>
                                                <p class="card-text">{{ Str::limit($book->description,150) }}</p>
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted fs-13px"><em class="icon ni ni-user-list"></em><span>{{ $book->author }}</span></span>
                                                    
                                                    <a href="/the-loai/sort_by=created_at/the-loai-sach/{{$book->types->slug}}" class="fs-13px"><span class="badge badge-dim bg-outline-danger">{{$book->types->name }}</span></a>


                                                </div>
                                                <a href="/sach/{{$book->id}}/{{$book->slug}}" class="btn btn-danger rounded-pill mt-5 px-4 ">Đọc ngay</a>
                                            </div>
                                            
                                        
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-8 col-md-12">
                    <div class="nk-block-head nk-block-head-sm">
                           
                            <div class="nk-block-head-content text-center">
                                <h4 class="nk-block-title">Có thể bạn thích</h4>
                            </div><!-- .nk-block-head-content -->
                        
                    </div><!-- .nk-block-head -->
                    <hr>
                    <div class="row g-gs">
                        @foreach ($random_books as $book)
                        <div class="col-xxl-4 col-lg-6 col-sm-6 high_reading_books">
                            <div class="card card-bordered shadow">
                                <div class="d-flex">
                                    <div class="flex-fill" style="position: relative; width:140px">    
                                        <a href="#" class="preview-book-btn" data-id ={{ $book->id }} data-option="1">
                                            <img class="high-reading-book-images" src="{{ $book->url }}" alt="">                            
                                        </a>                                                     
                                    </div>
                                    <div class="flex-fill">
                                        <div class="p-2 text-center">
                                            <ul class="product-tags">
                                                <li><a href="#">{{ $book->author }}</a></li>
                                            </ul>
                                            <h3 class="product-title fs-13px" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $book->name }}"><a href="/sach/{{$book->id}}/{{$book->slug}}"> {{ Str::limit($book->name,20) }}</a></h3>
                                            <a href="the-loai/sort_by=created_at/the-loai-sach/{{$book->types->slug}}" class="fs-13px"><span class="badge badge-dim bg-outline-danger">{{$book->types->name }}</span></a>
                                        </div>
                                    </div>          
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <p class="text-muted ms-2"><em class="icon ni ni-eye-alt"></em><span>{{ $book->totalReading }}</span></p>
                                    <p class="text-muted me-2"><em class="icon ni ni-star"></em><span>{{ $book->ratingScore }}</span></p>

                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                    
                </div>
                
            </div>   
        </div>
    </section>

</div>
  


<section class="mt-4" id="document-section">
    <div class="container p-5">
        <div class="nk-block-head nk-block-head-sm mb-5">
            <div class="nk-block-between">
                <div class="nk-block-head-content border border-dark p-4">
                    <a href="/tai-lieu/all" class="nk-block-title text-white ff-mono fw-bold">TÀI LIỆU ĐIỆN TỬ</a>
                </div><!-- .nk-block-head-content -->
            </div><!-- .nk-block-between -->
        </div><!-- .nk-block-head -->
        <div class="slider-init" data-slick='{"slidesToShow": 4 , "slidesToScroll": 2, "infinite":false, "responsive":[ {"breakpoint": 992,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}} ]}'>
            @foreach ($documents as $document)
                <div class="col document-card d-flex justify-content-center">
                    <div class="card card-bordered product-card shadow ">
                        <div class="product-thumb shine">
                            <img class="document-card-image" src="{{ $document->url }}" alt="" width="300px" height="350px">
                            
                            <ul class="product-actions d-flex h-100 align-items-center" >
                                <li >
                                    <a href="#" class="preview-book-btn" data-id ={{ $document->id }} data-option="2">
                                        <em class="icon icon-circle bg-success ni ni-book-read"></em>
                                    </a>
                                </li>
                            </ul>
                        </div>  
                                  
                    </div>
                </div>
            @endforeach
        </div>
    </div><!-- .nk-block -->  

</section>

<section class="mt-4">
    <div class="container">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title">Mới đăng</h4>
                </div><!-- .nk-block-head-content -->
            </div><!-- .nk-block-between -->
        </div><!-- .nk-block-head -->
        <div class="">
            <table class="table table-striped table-hover">
                <tbody>
                    @foreach ($new_documents as $document)
                        <tr>
                            <td> <span class="text-muted">{{ $document->types->name }}</span></td>
                            <td> <a class="title-book " href="/tai-lieu/{{$document->id}}/{{$document->slug}}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $document->name }}">{{ Str::limit($document->name,80) }}</a></td>                
                            <td>

                                @foreach(explode(",",$document->author) as $author)
                                    @if($loop->index < 3)                                                                
       
                                        <a class="text-muted" href="/tac-gia/tac-gia-tai-lieu/{{ $author }}">{{ $author }}</a>
                                        @if($loop->index < 2)
                                        <span class="text-muted">,</span>
                                        @endif
                                    @endif
                                @endforeach        

                            </td>
                            <td>                     
                            <span class="text-muted">{{ $document->time }}</span>                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
    </div>
   
</section>

<section class="mt-4">
    <div class="container">
            <div class="card card-bordered shadow">
                <div class="card-inner">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h5 class="nk-block-title">Lượt tải cao</h5>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu3"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu3">
                                        <ul class="nk-block-tools g-3">
                                            <li class="nk-block-tools-opt">
                                                <a href="/tai-lieu/all/luot-tai-cao" class="d-md-none a-more-button">Xem thêm</a>
                                                <a href="/tai-lieu/all/luot-tai-cao" class="d-none d-md-inline-flex a-more-button"><span>Xem thêm</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    
                
                    <div class="nk-block">
                        <div class="slider-init" data-slick='{"slidesToShow": 4, "slidesToScroll": 2, "infinite":false, "responsive":[ {"breakpoint": 992,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}} ]}'>
                            @foreach ($high_downloading_documents as $document)
                                <div class="col" >
                                    <div class="card card-bordered product-card shadow">
                                        <div class="product-thumb shine">
                                            
                                            <img class="card-img-top border" src="{{ $document->url }}" alt="" width="300px" height="350px">
                                            
                                            <ul class="product-actions d-flex h-100 align-items-center" >
                                                <li >
                                                    <a href="#" class="preview-book-btn" data-id ={{ $document->id }} data-option="2">
                                                        <em class="icon icon-circle bg-success ni ni-book-read"></em>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-inner text-center">
                                            <ul class="product-tags">

                                                <li  data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $document->author }}">
                                                    @foreach(explode(",",$document->author) as $author)
                                                    @if($loop->iteration == 1)                                                                
                    
                                                    <a href="/tac-gia/tac-gia-tai-lieu/{{ $author }}">{{ $author }}</a>
                                                    @else
                                                    <span>,...</span>
                                                    @endif
                                                    @endforeach
                                                </li>        
                                            </ul>

                                            <h3 class="product-title fs-13px" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $document->name }}"><a href="/tai-lieu/{{$document->id}}/{{$document->slug}}"> {{ Str::limit($document->name,25) }}</a></h3>
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

@section('modal')
<div class="modal fade" id="previewItemModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-left">
            
                
            </div>
        </div>
    </div>
</div>
@endsection
@section('additional-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

<script>    
   


   

    $('.preview-book-btn').on('click', function(e) {
        e.preventDefault();
        const item_id = $(this).data('id');
        const option = $(this).data('option');

        $.ajax({
                url:'/preview-item',
                type:"GET",
                data:{
                    'option': option,
                    'item_id':item_id,
                }
            })
            .done(function(res) {  

                const item = res.item;

                if (item){

                    $('#previewItemModal').find('.modal-body').empty().append(item);

                    $('#previewItemModal').modal('show');
                }

            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
            })
    })

    


</script>
@endsection
