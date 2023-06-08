@extends('client/forum.layouts.app')
@section('pageTitle', 'Cập nhật bài viết')
@section('content')
<div class="nk-fmg-body">
    <div class="nk-fmg-body-content">

        <div class="nk-fmg-quick-list nk-block">
            <div class="nk-block-head-sub"><a class="back-to" href="/dien-dan/{{$forum_slug}}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <form action="/bai-viet/{{ $forum_post->id }}" method="POST" id="editForm">

                        @csrf
                        @method('PUT')

                        <input type="hidden" name="forum_slug" value="{{ $forum_slug }}">


                        <label>Chủ đề<sup>*</sup></label>
                        <input type="text" required
                       name="topic"
                       value="{{ $forum_post->topic }}"
                        class="form-control mb-4 col-6">
        
                    

                      
                        <label>Nội dung</label>
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
        </div>
    </div>
</div>
@endsection

@section('additional-scripts')
<script>
    

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
            "preview", "searchreplace", "table", "visualblocks"," wordcount","emoticons",
        ],
        toolbar: "undo redo |  bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | emoticons | wordcount",
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