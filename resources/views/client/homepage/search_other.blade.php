@extends('client/homepage.layouts.app')
@section('additional-style')
@if($option_id == 1)
<link rel="stylesheet" href="{{ asset('assets/css/animatedbook.css') }}">
@else
<link rel="stylesheet" href="{{ asset('assets/css/animateddocument.css') }}">
@endif
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
                    @if($option_id == 1)
                    <ul class="align">
                        @foreach ($items as $book)
                
                        <li>
                            <figure class='book'>
            
                                <!-- Front -->
                        
                                    <ul class='paperback_front'>
                                        
                                        <li>
                                            @if(\Carbon\Carbon::parse($book->created_at)->isToday())
                                            <span class="ribbon">Mới</span>
                                            @endif
            
                                            <img src="{{ $book->url }}" alt="" width="100%" height="100%">
                                        </li>
                                        <li></li>
                                    </ul>
                        
                                <!-- Pages -->
                        
                                    <ul class='ruled_paper'>
                                        <li></li>
                                        <li class="">
                                            <a class="atag_btn"
                                            href="/sach/{{$book->id}}/{{$book->slug}}">{{ Str::limit($book->description,150) }}</a>
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
                                        {{-- <p>{{ Str::limit($book->description,200) }}</p> --}}
                                    </figcaption>
                                </figure>
                        </li>
                        @endforeach   
                
                    </ul>
                    @else
                    <ul class="align">
                        @foreach ($items as $document)
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
