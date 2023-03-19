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
                        name="code"  id="in"
                        class="form-control mb-4 col-6 @error('code') is-invalid @enderror"
                        value="{{ $chapter-> code}}">
                        
                        @error('code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <input type="hidden" required
                        name="slug" id="out"
                        class="form-control mb-4 col-6">

                        <label>Tên chương<sup>*</sup></label>
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
    function toSlug(str) {
	// Chuyển hết sang chữ thường
	str = str.toLowerCase();     
 
	// xóa dấu
	str = str
		.normalize('NFD') // chuyển chuỗi sang unicode tổ hợp
		.replace(/[\u0300-\u036f]/g, ''); // xóa các ký tự dấu sau khi tách tổ hợp
 
	// Thay ký tự đĐ
	str = str.replace(/[đĐ]/g, 'd');
	
	// Xóa ký tự đặc biệt
	str = str.replace(/([^0-9a-z-\s])/g, '');
 
	// Xóa khoảng trắng thay bằng ký tự -
	str = str.replace(/(\s+)/g, '-');
	
	// Xóa ký tự - liên tiếp
	str = str.replace(/-+/g, '-');
 
	// xóa phần dư - ở đầu & cuối
	str = str.replace(/^-+|-+$/g, '');
 
	// return
	return str;
}

    $(() => {
        let $in = $('#in');
        let $out = $('#out');
        
        function update() {
            $out.val(toSlug($in.val()));
        }
        update();
        
        $in.on('change', update);
    })
    
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
        toolbar: "undo redo |  bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | wordcount"
        
    });

</script>
@endsection