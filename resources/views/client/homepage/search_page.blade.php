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
                    <input type="text" name="query" class="form-control col-sm-8"  placeholder="Nhập tên sách hoặc tài liệu !!" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-outline-success btn-dim dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><span id='option_show'>Loại tài liệu</span><em class="icon mx-n1 ni ni-chevron-down"></em></button>
                        <div class="dropdown-menu dropdown-menu-end" style="">
                            <ul class="link-list-opt no-bdr">
                                <li><a href="#" class="search-btn" data-value=1 >Sách điện tử</a></li>
                                <li><a href="#" class="search-btn" data-value=2 >Tài liệu tham khảo</a></li>                                                                 
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
    
    <div class="nk-block mt-4">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between position-relative">
                <div class="nk-block-head-content">
    
                    <h3 class="nk-block-title page-title">Tìm kiếm: <span id="total-search">0</span> kết quả</h3>    
                </div>
                <div class="nk-block-head-content">
                    <ul class="nk-block-tools g-1">                   
                        <li class="d-lg-none me-n1">
                            <a class="btn btn-trigger btn-icon toggle" data-target="files-aside"><em class="icon ni ni-menu-alt-r" style="cursor: pointer"></em>
                            </a>
                        </li>
                    </ul>
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

$(".search-btn").click(function(){

    var option_value = $(this).attr('data-value');
    var input_value = $("input[type=text]").val();
    var renderArea = $('#result-box');

    if(input_value.length > 3){
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

                    $('#total-search').text(res.total);
                    if(res.res.length > 0 ){
                        renderArea.empty();                
                        for(item of res.res){
                      
                        var openEnderContent = 

                       '<div class="col-lg-3 col-md-6 mt-3">' +
                                           ' <div class="card card-bordered product-card shadow">'+
                                                '<div class="product-thumb">'+
                                                    `<img class="card-img-top" src="${item.searchable.url}" alt="" width="300px" height="400px">` +                                                                             
                                                       ' <div class="product-actions item-search w-100 h-100">' +
                                                           ' <div class="pricing-body w-100 h-100 d-flex text-center align-items-center">' +
                                                               ' <div class="row">' +
                                                                   ' <div class="pricing-amount">' +
                                                                      `<h6 class="bill text-white">${item.searchable.name}</h6>` +
                                                                      `<p class="text-white">Tác giả: ${item.searchable.author}</p>` +                                                               
                                                                   ' </div>'+
                                                                   ' <div class="pricing-action">'+
                                                                        `<a href="${item.url}" class="btn btn-outline-light">Chi tiết</a>`+
                                                                '    </div>'+
                                                               ' </div>'+                                                                              
                                                           ' </div>'+
                                                        '</div>'+
                                              '  </div>'+                                         
                                '</div>'+
                       ' </div>';

                        
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
