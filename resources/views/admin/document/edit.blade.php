@extends('admin/layouts.app')
@section('pageTitle', 'Cập nhật tài liệu')

@section('content')
<div class="nk-block-head-sub"><a class="back-to" href="{{ url()->previous() }}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>

	<div class="card shadow mb-4">
		<div class="card-body ">
			<form action="/admin/document/{{ $document->id }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')
                <label>Tiêu đề<sup>*</sup></label>
                <input type="text" required
                name="name" id="in"
                value="{{ $document->name }}"
                class="form-control mb-4 col-6 @error('name') is-invalid @enderror">
         
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror


                <input type="hidden" required
                name="slug" id="out"
                class="form-control mb-4 col-6">


                <label>Tác giả<sup>*</sup></label>
                <input type="text" required
                name="author"
                value="{{ $document->author }}"
                class="form-control mb-4 col-6 @error('author') is-invalid @enderror">
    
                @error('author')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label>Thể loại<sup>*</sup></label>
                <select required class="form-control mb-4 col-6" name="document_type_id" id="document_type_id">
                    @foreach ($types as $type)
                    <option value="{{ $type->id }}" {{ $document->type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>	 	
            
            

                <label class="mt-4">Ảnh đại diện<sup>*</sup></label>
                <input type="file"
                name="image"
                value="{{ $document -> image }}"
                class="form-control mb-4 col-6 @error('image') is-invalid @enderror">

                <input name="oldImage" type="hidden" value="{{ $document -> image }}">

                @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror         

                <label>Mô tả</label>
                <textarea     
                name="description"
                class="form-control mb-4 @error('description') is-invalid @enderror"
                >{{ $document -> description }}</textarea>

                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label>File đính kèm<sup>*</sup></label>
                <input type="file" 
                name="file_document"
                value="{{ $document -> file }}"
                class="form-control mb-4 col-6 @error('file_document') is-invalid @enderror">

                <input name="oldFile" type="hidden" value="{{ $document -> file }}">

                <input name="oldNumberOfPages" type="hidden" value="{{ $document -> numberOfPages }}">

                @error('file_document')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror


                <label>Tiến độ<sup>*</sup></label>
                <select required class="form-control mb-4 col-6"  name="isCompleted"> 
                <option value=0 {{ $document->isCompleted == 0 ? 'selected' : '' }} >Chưa hoàn thành</option>
                <option value=1 {{ $document->isCompleted == 1 ? 'selected' : '' }} >Đã hoàn thành</option>
                </select>

		 		<button type="submit" class="btn btn-info">Cập nhật tài liệu</button>
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

    $('#document_type_id').select2({
    });
</script>
@endsection