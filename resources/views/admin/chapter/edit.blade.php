@extends('admin/layouts.app')
@section('pageTitle', 'Cập nhật chương')

@section('content')
<nav>
    <ul class="breadcrumb breadcrumb-arrow">
        <li class="breadcrumb-item"><a href="/admin/book">Sách</a></li>
        <li class="breadcrumb-item"><a href="/admin/book/chapter/{{ $chapter->book_id }}">Chương</a></li>
        <li class="breadcrumb-item active">Cập nhật</li>

    </ul>
</nav>
<div class="card shadow mb-4">
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-warning">
            @foreach ($errors->all() as $error)
                <div class="">{{ $error }}</div>
            @endforeach

        </div>
        @endif
        <form action="/admin/book/chapter/{{ $chapter->id }}" method="POST">
             
            @csrf
            @method('PUT')
             <label>Chương số <sup>*</sup></label>
             <input type="text" required
             name="code"
             class="form-control mb-4 col-6"
             value="{{ $chapter-> code}}">
             

         


             <label>Tên chương<sup></sup></label>
             <input type="text"
             name="name"
             class="form-control mb-4 col-6"
             value="{{ $chapter-> name }}">
                                  
             <label>Nội dung</label>
             <textarea id="mytextarea" 
             required 
             name="content" 
             class="form-control mb-4 col-6">
             {{ $chapter-> content }}</textarea>
     
             <input name="book_id" type="hidden" value="{{ $chapter->book_id }}">

             <input type="hidden" required
             name="wordCount" id="wordCount"
             class="form-control mb-4 col-6">

             <button type="submit" class="btn btn-info">Cập nhật</button>

         </form>
       </div>
</div>

@endsection

@section('additional-scripts')
<script>


    $(() => {
        


        tinymce.init({
        entity_encoding : "raw",
        selector: '#mytextarea',
        setup: function (editor) {
            editor.on('init', function (e) {
                var theEditor = tinymce.activeEditor;
                var wordCount = theEditor.plugins.wordcount.getCount();
                $('#wordCount').val(wordCount);
            });
        },
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
        toolbar: "undo redo |  bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | wordcount",
        init_instance_callback: function (editor) {
            editor.on('Change', function (e) {
                
                var theEditor = tinymce.activeEditor;

                var wordCount = theEditor.plugins.wordcount.getCount();

                $('#wordCount').val(wordCount);

            });
        }
        });
        





    })
    
    
    
   

    
</script>
@endsection