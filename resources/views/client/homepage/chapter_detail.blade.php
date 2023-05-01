@extends('client/homepage.layouts.app')

@section('additional-style')
<style>
/*
*************************************************

---   SECTION   --->   TOP
   
*************************************************
*/

.btn2top .sticky-btn {
  position: fixed;
  bottom: -96px;
  right: 60px;
  background: dodgerblue;
  opacity: .6;
  border-radius: 50%;
  transition: all 0.9s ease;
}
.btn2top .sticky-btn img {
  width: 36px;
  height: 36px;
}
.btn2top .sticky-btn.revealed {
  bottom: 36px;
  opacity: 1;
}
.btn2top a.sticky-btn {
  font-family: sans-serif;
  padding: 9px;
  display: block;
  transition: all 0.3s ease;
  color: #fff;
  text-decoration: none;
}
.btn2top a.sticky-btn:hover {
  color: yellow;
  cursor: pointer;
}

@media screen and (max-width: 768px) {
  .btn2top .sticky-btn {
    right: 21px;
  }  
  .btn2top .sticky-btn.revealed {
    bottom: 21px;
  }
}

/*
*************************************************
---   SECTION   --->   WHATSAPP-STICKY  
*************************************************
*/


.btn2contact .sticky-btn {
  position: fixed;
  bottom: -96px;
  left: 33px;
  background: rgba(255, 255, 255, 0.81);
  padding: 12px;
  border-radius: 50%;
  transition: all 0.8s ease;
}
.btn2contact .sticky-btn:hover {
  cursor: pointer;

  background: rgba(255, 255, 255, 0.81);
  transform: translateY(-3px);
}
.btn2contact .sticky-btn img {
  width: 45px;
}

.btn2contact .sticky-btn.revealed {
  bottom: 36px;
  opacity: 1;
}

@media screen and (max-width: 768px) {
  .btn2contact .sticky-btn {
    left: 21px;
  } 
  .btn2contact .sticky-btn img {
    width: 36px;
  }
  .btn2contact .sticky-btn.revealed {
    bottom: 21px;
  } 
}
 
</style>
@endsection
@section('content')
<div class="nk-content-body">
  {{-- <div class="popup-btn">
    <div class="toggle-expand-content expanded" data-content="pageMenu" style="display: block;">
      <ul class="nk-block-tools g-3">   
          <li class="nk-block-tools-opt">
              <a href="#" data-target="addProduct" class="toggle btn btn-icon btn-primary d-md-none"><em class="icon ni ni-setting"></em>Icon</a>
              <a href="#" data-target="addProduct" class="toggle btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-setting"></em>Icon</a>
          </li>
      </ul>
  </div>
  </div>   --}}
  {{-- <div class="nk-block-head nk-block-head-sm">
      <div class="nk-block-between">
          <div class="nk-block-head-content">
            <div class="toggle-expand-content expanded" data-content="pageMenu" style="display: block;">
                <ul class="nk-block-tools g-3">   
                    <li class="nk-block-tools-opt">
                        <a href="#" data-target="addProduct" class="toggle btn btn-icon btn-primary d-md-none"><em class="icon ni ni-setting"></em></a>
                        <a href="#" data-target="addProduct" class="toggle btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-setting"></em></a>
                    </li>
                </ul>
            </div>
          </div>
      </div>
  </div> --}}
    <div class="nk-block" id="content-box-detail">
      <div class="container">
        <div class="card card-bordered h-100">

        
          <div class="card-inner">
            <div class="d-flex mb-3">
              <div class="p-2 ">
                @if($previous)
                <a href="{{ $previous->slug }}"  class="btn btn-icon btn-lg btn-primary">
                  <em class="icon ni ni-arrow-long-left"></em>
                  </a>
                @else
                <button  class="btn btn-icon btn-lg btn-primary" disabled><em class="icon ni ni-arrow-long-left"></em></button>
                @endif
              </div>
              <div class="ms-auto p-2">
              
                @if($next)
                <a href="{{ $next->slug }}" class="btn btn-icon btn-lg btn-primary">
                  <em class="icon ni ni-arrow-long-right"></em>
                </a>
                @else
                <button class="btn btn-icon btn-lg btn-primary" disabled><em class="icon ni ni-arrow-long-right"></em></button>
                @endif
              </div>
            </div>
            
          
            <div class="title">
            @if($chapter->name)
            <h3 class="text-left">       
              {{$chapter->code}}: {{ $chapter->name }}
              </h3>
              @else
              <h3 class="text-left">       
                {{$chapter->code}}
              </h3>
              @endif
    
            
            </div>
    
            <div class="d-flex bg-light">
              <div class="p-2 flex-fill bg-light">
                <em class="icon ni ni-book"></em>
                <a href="/sach/{{$chapter->books->id  }}/{{ $chapter->books->slug  }}">{{ $chapter->books->name }}</a>
              </div>
              <div class="p-2 flex-fill bg-light">
                <em class="icon ni ni-edit"></em>          
                <a href="/thanh-vien/{{ $chapter->books->users->id }}">{{ $chapter->books->users->profile->displayName }}</a>
              </div>
              <div class="p-2 flex-fill bg-light">
                <em class="icon ni ni-text"></em>
                <span>{{ $chapter->numberOfWords }} chữ</span>
              </div>
              <div class="p-2 flex-fill bg-light">
                <em class="icon ni ni-clock"></em>          
                <span>{{ $chapter->updated_at }}</span>
              </div>
    
              @if(Auth::check())
    
              <button type="button" class="btn btn-icon btn-lg ms-1" data-bs-toggle="modal" data-bs-target="#reportForm">
                <em class="icon ni ni-alert" style="color:red"></em>
              </button>
    
              @endif
            </div>
            <div class="border px-4 pt-3" id="divhtmlContent" 
              
            style="font-size: 16px;line-height:30px">
    
            {!! clean($chapter->content) !!}
    
            </div>  
            <div class="d-flex mt-3">
              <div class="p-2 ">
                @if($previous)
                <a href="{{ $previous->slug }}"  class="btn btn-icon btn-lg btn-primary">
                  <em class="icon ni ni-arrow-long-left"></em>
                  </a>
                @else
                <button  class="btn btn-icon btn-lg btn-primary" disabled><em class="icon ni ni-arrow-long-left"></em></button>
                @endif
              </div>
              <div class="ms-auto p-2">
              
                @if($next)
                <a href="{{ $next->slug }}" class="btn btn-icon btn-lg btn-primary">
                  <em class="icon ni ni-arrow-long-right"></em>
                </a>
                @else
                <button class="btn btn-icon btn-lg btn-primary" disabled><em class="icon ni ni-arrow-long-right"></em></button>
                @endif
              </div>
            </div> 
          </div>
        </div>
      </div>
  
  



      <div class="btn2top">
        <a class="sticky-btn">
          <img src="https://byjaris.com/code/icons/chevron-up.svg">
        </a>
      </div>
      
      
      <div class="btn2contact">
        <a target="blank" class="toggle sticky-btn" data-target="addProduct"> 
          <img src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/svg/configure-svgrepo-com.svg">
        </a>
      </div>
    </div>


    <div class="nk-add-product toggle-slide toggle-slide-right toggle-screen-any" data-content="addProduct" data-toggle-screen="any" data-toggle-overlay="true" data-toggle-body="true" data-simplebar="init">
      <div class="simplebar-wrapper" style="margin: -24px;">
          <div class="simplebar-height-auto-observer-wrapper">
            <div class="simplebar-height-auto-observer">
            </div>
          </div>
            <div class="simplebar-mask">
        <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
          <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
            <div class="simplebar-content" style="padding: 24px;">
              <div class="nk-block-head">
                  <div class="nk-block-head-content">
                    <div class="form-group">
                      <label class="form-label" for="product-title">Danh sách chương</label>
                      <div class="form-control-wrap">
                        <select class="form-control" id="change-chapter">
                          @foreach ($chapters as $item)
                          <option value="{{ $item->slug }}" {{ $item->id == $chapter->id ? 'selected' : '' }}>
                            
                              <span>{{$item->code}}</span>
                              
                          </option>
                          @endforeach
                        </select>
                      </div>
                  </div>
                      
                  <h5 class="nk-block-title">Cài đặt hiển thị</h5>

                  </div>
              </div><!-- .nk-block-head -->
              <div class="nk-block">
                  <div class="row g-3">
                      <div class="col-12">
                          <div class="form-group">
                              <label class="form-label" for="product-title">       
                                <span>Màu nền
                                </span>
                                <em class="icon ni ni-color-palette"></em>
                              </label>
                              <div class="form-control-wrap">                  
                                <ul class="custom-control-group g-1">
                                  <li>
                                      <div class="custom-control color-control border rounded-circle">
                                          <input type="radio" class="custom-control-input" id="productColor1" name="productColor">
                                          <label class="custom-control-label dot dot-xl" data-bg="#fff" for="productColor1" style="background:#fff"></label>
                                      </div>
                                  </li>
                                  <li>
                                      <div class="custom-control color-control border rounded-circle">
                                          <input type="radio" class="custom-control-input" id="productColor2" name="productColor">
                                          <label class="custom-control-label dot dot-xl" data-bg="#ddd" for="productColor2" style="background:#ddd"></label>
                                      </div>
                                  </li>
                                  <li>
                                      <div class="custom-control color-control border rounded-circle">
                                          <input type="radio" class="custom-control-input" id="productColor3" name="productColor">
                                          <label class="custom-control-label dot dot-xl" data-bg="#f4f4f4" for="productColor3" style="background:#f4f4f4"></label>
                                      </div>
                                  </li>
                                  <li>
                                      <div class="custom-control color-control border rounded-circle">
                                          <input type="radio" class="custom-control-input" id="productColor4" name="productColor">
                                          <label class="custom-control-label dot dot-xl" data-bg="#e9ebee" for="productColor4" style="background:#e9ebee"></label>
                                      </div>
                                  </li>
                                  <li>
                                      <div class="custom-control color-control border rounded-circle">
                                          <input type="radio" class="custom-control-input" id="productColor5" name="productColor">
                                          <label class="custom-control-label dot dot-xl" data-bg="#E1E4F2" for="productColor5" style="background:#E1E4F2"></label>
                                      </div>
                                  </li>
                                  <li>
                                      <div class="custom-control color-control border rounded-circle">
                                          <input type="radio" class="custom-control-input" id="productColor6" name="productColor">
                                          <label class="custom-control-label dot dot-xl" data-bg="#F4F4E4" for="productColor6" style="background:#F4F4E4"></label>
                                      </div>
                                  </li>
                                  <li>
                                      <div class="custom-control color-control border rounded-circle">
                                          <input type="radio" class="custom-control-input" id="productColor7" name="productColor">
                                          <label class="custom-control-label dot dot-xl" data-bg="#EAE4D3"  for="productColor7" style="background:#EAE4D3"></label>
                                      </div>
                                  </li>
                                  <li>
                                      <div class="custom-control color-control border rounded-circle">
                                          <input type="radio" class="custom-control-input" id="productColor8" name="productColor">
                                          <label class="custom-control-label dot dot-xl" data-bg="#FAFAC8" for="productColor8" style="background:#FAFAC8"></label>
                                      </div>
                                  </li>
                                  <li>
                                      <div class="custom-control color-control border rounded-circle">
                                          <input type="radio" class="custom-control-input" id="productColor9" name="productColor">
                                          <label class="custom-control-label dot dot-xl"  data-bg="#EFEFAB" for="productColor9" style="background:#EFEFAB"></label>
                                      </div>
                                  </li>
                              
                                </ul>
                              </div>
                          </div>
                      </div>
                      <div class="col-12">
                          <div class="form-group">
                              <label class="form-label" for="regular-price">
                                <span>Font chữ
                                </span>
                                <em class="icon ni ni-text"></em>
                              </label>
                              <div class="form-control-wrap">
                                <select class="form-control" id="change-font">
                                  <option value="Roboto" selected="selected">Mặc định</option>
                                  <option value="Segoe UI">Segoe UI</option>
                                  <option value="Palatino Linotype" >Palatino Linotype</option>
                                  <option value="Bookerly">Bookerly</option>
                                  <option value="Patrick Hand">Patrick Hand</option>
                                  <option value="Times New Roman">Times New Roman</option>
                                  <option value="Verdana">Verdana</option>
                                  <option value="Tahoma">Tahoma</option>
                                  <option value="Arial">Arial</option>
                                </select>
                              </div>
                          </div>
                      </div>
                      <div class="col-12">
                          <div class="form-group">
                              <label class="form-label" for="sale-price">
                                <span>Độ cao dòng
                                </span>
                                <em class="icon ni ni-view-x7"></em>
                              </label>
                              <div class="form-control-wrap">
                                <select class="form-control" id="change-lineheight">
                                  <option value="30" selected="selected">Mặc định</option>
                                  <option value="40">40</option>
                                  <option value="50">50</option>
                                  <option value="60">60</option>
                                </select>
                              </div>
                          </div>
                      </div>
                      <div class="col-12">
                          <div class="form-group">
                              <label class="form-label" for="stock">
                                <span>Cỡ chữ
                                </span>
                                <em class="icon ni ni-text2"></em>
                              </label>
                              <div class="form-control-wrap number-spinner-wrap">
                                {{-- <input type="hidden" class="fontsize" id="change-fontsize" value=16>
                                <button type="button" class="btn btn-primary size-increment">Tăng</button>
                                <button type="button" class="btn btn-info size-orig">Ban đầu</button>
                                <button type="button" class="btn btn-secondary size-decrement">Giảm</button> --}}
                                <button class="btn btn-icon btn-outline-light number-spinner-btn number-minus size-decrement" data-number="minus"><em class="icon ni ni-minus"></em></button>
                                <input type="number" class="form-control number-spinner fontsize" value="16" id="change-fontsize" step="1" min="10" max="30">
                                <button class="btn btn-icon btn-outline-light number-spinner-btn number-plus size-increment" data-number="plus"><em class="icon ni ni-plus"></em></button>
                              </div>
                          </div>
                      </div>
                      {{-- <div class="col-12">
                          <div class="form-group">
                              <label class="form-label" for="SKU">SKU</label>
                              <div class="form-control-wrap">
                                  <input type="text" class="form-control" id="SKU">
                              </div>
                          </div>
                      </div>
                  
                      <div class="col-12">
                          <div class="upload-zone small bg-lighter my-2 dropzone dz-clickable">
                              <div class="dz-message">
                                  <span class="dz-message-text">Drag and drop file</span>
                              </div>
                          </div>
                      </div> --}}
                      <div class="col-12">
                          <button class="btn btn-primary" id="save-setting"><em class="icon ni ni-plus"></em><span>Lưu cài đặt</span></button>
                      </div>

                      <div class="col-12">
                        <a href="/sach-noi/{{ $chapter->books->slug }}/{{  $chapter->slug }}" class="btn btn-primary w-75" >
                          <em class="icon ni ni-headphone"></em><span>Chuyển sang sách nói</span>
                        </a>
                      </div>
                  </div>
              </div><!-- .nk-block -->
            </div>
          </div>
        </div>
      </div>
    <div class="simplebar-placeholder" style="width: auto; height: 697px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 636px; display: block; transform: translate3d(0px, 0px, 0px);"></div></div></div>
</div>


@endsection
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
                    <input type="hidden" class="form-control" id="type_id" name="type_id" value=2>
                    <input type="hidden" class="form-control" id="identifier_id" name="identifier_id" value={{ $chapter->id }}>

                    <div class="form-group">
                        <label class="form-label" for="chapter-code">Tên chương</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="chapter-code" required="" value='{{ $chapter->code }}' readonly>
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
@section('additional-scripts')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<script>

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

  
    
    $(function() {

      
      $('.btn2top').on('click', function() {
          window.scrollTo({top: 0})
      });

      var scroll_offset = 120;
        $(window).scroll(function(){
          var $this = $(window);


          if( $this.scrollTop() > ($('#content-box-detail').height() - 600) ) { 
            $('.sticky-btn').hide();


          }
          else{
            $('.sticky-btn').show();

          }
        
          if( $('.sticky-btn').length ) {
            if( $this.scrollTop() > scroll_offset ) { 
              $('.sticky-btn').addClass('revealed');
            } else {
              $('.sticky-btn').removeClass('revealed');
            }	
          }

        
         

          });
          
          $('#change-chapter').select2({});

      const settingLog = window.localStorage.getItem('setting');
     
      if(settingLog){
        var setting = JSON.parse(settingLog);

        var color = setting.color;
        var font = setting.font;
        var lightheight = setting.lightheight;
        var currentFontSize = parseInt(setting.fontsize);

        // $(`#change-color option[value=${color}]`).attr('selected','selected');
        $(`label[data-bg='${color}']`).parent().addClass('checked');
        $(`label[data-bg='${color}']`).prev().attr('checked', true);


        $(`#change-font option[value='${font}']`).attr('selected','selected');
        $(`#change-lineheight option[value=${lightheight}]`).attr('selected','selected');

        $("#divhtmlContent").css("background-color",color);
        $("#divhtmlContent").css("font-family",font);
        $("#divhtmlContent").css("line-height",lightheight+'px');
        $("#divhtmlContent").css("font-size",currentFontSize+'px');
        $(".fontsize").val(currentFontSize);
      }
      else{
        $(`label[data-bg='#fff']`).prev().attr('checked', true);

      }

   
      const current_book_id = {!! $chapter->books->id !!}
      var chapter_id =  {!! $chapter->id !!}

      var readingLog = window.localStorage.getItem('readingLog');

      var log = JSON.parse(readingLog);


      //update cookie
      if(log){             
          objIndex = log.findIndex((obj => obj.book_id == current_book_id));
          //book exist
          if(objIndex > -1){
              var currentChapterList = log[objIndex].chapter_id;
              if(currentChapterList.includes(chapter_id)){

              }
              else{
                  const updateChapterList = [...currentChapterList,chapter_id]
                  log[objIndex].chapter_id = updateChapterList;

                  window.localStorage.setItem('readingLog',JSON.stringify(log));
              }
              
          }
          //book not exist
          else{
              var chapter_list = [];
              chapter_list.push(chapter_id);

              var reading_object = {
              'book_id' : current_book_id,
              'chapter_id' : chapter_list        
              };       
              const updateLog = [...log,reading_object]
              window.localStorage.setItem('readingLog',JSON.stringify(updateLog));

          }        
      }
      //create new cookie
      else{
          var chapter_list = [];
          chapter_list.push(chapter_id);
          var reading_object = {
          'book_id' : current_book_id,
          'chapter_id' : chapter_list        
          };            
          var reading_log = [];
          reading_log.push(reading_object);
          window.localStorage.setItem('readingLog',JSON.stringify(reading_log));

      }

      
  });


    
    $('#save-setting').click(function(){


      window.localStorage.removeItem("setting");

      var color = $('.color-control.checked').find('label').data('bg');
      var font = $('#change-font').val();
      var lightheight = $('#change-lineheight').val();
      var currentFontSize = $(".fontsize").val();

      var setting ={
        'color':color,
        'font':font,
        'lightheight':lightheight,
        'fontsize':currentFontSize

      }
      // createCookie('setting',setting);
      window.localStorage.setItem("setting", JSON.stringify(setting));

      Swal.fire({
                        icon: 'success',
                        title: `Lưu cài đặt thành công!!!`,
                        showConfirmButton: false,
                        timer: 2500
          })


    })

    $('.color-control').change(function(){

      var color = $(this).find('label').data('bg');
      $("#divhtmlContent").css("background-color",color);

    })


    $("#change-font").change(function(){ //2 step
      var font = $(this).val();
      $("#divhtmlContent").css("font-family",font);
    });


    $("#change-lineheight").change(function(){ //2 step
      var lightheight = $(this).val();
      $("#divhtmlContent").css("line-height",lightheight+'px');
    });

    $("#change-chapter").change(function(){ //2 step
      var chapter_slug = $(this).val();  


      var chapter_id = $(this).find('option:selected').data('id')


      $(location).prop('href', chapter_slug);
    });


      $(".size-increment").on("click", function(){
          var currentFontSize = parseInt($(".fontsize").val());

          if(currentFontSize === 30){
            Swal.fire({
                        icon: 'info',
                        title: `Không thể tăng cỡ chữ`,
                        showConfirmButton: false,
                        timer: 2500
          })
        }
          else{
            $("#divhtmlContent").css("font-size",(currentFontSize + 1) +'px');
          }

      

      })

      $(".size-orig").on("click", function(){
          $("#divhtmlContent").css("font-size",'16px');
          $(".fontsize").val(16);

      })

      $(".size-decrement").on("click", function(){
          var currentFontSize = parseInt($(".fontsize").val());

          if(currentFontSize === 10){
            Swal.fire({
                        icon: 'info',
                        title: `Không thể giảm cỡ chữ`,
                        showConfirmButton: false,
                        timer: 2500
          });
          }
          else{
            $("#divhtmlContent").css("font-size",(currentFontSize - 1) +'px');
          }
       

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
                            }, 2500);
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