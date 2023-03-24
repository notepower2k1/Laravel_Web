@extends('client/layouts.app')

@section('additional-style')
@endsection
@section('content')
<div class="nk-content-body">
  <div class="nk-block-head nk-block-head-sm">
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
          </div><!-- .nk-block-head-content -->
      </div><!-- .nk-block-between -->
  </div><!-- .nk-block-head -->
  <div class="nk-block">
    <div class="card card-bordered h-100">

    
    <div class="card-inner">
      <div class="d-flex mb-3">
        <div class="p-2 ">
          @if($next)
          <a href="{{ $next->slug }}" class="btn btn-icon btn-lg btn-primary"><em class="icon ni ni-arrow-long-right"></em></a>
          @else
          <button class="btn btn-icon btn-lg btn-primary" disabled><em class="icon ni ni-arrow-long-right"></em></button>
          @endif
        </div>
        <div class="ms-auto p-2">
          @if($previous)
          <a href="{{ $previous->slug }}"  class="btn btn-icon btn-lg btn-primary"> <em class="icon ni ni-arrow-long-left"></em></a>
          @else
          <button  class="btn btn-icon btn-lg btn-primary" disabled><em class="icon ni ni-arrow-long-left"></em></button>
          @endif

        </div>
      </div>
      
      <div class="feature-box">
      

          {{-- <div class="form-group">
           
          </div> --}}
        
    
      
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
      </div>
      <div class="border px-4 pt-3" id="divhtmlContent" 
        
      style="font-size: 16px;line-height:30px">

      {!! clean($chapter->content) !!}

    </div>   
  </div>
  </div><!-- .nk-block -->
  <div class="nk-add-product toggle-slide toggle-slide-right toggle-screen-any" data-content="addProduct" data-toggle-screen="any" data-toggle-overlay="true" data-toggle-body="true" data-simplebar="init"><div class="simplebar-wrapper" style="margin: -24px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 24px;">
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
                        <select class="form-control" id="change-color">
                          <option value="fff" selected="selected">Mặc định</option>
                          <option value="ddd" >Màu tối</option>
                          <option value="f4f4f4">Xám nhạt</option>
                          <option value="e9ebee">Xanh nhạt</option>
                          <option value="E1E4F2">Xanh đậm</option>
                          <option value="F4F4E4">Vàng nhạt</option>
                          <option value="EAE4D3">Màu sepia</option>
                          <option value="FAFAC8">Vàng đậm</option>
                          <option value="EFEFAB">Vàng ố</option> 
                        </select>
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
                      <div class="form-control-wrap">
                        <input type="hidden" class="fontsize" id="change-fontsize" value=16>
                        <button type="button" class="btn btn-primary size-increment">Tăng</button>
                        <button type="button" class="btn btn-info size-orig">Ban đầu</button>
                        <button type="button" class="btn btn-secondary size-decrement">Giảm</button>
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
  </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 697px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 636px; display: block; transform: translate3d(0px, 0px, 0px);"></div></div></div>
</div>




@endsection

@section('additional-scripts')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

  

  
    
    $(function() {

   
      if(readCookie('setting')){
        var setting = readCookie('setting');
        var color = setting.color;
        var font = setting.font;
        var lightheight = setting.lightheight;
        var currentFontSize = parseInt(setting.fontsize);

        $(`#change-color option[value=${color}]`).attr('selected','selected');
        $(`#change-font option[value=${font}]`).attr('selected','selected');
        $(`#change-lineheight option[value=${lightheight}]`).attr('selected','selected');

        $("#divhtmlContent").css("background-color",'#'+color);
        $("#divhtmlContent").css("font-family",font);
        $("#divhtmlContent").css("line-height",lightheight+'px');
        $("#divhtmlContent").css("font-size",currentFontSize+'px');
        $(".fontsize").val(currentFontSize);
      }
    

  });


    function createCookie(name, value, days) {
        var expires;

        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        } else {
            expires = "";
        }
        document.cookie = encodeURIComponent(name) + "=" + JSON.stringify(value) + expires + "; path=/";
    }

    function readCookie(name) {
      var result = document.cookie.match(new RegExp(name + '=([^;]+)'));
      result && (result = JSON.parse(result[1]));
      return result;
    }

    function eraseCookie(name) {
        createCookie(name, "", -1);
    }

    $('#save-setting').click(function(){

      eraseCookie('setting');
      var color = $('#change-color').val();
      var font = $('#change-font').val();
      var lightheight = $('#change-lineheight').val();
      var currentFontSize = $(".fontsize").val();

      var setting ={
        'color':color,
        'font':font,
        'lightheight':lightheight,
        'fontsize':currentFontSize

      }
      createCookie('setting',setting);
      Swal.fire({
                        icon: 'success',
                        title: `Lưu cài đặt thành công!!!`,
                        showConfirmButton: false,
                        timer: 2500
          })
    })

  $("#change-color").change(function(){ //2 step
        var color = $(this).val();
        $("#divhtmlContent").css("background-color",'#'+color);
      });

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
            $(".fontsize").val(currentFontSize + 1);
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
            $(".fontsize").val(currentFontSize - 1);
          }
       

      })




 </script>


@endsection