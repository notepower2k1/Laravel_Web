@extends('admin/layouts.app')
@section('pageTitle', 'Thêm tài liệu')

@section('content')
<div class="nk-block-head-sub"><a class="back-to" href="{{ url()->previous() }}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>

<div class="card shadow mb-4">
    <div class="card-body ">
            @if($errors->any())
            <div class="alert alert-warning">
                @foreach ($errors->all() as $error)
                    <div class="">{{ $error }}</div>
                @endforeach

            </div>
            @endif
            <form action="{{ route('document.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label>Tiêu đề<sup>*</sup></label>
            <input type="text" required
            name="name"
            class="form-control mb-4 col-6" value="{{ old('name') }}" >
           

            <label>Tác giả<sup>*</sup></label>
            <input type="text" required
            name="author"
            class="form-control mb-4 col-6" value="{{ old('author') }}">

         


            <label>Thể loại<sup>*</sup></label>
            <select required class="form-control mb-4 col-6" name="document_type_id" id="document_type_id">
                @foreach ($types as $type)
                <option value="{{ $type->id }}" >{{ $type->name }}</option>
                @endforeach
            </select>	 	
        
          

            <label class="mt-4">Ảnh bìa<sup>*</sup></label>
            <input type="file"
            name="image"
            class="form-control mb-4 col-6" accept="image/*" data-bs-toggle="tooltip" data-bs-placement="top" title="Nếu bạn để trống hệ thống sẽ sử dụng ảnh mặc định!!!">



            <label>Ngôn ngữ<sup>*</sup></label>
            <select required class="form-control mb-4 col-6" name="language">                           
                <option value="1" >Tiếng việt</option>
                <option value="0" >Tiếng anh</option>
            </select>     

            <label>Mô tả</label>
            <textarea     
            name="description"
            class="form-control mb-4"
            ></textarea>

        

            <label>File đính kèm<sup>*</sup></label>
            <input type="file" required
            name="file_document"
            class="form-control mb-4 col-6" accept=".docx,.pdf">

          

            <button type="submit" class="btn btn-info">Thêm tài liệu</button>
        </form>
    </div>
</div>



                


@endsection

    
@section('additional-scripts')

<script>
   

    
    
    $('#document_type_id').select2({
    });

 

  
    

  
</script>

@endsection