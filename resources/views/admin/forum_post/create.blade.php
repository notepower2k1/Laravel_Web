@extends('admin/layouts.app')
@section('pageTitle', 'Thêm bài đăng')
@section('content')
<div class="nk-block-head-sub"><a class="back-to" href="{{ url()->previous() }}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="/admin/forum/post" method="POST" enctype="multipart/form-data">
             
            @csrf
            <input type="hidden" name="forum_id" value={{ $forum_id }}>

            <label>Chủ đề<sup>*</sup></label>
            <input type="text" required
            name="topic"
            class="form-control mb-4 col-6"> 

            <label>Ảnh đại diện<sup>*</sup></label>
            <input type="file" required
            name="image"
            class="form-control mb-4 col-6">     

            <label>Nội dung</label>
            <textarea id="mytextarea" 
            required 
            name="content" 
            class="form-control mb-4 col-6">
            </textarea>
     

             <button type="submit" class="btn btn-info">Thêm mới</button>
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