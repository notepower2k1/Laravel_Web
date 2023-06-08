@extends('admin/layouts.app')
@section('pageTitle', 'Cập nhật bài đăng')
@section('content')
<ul class="breadcrumb breadcrumb-arrow">
    <li class="breadcrumb-item"><a href="/admin/forum">Diễn đàn</a></li>
    <li class="breadcrumb-item"><a href="/admin/forum/post/{{ $forum_post->forumID }}">Bài đăng</a></li>
    <li class="breadcrumb-item active">Cập nhật</li>

</ul>	
<div class="card shadow mb-4">
		<div class="card-body ">
            @if($errors->any())
            <div class="alert alert-warning">
                @foreach ($errors->all() as $error)
                    <div class="">{{ $error }}</div>
                @endforeach

            </div>
            @endif
			<form action="/admin/forum/post/{{ $forum_post->id }}" method="POST" id="editForm">

                @csrf
                @method('PUT')
                <label class="form-label">Chủ đề<sup>*</sup></label>
                <input type="text" required
               name="topic"
               value="{{ $forum_post->topic }}"
                class="form-control mb-4 col-6">

           
    
              
                <label class="form-label">Nội dung</label>
                <textarea 
               cols="50" 
               rows="20" 
               name="content"
               class="form-control mb-4"
               id="mytextarea"

               >{{ $forum_post -> content }}</textarea>

               <input name="forum_id" type="hidden" value="{{ $forum_post->forumID  }}">

		 	</form>
             <button id="add-btn" class="btn btn-info">Cập nhật bài đăng</button>

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
    

  $(function () {
        tinymce.init({
        entity_encoding : "raw",
        selector: '#mytextarea',
        branding: false,
        statusbar: false,
        height: 800,
        resize: false,
        menubar: false,
        plugins: [
            "advlist", "anchor", "autolink", "charmap", "code", "fullscreen", 
            "help", "image", "insertdatetime", "link", "lists", "media", 
            "preview", "searchreplace", "table", "visualblocks",
        ],
        toolbar: "undo redo |  bold italic underline strikethrough | link image | forecolor ",
        image_title: true,
        /* enable automatic uploads of images represented by blob or data URIs*/
        images_upload_url: '/upload',
        automatic_uploads: false,
        file_picker_types: 'image',
        /* and here's our custom image picker*/
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function () {
            var file = this.files[0]; 
            var reader = new FileReader();
            reader.onload = function () {
                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);

                /* call the callback and populate the Title field with the file name */
                cb(blobInfo.blobUri(), { title: file.name });
            };
            reader.readAsDataURL(file);
            };

            input.click();
        },
        content_style: 'body { font-size: 16px; font-family: Roboto; }' 
        });

    })
    

  


    $('#add-btn').click(function(){
        var content = tinymce.activeEditor.getContent("myTextarea");
        if(content){

        tinymce.activeEditor.uploadImages().then((response)=>{
        var update_content = tinymce.activeEditor.getContent("myTextarea");
            $('#editForm').submit();

        })
            
        }
        else{
        Swal.fire({
                icon: 'error',
                title: `Vui lòng điền nội dung`,
                showConfirmButton: false,
                timer: 2500
            });    
        }
    })

</script>
@endsection