@extends('admin/layouts.app')
@section('pageTitle', 'Cập nhật sách điện tử')
@section('content')
<div class="nk-block-head-sub"><a class="back-to" href="{{ url()->previous() }}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>

	<div class="card shadow mb-4">
		<div class="card-body ">
			<form action="/admin/book/{{ $book->id }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')
                <label>Tên truyện<sup>*</sup></label>
                <input type="text" required
               name="name" id="in"
               value="{{ $book->name }}"
                class="form-control mb-4 col-6"
               >
                
               <input type="hidden" required
               name="slug" id="out"
               class="form-control mb-4 col-6">

               
                <label>Thể loại<sup>*</sup></label>
                <select required class="form-control mb-4 col-6"  name="book_type_id" id="book_type_id">
                   @foreach ($types as $type)
                    <option value="{{ $type->id }}" {{ $book->type_id == $type->id ? 'selected' : '' }} >{{ $type->name }}</option>
                    @endforeach
                </select>

                <label class="mt-4">Tác giả<sup>*</sup></label>
                <input type="text" required
                name="author"
                value="{{ $book -> author }}"

                class="form-control mb-4 col-6">	 			 	
            
                <label>Ảnh đại diện<sup>*</sup></label>
                <input type="file"
                name="image"
                value="{{ $book -> image }}"
                class="form-control mb-4 col-6">
                       
                <input name="oldImage" type="hidden" value="{{ $book -> image }}">

                <label>Mô tả</label>
                <textarea 
                name="description"
                class="form-control mb-4"
                >{{ $book -> description }}</textarea>


                <label>Tiến độ<sup>*</sup></label>
                <select required class="form-control mb-4 col-6"  name="isCompleted"> 
                <option value=0 {{ $book->isCompleted == 0 ? 'selected' : '' }} >Chưa hoàn thành</option>
                <option value=1 {{ $book->isCompleted == 1 ? 'selected' : '' }} >Đã hoàn thành</option>
                </select>

		 		<button type="submit" class="btn btn-info">Cập nhật truyện</button>
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

<script>
    $('#book_type_id').select2({
    });
</script>

@endsection