@extends('admin/layouts.app')
@section('content')

<h1 class="h3 mb-2 text-gray-800">Thêm truyện</h1>
	<div class="card shadow mb-4">
		<div class="card-body ">
			<form action="{{ route('book.store') }}" method="POST" enctype="multipart/form-data">

                @csrf
		 		<label>Tên truyện<sup>*</sup></label>
		 		<input type="text" required
                name="name"
		 		class="form-control mb-4 col-6">
		 		
		 		<label>Thể loại<sup>*</sup></label>


		 		<select required class="form-control mb-4 col-6" name="type_id">
                    @foreach ($types as $type)
		 			<option value="{{ $type->id }}" >{{ $type->name }}</option>
                     @endforeach

		 		</select>

		 		<label>Tác giả<sup>*</sup></label>
		 		<input type="text" required
                 name="author"
		 		class="form-control mb-4 col-6">	 			 	
		 	
		 		<label>Ảnh đại diện<sup>*</sup></label>
		 		<input type="file" required
                 name="image"
		 		class="form-control mb-4 col-6">
		 			 		
		 		<label>Mô tả</label>
		 		<textarea 
                cols="50" 
                rows="20" 
                name="description"
                class="form-control mb-4"
				id="mytextarea"
                ></textarea>

		 		<button type="submit" class="btn btn-info">Thêm truyện</button>
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
        plugins: [
            "advlist", "anchor", "autolink", "charmap", "code", "fullscreen", 
            "help", "image", "insertdatetime", "link", "lists", "media", 
            "preview", "searchreplace", "table", "visualblocks", " wordcount",
        ],
        toolbar: "undo redo | styles | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | wordcount"
        
    });

</script>
@endsection