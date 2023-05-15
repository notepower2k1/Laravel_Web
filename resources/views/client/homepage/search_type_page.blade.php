@extends('client/homepage.layouts.app')
@section('pageTitle', 'Thể loại')
@section('additional-style')
<link href="{{ asset('js/pagination/pagination.css') }}" rel="stylesheet" type="text/css">

<style>
    .preview-item{
        padding:0.5rem;
    }
    .type-option{
        cursor: pointer;
    }
    .type_books:hover{
        background-color:rgba(34,197,94,0.9);
    }
    .type_documents:hover{
        background-color:rgba(190,18,60,0.9);
    }
    .title-book{
        text-decoration: none;
        color:#33373a;
    }

    .nk-content{
        background-image:url('https://raw.githubusercontent.com/notepower2k1/MyImage/main/banner/main-banner-1.png') !important;
        background-repeat: no-repeat;
        background-position: left top;

    }
    .container{
        margin-top:250px  !important;
    }
    </style>
@endsection
@section('content')
<div class="container">
    <div class="nk-fmg" style="background-color:#ffffff">
        <div class="nk-fmg-aside toggle-screen-lg" data-content="files-aside" data-toggle-overlay="true" data-toggle-body="true" data-toggle-screen="lg" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">
            <div class="nk-fmg-aside-wrap">
                    <ul class="list-unstyled">               
                        <li>
                            <div class="nk-fmg-menu-item type-option-select bg-success" id="type-option-select-book">
                                <em class="icon ni ni-book-read text-white"></em>
                                <span class="nk-fmg-menu-text text-white" style="cursor: pointer">Thể loại sách</span>
                            </div>
                            <ul id="book-type-menu">
                                @foreach ($book_types as $book_type)
                                <li class="type-option" data-value={{ $book_type->slug  }} data-option=1 data-id={{ $book_type->id }} >
                                    <p class="nk-fmg-menu-item">
                                        <span class="nk-fmg-menu-text">{{ $book_type->name }}</span>
                                    </p>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                      
                        <li>
                            <div class="nk-fmg-menu-item type-option-select bg-danger" id="type-option-select-document">
                                <em class="icon ni ni-file-docs text-white"></em>
                                <span class="nk-fmg-menu-text text-white"  style="cursor: pointer">Thể loại tài liệu</span>
                            </div>
                            <ul id="document-type-menu">
                                @foreach ($document_types as $document_type)
                                <li class="type-option" data-value={{ $document_type->slug  }} data-option=2 data-id={{ $document_type->id }} > 
                                    <p class="nk-fmg-menu-item">
                                        <span class="nk-fmg-menu-text">{{ $document_type->name }}</span>
                                    </p>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
              
            </div>
        </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 715px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 620px; display: block; transform: translate3d(0px, 0px, 0px);"></div></div></div><!-- .nk-fmg-aside -->
        <div class="nk-fmg-body">
            <div class="nk-fmg-body-head d-none d-lg-flex">
                <div class="nk-fmg-search">
                    <em class="icon ni ni-search"></em>
                    <input type="text" class="form-control border-transparent form-focus-none" id="search-input"  placeholder="Tên sách bạn muốn tìm kiếm">
                </div>
                
            </div>
            <div class="nk-fmg-body-content">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between position-relative">
                        <div class="nk-block-head-content">
                            
                            <h3 class="nk-block-title page-title" id="search-type-total-h3">Tìm kiếm: {{ $total }} kết quả</h3>    
                        </div>
                        <div class="nk-block-head-content">
                            <ul class="nk-block-tools g-1">         
                                <li class="d-lg-none">
                                    <a href="#" class="btn btn-trigger btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
                                </li>          
                                <li class="d-lg-none me-n1"><a href="#" class="btn btn-trigger btn-icon toggle" data-target="files-aside"><em class="icon ni ni-menu-alt-r"></em></a></li>
                            </ul>
                        </div>  
                        <div class="search-wrap px-2 d-lg-none" data-search="search">
                            <div class="search-content">
                                <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                <input type="text" class="form-control border-transparent form-focus-none" id="search-input-responsive" placeholder="Search by user or message">
                            </div>
                        </div>    
                    </div>
                </div>
                <div class="nk-fmg-quick-list nk-block mt-2" style="min-height:100vh">          
                    <div class="toggle-expand-content expanded" data-content="quick-access">
                        <div class="nk-files nk-files-view-grid">
                            @if($items)
                            <div class="content">
                                @if($option_id == 1)
                                    <div class="row" id="render-div">
                                        @foreach ($items as $book)
                                            <div class="col-lg-6 col-md-6">
                                                <div class="card">
                                                    <div class="d-flex">  
                                                        <div class="flex-grow-1 me-2 shine">
                                                            <img class="card-img-top" src="{{ $book->url }}" alt="" style="width:160px;height:120px">    
                                                        </div>
                                                        <div class="d-flex flex-column">                                 
                                                            <a class="title-book" href="/sach/{{$book->id}}/{{$book->slug}}">{{ Str::limit($book->name,40) }}</a>
                                                            <span class="text-muted fs-13px ">{{ Str::limit($book->description,100) }}</span>
                                                            <div class="d-flex justify-content-between mt-1">
                                                                <span class="text-muted fs-13px"><em class="icon ni ni-user-list"></em><span>{{ Str::limit($book->author,30) }}</span></span>
                                                       
                                                                <span class="fs-13px">
                                                                    <span class="badge badge-dim bg-outline-danger">{{$book->types->name }}</span>      
                                                                </span>
                                                            </div> 
                                                            <span class="text-muted fs-13px ">

                                                                @if($book->file == null)
                                                                <em class="icon ni ni-view-row-wd"></em><span>{{ $book->numberOfChapter }}</span>
                                                                @else
                                                                <em class="icon ni ni-file-pdf"></em><span>PDF</span>

                                                                @endif
                                                            </span>
                                                        </div>                    
                                                          
                                                    </div>
                                                
                                                </div> 
                                                <hr>                                                  
                                            </div>  
                                                              
                                        @endforeach
                                    </div>
                                @else
                                <div class="row" id="render-div">
                                    @foreach ($items as $document)
                                        <div class="col-lg-6 col-md-6">
                                            <div class="card">
                                                <div class="d-flex">  
                                                    <div class="flex-grow-1 me-2 shine">
                                                        <img class="card-img-top border" src="{{ $document->url }}" alt="" style="width:160px;height:120px">    
                                                    </div>
                                                    <div class="d-flex flex-column">                                 
                                                        <a class="title-book" href="/tai-lieu/{{$document->id}}/{{$document->slug}}">{{ Str::limit($document->name,40) }}</a>
                                                        <span class="text-muted fs-13px ">{{ Str::limit($document->description,100) }}</span>
                                                        <div class="d-flex justify-content-between mt-1">
                                                            <span class="text-muted fs-13px"><em class="icon ni ni-user-list"></em><span>{{ Str::limit($document->author,20) }}</span></span>
                                                   
                                                            <span class="fs-13px">
                                                                <span class="badge badge-dim bg-outline-danger">{{$document->types->name }}</span>      
                                                            </span>
                                                        </div> 
                                                        <span class="text-muted fs-13px ">

                                                         
                                                            <em class="icon ni ni-file-pdf"></em><span>{{ $document->numberOfPages }}</span>

                                                        </span>
                                                    </div>                    
                                                      
                                                </div>
                                            
                                            </div> 
                                            <hr>                                                  
                                        </div>  
                                                          
                                    @endforeach
                                </div>
                                @endif
                                
                                @if($items->count() > 0)
                                <div class="data-container"></div>
                                <div class="col-md-12 d-flex justify-content-end mt-4 align-items-end h-100">                          
                                    <div id="pagination"></div>
                                </div>
                                @endif
                            </div>
                            @else
                            <strong>Không có kết quả mong muốn !!!</strong>
                            @endif
                        </div><!-- .nk-files -->
                    </div>
                </div>
               
            </div><!-- .nk-fmg-body-content -->
        </div><!-- .nk-fmg-body -->
    </div>
</div>

@endsection
@section('additional-scripts')
<script src="{{ asset('js/pagination/pagination.min.js') }}" ></script>

<script>
   
  
  

   

    $(document).ready(function() {
        bookRender();

        var option_id = {!! $option_id !!};
        var type_id = {!! $type_id !!};

        $(`*[data-id="${type_id}"][data-option="${option_id}"]`).addClass('active');

        
        if (option_id == 1){
            $('#book-type-menu').show("slow");
            $('#document-type-menu').hide();
        }
        else if (option_id == 2){             
            $('#document-type-menu').show("slow");
            $('#book-type-menu').hide();
        }
       

      
    });


    var typingTimer; 
    var doneTypingInterval = 1000;  

    $('#search-input').on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTypingType, doneTypingInterval);
    });

    //on keydown, clear the countdown 
    $('#search-input').on('keydown', function () {
        clearTimeout(typingTimer);
    });


    function doneTypingType () {
        const inputValue = $('#search-input').val();
        if(inputValue){
            const listTag = $('.data-container').find('.title-book');

        
            listTag.each(function(index){

                const name = $(this).text();

                if(name.toLowerCase().normalize().includes(inputValue.toLowerCase().normalize())){

                    var temp = $(this).parent().parent().parent().parent();

                    const container = $('#pagination');
                    container.parent().prev().empty();
                    container.empty();



                    
                    var sources = function () {
                        var result = [];
                        result.push(temp.get(0).outerHTML);            
                        return result;


                    }();

                    var options = {
                        dataSource: sources,
                        pageSize: 20,
                        callback: function (response, pagination) {
                            var dataHtml = '<div class="row">';

                            $.each(response, function (index, item) {
                                dataHtml += item;
                            });

                            dataHtml += '</div>';

                            container.parent().prev().html(dataHtml);
                        }
                    };


                    const total = sources.length;
                    $('#search-type-total-h3').text(`Tìm kiếm: ${total} kết quả`)
                    container.pagination(options);
                }
                
            })
        }
        else{
            bookRender();
        }
     
    }


    $('#search-input-responsive').on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTypingTypeResponsive, doneTypingInterval);
    });

    //on keydown, clear the countdown 
    $('#search-input-responsive').on('keydown', function () {
        clearTimeout(typingTimer);
    });


    function doneTypingTypeResponsive () {
        const inputValue = $('#search-input-responsive').val();
        if(inputValue){
            const listTag = $('.data-container').find('.title-book');

        
            listTag.each(function(index){

                const name = $(this).text();

                if(name.toLowerCase().normalize().includes(inputValue.toLowerCase().normalize())){

                    var temp = $(this).parent().parent().parent().parent();

                    const container = $('#pagination');
                    container.parent().prev().empty();
                    container.empty();



                    
                    var sources = function () {
                        var result = [];
                        result.push(temp.get(0).outerHTML);            
                        return result;


                    }();

                    var options = {
                        dataSource: sources,
                        pageSize: 20,
                        callback: function (response, pagination) {
                            var dataHtml = '<div class="row">';

                            $.each(response, function (index, item) {
                                dataHtml += item;
                            });

                            dataHtml += '</div>';

                            container.parent().prev().html(dataHtml);
                        }
                    };


                    const total = sources.length;
                    $('#search-type-total-h3').text(`Tìm kiếm: ${total} kết quả`)
                    container.pagination(options);
                }
                
            })
        }
        else{
            bookRender();
        }
     
    }
   

        $(document).on('click','#type-option-select-book',function () {
            $('#book-type-menu').toggle('slow');

        });

        $(document).on('click','#type-option-select-document',function () {
            $('#document-type-menu').toggle('slow');

        });



        $(document).on('click','.type-option',function () {
            const type_slug = $(this).attr('data-value');
            const option_id = $(this).attr('data-option');
            
            var option = '';
            if(option_id == 1){
                option = 'the-loai-sach';
            }
            else{
                option = 'the-loai-tai-lieu';
            }
            window.location.href=`/the-loai/${option}/${type_slug}`;
       

        })

            

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
                pageSize: 20,
                callback: function (response, pagination) {
                    var dataHtml = '<div class="row">';

                    $.each(response, function (index, item) {
                        dataHtml += item;
                    });

                    dataHtml += '</div>';

                    container.parent().prev().html(dataHtml);
                    $('#render-div').hide();
                }
            };


            const total = sources.length;
            $('#search-type-total-h3').text(`Tìm kiếm: ${total} kết quả`)

            container.pagination(options);
        }
</script>
@endsection