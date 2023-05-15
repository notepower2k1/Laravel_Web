@extends('client/homepage.layouts.app')
@section('additional-style')
@if($type_id == 1)
<link rel="stylesheet" href="{{ asset('assets/css/animatedbook.css') }}">
@else
<link rel="stylesheet" href="{{ asset('assets/css/animateddocument.css') }}">
@endif
<link rel="stylesheet" href="{{ asset('assets/css/infohelper.css') }}">
<link href="{{ asset('js/pagination/pagination.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('content')
<div class="container">
    <div class="nk-block mt-4">
        <div class="nk-block-head nk-block-head-sm">
            <div class="">
                <div class="nk-block-head-content">
                    <div class="d-flex">
                        <h3 class="align-end">Tìm kiếm: {{ $total }} kết quả</h3> 
                        <div class="border border-dark p-4 ms-auto">
                            <p class="nk-block-title ff-mono fw-bold">
                
                                @if($type_id == 1)
    
                                    @switch($option)
                                        @case('tac-gia-sach')                     
                                            Tác giả sách: {{ $sub }}
                                            @break
                                    
                                        @case('ngon-ngu-sach')
                                            Ngôn ngữ sách: {{ $sub }}
                                            @break
                    
                                        @case('tinh-trang-sach')
                                            Tình trạng sách: {{ $sub }}
                                            @break
                    
                                        @default    
                                            Không có                                    
                                    @endswitch
                                @else
                                    @switch($option)
                                        @case('tac-gia-tai-lieu')                     
                                            Tác giả tài liệu: {{ $sub }}
                                            @break
                                    
                                        @case('ngon-ngu-tai-lieu')
                                            Ngôn ngữ tài liệu: {{ $sub }}
                                            @break
                    
                                        @case('tinh-trang-tai-lieu')
                                            Tình trạng tài liệu: {{ $sub }}
                                            @break
                    
                                        @default    
                                            Không có                                    
                                    @endswitch
                                @endif
                            </p>
                        </div>
                    </div>
                  
                </div>             
            </div>
        </div>
        <hr>
        <div class="nk-content">
            @if(isset($items))
            @if($items)
                <div class="content">
                    @if($type_id == 1)
                    <ul class="align" id="render-div">
                        @foreach ($items as $book)
            
                        <li>
                            <div class="info mb-2">
                                <dfn data-info="{{ $book->name }}"><em class="icon ni ni-book text-success"></em></dfn>
            
                                <dfn data-info="{{ $book->author }}"><em class="icon ni ni-user text-info"></em></dfn>
                            </div>
                            
            
                            <figure class='book'>    
                                    <ul class='paperback_front'>
                                        
                                        <li>
                                            @if(\Carbon\Carbon::parse($book->created_at)->isToday())
                                            <span class="ribbon">Mới</span>
                                            @endif
            
                                            <img src="{{ $book->url }}" alt="" width="100%" height="100%">
                                        </li>
                                        <li></li>
                                    </ul>
                        
                        
                                    <ul class='ruled_paper'>
                                        <li></li>
                                        <li class="">
                                            <a class="atag_btn"
                                            href="/sach/{{$book->id}}/{{$book->slug}}">{{ Str::limit($book->description,250) }}</a>
                                        </li>
                                        <li></li>
                                        <li></li>
                                        <li></li>
                                    </ul>
                        
                        
                                    <ul class='paperback_back'>
                                        <li></li>
                                        <li></li>
                                    </ul>
                                    {{-- <figcaption>
                                        <h4>{{ $book->name }}</h4>
                                        <span>{{ $book->author }}</span>
                                    </figcaption> --}}
                            </figure>
                        </li>
                        @if($loop->iteration % 3 == 0 || $loop->iteration == $items->count()  )
                        <div class="shelf d-none d-xl-block">
            
                            <div class="bookend_left"></div>
                              <div class="bookend_right"></div>
                              <div class="reflection"></div>
                          
                        </div>
                        @endif
                        @endforeach   
            
                    </ul>
                    @else
                    <ul class="align" id="render-div">
                        @foreach ($items as $document)
                        <li>
                            <div class="info mb-2 d-flex justify-content-start">
                                <dfn data-info="{{ $document->name }}"><em class="icon ni ni-file text-success"></em></dfn>
                
                                <dfn data-info="{{ $document->author }}"><em class="icon ni ni-user text-info"></em></dfn>
                            </div>
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
                                            href="/tai-lieu/{{$document->id}}/{{$document->slug}}">{{ Str::limit($document->description,250) }}</a>
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
                            </figure>
                        </li>
                        @if($loop->iteration % 3 == 0 || $loop->iteration == $items->count()  )
                        <div class="shelf d-none d-xl-block">
            
                            <div class="bookend_left"></div>
                              <div class="bookend_right"></div>
                              <div class="reflection"></div>
                          
                        </div>
                        @endif
                        @endforeach   
                    </ul>
                    @endif

                    <div class="data-container"></div>
                    <div class="col-md-12 d-flex justify-content-end mt-4">                          
                        <div id="pagination"></div>
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
<script src="{{ asset('js/pagination/pagination.min.js') }}" ></script>

<script>
    $(function(){
        bookRender();
    });
    
    function bookRender(){
        const container = $('#pagination');


        if (!container.length) return;
            var sources = function () {
            var result = [];

            $('#render-div').children().each(function(item){

                result.push($(this).get(0).outerHTML);

                console.log($(this).get(0));
            })
        return result;
        }();

        var options = {
            dataSource: sources,
            pageSize: 12,
            callback: function (response, pagination) {
                var dataHtml = '<ul class="align">';

                $.each(response, function (index, item) {
                    dataHtml += item;
                });

                dataHtml += '</ul>';

                container.parent().prev().html(dataHtml);
                $('#render-div').remove();
            }
        };


  
        container.pagination(options);
    }
</script>
@endsection
