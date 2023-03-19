@extends('client/manage/layouts.app')
@section('pageTitle', 'Cập nhật sách điện tử')
@section('content')
<div class="nk-fmg-body">
    <div class="nk-fmg-body-content">
        <div class="nk-fmg-quick-list nk-block">
            <div class="nk-block-head-sub"><a class="back-to" href="{{ url()->previous() }}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <form action="/quan-ly/sach/{{ $book->id }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        @method('PUT')
                        <label>Tên truyện<sup>*</sup></label>
                        <input type="text" required
                        name="name" id="in"
                        value="{{ $book->name }}"
                        class="form-control mb-4 col-6 @error('name') is-invalid @enderror"
                        >
                        
                        <input type="hidden" required
                        name="slug" id="out"
                        class="form-control mb-4 col-6">

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        
                        <label>Thể loại<sup>*</sup></label>
                        <select required class="form-control mb-4 col-6"  name="book_type_id" id="book_type_id">
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}" {{ $book->type_id == $type->id ? 'selected' : '' }} >{{ $type->name }}</option>
                            @endforeach
                        </select>

                        <label>Tác giả<sup>*</sup></label>
                        <input type="text" required
                        name="author"
                        value="{{ $book -> author }}"

                        class="form-control mb-4 col-6  @error('author') is-invalid @enderror">	 			 	
                    
                        @error('author')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <label>Ảnh đại diện<sup>*</sup></label>
                        <input type="file"
                        name="image"
                        value="{{ $book -> image }}"
                        class="form-control mb-4 col-6 @error('file') is-invalid @enderror">
                        
                        
                        @error('file')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <input name="oldImage" type="hidden" value="{{ $book -> image }}">

                        <label>Mô tả</label>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <textarea 
                        name="description"
                        class="form-control mb-4 @error('description') is-invalid @enderror"
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

    $('#book_type_id').select2({
    });
</script>
@endsection