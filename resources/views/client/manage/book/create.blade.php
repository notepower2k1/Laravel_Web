@extends('client/layouts.app')
@section('pageTitle', 'Thêm sách sách điện tử')

@section('content')
<div class="nk-block-head-sub"><a class="back-to" href="{{ url()->previous() }}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>

<div class="card shadow mb-4">
    <div class="card-body ">
        <form action="{{ route('sach.store') }}" method="POST" enctype="multipart/form-data" novalidate>

            @csrf
            <label>Tên truyện<sup>*</sup></label>
            <input type="text" required
            name="name"
            class="form-control mb-4 col-6 @error('name') is-invalid @enderror" value="{{ old('name') }}" autocomplete="name" autofocus>
            
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror


            <label>Thể loại<sup>*</sup></label>
            <select required class="form-control mb-4 col-6" name="type_id">
                @foreach ($types as $type)
                <option value="{{ $type->id }}" >{{ $type->name }}</option>
                @endforeach
            </select>

            <label>Tác giả<sup>*</sup></label>
            <input type="text" required
            name="author"
            class="form-control mb-4 col-6 @error('author') is-invalid @enderror" value="{{ old('author') }}"  autocomplete="author">	 			 	
        
            @error('author')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <label>Ảnh đại diện<sup>*</sup></label>
            <input type="file" required
            name="image"
            class="form-control mb-4 col-6 @error('image') is-invalid @enderror">

            @error('image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        

            <label>Ngôn ngữ<sup>*</sup></label>
            <select required class="form-control mb-4 col-6" name="language">                           
                <option value="1" >Tiếng việt</option>
                <option value="0" >Tiếng anh</option>
            </select> 

            <label>Mô tả</label>
            @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <textarea     
            name="description"
            class="form-control mb-4 @error('description') is-invalid @enderror" required
            id="mytextarea"
            ></textarea>

         
            
            <button type="submit" class="btn btn-info">Thêm truyện</button>
        </form>
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