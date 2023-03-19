@extends('admin/layouts.app')
@section('pageTitle', 'Cập nhật diễn đàn')

@section('content')
<div class="nk-block-head-sub"><a class="back-to" href="{{ url()->previous() }}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>

	<div class="card shadow mb-4">
		<div class="card-body ">
			<form action="/admin/forum/{{ $forum->id }}" method="POST">

                @csrf
                @method('PUT')
                <label>Tên diễn đàn<sup>*</sup></label>
                <input type="text" required
               name="name" id="in"
               value="{{ $forum->name }}"
                class="form-control mb-4 col-6"
               >
                
               <input type="hidden" required
               name="slug" id="out"
               class="form-control mb-4 col-6">

                <label>Mô tả</label>
                <textarea 
               cols="50" 
               rows="20" 
               name="description"
               class="form-control mb-4"

               >{{ $forum -> description }}</textarea>

		 		<button type="submit" class="btn btn-info">Cập nhật diễn đàn</button>
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
    
</script>
@endsection