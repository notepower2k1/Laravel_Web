@extends('client/layouts.app')
@section('content')
<div class="card card-bordered card-preview">
    <div class="card-inner">
        <div class="row g-4">
            <div class="col-12">
                <div class="form-control-wrap">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                            <em class="icon ni ni-search"></em></span>
                        </div>
                            <input type="text" name="query" class="form-control col-sm-8"  placeholder="Nhập tên tài liệu hoặc tác giả!!!" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary btn-dim" id="search-btn" >Tìm kiếm sách điện tử</button>
                            <button class="btn btn-outline-primary btn-dim dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><span id='option_show'>Loại tài liệu</span><em class="icon mx-n1 ni ni-chevron-down"></em></button>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <ul class="link-list-opt no-bdr">
                                    <li><a href="#" class="search-option" data-value=1 >Sách điện tử</a></li>
                                    <li><a href="#" class="search-option" data-value=2 >Tài liệu tham khảo</a></li>                                                                 
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           
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
<div class="nk-block">
    <div class="row g-gs" id="result-box">
       
       
      

    </div>
    
</div>                                  
@endsection

@section('additional-scripts')
<script src="{{ asset('assets/js/example-sweetalert.js?ver=3.1.2') }}" aria-hidden="true"></script>

<script>

function toSlug(str) {
	// Chuyển hết sang chữ thường
	str = str.toLowerCase();     
 
	// xóa dấu
	str = str
		.normalize('NFD') // chuyển chuỗi sang unicode tổ hợp
		.replace(/[\u0300-\u036f]/g, ''); // xóa các ký tự dấu sau khi tách tổ hợp
 
	// Thay ký tự đĐ
	str = str.replace(/[đĐ]/g, 'd');
	
	// Xóa ký tự đặc biệt
	str = str.replace(/([^0-9a-z-\s])/g, '');
 
	// Xóa khoảng trắng thay bằng ký tự -
	str = str.replace(/(\s+)/g, '-');
	
	// Xóa ký tự - liên tiếp
	str = str.replace(/-+/g, '-');
 
	// xóa phần dư - ở đầu & cuối
	str = str.replace(/^-+|-+$/g, '');
 
	// return
	return str;
}



$(".search-option").click(function(){

    $(".search-option").parent().removeClass("active");

    var option_text = $(this).text();
    var option_value = $(this).attr('data-value');

    $("#search-btn").text("Tìm kiếm " + option_text.toLowerCase());
    $("#search-btn").attr('data-value',option_value);
    
    
    $(this).parent().addClass("active");

});

$("#search-btn").click(function(){

    var option_value = $(this).attr('data-value');
    var input_value = $("input[type=text]").val();
    var renderArea = $('#result-box');

    if(input_value.length > 5){
        var slug_value = toSlug(input_value);

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
                    "query": slug_value,
                    "option":option_value
                },
                })
                .done(function(res) {
                    $('#spinner').hide();

                    if(res.res.length > 0 ){
                        renderArea.empty(); 

                        for(item of res.res){
                        var openEnderContent = 
                        '<div class="col-xxl-2 col-lg-2 col-sm-6" id="new_div">' +
                            '<div class="card card-bordered product-card">' +
                                '<div class="product-thumb">' + 
                                    `<a href="${item.url}">` +
                                        `<img class="card-img-top" src="${item.searchable.url}" alt="image" >` +
                                    '</a>' +               
                                '</div>'
                                +
                                '<div class="card-inner text-center">' +
                                    `<h5 class="product-title"><a href="/sach/${item.searchable.id}/${item.searchable.slug}">${item.searchable.name}</a></h5>` +
                                    `<div class="product-price text-primary h5">${item.searchable.author}</div>` +
                                '</div>' +
                            '</div>'+
                        '</div>';


                        
                        renderArea.append(openEnderContent);
                    
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
