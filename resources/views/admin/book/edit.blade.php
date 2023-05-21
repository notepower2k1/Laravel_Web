@extends('admin/layouts.app')
@section('pageTitle', 'Cập nhật sách điện tử')
@section('content')
<ul class="breadcrumb breadcrumb-arrow">
    <li class="breadcrumb-item"><a href="/admin/book">Sách</a></li>
    <li class="breadcrumb-item active"><a href="#">Cập nhật</a></li>
  </ul>
<hr>   
	<div class="card shadow mb-4">
		<div class="card-body ">
                @if($errors->any())
                <div class="alert alert-warning">
                    @foreach ($errors->all() as $error)
                        <div class="">{{ $error }}</div>
                    @endforeach

                </div>
                @endif
			<form action="/admin/book/{{ $book->id }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')
                <label>Tên truyện<sup>*</sup></label>
                <input type="text" required
               name="name" 
               value="{{ $book->name }}"
                class="form-control mb-4 col-6"
               >
           

               
                <label>Thể loại<sup>*</sup></label>
                <select required class="form-control col-6"  name="book_type_id" id="book_type_id">
                   @foreach ($types as $type)
                    <option value="{{ $type->id }}" {{ $book->type_id == $type->id ? 'selected' : '' }} >{{ $type->name }}</option>
                    @endforeach
                </select>

                <label class="mt-4">Tác giả<sup>*</sup></label>
                <input type="text" required
                name="author"
                value="{{ $book -> author }}"

                class="form-control mb-4 col-6">	 			 	
            
                <label class="">Ảnh bìa<sup>*</sup></label>

                <div class="mb-2" style="display:none">
                    <canvas id="the-canvas" style="border:1px solid black;width:200px;height:300px" ></canvas>
                </div>
                <div class="mb-2" id="default-image-loading">
                    <img src="{{ $book->url }}" alt="img" style="border:1px solid black;width:200px;height:300px" loading="lazy">
                </div>
    
    
                <input type="file"
                name="image" id="imageFileInput" required
                class="form-control mb-4 col-6" accept="image/*" data-bs-toggle="tooltip" data-bs-placement="top" title="Nếu bạn để trống hệ thống sẽ sử dụng ảnh mặc định!!!">
                       
                <input name="oldImage" type="hidden" value="{{ $book -> image }}">

                <label>Mô tả</label>
                <textarea 
                name="description"
                class="form-control mb-4"
                >{{ $book -> description }}</textarea>


                <label>Tiến độ<sup>*</sup></label>
                <select required class="form-control mb-4 col-6"  name="isCompleted"> 
                <option value=0 {{ $book->isCompleted == 0 ? 'selected' : '' }} >Chưa hoàn thành</option>
                <option value=1 {{ $book->isCompleted == 1 ? 'selected' : '' }} >Đã hoàn thành</option>
                </select>

		 		<button type="submit" class="btn btn-info">Cập nhật truyện</button>
		 	</form>
   		</div>
	</div>
	
    



@endsection
@section('additional-scripts')

   

<script>

 
    
    $("button[type=submit]").click(function() {

        $(this).attr("disabled","disabled");

            Swal.fire({
            title: 'Đang thêm dữ liệu!',
            text: 'Vui lòng đợi thêm dữ liệu.',
            imageUrl: 'https://raw.githubusercontent.com/notepower2k1/MyImage/main/gif/codevember-day-6-bookshelf-loader.gif',
            imageWidth: 400,
            imageHeight: 200,
            imageAlt: 'Custom image',
            showConfirmButton: false
        });


        $(this).parent().submit();
    });
    
    $('#book_type_id').select2({
    });

    $("#imageFileInput").change(function() {

        const file = this.files[0]

        if (file) {
            $('#default-image-loading').remove();
            $('#the-canvas').parent().show();
            var canvas = document.getElementById('the-canvas');
            var ctx = canvas.getContext('2d');
            var url = URL.createObjectURL(file);
            var img = new Image();

            img.onload = function() {
                var ratio = this.height / this.width;
                canvas.height = canvas.width * ratio;   

                ctx.drawImage(this, 0, 0,canvas.width, canvas.height);    
            }
            img.src = url;
        }
    })
    
</script>

@endsection