@extends('admin/layouts.app')
@section('pageTitle', 'Thêm bài đăng')
@section('content')
<ul class="breadcrumb breadcrumb-arrow">
    <li class="breadcrumb-item"><a href="/admin/forum">Diễn đàn</a></li>
    <li class="breadcrumb-item"><a href="/admin/forum/post/{{ $forum_id }}">Bài đăng</a></li>
    <li class="breadcrumb-item active">Thêm</li>

</ul><div class="card shadow mb-4">
    <div class="card-body">
            @if($errors->any())
            <div class="alert alert-warning">
                @foreach ($errors->all() as $error)
                    <div class="">{{ $error }}</div>
                @endforeach

            </div>
            @endif
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