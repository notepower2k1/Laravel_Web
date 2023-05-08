@extends('client/manage.layouts.app')
@section('pageTitle', 'Cập nhật tài liệu')

@section('content')
<div class="nk-fmg-body">
    <div class="nk-fmg-body-head d-none d-lg-flex">
        <div class="nk-fmg-actions">
            <ul class="nk-block-tools g-3">
                <li>
                    <a href="{{ url()->previous() }}" class="btn btn-light"><em class="icon ni ni-arrow-left"></em> <span>Quay lại</span></a>                    
                </li>
            </ul>
        </div>
    </div>
    <div class="nk-fmg-body-content">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between position-relative">               
                <div class="nk-block-head-content">
                    <ul class="nk-block-tools g-1">           
                        <li class="d-lg-none">
                            <div class="dropdown">
                                <a href="{{ url()->previous() }}" class="btn btn-light"><em class="icon ni ni-arrow-left"></em> <span>Quay lại</span></a>                    
                            </div>
                        </li>
                        <li class="d-lg-none me-n1"><a href="#" class="btn btn-trigger btn-icon toggle" data-target="files-aside"><em class="icon ni ni-menu-alt-r"></em></a></li>
                    </ul>
                </div>             
            </div>
        </div>
        <div class="nk-fmg-quick-list nk-block">
            <div class="card card-bordered shadow">
                <div class="card-inner">
                    @if($errors->any())
                    <div class="alert alert-warning">
                        @foreach ($errors->all() as $error)
                            <div class="">{{ $error }}</div>
                        @endforeach
        
                    </div>
                    @endif
                    <form action="/quan-ly/tai-lieu/{{ $document->id }}" method="POST" enctype="multipart/form-data">
        
                        @csrf
                        @method('PUT')
                        <label>Tiêu đề<sup>*</sup></label>
                        <input type="text" required
                        name="name"
                        value="{{ $document->name }}"
                        class="form-control mb-4 col-6">
                 
        
                    
        
                        <label class="mt-4">Tác giả<sup>*</sup></label>
                        <input type="text" required
                        name="author"
                        value="{{ $document->author }}"
                        class="form-control mb-4 col-6">
          
        
                        <label>Thể loại<sup>*</sup></label>
                        <select required class="form-control mb-4 col-6" name="document_type_id" id="document_type_id">
                            @foreach ($types as $type)
                            <option value="{{ $type->id }}" {{ $document->type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>	 	
                    
                    
                        <label class="mt-4">Ảnh bìa<sup>*</sup></label>

                        <div class="mb-2" style="display:none">
                            <canvas id="the-canvas" style="border:1px solid black;width:200px;height:300px" ></canvas>
                        </div>
                        <div class="mb-2" id="default-image-loading">
                            <img src="{{ $document->url }}" alt="img" style="border:1px solid black;width:200px;height:300px" loading="lazy">
                        </div>
            
            
                        <input type="file"
                        name="image" id="imageFileInput" required
                        class="form-control mb-4 col-6" accept="image/*" data-bs-toggle="tooltip" data-bs-placement="top" title="Nếu bạn để trống hệ thống sẽ sử dụng ảnh mặc định!!!">
                               
                        
                        
                        <input name="oldImage" type="hidden" value="{{ $document -> image }}">
        
                         
        
                        <label>Mô tả</label>
                        <textarea     
                        name="description"
                        class="form-control mb-4"
                        >{{ $document -> description }}</textarea>
        
                   
                        
                        <label>Tiến độ<sup>*</sup></label>
                        <select required class="form-control mb-4 col-6"  name="isCompleted"> 
                        <option value=0 {{ $document->isCompleted == 0 ? 'selected' : '' }} >Chưa hoàn thành</option>
                        <option value=1 {{ $document->isCompleted == 1 ? 'selected' : '' }} >Đã hoàn thành</option>
                        </select>
        
                         <button type="submit" class="btn btn-info">Cập nhật tài liệu</button>
                     </form>
                   </div>
            </div>
        </div>
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

    $('#document_type_id').select2({
    });

    $("#imageFileInput").change(function() {

        const file = this.files[0]

        if (file) {
            $('#default-image-loading').remove();
            $('#the-canvas').parent().show();
            var canvas = document.getElementById('the-canvas');
            var ctx = canvas.getContext('2d');
            var url = URL.createObjectURL(file);
            var img = new Image();

            img.onload = function() {
                var ratio = this.height / this.width;
                canvas.height = canvas.width * ratio;   

                ctx.drawImage(this, 0, 0,canvas.width, canvas.height);    
            }
            img.src = url;
    }
    })
</script>
@endsection