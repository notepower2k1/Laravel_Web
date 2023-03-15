@extends('client/layouts.app')
@section('pageTitle', `${{$post->topic}}`)
@section('content')
<div class="nk-block">
  <nav>
      <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dien-dan">Diễn đàn</a></li>
          <li class="breadcrumb-item"><a href="/dien-dan/{{ $post->forum->slug }}">{{ $post->forum->name }}</a></li>
          <li class="breadcrumb-item active">{{ $post->topic }}</li>

      </ul>
  </nav>
  <div class="card card-bordered">
      <div class="card-inner">
          <div class="row g-gs flex-lg-row-reverse">
              <div class="col-lg-5">
                  <div class="video">
                      <img class="video-poster w-100" src="{{ $post->url }}" alt="">                   
                  </div>
              </div><!-- .col -->
              <div class="col-lg-7">
                  <div class="entry me-xxl-3">
                   
                    <div class="d-flex align-content-center">
                      <h3>{{ $post->topic }}
                        
                        @if(Auth::check())
                        <button type="button" class="btn btn-icon btn-lg ms-1" data-bs-toggle="modal" data-bs-target="#reportForm">
                          <em class="icon ni ni-alert" style="color:red"></em>
                        </button>
                        @endif
                    </h3>
                     
                      
                    </div>
                      <span class="text-mute ff-italic fw-bold">Đăng bởi: <a href="/thanh-vien/{{ $post->user->id }}" class="text-primary fs-14px">{{ $post->user->profile->displayName }}</a></span>
                      <br>
                      <span class="text-mute ff-italic fw-bold">Ngày đăng: {{ $post->created_at->format("H:i Y/m/d") }} </span>

                    <div id="divhtmlContent">{{ $post->content }}</div>
                  </div>

               
              </div><!-- .col -->
          </div><!-- .row -->
          <div class="d-flex align-items-center border bg-gray-200 p-1 mt-3 fs-11px">
            <em class="icon ni ni-clock"></em>
            <span> Update vào lúc {{  $post->updated_at->format("H:i Y/m/d") }}</span>  
          </div>
        </div>
     
  </div>
</div>
@endsection
@section('modal')
@if(Auth::check())

<div class="modal fade" id="reportForm" style="display: none;" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Báo cáo bài đăng</h5>
              <button id="close-btn" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <em class="icon ni ni-cross"></em>
              </button>
          </div>
          <div class="modal-body">
              <form class="form-validate is-alter" novalidate="novalidate">
                  @csrf
                  <input type="hidden" class="form-control" id="type_id" name="type_id" value=4>
                  <input type="hidden" class="form-control" id="identifier_id" name="identifier_id" value={{ $post->id }}>

                  <div class="form-group">
                      <label class="form-label" for="book-name">Tên thành viên</label>
                      <div class="form-control-wrap">
                          <input type="text" class="form-control" id="book-name" required="" value='{{ $post->topic }}' readonly>
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
@endsection
@section('additional-scripts')

<script>
      var value = document.getElementById('divhtmlContent').textContent;
    document.getElementById('divhtmlContent').innerHTML =
          marked.parse(value);

          $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
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