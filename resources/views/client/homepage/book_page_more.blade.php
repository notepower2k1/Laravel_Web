@extends('client/homepage.layouts.app')
@section('pageTitle', `${{$title}}`)
@section('additional-style')
<link rel="stylesheet" href="{{ asset('assets/css/animatedbook.css') }}">

{{-- <style>
 
    .high_reading_books{
        margin-top: 80px;
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
   
</style> --}}

@endsection

@section('content')

{{-- <div class="container">
    <div class="nk-block">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h5 class="nk-block-title">{{ $title }}</h5>
                </div><!-- .nk-block-head-content -->
               
            </div><!-- .nk-block-between -->
        </div><!-- .nk-block-head -->
        <div class="row g-gs">
            @foreach ($books as $book)
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
       
      
      
    <div class="col-md-12 mt-4 d-flex justify-content-end">                          
    
        {{ $books->links('vendor.pagination.custom',['elements' => $books]) }}
    </div>
</div> --}}

<div class="container">

    <h2>{{ $title }}</h2>
    <div class="nk-block">
        <ul class="align">
            @foreach ($books as $book)
    
            <li>
                <figure class='book'>

                    <!-- Front -->
            
                        <ul class='paperback_front'>
                            
                            <li>
                                <span class="ribbon">{{ $book->ratingScore }}/5</span>

                                <img src="{{ $book->url }}" alt="" width="100%" height="100%">
                            </li>
                            <li></li>
                        </ul>
            
                    <!-- Pages -->
            
                        <ul class='ruled_paper'>
                            <li></li>
                            <li class="d-flex align-items-start  justify-content-center">
                                <a class="atag_btn"
                                href="/sach/{{$book->id}}/{{$book->slug}}">Chi tiết</a>
                            </li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
            
                    <!-- Back -->
            
                        <ul class='paperback_back'>
                            <li></li>
                            <li></li>
                        </ul>
                        <figcaption>
                            <h4>{{ $book->name }}</h4>
                            <span>{{ $book->author }}</span>
                            <p>{{ Str::limit($book->description,200) }}</p>
                        </figcaption>
                    </figure>
            </li>
            @endforeach   
    
        </ul>
        <div class="col-md-12 d-flex justify-content-end">                          

            {{ $books->links('vendor.pagination.custom',['elements' => $books]) }}
        </div>
    </div>
</div>
@endsection
