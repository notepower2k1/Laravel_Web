@extends('client/homepage.layouts.app')
@section('pageTitle', 'Thành viên')
@section('additional-style')
<link href="{{ asset('js/pagination/pagination.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('content')
<div class="nk-block">
    <div class="p-4">
        <div class="row g-gs">
            <div class="col-lg-4 col-xl-4 col-xxl-3">
                <div class="card card-bordered">
                    <div class="card-inner-group">
                        <div class="card-inner">
                            <div class="user-card user-card-s2">
                                <div class="user-avatar lg bg-primary">
                                    <img src="{{ $user->profile->url }}" alt="">
                                </div>
                                <div class="user-info">
                                    <div class="badge bg-light rounded-pill ucap">Thành viên</div>
                                    <h5>{{ $user->profile->displayName }}</h5>
                                </div>
                            </div>
                        </div>              
                        <div class="card-inner">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="profile-stats">
                                        <span class="amount">{{ $books->count() }}</span>
                                        <span class="sub-text">Sách đã đăng</span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="profile-stats">
                                        <span class="amount">{{ $documents->count() }}</span>
                                        <span class="sub-text">Tài liệu đã đăng</span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="profile-stats">
                                        <span class="amount">{{ $posts->count() }}</span>
                                        <span class="sub-text">Bài viết đã đăng</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .card-inner -->
                        <div class="card-inner">
                            <h6 class="overline-title mb-2">Thông tin khác</h6>
                            <div class="row g-3">
                                <div class="col-sm-6 col-md-4 col-lg-12">
                                    <span class="sub-text">Giới tính</span>
    
                                    <span>
                                        @switch($user->profile->gender)
                                        @case(0)
                                            Nam
                                            @break
        
                                        @case(1)
                                            Nữ
                                            @break
        
                                        @default
                                            Không công khai
                                        @endswitch
                                    </span>
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-12">
                                    <span class="sub-text">Email liên kết:</span>
                                    <span>{{ $user->email }}</span>
                                </div>                          
                                <div class="col-sm-6 col-md-4 col-lg-12">
                                    <span class="sub-text">Tình trạng:</span>
                                    @if($user->email_verified_at)
                                    <span class="lead-text text-success">Đã xác thực</span>
                                    @else                                
                                    <span class="lead-text text-danger">Chưa xác thực</span>
                                    @endif
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-12">
                                    <span class="sub-text">Ngày tham gia:</span>
                                    <span>{{ $user->created_at->format('Y-m-d') }}</span>
                                </div>
                            </div>
                        </div><!-- .card-inner -->
                    </div>
                </div>
            </div><!-- .col -->
            <div class="col-lg-8 col-xl-8 col-xxl-9">
                <div class="card card-bordered">
                    <div class="card-inner">   
                        
                        <div class="nk-block">
                            <h6 class="lead-text mb-3">Sách đã đăng</h6>
                            <div class="nk-tb-list nk-tb-ulist is-compact border round-sm">
                                <div class="nk-tb-item nk-tb-head">                          
                                    <div class="nk-tb-col tb-col-sm">
                                        <span class="sub-text">Tên sách</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="sub-text">Tình trạng</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="sub-text">Số chương</span>
                                    </div>                       
                                </div>
                                @foreach ($books as $book )
                                <div class="nk-tb-item book-render-div">   
                                    <div class="nk-tb-col tb-col-sm">
                                        <span class="tb-product">
                                            <img src="{{ $book->url }}" alt="" class="thumb">
                                            <a href="/sach/{{ $book->id}}/{{ $book->slug }}"><span class="fw-bold text-dark">{{ Str::limit($book->name,60) }}</span></a>
                                        </span>
                                    </div>
                                    <div class="nk-tb-col">
                                        @if ($book->isCompleted === 1)
                                        <span class="text-success">Đã hoàn thành</span>
                                        @else
                                        <span class="text-info">Chưa hoàn thành</span>
                                        @endif 
                                    </div>                      
                                    <div class="nk-tb-col">
                                        <span class="sub-text">{{ $book->numberOfChapter }}</span>
                                    </div>
                                </div>   
                            
                                @endforeach
                                   
                                
                            
                            </div><!-- .nk-tb-list -->

                            @if($books->count() > 0)

                            <div class="col-md-12 d-flex justify-content-end mt-4">                          
                                <div id="pagination-1"></div>
                            </div>
                            @endif
                        </div>
                      
                                                

                        <div class="nk-block" >
                            <h6 class="lead-text mb-3">Tài liệu đã đăng</h6>
                            <div class="nk-tb-list nk-tb-ulist is-compact border round-sm">
                                <div class="nk-tb-item nk-tb-head">
                                    <div class="nk-tb-col">
                                        <span class="sub-text">Tên tài liệu</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="sub-text">Tình trạng</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="sub-text">Số trang</span>
                                    </div>
                                 
                                </div>
                                @foreach ($documents as $document )
        
                                    <div class="nk-tb-item document-render-div">
                                        <div class="nk-tb-col">
                                            <a href="/tai-lieu/{{ $document->id}}/{{ $document->slug }}"><span class="fw-bold text-dark">{{ Str::limit($document->name,60) }}</span></a>
                                        </div>                         
                                        <div class="nk-tb-col">
                                            @if ($document->isCompleted === 1)
                                            <span class="text-success">Đã hoàn thành</span>
                                            @else
                                            <span class="text-info">Chưa hoàn thành</span>
                                            @endif 
                                        </div>                   
                                        <div class="nk-tb-col">
                                            <span class="sub-text">{{ $document->numberOfPages }}</span>
                                        </div>
                                    </div>
                                @endforeach
                                  
                                              
                            </div><!-- .nk-tb-list -->
                            @if($documents->count() > 0)

                            <div class="col-md-12 d-flex justify-content-end mt-4">                          
                                <div id="pagination-2"></div>
                            </div>    
                            @endif  
                        </div>  
                        
                     
                        <div class="nk-block">
                            <h6 class="lead-text">Gửi e-mail</h6>
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="between-center flex-wrap flex-md-nowrap g-3">
                                        <div class="media media-center gx-3 wide-xs">
                                            <div class="media-object">
                                                <em class="icon icon-circle icon-circle-lg ni ni-mail"></em>
                                            </div>
                                            <div class="media-content">
                                                @if($user->email_verified_at)
                                                <em class="d-block text-success">Đã xác thực</em>
                                                <p>Tài khoản đã xác thực bạn có thể gửi mail đến tài khoản này</p>
                                                @else                                
                                                <em class="d-block text-success">Chưa xác thực</em>
                                                <p>Tài khoản chưa xác thực bạn không nên gửi mail đến tài khoản này</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="nk-block-actions flex-shrink-0">
                                            <a href="#" class="btn btn btn-danger btn-email">Gửi</a>
                                        </div>
                                    </div>
                                </div><!-- .nk-card-inner -->
                            </div><!-- .nk-card -->

                            @if(Auth::check())
                                @if(Auth::user()->id != $user->id)
                                <h6 class="lead-text">Báo cáo</h6>
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="between-center flex-wrap flex-md-nowrap g-3">
                                            <div class="media media-center gx-3 wide-xs">
                                                <div class="media-object">
                                                    <em class="icon icon-circle icon-circle-lg ni ni-alert" ></em>
                                                </div>
                                                <div class="media-content">
                                                    <p>Báo cáo thành viên này</p>
                                                </div>
                                            </div>
                                            <div class="nk-block-actions flex-shrink-0" id="report-div">
                                                @if($reportUser)

                                                    @if($reportUser->isEnabled)
                                                        <a href="#" class="btn btn btn-dim btn-primary" data-bs-toggle="modal" data-bs-target="#reportForm">Báo cáo</a>
                                                    @else
    
                                                        <a class="btn btn-primary">Đã báo cáo</a>

                                                    
                                                    @endif
                                                @else
                                                    <a href="#" class="btn btn btn-dim btn-primary" data-bs-toggle="modal" data-bs-target="#reportForm">Báo cáo</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div><!-- .nk-card-inner -->
                                </div><!-- .nk-card -->
                                @endif
                            @endif
                        </div>
                    </div><!-- .card-inner -->
                </div><!-- .card -->
            </div><!-- .col -->
        </div><!-- .row -->
    </div>
   
</div>
@endsection

@section('modal')

@if(Auth::check())
<div class="modal fade" id="reportForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Báo cáo thành viên</h5>
                <button id="close-btn" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-validate is-alter" novalidate="novalidate">
                    @csrf
                    <input type="hidden" class="form-control" id="type_id" name="type_id" value=5>
                    <input type="hidden" class="form-control" id="identifier_id" name="identifier_id" value={{ $user->id }}>

                    <div class="form-group">
                        <label class="form-label" for="book-name">Tên thành viên</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="book-name" required="" value='{{ $user->profile->displayName }}' readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reason">Lý do</label>
                        <div class="form-control-wrap">
                            <select required class="form-control mb-4 col-6" name="reason" id="reason">
                                @foreach ($reportReasons as $reason)
                                <option value="{{ $reason->id }}" >{{ $reason->name }}</option>
                                @endforeach
                            </select>                        
                        </div>                     
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="description">Ghi chú</label>
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
@endsection
@section('additional-scripts')
<script src="{{ asset('js/pagination/pagination.min.js') }}" ></script>

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    $(function() {
        bookRender();
        documentRender();

    })
    function bookRender(){
        const container = $('#pagination-1');

  

        if (!container.length) return;
            var sources = function () {
            var result = [];

            $('.book-render-div').each(function(item){

                result.push($(this).get(0).outerHTML);

            })

            return result;

        }();

        var options = {
            dataSource: sources,
            pageSize: 3,
            callback: function (response, pagination) {
                var dataHtml = '';

                $.each(response, function (index, item) {
                    dataHtml += item;
                });


                $('.book-render-div').remove();
                container.parent().prev().append(dataHtml);
            }
        };


  
        container.pagination(options);
    }

    function documentRender(){
        const container = $('#pagination-2');

        if (!container.length) return;
            var sources = function () {
            var result = [];

            $('.document-render-div').each(function(item){

                result.push($(this).get(0).outerHTML);

            })
        return result;
        }();

        var options = {
            dataSource: sources,
            pageSize: 3,
            callback: function (response, pagination) {
                var dataHtml = '';

                $.each(response, function (index, item) {
                    dataHtml += item;
                });


                $('.document-render-div').remove();
                container.parent().prev().append(dataHtml);
            }
        };


  
        container.pagination(options);
    }


    $('.download-btn').click(function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');     
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
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                })
        
    })

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
                const reason = form.find('select[name="reason"]').val();

                if(description){
                        $.ajax({
                        url:'/bao-cao',
                        type:"POST",
                        data:{
                            'description': description,
                            'identifier_id':identifier_id,
                            'type_id':type_id,
                            'reason':reason
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
                            }, 2500);

                            $("#report-div").load(" #report-div > *");

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

    $(document).on('click','.btn-email',function(e){
        e.preventDefault();
        var email = @json($user->email);
        window.location = "mailto:"+email;
        // window.location =  `https://mail.google.com/mail/?view=cm&fs=1&to=${email}&su=${subject}&body=${emailBody}`;
    });
</script>
@endsection
