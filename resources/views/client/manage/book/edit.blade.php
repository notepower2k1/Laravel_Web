@extends('client/layouts.app')
@section('pageTitle', 'Cập nhật sách điện tử')
@section('content')
<div class="nk-block-head-sub"><a class="back-to" href="{{ url()->previous() }}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>

	<div class="card shadow mb-4">
		<div class="card-body ">
			<form action="/quan-ly/sach/{{ $book->id }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')
                <label>Tên truyện<sup>*</sup></label>
                <input type="text" required
                name="name"
                value="{{ $book->name }}"
                class="form-control mb-4 col-6 @error('name') is-invalid @enderror"
                >
                
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                
                <label>Thể loại<sup>*</sup></label>
                <select required class="form-control mb-4 col-6"  name="type_id">
                   @foreach ($types as $type)
                    <option value="{{ $type->id }}" {{ $book->type_id == $type->id ? 'selected' : '' }} >{{ $type->name }}</option>
                    @endforeach
                </select>

                <label>Tác giả<sup>*</sup></label>
                <input type="text" required
                name="author"
                value="{{ $book -> author }}"

                class="form-control mb-4 col-6  @error('author') is-invalid @enderror">	 			 	
            
                @error('author')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label>Ảnh đại diện<sup>*</sup></label>
                <input type="file"
                name="image"
                value="{{ $book -> image }}"
                class="form-control mb-4 col-6 @error('file') is-invalid @enderror">
                  
                
                @error('file')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <input name="oldImage" type="hidden" value="{{ $book -> image }}">

                <label>Mô tả</label>
                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <textarea 
                name="description"
                class="form-control mb-4 @error('description') is-invalid @enderror"
                id="mytextarea"
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
    tinymce.init({
        entity_encoding : "raw",
        selector: '#mytextarea',
        branding: false,
        statusbar: false,
        height: 1000,
        resize: false,
         menubar: false,
        plugins: [
            "advlist", "anchor", "autolink", "charmap", "code", "fullscreen", 
            "help", "image", "insertdatetime", "link", "lists", "media", 
            "preview", "searchreplace", "table", "visualblocks", " wordcount",
        ],
        toolbar: "undo redo | styles | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | wordcount"
        
    });

</script>
@endsection