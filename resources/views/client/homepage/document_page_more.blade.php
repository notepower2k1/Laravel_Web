@extends('client/homepage.layouts.app')
@section('additional-style')
<link rel="stylesheet" href="{{ asset('assets/css/animateddocument.css') }}">

<style>
 
    
</style>
@endsection
@section('content')

{{--       
    <div class="container">
        <div class="nk-block">
            <div class="row">
                @foreach ($documents as $document)
                <div class="col-lg-3 col-md-6 mt-3">
                    <div class="card card-bordered product-card shadow">
                        <div class="product-thumb">                             
                                <img class="card-img-top" src="{{ $document->url }}" alt="" width="300px" height="400px">    
                                                         
                                <div class="product-actions high_downloading_documents w-100 h-100">
                                    <div class="pricing-body w-100 h-100  d-flex text-center align-items-center">      
                                        <div class="row">
                                            <div class="pricing-amount">
                                                <h6 class="bill text-white">{{ $document->name }}</h6>
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
        </div>

    <div class="col-md-12 d-flex justify-content-end">                          

        {{ $documents->links('vendor.pagination.custom',['elements' => $documents]) }}
    </div>
    </div> --}}
      
    <div class="container">

        <h2>{{ $title }}</h2>
        <div class="nk-block">
           

				<ul class="align">
                    @foreach ($documents as $document)
                    <li>
                        <figure class='book'>
        
                            <!-- Front -->
            
                                <ul class='hardcover_front'>
                                    <li>
                                        @if(\Carbon\Carbon::parse($document->created_at)->isToday())
                                        <span class="ribbon">Mới</span>
                                        @endif
                                        <img src="{{ $document->url }}" alt="" width="100%" height="100%">
                                    </li>
                                    <li></li>
                                </ul>
            
                            <!-- Pages -->
            
                                <ul class='page'>
                                    <li></li>
                                    <li class="d-flex align-items-start justify-content-center">
                                        <a class="atag_btn"
                                        href="/tai-lieu/{{$document->id}}/{{$document->slug}}">{{ Str::limit($document->description,150) }}</a>
                                    </li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ul>
            
                            <!-- Back -->
            
                                <ul class='hardcover_back'>
                                    <li></li>
                                    <li></li>
                                </ul>
                                <ul class='book_spine'>
                                    <li></li>
                                    <li></li>
                                </ul>
                                <figcaption>
                                    <h4>{{ $document->name }}</h4>
                                    <span>{{ $document->author }}</span>
                                    {{-- <p>{{ Str::limit($document->description,200) }}</p> --}}
                                </figcaption>
                        </figure>
                    </li>
                    @endforeach   
                </ul>
               
        
            
            <div class="col-md-12 d-flex justify-content-end">                          

                {{ $documents->links('vendor.pagination.custom',['elements' => $documents]) }}
            </div>
        </div>
    </div>
   
@endsection
