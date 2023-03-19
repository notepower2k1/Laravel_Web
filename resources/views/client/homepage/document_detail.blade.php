@extends('client/layouts.app')
@section('pageTitle', `${{$document->name}}`)
@section('additional-style')
<style>
   .doc {
    width: 100%;
    height: 500px;
}

</style>  
@endsection
@section('content')

<div class="container">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="product-gallery" >    
                                    <img src="{{ $document->url }}" class="w-100" alt="">                                     
                                </div>
                            </div><!-- .col -->
                            <div class="col-lg-6 d-flex align-items-end">
                                <div class="product-info mb-5 me-xxl-5">
                                        <h2 class="product-title">{{ $document->name }}
                                        
                                            @if(Auth::check())

                                            <button type="button" class="btn btn-icon btn-lg ms-1" data-bs-toggle="modal" data-bs-target="#reportForm">
                                                <em class="icon ni ni-alert" style="color:red"></em>
                                            </button>

                                            @endif
                                        </h2>    
                                      
                                        
                                    <p class="product-title">Tác giả: {{ $document->author }}</p>                                                           
                                    <div class="product-meta">
                                        <ul class="d-flex g-3 gx-5">
                                            <li>
                                                <div class="fs-14px text-muted">Lượt tải</div>
                                                <div class="fs-16px fw-bold text-secondary" id="totalDownload">{{ $document->totalDownloading }}</div>
                                            </li>
                                            <li>
                                                <div class="fs-14px text-muted">Số trang</div>
                                                <div class="fs-16px fw-bold text-secondary">{{ $document->numberOfPages }}</div>
                                            </li>
                                            <li>
                                                <div class="fs-14px text-muted">Định dạng</div>
                                                <div class="fs-16px fw-bold text-secondary">.{{ $document->extension }}</div>
                                            </li>
                                      
                                            
                                        </ul>
                                    </div>
                                    <div class="product-meta">
                                        <h6 class="title">Ngôn ngữ: 
                                            @if ($document->language === 1)
                                            <span class="text-success fs-14px">Tiếng việt</span>
                                            @else
                                            <span class="text-info fs-14px">Tiếng anh</span>

                                            @endif 
                                        </h6>
                                      
                                    </div><!-- .product-meta -->
                                    <div class="product-meta">
                                        <h6 class="title">Tình trạng: 

                                            @if ($document->isCompleted === 1)
                                            <span class="text-success fs-14px fw-bold">Đã hoàn thành</span>
                                            @else
                                            <span class="text-info fs-14px fw-bold">Chưa hoàn thành</span>

                                            @endif 
                                        </h6>
                                      
                                    </div><!-- .product-meta -->
                                    <div class="product-meta">
                                        <h6 class="title">Thể loại</h6>
                                        <ul class="d-flex flex-wrap ailgn-center g-2 pt-1">                                     
                                            <li class="ms-n1">
                                                <a href="/the-loai/the-loai-tai-lieu/{{$document->types->slug}}" class="btn btn-primary">{{ $document->types->name }}</a>
                                            </li>         
                                        </ul>
                                    </div><!-- .product-meta -->
                                    <div class="product-meta">
                                        <ul class="d-flex flex-wrap ailgn-center g-2 pt-1">
                                            {{-- <li class="ms-n1">
                                                @if($book->numberOfChapter === 0)
                                                <button class="btn btn-xl btn-primary disabled"><em class="icon ni ni-arrow-right-circle"></em><span>Đọc ngay</span></button>
                                                @else
                                                <button class="btn btn-xl btn-primary"><em class="icon ni ni-arrow-right-circle"></em><span>Đọc ngay</span></button>
                                                @endif
                                            </li> --}}
                                            <li class="ms-n1">
                                                <button class="btn btn-xl btn-primary" id="download-btn"><em class="icon ni ni-download"></em><span>Tải xuống</span></button>
                                            </li>
                                            <li class="ms-n1">
                                                <button id="preview-btn" class="btn btn-xl btn-primary" data-bs-toggle="modal" data-bs-target="#modalDefault" ><em class="icon ni ni-eye"></em><span>Xem trước</span></button>
                                            

                                            </li>
                                        </ul>
                                    </div><!-- .product-meta -->
                                </div><!-- .product-info -->
                                
                                
                            </div><!-- .col -->
                        </div><!-- .row -->
                        <div class="row g-gs flex-lg-row-reverse">                      
                            <div class="col-lg-12">
                                <div class="product-details entry me-xxl-3">
                                    <hr class="hr">
                                    <h3>Giới thiệu</h3>
                                    <div id="divhtmlContent" >{{ $document->description }}</div>   

                                </div>
                            </div><!-- .col -->
                        </div><!-- .row -->
                     
                     
                    </div>
                </div>
            </div><!-- .nk-block -->
            {{-- <div class="nk-block nk-block-lg">
                <div class="nk-block-head">
                    <div class="nk-block-between g-3">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Related Products</h3>
                        </div>
                    </div>
                </div><!-- .nk-block-head -->
                <div class="slider-init row slick-initialized slick-slider" data-slick="{&quot;slidesToShow&quot;: 4, &quot;centerMode&quot;: false, &quot;slidesToScroll&quot;: 1, &quot;infinite&quot;:false, &quot;responsive&quot;:[ {&quot;breakpoint&quot;: 1540,&quot;settings&quot;:{&quot;slidesToShow&quot;: 3}},{&quot;breakpoint&quot;: 992,&quot;settings&quot;:{&quot;slidesToShow&quot;: 2}}, {&quot;breakpoint&quot;: 576,&quot;settings&quot;:{&quot;slidesToShow&quot;: 1}} ]}"><div class="slick-arrow-prev slick-arrow slick-disabled" aria-disabled="true" style=""><a href="javascript:void(0);" class="slick-prev"><em class="icon ni ni-chevron-left"></em></a></div>
                    <!-- .col -->
                    <!-- .col -->
                    <!-- .col -->
                    <!-- .col -->
                    <!-- .col -->
                    <!-- .col -->
                <div class="slick-list draggable"><div class="slick-track" style="opacity: 1; width: 1638px; transform: translate3d(0px, 0px, 0px);"><div class="col slick-slide slick-current slick-active" style="width: 273px;" tabindex="0" data-slick-index="0" aria-hidden="false">
                        <div class="card card-bordered product-card">
                            <div class="product-thumb">
                                <a href="html/product-details.html" tabindex="0">
                                    <img class="card-img-top" src="./images/product/lg-a.jpg" alt="">
                                </a>
                                <ul class="product-badges">
                                    <li><span class="badge bg-success">New</span></li>
                                </ul>
                                <ul class="product-actions">
                                    <li><a href="#" tabindex="0"><em class="icon ni ni-cart"></em></a></li>
                                    <li><a href="#" tabindex="0"><em class="icon ni ni-heart"></em></a></li>
                                </ul>
                            </div>
                            <div class="card-inner text-center">
                                <ul class="product-tags">
                                    <li><a href="#" tabindex="0">Smart Watch</a></li>
                                </ul>
                                <h5 class="product-title"><a href="html/product-details.html" tabindex="0">Classy Modern Smart watch</a></h5>
                                <div class="product-price text-primary h5"><small class="text-muted del fs-13px">$350</small> $324</div>
                            </div>
                        </div>
                    </div><div class="col slick-slide slick-active" style="width: 273px;" tabindex="0" data-slick-index="1" aria-hidden="false">
                        <div class="card card-bordered product-card">
                            <div class="product-thumb">
                                <a href="html/product-details.html" tabindex="0">
                                    <img class="card-img-top" src="./images/product/lg-b.jpg" alt="">
                                </a>
                                <ul class="product-actions">
                                    <li><a href="#" tabindex="0"><em class="icon ni ni-cart"></em></a></li>
                                    <li><a href="#" tabindex="0"><em class="icon ni ni-heart"></em></a></li>
                                </ul>
                            </div>
                            <div class="card-inner text-center">
                                <ul class="product-tags">
                                    <li><a href="#" tabindex="0">Vintage Phone</a></li>
                                </ul>
                                <h5 class="product-title"><a href="html/product-details.html" tabindex="0">White Vintage telephone</a></h5>
                                <div class="product-price text-primary h5"><small class="text-muted del fs-13px">$209</small> $119</div>
                            </div>
                        </div>
                    </div><div class="col slick-slide" style="width: 273px;" tabindex="-1" data-slick-index="2" aria-hidden="true">
                        <div class="card card-bordered product-card">
                            <div class="product-thumb">
                                <a href="html/product-details.html" tabindex="-1">
                                    <img class="card-img-top" src="./images/product/lg-c.jpg" alt="">
                                </a>
                                <ul class="product-badges">
                                    <li><span class="badge bg-danger">Hot</span></li>
                                </ul>
                                <ul class="product-actions">
                                    <li><a href="#" tabindex="-1"><em class="icon ni ni-cart"></em></a></li>
                                    <li><a href="#" tabindex="-1"><em class="icon ni ni-heart"></em></a></li>
                                </ul>
                            </div>
                            <div class="card-inner text-center">
                                <ul class="product-tags">
                                    <li><a href="#" tabindex="-1">Headphone</a></li>
                                </ul>
                                <h5 class="product-title"><a href="html/product-details.html" tabindex="-1">Black Wireless Headphones</a></h5>
                                <div class="product-price text-primary h5"><small class="text-muted del fs-13px">$129</small> $89</div>
                            </div>
                        </div>
                    </div><div class="col slick-slide" style="width: 273px;" tabindex="-1" data-slick-index="3" aria-hidden="true">
                        <div class="card card-bordered product-card">
                            <div class="product-thumb">
                                <a href="html/product-details.html" tabindex="-1">
                                    <img class="card-img-top" src="./images/product/lg-d.jpg" alt="">
                                </a>
                                <ul class="product-actions">
                                    <li><a href="#" tabindex="-1"><em class="icon ni ni-cart"></em></a></li>
                                    <li><a href="#" tabindex="-1"><em class="icon ni ni-heart"></em></a></li>
                                </ul>
                            </div>
                            <div class="card-inner text-center">
                                <ul class="product-tags">
                                    <li><a href="#" tabindex="-1">Smart Watch</a></li>
                                </ul>
                                <h5 class="product-title"><a href="html/product-details.html" tabindex="-1">Modular Smart Watch</a></h5>
                                <div class="product-price text-primary h5"><small class="text-muted del fs-13px">$169</small> $120</div>
                            </div>
                        </div>
                    </div><div class="col slick-slide" style="width: 273px;" tabindex="-1" data-slick-index="4" aria-hidden="true">
                        <div class="card card-bordered product-card">
                            <div class="product-thumb">
                                <a href="html/product-details.html" tabindex="-1">
                                    <img class="card-img-top" src="./images/product/lg-e.jpg" alt="">
                                </a>
                                <ul class="product-actions">
                                    <li><a href="#" tabindex="-1"><em class="icon ni ni-cart"></em></a></li>
                                    <li><a href="#" tabindex="-1"><em class="icon ni ni-heart"></em></a></li>
                                </ul>
                            </div>
                            <div class="card-inner text-center">
                                <ul class="product-tags">
                                    <li><a href="#" tabindex="-1">Headphones</a></li>
                                </ul>
                                <h5 class="product-title"><a href="html/product-details.html" tabindex="-1">White Wireless Headphones</a></h5>
                                <div class="product-price text-primary h5"><small class="text-muted del fs-13px">$109</small> $78</div>
                            </div>
                        </div>
                    </div><div class="col slick-slide" style="width: 273px;" tabindex="-1" data-slick-index="5" aria-hidden="true">
                        <div class="card card-bordered product-card">
                            <div class="product-thumb">
                                <a href="html/product-details.html" tabindex="-1">
                                    <img class="card-img-top" src="./images/product/lg-f.jpg" alt="">
                                </a>
                                <ul class="product-actions">
                                    <li><a href="#" tabindex="-1"><em class="icon ni ni-cart"></em></a></li>
                                    <li><a href="#" tabindex="-1"><em class="icon ni ni-heart"></em></a></li>
                                </ul>
                            </div>
                            <div class="card-inner text-center">
                                <ul class="product-tags">
                                    <li><a href="#" tabindex="-1">Phone</a></li>
                                </ul>
                                <h5 class="product-title"><a href="html/product-details.html" tabindex="-1">Black Android Phone</a></h5>
                                <div class="product-price text-primary h5">$329</div>
                            </div>
                        </div>
                    </div></div></div><div class="slick-arrow-next slick-arrow" style="" aria-disabled="false"><a href="javascript:void(0);" class="slick-next"><em class="icon ni ni-chevron-right"></em></a></div></div>
            </div> --}}
        </div>
    </div>
</div>
@section('modal')
@if(Auth::check())

<div class="modal fade" id="reportForm" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Báo cáo tài liệu</h5>
                <button id="close-btn" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-validate is-alter" novalidate="novalidate">
                    @csrf
                    <input type="hidden" class="form-control" id="type_id" name="type_id" value=3>
                    <input type="hidden" class="form-control" id="identifier_id" name="identifier_id" value={{ $document->id }}>

                    <div class="form-group">
                        <label class="form-label" for="book-name">Tên tài liệu</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="book-name" required="" value='{{ $document->name }}' readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="description">Lý do</label>
                        <div class="form-control-wrap">
                            <textarea class="form-control form-control-sm" id="description" name="description" placeholder="Lý do của bạn" required></textarea>
                        </div>
                      
                    </div>
                    <div class="form-group text-right">
                        <button id="report-btn" class="btn btn-lg btn-primary">Báo cáo</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <span class="sub-text">Báo cáo bởi {{ Auth::user()->profile->displayName }}</span>
            </div>
        </div>
    </div>
</div>
@endif
<div class="modal fade" tabindex="-1" id="modalDefault">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close" id="close-modal">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Xem trước</h5>
            </div>
            <div class="modal-body embed-responsive embed-responsive-16by9">
                <iframe  id="preview-iframe" class="doc embed-responsive-item"></iframe>
            </div>
            <div class="modal-footer">
                <span class="modal-title">Thử lại nếu chưa hiện dữ liệu</span><em class="icon ni ni-info"></em>
            </div>
        </div>
    </div>
</div>
@endsection

@endsection
@section('additional-scripts')

<script>
    
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    $("#download-btn").click(function(e){
        e.preventDefault();
        var id = {!! $document->id !!}
        $.ajax({
                type:"GET",
                url:'/tai-tai-lieu',
                data : {
                    "id": id
                },
                })
                .done(function(res) {
                // If successful           
                    window.location.href = res.url;      
                    $('#totalDownload').text(res.totalDownload);
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                })
        
    })


    $("#preview-btn").click(function(e){
        e.preventDefault();
        var id = {!! $document->id !!}
     
            $.ajax({
                type:"GET",
                url:'/preview-document',
                data : {
                    "id": id
                },
                })
                .done(function(res) {
                // If successful           
                    var url = res.url;
                    $('#preview-iframe').attr('src',url);

                    setTimeout(()=>{
                        $('#modal-btn').click();
                    }, 2000);
                


                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                })
      
       
      

    })

    $("#close-modal").click(function(e){
        $('#preview-iframe').attr('src','');
    });

    $('#report-btn').click(function(e){
        e.preventDefault();
        Swal.fire({
            icon: 'info',
            html:
                'Tài khoản của bạn có thể bị <b>khóa</b> nếu bạn cố tình báo cáo sai',
            showCloseButton: true,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Báo cáo',
            cancelButtonText: `Không báo cáo`,
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                var form = $('#reportForm');

                var type_id = form.find('input[name="type_id"]').val();
                var identifier_id = form.find('input[name="identifier_id"]').val();
                var description = form.find('textarea[name="description"]').val();
                
                if(description){
                        $.ajax({
                        url:'/bao-cao',
                        type:"POST",
                        data:{
                            'description': description,
                            'identifier_id':identifier_id,
                            'type_id':type_id
                        }
                        })
                        .done(function(res) {
                        
                            Swal.fire({
                                    icon: 'success',
                                    title: `${res.report}`,
                                    showConfirmButton: false,
                                    timer: 2500
                                });     

                            
                            setTimeout(()=>{
                                $('#close-btn').click();
                            }, 3000);
                        })

                        .fail(function(jqXHR, textStatus, errorThrown) {
                        // If fail
                        console.log(textStatus + ': ' + errorThrown);
                        })
                }
                else{
                    Swal.fire('Vui lòng nhập lý do!!!', '', 'info')
                }

              



            } else if (result.isDenied) {
                Swal.fire('Báo cáo thất bại', '', 'info')
            }
        })
    })
</script>
@endsection