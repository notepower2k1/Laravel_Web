@extends('client/layouts.app')
@section('pageTitle', 'Thể loại')
@section('additional-style')
<style>
    .preview-item{
        padding:0.5rem;
    }
    </style>
@endsection
@section('content')
<div class="card card-bordered card-preview">
    <div class="card-inner">
        <div class="dropdown">
            <a href="#" class="dropdown-toggle btn btn-light" data-bs-toggle="dropdown" aria-expanded="false">Chọn thể loại: </a>
            <div class="dropdown-menu">
                <ul class="link-list-opt">
                    <li class="type-option-select" data-option-select=0><a href="#"><em class="icon ni ni-book-fill"></em><span>Sách</span></a></li>
                    <li class="type-option-select" data-option-select=1><a href="#"><em class="icon ni ni-file-text"></em><span>Tài liệu tham khảo</span></a></li>
                </ul>
            </div>
        </div>

        <span class="preview-title overline-title mt-4" id="option-title">Thể loại sách</span>
        <ul class="preview-list" id="book-type-menu">
            @foreach ($book_types as $book_type)
            <li class="preview-item">
                <a href="#" class="type-option badge rounded-pill badge-md bg-outline-primary" data-value={{ $book_type->slug  }} data-option=0  data-id={{ $book_type->id }} >{{ $book_type->name }}</a>
            </li>
            @endforeach
          
         
        </ul>

        <ul class="preview-list" id="document-type-menu" style="display: none">
            @foreach ($document_types as $document_type)
            <li class="preview-item">
                <a href="#" class="type-option badge rounded-pill badge-md bg-outline-primary" data-value={{ $document_type->slug  }} data-option=1 data-id={{ $document_type->id }} >{{ $document_type->name }}</a>
            </li>
            @endforeach
          
         
        </ul>
    </div>

  
</div>
<div class="nk-block">
    <div class="row g-gs" id="result-box">

        @if($option_id == 0)
            @foreach ($items as $item)
                <div class="col-sm-6 col-lg-3 col-xxl-3" id="new_div">
                    <div class="card card-bordered product-card">
                        <div class="product-thumb">
                            <a href="/sach/{{ $item->id }}/{{ $item->slug }}">
                                <img class="card-img-top" src="{{ $item->url }}" alt="image" >
                            </a>          
                        </div>
                        
                        <div class="card-inner text-center">
                            <h5 class="product-title"><a href="/sach/{{ $item->name }}/{{ $item->slug }}">{{ $item->name }}</a></h5>
                            <div class="product-price text-primary h5">{{ $item->author }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            @foreach ($items as $item)
            <div class="col-sm-6 col-lg-3 col-xxl-3" id="new_div">
                <div class="card card-bordered product-card">
                    <div class="product-thumb">
                        <a href="/tai-lieu/{{ $item->id }}/{{ $item->slug }}">
                            <img class="card-img-top" src="{{ $item->url }}" alt="image" >
                        </a>          
                    </div>
                    
                    <div class="card-inner text-center">
                        <h5 class="product-title"><a href="/tai-lieu/{{ $item->name }}/{{ $item->slug }}">{{ $item->name }}</a></h5>
                        <div class="product-price text-primary h5">{{ $item->author }}</div>
                    </div>
                </div>
            </div>
        @endforeach
        @endif

    </div>
    
</div> 
@endsection
@section('additional-scripts')
<script>

    $(document).ready(function() {
        var option_id = {!! $option_id !!};
        var type_id = {!! $type_id !!};

        $(`*[data-id="${type_id}"][data-option="${option_id}"]`).css({"background-color":"#ededed"});

        
       if(type_id > 0){
        if (option_id == 0){
            $('#option-title').text('Thể loại sách');

            $('#book-type-menu').show("slow");

            $('#document-type-menu').hide();
        }

        else if (option_id == 1){
            $('#option-title').text('Thể loại tài liệu');
            $('#book-type-menu').hide();

            $('#document-type-menu').show("slow");
        }
       }

      
    });

$('.book-type-option').hover(
    
   function () {
      $(this).css({"background-color":"#ededed"});
   }, 
    
   function () {
      $(this).css({"background-color":"transparent"});
   }
);


$('.type-option-select').click(function () {
    var option = $(this).attr('data-option-select');

    if (option == 0){

        $('#option-title').text('Thể loại sách');

        $('#book-type-menu').show("slow");

        $('#document-type-menu').hide();
    }
    else if (option == 1){

        $('#option-title').text('Thể loại tài liệu');
        $('#book-type-menu').hide();

        $('#document-type-menu').show("slow");
    }

})



$('.type-option').click(function(){

    var type_slug = $(this).attr('data-value');
    var option_id = $(this).attr('data-option');
    
    getResult(type_slug,option_id);
});

function getResult(type_slug,option_id){

    var option = "";

    if(option_id == 0){
        option = 'the-loai-sach'
    }
    else{
        option = 'the-loai-tai-lieu'
    }

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

}
</script>
@endsection