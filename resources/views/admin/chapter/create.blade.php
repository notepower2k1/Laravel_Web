@extends('admin/layouts.app')
@section('pageTitle', 'Thêm chương')

@section('content')
<ul class="breadcrumb breadcrumb-arrow">
    <li class="breadcrumb-item"><a href="/admin/book">Sách</a></li>
    <li class="breadcrumb-item"><a href="/admin/book/chapter/{{ $book_id }}">Chương</a></li>
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
            <form action="/admin/book/chapter" method="POST">
                
                @csrf
                <input type="hidden" name="book_id" value={{ $book_id }}>

                <label class="form-label">Chương số <sup>*</sup></label>
                <input type="text" required
                name="code"
                class="form-control mb-4 col-6" value="{{ old('code') }}">

            

                <label class="form-label">Tên chương<sup></sup></label>
                <input type="text"
                name="name" 
                class="form-control mb-4 col-6" value="{{ old('name') }}">
                                    
                <label class="form-label">Nội dung</label>
                <textarea id="mytextarea" 
                required 
                name="content" 
                class="form-control mb-4 col-6">
                </textarea>
                
                <input type="hidden" required
                name="wordCount" id="wordCount"
                class="form-control mb-4 col-6">

                <button type="submit" class="btn btn-info">Thêm mới</button>
            </form>
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
        min_height: 600,
        resize: false,
        menubar: false,
        plugins: [
                "advlist", "anchor", "autolink", "charmap", "code", "fullscreen", 
                "help", "image", "insertdatetime", "link", "lists", "media", 
                "preview", "searchreplace", "table", "visualblocks"," wordcount","emoticons","wordcount", 'charmap',"directionality","quickbars","autoresize","table"
            ],
        toolbar: "undo redo |  blockquote bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link emoticons charmap |  preview searchreplace wordcount | table | ltr rtl",
        table_toolbar: 'tableprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
        quickbars_selection_toolbar: 'bold italic underline strikethrough',
        quickbars_insert_toolbar: false,
        toolbar_mode: 'sliding',
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