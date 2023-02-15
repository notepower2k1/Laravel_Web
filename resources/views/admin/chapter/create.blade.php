@extends('admin/layouts.app')
@section('content')

<h1 class="h3 mb-2 text-gray-800">Thêm chương</h1>
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="/admin/book/chapter" method="POST">
             
            @csrf
            <input type="hidden" name="book_id" value={{ $book_id }}>

             <label>Chương số <sup>*</sup></label>
             <input type="text" required
             name="code"
             class="form-control mb-4 col-6">
             
             <label>Tên chương<sup>*</sup></label>
             <input type="text"
             name="name"
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
        plugins: [
            "advlist", "anchor", "autolink", "charmap", "code", "fullscreen", 
            "help", "image", "insertdatetime", "link", "lists", "media", 
            "preview", "searchreplace", "table", "visualblocks", " wordcount",
        ],
        toolbar: "undo redo | styles | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | wordcount"
        
    });

</script>
@endsection