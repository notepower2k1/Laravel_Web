@extends('admin/layouts.app')
@section('content')

<h1 class="h3 mb-2 text-gray-800">Cập nhật truyện</h1>
	<div class="card shadow mb-4">
		<div class="card-body ">
			<form action="/admin/forum/{{ $forum->id }}" method="POST">

                @csrf
                @method('PUT')
                <label>Tên truyện<sup>*</sup></label>
                <input type="text" required
               name="name"
               value="{{ $forum->name }}"
                class="form-control mb-4 col-6"
               >
                
                <label>Mô tả</label>
                <textarea 
               cols="50" 
               rows="20" 
               name="description"
               class="form-control mb-4"
               id="mytextarea"

               >{{ $forum -> description }}</textarea>

		 		<button type="submit" class="btn btn-info">Cập nhật diễn đàn</button>
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