@extends('client/manage/layouts.app')
@section('pageTitle', 'Cập nhật chương')
@section('additional-style')
<style>
    .mce-tinymce, .mce-edit-area.mce-container, .mce-container-body.mce-stack-layout
    {
        height: 100% !important;
    }
    
    .mce-edit-area.mce-container {
        height: calc(100% - 88px) !important;
        overflow-y: scroll;
    }
</style>
@endsection
@section('content')
<div class="nk-fmg-body">
    <div class="nk-fmg-body-content">


        <div class="nk-fmg-quick-list nk-block">
            <div class="nk-block-head-sub"><a class="back-to" href="{{ url()->previous() }}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <form action="/quan-ly/chuong/{{  $chapter->id  }}" method="POST">
                        
                        @csrf
                        @method('PUT')
                        <label>Chương số <sup>*</sup></label>
                        <input type="text" required
                        name="code"
                        class="form-control mb-4 col-6 @error('code') is-invalid @enderror"
                        value="{{ $chapter-> code}}">
                        
                        @error('code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    

                        <label>Tên chương<sup></sup></label>
                        <input type="text"
                        name="name"
                        class="form-control mb-4 col-6"
                        value="{{ $chapter-> name }}">
                                            
                        <label>Nội dung</label>
                        @error('content')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <textarea id="mytextarea" 
                        required 
                        name="content" 
                        class="form-control mb-4 col-6 @error('content') is-invalid @enderror" >
                        {{ $chapter-> content }}</textarea>
                
                        <input name="book_id" type="hidden" value="{{ $chapter->book_id }}">

                        <input type="hidden" required
                        name="wordCount" id="wordCount"
                        class="form-control mb-4 col-6">

                        <button type="submit" class="btn btn-info mt-4">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
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