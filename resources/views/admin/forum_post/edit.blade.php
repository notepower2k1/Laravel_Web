@extends('admin/layouts.app')
@section('pageTitle', 'Cập nhật bài đăng')
@section('content')
<div class="nk-block-head-sub"><a class="back-to" href="{{ url()->previous() }}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>
	<div class="card shadow mb-4">
		<div class="card-body ">
			<form action="/admin/forum/post/{{ $forum_post->id }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')
                <label>Chủ đề<sup>*</sup></label>
                <input type="text" required
               name="topic"
               value="{{ $forum_post->topic }}"
                class="form-control mb-4 col-6">

                <label>Ảnh đại diện<sup>*</sup></label>
                <input type="file"
                name="image"
                value="{{ $forum_post -> image }}"
                class="form-control mb-4 col-6">
                        
                <input name="oldImage" type="hidden" value="{{ $forum_post -> image }}">
                <label>Nội dung</label>
                <textarea 
               cols="50" 
               rows="20" 
               name="content"
               class="form-control mb-4"
               id="mytextarea"

               >{{ $forum_post -> content }}</textarea>

               <input name="forum_id" type="hidden" value="{{ $forum_post->forumID  }}">

		 		<button type="submit" class="btn btn-info">Cập nhật bài đăng</button>
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