@extends('client/layouts.app')
@section('content')

<!-- Page Introduction Wrapper /- -->
<!-- Blog-Detail-Page -->
{{-- <form action="/book/chapter/{{ $chapter->id }}" method="post" >
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-danger" disabled>
      Delete
    </button>
  </form>
<a href="{{ $chapter->id }}/edit" class="btn btn-primary">Cập nhật</a> --}}

<div class="page-blog-detail u-s-p-t-80">
    <div class="container">
        <h1 class="text-center font-weight-bold"></h1>
        <h2 class="blog-post-detail-heading text-center">
        {{$chapter->code}}
          @if($chapter->name)
          <span>: {{ $chapter->name }}</span>
           @else
           
           @endif
        
        </h2>

        <div class="feature-box">

          <div class="form-group">
            <label for="exampleFormControlSelect2">Chon chuong</label>
            <select class="form-control" id="change-chapter">
              @foreach ($chapters as $item)
              <option value="{{ $item->id }}" {{ $item->id == $chapter->id ? 'selected' : '' }}>
                  {{$item->code}}
                  @if($item->name)
                  <span>: {{ $item->name }}</span>
                    @else
                    
                    @endif         
              </option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="exampleFormControlSelect2">Màu sắc</label>
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


          <div class="form-group">
            <label for="exampleFormControlSelect2">Font chữ</label>
            <select class="form-control" id="change-font">
              <option value="Segoe UI" selected="selected">Mặc định</option>
              <option value="Palatino Linotype" >Palatino Linotype</option>
              <option value="Bookerly">Bookerly</option>
              <option value="Patrick Hand">Patrick Hand</option>
              <option value="Times New Roman">Times New Roman</option>
              <option value="Verdana">Verdana</option>
              <option value="Tahoma">Tahoma</option>
              <option value="Arial">Arial</option>
            </select>
          </div>

          <div class="form-group">
            <label for="exampleFormControlSelect2">Chiều cao dòng</label>
            <select class="form-control" id="change-lineheight">
              <option value="40" selected="selected">40</option>
              <option value="60">60</option>
              <option value="80">80</option>
              <option value="100">100</option>
              <option value="120">120</option>
            </select>
          </div>

          <div class="form-group">
            <label for="exampleFormControlSelect2">Kích thước chữ</label>
            <input type="hidden" class="fontsize" value=12>
            <button type="button" class="btn btn-primary size-increment">Tăng</button>
            <button type="button" data-orig_size="25px" class="btn btn-info size-orig">Ban đầu</button>
            <button type="button" class="btn btn-secondary size-decrement">Giảm</button>
          </div>

        </div>
        <div class="blog-post-info u-s-m-b-13">
            <span class="blog-post-preposition">Đăng bởi</span>
            <a class="blog-post-author-name" href="#">Admin</a>
            <span class="blog-post-info-separator">/</span>
            <span class="blog-post-published-date">
                 <span></span>
            </span>
            
            
       
        </div>
      
           
            <div class="border px-4 pt-3" id="divhtmlContent" >{{ $chapter->content }}</div>   
     
            
              
           
         
        
     </div>
</div>
 </section>



@endsection
@section('additional-scripts')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

    var value = document.getElementById('divhtmlContent').textContent;
    document.getElementById('divhtmlContent').innerHTML =
          marked.parse(value);

   
    
    $(function() {
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
        var chapterID = $(this).val();
        
        $(location).prop('href', chapterID);

      });

      $(".size-increment").on("click", function(){
          var currentFontSize = parseInt($(".fontsize").val());
          $("#divhtmlContent").css("font-size",(currentFontSize + 1) +'pt');
          $(".fontsize").val(currentFontSize + 1);

      })

      $(".size-orig").on("click", function(){
          $("#divhtmlContent").css("font-size",'12pt');
          $(".fontsize").val(12);

      })

      $(".size-decrement").on("click", function(){
          var currentFontSize = parseInt($(".fontsize").val());
          $("#divhtmlContent").css("font-size",(currentFontSize - 1) +'pt');
          $(".fontsize").val(currentFontSize - 1);

      })
  });

 </script>


@endsection