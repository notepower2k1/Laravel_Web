@extends('client/layouts.app')
@section('pageTitle', 'Cập nhật bài viết')
@section('content')
<div class="nk-fmg-body">
    <div class="nk-fmg-body-content">

        <div class="nk-fmg-quick-list nk-block">
            <div class="nk-block-head-sub"><a class="back-to" href="/dien-dan/{{$forum_slug}}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <form action="/bai-viet/{{ $forum_post->id }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <input type="hidden" name="forum_slug" value="{{ $forum_slug }}">


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
        </div>
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
        height: 500,
        resize: false,
        menubar: false,
        plugins: [
            "advlist", "anchor", "autolink", "charmap", "code", "fullscreen", 
            "help", "image", "insertdatetime", "link", "lists", "media", 
            "preview", "searchreplace", "table", "visualblocks", " wordcount",
        ],
        toolbar: "undo redo | styles | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | wordcount"
        
    })
</script>

@endsection