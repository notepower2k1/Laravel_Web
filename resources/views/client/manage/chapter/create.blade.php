@extends('client/layouts.app')
@section('pageTitle', 'Thêm chương')

@section('content')
<div class="nk-block-head-sub"><a class="back-to" href="{{ url()->previous() }}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>


                  

                <div class="card shadow mb-4">
                    <div class="card-body">
                            <form action="/quan-ly/chuong" method="POST">
                            
                            @csrf
                            <input type="hidden" name="book_id" value={{ $book_id }}>

                            <label>Chương số <sup>*</sup></label>
                            <input type="text" required
                            name="code"
                            class="form-control mb-4 col-6 @error('code') is-invalid @enderror" value="{{ old('code') }}"  autocomplete="code" autofocus>

                            @error('code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <label>Tên chương<sup>*</sup></label>
                            <input type="text" required
                            name="name"
                            class="form-control mb-4 col-6" value="{{ old('name') }}"  autocomplete="name" >
                                  
                         

                            <label>Nội dung</label>
                            @error('content')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <textarea id="mytextarea" 
                            required 
                            name="content" 
                            class="form-control mb-4 col-6 col-6 @error('content') is-invalid @enderror">
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