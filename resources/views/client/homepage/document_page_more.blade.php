@extends('client/homepage.layouts.app')
@section('pageTitle', 'Danh sách')
@section('additional-style')
<link rel="stylesheet" href="{{ asset('assets/css/animateddocument.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/infohelper.css') }}">
<link href="{{ asset('js/pagination/pagination.css') }}" rel="stylesheet" type="text/css">

@endsection
@section('content')
      
    <div class="container">

        <div class="d-flex">
            <h3 class="align-end">{{ $title }}</h3>
            <div class="border border-dark p-4 ms-auto">
                <p class="nk-block-title ff-mono fw-bold">
    
                    @switch($option)
                        @case('luot-tai-cao')                     
                            Danh sách các tài liệu có tổng lượt tải cao
                            @break
                        @case('moi-dang')
                            Danh sách các tài liệu vừa được đăng gần đây
                            @break
                        @default    
                            Danh sách toàn bộ các tài liệu đang có
                        
                    @endswitch
                </p>
            </div>
        </div>
        <hr>
        <div class="nk-block">
           

            <ul class="align" id="render-div">
                @foreach ($documents as $document)
                <li class="item-book">
                    <div class="d-sm-none d-md-block">
                        <div class="info mb-2 d-flex justify-content-start">
                            <dfn data-info="Đăng tải bởi {{ $document->users->name }}"><em class="icon ni ni-user text-success"></em></dfn>
                      

                            @if($document->language == 1)
                            <dfn data-info="Tiếng Việt"><em class="icon ni ni-globe text-info"></em></dfn>
                            @else
                            <dfn data-info="Tiếng Anh"><em class="icon ni ni-globe text-info"></em></dfn>
                            @endif                      
                        </div>
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
                                    href="/tai-lieu/{{$document->id}}/{{$document->slug}}">{{ Str::limit($document->description,200) }}</a>
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
                            <figcaption>
                                <h5><a style="text-decoration:none" class="text-gray" href="/tai-lieu/{{$document->id}}/{{$document->slug}}">{{ Str::limit($document->name,50) }}</a></h5>
                                @foreach(explode(",",$document->author) as $author)        
                                    @if($loop->index < 3)                                                                
                                                        
                                        <a class="text-info" href="/tac-gia/tac-gia-tai-lieu/{{ $author }}">{{ $author }}</a>
                                        @if($loop->index < 2)
                                            ,
                                        @endif
                                    
                                    @endif
                                @endforeach      
                                <ul class="link-list-opt no-bdr">
                                    <li>                                  
                                        <span class="sub-text">Số trang {{ $document->numberOfPages }}</span> 
                                    </li>
                                    <li>
                                        @if ($document->isCompleted === 1)
                                            <span class="sub-text text-success">Đã hoàn thành</a></span>
                                        @else
                                            <span class="sub-text text-warning">Chưa hoàn thành</a></span>
                                        @endif 
                                    </li>                         
                                </ul>
                                <a href="/the-loai/sort_by=created_at/the-loai-tai-lieu/{{$document->types->slug}}"><span class="badge badge-dim bg-outline-danger fs-13px">{{ $document->types->name }}</span>
                                </a>                                 
                            </figcaption>
                            <ul class='book_spine'>
                                <li></li>
                                <li></li>
                            </ul>                          
                    </figure>
                </li>

                @if($loop->iteration % 2 == 0 || $loop->iteration == $documents->count()  )
                <div class="shelf d-none d-xl-block">
    
                    <div class="bookend_left"></div>
                      <div class="bookend_right"></div>
                      <div class="reflection"></div>
                  
                </div>
                @endif
                @endforeach   
            </ul>
            
            <div class="data-container"></div>
            <div class="col-md-12 d-flex justify-content-end mt-4">                          
                <div id="pagination"></div>
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

            })
        return result;
        }();

        var options = {
            dataSource: sources,
            pageSize: 18,
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