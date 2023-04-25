@extends('client/homepage.layouts.app')
@section('pageTitle', 'Thể loại')
@section('additional-style')
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
    </style>
@endsection
@section('content')
<div class="container">
    <div class="nk-fmg">
        <div class="nk-fmg-aside toggle-screen-lg" data-content="files-aside" data-toggle-overlay="true" data-toggle-body="true" data-toggle-screen="lg" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">
            <div class="nk-fmg-aside-wrap">
                    <ul class="list-unstyled">               
                        <li>
                            <div class="nk-fmg-menu-item type-option-select bg-success" id="type-option-select-book">
                                <em class="icon ni ni-book-read text-white"></em>
                                <span class="nk-fmg-menu-text text-white">Thể loại sách</span>
                            </div>
                            <ul id="book-type-menu">
                                @foreach ($book_types as $book_type)
                                <li class="type-option" data-value={{ $book_type->slug  }} data-option=0 data-id={{ $book_type->id }} >
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
                                <span class="nk-fmg-menu-text text-white">Thể loại tài liệu</span>
                            </div>
                            <ul id="document-type-menu">
                                @foreach ($document_types as $document_type)
                                <li class="type-option" data-value={{ $document_type->slug  }} data-option=1 data-id={{ $document_type->id }} > 
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
            <div class="nk-fmg-body-content">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between position-relative">
                        <div class="nk-block-head-content">
                            
                            <h3 class="nk-block-title page-title">Tìm kiếm: {{ $total }} kết quả</h3>    
                        </div>
                        <div class="nk-block-head-content">
                            <ul class="nk-block-tools g-1">                   
                                <li class="d-lg-none me-n1"><a href="#" class="btn btn-trigger btn-icon toggle" data-target="files-aside"><em class="icon ni ni-menu-alt-r"></em></a></li>
                            </ul>
                        </div>      
                    </div>
                </div>
                <div class="nk-fmg-quick-list nk-block mt-2" style="min-height:100vh">          
                    <div class="toggle-expand-content expanded" data-content="quick-access">
                        <div class="nk-files nk-files-view-grid">
                            @if($items)
                            <div class="content">
                                @if($option_id == 0)
                                    <div class="row">
                                        @foreach ($items as $item)
                                            <div class="col-lg-4 col-md-6 mt-4">
                                                <div class="card card-bordered product-card shadow">
                                                    <div class="product-thumb">                             
                                                            <img class="card-img-top" src="{{ $item->url }}" alt="" width="300px" height="400px">    
                                                                                    
                                                            <div class="product-actions type_books w-100 h-100">
                                                                <div class="pricing-body w-100 h-100 text-center">      
                                                                    <div class="h-100 d-flex flex-column justify-content-center">
                                                                        <div class="pricing-amount">
                                                                            <h6 class="bill text-white">{{ $item->name }}</h6>
                                                                            <p class="text-white">Tác giả: {{ $item->author }}</p>
                                                                            <p class="text-white">Số chương: {{ $item->numberOfChapter }}</p>
                                                                            <p class="text-white">Lượt đọc: {{ $item->totalReading }}</p>
                                                                        </div>
                                                                        <div class="pricing-action">
                                                                            <a href="/sach/{{$item->id}}/{{$item->slug}}" class="btn btn-outline-light">Chi tiết</a>
                                                                        </div>
                                                                    </div>                                      
                                                                    
                                                                </div>
                                                            </div>
                                                    </div>
                                                
                                                </div>
                                            </div>                         
                                        @endforeach
                                    </div>
                                @else
                                    <div class="row">
                                        @foreach ($items as $item)
                                            <div class="col-lg-4 col-md-6 mt-4">
                                                <div class="card card-bordered product-card shadow">
                                                    <div class="product-thumb">                             
                                                            <img class="card-img-top" src="{{ $item->url }}" alt="" width="300px" height="400px">    
                                                                                    
                                                            <div class="product-actions type_documents w-100 h-100">
                                                                <div class="pricing-body w-100 h-100 text-center">      
                                                                    <div class="h-100 d-flex flex-column justify-content-center">
                                                                        <div class="pricing-amount">
                                                                            <h6 class="bill text-white">{{ $item->name }}</h6>
                                                                            <p class="text-white">Tác giả: {{ $item->author }}</p>
                                                                            <p class="text-white">Số trang: {{ $item->numberOfPages }}</p>
                                                                            <p class="text-white">Lượt tải: {{ $item->totalDownloading }}</p>
                                                                        </div>
                                                                        <div class="pricing-action">
                                                                            <a href="/tai-lieu/{{$item->id}}/{{$item->slug}}" class="btn btn-outline-light">Chi tiết</a>
                                                                        </div>
                                                                    </div>                                      
                                                                    
                                                                </div>
                                                            </div>
                                                    </div>
                                                
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
    
                                <div class="col-md-12 d-flex justify-content-end mt-4">                          
                                    {{ $items->links('vendor.pagination.custom',['elements' => $items]) }}
                                </div>
                                      
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
<script>

    $(document).ready(function() {
        var option_id = {!! $option_id !!};
        var type_id = {!! $type_id !!};

        $(`*[data-id="${type_id}"][data-option="${option_id}"]`).addClass('active');

        
        if (option_id == 0){
            $('#book-type-menu').show("slow");
            $('#document-type-menu').hide();
        }
        else if (option_id == 1){             
            $('#document-type-menu').show("slow");
            $('#book-type-menu').hide();
        }
       

      
    });

$('.type-option-select').hover(
    
   function () {
    $(this).css({"cursor":"pointer"});
    $(this).css({"background-color":"#ededed"});
   }, 
    
   function () {
    $(this).css({"cursor":"pointer"});
    $(this).css({"background-color":"transparent"});
   }
);

$('#type-option-select-book').click(function () {

    $('#book-type-menu').toggle('slow');

})
$('#type-option-select-document').click(function () {

    $('#document-type-menu').toggle('slow');

 

})


$('.type-option').click(function(){

    const type_slug = $(this).attr('data-value');
    const option_id = $(this).attr('data-option');
    
    var option = '';
    if(option_id == 0){
        option = 'the-loai-sach';
    }
    else{
        option = 'the-loai-tai-lieu';
    }
    window.location.href=`/the-loai/${option}/${type_slug}`;
});


</script>
@endsection