@extends('client/homepage.layouts.app')
@section('pageTitle', `${{$title}}`)
@section('additional-style')
<link rel="stylesheet" href="{{ asset('assets/css/animatedbook.css') }}">
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
                    @case('danh-gia-cao')                     
                        Danh sách các sách có điểm đánh giá cao
                        @break
                
                    @case('doc-nhieu')
                        Danh sách các sách có tổng lượt đọc cao

                        @break

                    @case('moi-dang')
                        Danh sách các sách vừa được đăng gần đây
                        @break

                    @default    
                        Danh sách toàn bộ các sách đang có
                    
                @endswitch
            </p>
        </div>
    </div>
    <hr>
    <div class="nk-block">
        <ul class="align" id="render-div">
            @foreach ($books as $book)

          
            <li class="item-book">
                <div class="d-sm-none d-md-block">
                    <div class="info mb-2 d-flex justify-content-start">
                        <dfn data-info="{{ $book->types->name }}"><em class="icon ni ni-book text-success"></em></dfn>
                      

                        @if($book->language == 1)
                        <dfn data-info="Tiếng Việt"><em class="icon ni ni-globe text-info"></em></dfn>
                        @else
                        <dfn data-info="Tiếng Anh"><em class="icon ni ni-globe text-info"></em></dfn>
                        @endif
                    </div>
                </div>
                <figure class='book'>    
                        <ul class='paperback_front'>
                            
                            <li>

                                @switch($option)
                                    @case('danh-gia-cao')
                                        <span class="ribbon">
                                            <span class="fs-9px">
                                                {{ $book->ratingScore }}
                                                <em class="icon ni ni-star-fill"></em>
                                            </span>
                                        </span>

                                        @break
                                
                                    @case('doc-nhieu')
                                        <span class="ribbon">
                                            <span class="fs-9px">
                                                {{ $book->totalReading }}
                                                <em class="icon ni ni-eye-fill"></em>
                                            </span>
                                  

                                        </span>

                                        @break

                                    @case('moi-dang')
                                        <span class="ribbon">{{ $book->time }}</span>

                                        @break

                                    @default
                                    
                                    @if(\Carbon\Carbon::parse($book->created_at)->isToday())
                                        <span class="ribbon">Mới</span>
                                    @endif
                                @endswitch

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
                        <figcaption>
                            <h4>{{ $book->name }}</h4>
                            @foreach(explode(",",$book->author) as $author)                                                                       
                                <a class="text-info" href="/tac-gia/tac-gia-sach/{{ $author }}">{{ $author }}</a>
                                @if($loop->index < count(explode(",",$book->author)) - 1)
                                    ,
                                @endif
                        @endforeach       
                         
                        </figcaption>
                </figure>

           

            </li>
            
            @if($loop->iteration % 2 == 0 || $loop->iteration == $books->count()  )
                <div class="shelf d-none d-xl-block">

                    <div class="bookend_left"></div>
                    <div class="bookend_right"></div>
                    <div class="reflection"></div>
                
                </div>
            @endif
            @endforeach   

        </ul>
        

        <div class="data-container" style=""></div>
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