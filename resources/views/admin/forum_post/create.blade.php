@extends('admin/layouts.app')
@section('pageTitle', 'Thêm bài đăng')
@section('content')
<ul class="breadcrumb breadcrumb-arrow">
    <li class="breadcrumb-item"><a href="/admin/forum">Diễn đàn</a></li>
    <li class="breadcrumb-item"><a href="/admin/forum/post/{{ $forum_id }}">Bài đăng</a></li>
    <li class="breadcrumb-item active">Thêm</li>

</ul>
<div class="card shadow mb-4">
    <div class="card-body">
            @if($errors->any())
            <div class="alert alert-warning">
                @foreach ($errors->all() as $error)
                    <div class="">{{ $error }}</div>
                @endforeach

            </div>
            @endif
        <form action="#" method="POST" id="addForm">
             
            @csrf
            <input type="hidden" name="forum_id" value={{ $forum_id }}>

            <label class="form-label">Chủ đề<sup>*</sup></label>
            <input type="text" required
            name="topic"
            class="form-control mb-4 col-6"> 


            <label class="form-label">Nội dung</label>
            <textarea id="mytextarea" 
            required 
            name="content" 
            class="form-control mb-4 col-6">
            </textarea>
     

         </form>
         <button id="add-btn" class="btn btn-info">Thêm mới</button>

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
            min_height: 800,
            resize: false,
            menubar: false,
            plugins: [
                        "advlist", "anchor", "autolink", "charmap", "code", "fullscreen", 
                        "help", "image", "insertdatetime", "link", "lists", "media", 
                        "preview", "searchreplace", "table", "visualblocks"," wordcount","emoticons","wordcount", 'charmap',"directionality","quickbars","autoresize","table"
                    ],
            toolbar: "undo redo |  blockquote bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | emoticons charmap |  preview searchreplace wordcount | table | ltr rtl",
            table_toolbar: 'tableprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
            quickbars_selection_toolbar: 'bold italic underline strikethrough',
            quickbars_insert_toolbar: false,
            toolbar_mode: 'sliding',
            image_title: true,
            /* enable automatic uploads of images represented by blob or data URIs*/
            images_upload_url: '/upload',
            automatic_uploads: false,
            file_picker_types: 'image',
            paste_block_drop: true,
            block_unsupported_drop: true,
            image_uploadtab: false,
            image_description: false,
            /* and here's our custom image picker*/
            file_picker_callback: function (cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                input.onchange = function () {
                var file = this.files[0]; 
                if(this.files[0].size > 2000000) {
                    alert("Kích thước ảnh phải nhỏ hơn 2MB");
                    $(this).val('');
                }
                else{
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
                }
            

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
                $('#addForm').attr('action', "/admin/forum/post").submit();

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