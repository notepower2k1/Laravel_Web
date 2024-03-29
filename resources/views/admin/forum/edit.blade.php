@extends('admin/layouts.app')
@section('pageTitle', 'Cập nhật diễn đàn')

@section('content')
<ul class="breadcrumb breadcrumb-arrow">
    <li class="breadcrumb-item"><a href="/admin/forum">Tài liệu</a></li>
    <li class="breadcrumb-item active"><a href="#">Cập nhật</a></li>
  </ul>
<hr>   
	<div class="card shadow mb-4">
		<div class="card-body ">
                @if($errors->any())
                <div class="alert alert-warning">
                    @foreach ($errors->all() as $error)
                        <div class="">{{ $error }}</div>
                    @endforeach

                </div>
                @endif
			<form action="/admin/forum/{{ $forum->id }}" method="POST">

                @csrf
                @method('PUT')
                <label class="form-label">Tên diễn đàn<sup>*</sup></label>
                <input type="text" required
               name="name"
               value="{{ $forum->name }}"
                class="form-control mb-4 col-6"
               >
                
         

                <label class="form-label">Mô tả</label>
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
    
</script>
@endsection