@extends('client/homepage.layouts.app')
@section('additional-style')
<link href="{{ asset('js/pagination/pagination.css') }}" rel="stylesheet" type="text/css">

<style>
    @media (min-width: 1200px){
        .container-xl, .container-lg, .container-md, .container-sm, .container {
            max-width: 1300px;
        }
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
    <div class="row">
        <div class="col-12">
            <div class="form-control-wrap form-control-lg shadow-sm bg-white rounded">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                        <em class="icon ni ni-search"></em></span>
                    </div>
                    <input type="text" name="query" id="search" class="form-control col-sm-8" placeholder="Nhập tên sách hoặc tài liệu !!" aria-label="Search">                 
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary btn-dim" id="search-btn" data-value="1">Tìm kiếm sách điện tử</button>
                        <button class="btn btn-outline-success btn-dim dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><span id='option_show'>Loại tài liệu</span><em class="icon mx-n1 ni ni-chevron-down"></em></button>
                        <div class="dropdown-menu dropdown-menu-end" style="">
                            <ul class="link-list-opt no-bdr">
                                <li class="active"><a href="#" class="search-option" data-value=1 >Sách điện tử</a></li>
                                <li><a href="#" class="search-option" data-value=2 >Tài liệu tham khảo</a></li>                                                                 
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="link-list-opt" id="renderArea-ul">
                 
                </ul>
              
            </div>
        </div>    
    </div>
    
    <div class="nk-block mt-4">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between position-relative">
                <div class="nk-block-head-content">
    
                    <h3 class="nk-block-title page-title"><span id="total-search"></span></h3>    
                </div>              
            </div>
        </div>
        <div class="card card-bordered shadow">
            <div class="card-inner">
                <div class="row g-gs" id="result-box">
                    @foreach ($default_books as $book)
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="d-flex">  
                                <div class="me-2 shine">
                                    <img class="card-img-top" src="{{ $book->url }}" alt="" style="width:180px;height:150px">    
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


                <div class="data-container mt-3"></div>
                <div class="col-md-12 d-flex justify-content-end mt-4 align-items-end h-100">                          
                    <div id="pagination"></div>
                </div>
            </div>
           
        </div>
    </div> 
      
    <div id="spinner" style="display:none">
        <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>  
</div>
                               
@endsection

@section('additional-scripts')
<script src="{{ asset('assets/js/example-sweetalert.js?ver=3.1.2') }}" aria-hidden="true"></script>
<script src="{{ asset('js/pagination/pagination.min.js') }}" ></script>

<script>
const bookNames = @json($books);
const documentNames = @json($documents);

var typingTimer;                //timer identifier
var doneTypingInterval = 1000;  //time in ms, 5 seconds for example


$(function() {
    bookRender();
})
//on keyup, start the countdown
$('#search').on('keyup', function () {
  clearTimeout(typingTimer);
  typingTimer = setTimeout(doneTyping, doneTypingInterval);
});

//on keydown, clear the countdown 
$('#search').on('keydown', function () {
  clearTimeout(typingTimer);
});

//user is "finished typing," do something
function doneTyping () {
    const renderBox = $('#renderArea-ul');

    renderBox.empty();
    const inputValue = $('#search').val();

    const option_value = $('#search-btn').attr('data-value');

    if(inputValue){

        var fullName = []
        if(option_value == 1){
            fullName =  bookNames.filter(function(name){

            return name.toLowerCase().normalize().includes(inputValue.toLowerCase().normalize());
            });
        }
        if(option_value == 2){
            fullName =  documentNames.filter(function(name){
            return name.toLowerCase().normalize().includes(inputValue.toLowerCase().normalize());
            });
        }

        
        fullName.forEach(name => {
            const item = `<li><a href="#" class="search-items"><span>${name}</span></a></li>`;
            renderBox.append(item).hide().show('slow');
        });
    }
}



$(document).on('click','.search-items',function(e){

    e.preventDefault();
    const text = $(this).find('span').text();
    $('#search').val(text);

})

$(".search-option").click(function(e){
    e.preventDefault();

    $(".search-option").parent().removeClass("active");
    var option_text = $(this).text();
    var option_value = $(this).attr('data-value');
    $("#search-btn").text("Tìm kiếm " + option_text.toLowerCase());
    $("#search-btn").attr('data-value',option_value);
    
    
    $(this).parent().addClass("active");
    $('#search').val("");
});

$("#search-btn").click(function(e){
    e.preventDefault();

    var option_value = $(this).attr('data-value');
    var input_value = $("input[type=text]").val();
    var renderArea = $('#result-box');

    if(input_value.length > 3){

        if(input_value===""){
            Swal.fire({
                icon: 'info',
                title: `Vui lòng nhập dữ liệu!!!`,
                showConfirmButton: false,
                timer: 2500
            });
            $("input[type=text]").focus();

            }
        else{
            $('#spinner').show();
            $.ajax({
                url:'/tim-kiem-ket-qua',
                type:"GET",
                data : {
                    "query": input_value,
                    "option":option_value
                },
                })
                .done(function(res) {
                    $('#spinner').hide();

                    $('#total-search').text(res.total);
                    if(res.total > 0 ){
                        renderArea.empty();    
                        const item = res.res;        
                    
                        
                        renderArea.append(item).hide().show();
                            

                        bookRender();
                        

                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            title: `Không có tên hợp lệ`,
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
        }
        else{
            Swal.fire({
                icon: 'error',
                title: `Bạn nên tìm kiếm nhiều ký tự hơn`,
                showConfirmButton: false,
                timer: 2500
            });
        }

   
  
})

    function bookRender(){
        const container = $('#pagination');


        if (!container.length) return;
            var sources = function () {
            var result = [];

            $('#result-box').children().each(function(item){

                result.push($(this).get(0).outerHTML);

            })
        return result;
        }();

        var options = {
            dataSource: sources,
            pageSize: 20,
            callback: function (response, pagination) {
                var dataHtml = '<div class="row g-gs">';

                $.each(response, function (index, item) {
                    dataHtml += item;
                });

                dataHtml += '</div>';

                container.parent().prev().html(dataHtml);
                $('#result-box').empty();
            }
        };


        const total = sources.length;
        $('#total-search').text(`Tìm kiếm: ${total} kết quả`)

        container.pagination(options);
    }
</script>
@endsection
