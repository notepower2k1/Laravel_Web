@extends('client/homepage.layouts.app')
@section('additional-style')
<style>
    .item-search:hover{
        background-color:#062788;
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
    
                    <h3 class="nk-block-title page-title">Tìm kiếm: <span id="total-search">0</span> kết quả</h3>    
                </div>              
            </div>
        </div>
        <div class="nk-content">
            <div class="row g-gs" id="result-box">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js">
</script>
<script>
const bookNames = @json($books);
const documentNames = @json($documents);

var typingTimer;                //timer identifier
var doneTypingInterval = 1000;  //time in ms, 5 seconds for example


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



$(document).on('click','.search-items',function(){

    const text = $(this).find('span').text();
    $('#search').val(text);

})

$(".search-option").click(function(){
    $(".search-option").parent().removeClass("active");
    var option_text = $(this).text();
    var option_value = $(this).attr('data-value');
    $("#search-btn").text("Tìm kiếm " + option_text.toLowerCase());
    $("#search-btn").attr('data-value',option_value);
    
    
    $(this).parent().addClass("active");
    $('#search').val("");
});

$("#search-btn").click(function(){

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
                        for(item of res.res){
                    
                        
                        renderArea.append(item).hide().show('slow');
                    
                        }

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
</script>
@endsection
