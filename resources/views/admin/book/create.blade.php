@extends('admin/layouts.app')
@section('pageTitle', 'Thêm sách sách điện tử')

@section('content')
<div class="nk-block-head-sub"><a class="back-to" href="{{ url()->previous() }}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>

<div class="card shadow mb-4">
    <div class="card-body ">
        <form action="{{ route('book.store') }}" method="POST" enctype="multipart/form-data">

            @csrf
            <label>Tên sách<sup>*</sup></label>
            <input type="text" required
            name="name"
            class="form-control mb-4 col-6 @error('name') is-invalid @enderror" value="{{ old('name') }}" autocomplete="name" autofocus>
            
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label>Thể loại<sup>*</sup></label>
            <select required class="form-select mb-4 col-6" name="book_type_id" id="book_type_id" data-search="Ngôn ngữ">
                @foreach ($types as $type)
                <option value="{{ $type->id }}" >{{ $type->name }}</option>
                @endforeach
            </select>

            <label class="mt-4">Tác giả<sup>*</sup></label>
            <input type="text" required
            name="author"
            class="form-control mb-4 col-6 @error('author') is-invalid @enderror" value="{{ old('author') }}"  autocomplete="author">	 			 	
        
            @error('author')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <label>Ảnh bìa<sup>*</sup></label>
            <input type="file" required accept="image/*"
            name="image"
            class="form-control mb-4 col-6 @error('image') is-invalid @enderror">

            @error('image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <label>Ngôn ngữ<sup>*</sup></label>
            <select required class="form-select mb-4 col-6" name="language"  data-search="Ngôn ngữ">                           
                <option value="1" >Tiếng việt</option>
                <option value="0" >Tiếng anh</option>
            </select> 

            <label>Mô tả</label>
            <textarea     
            name="description"
            class="form-control mb-4 @error('description') is-invalid @enderror" required
            ></textarea>

            @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            
            <button type="submit" class="btn btn-info">Thêm sách</button>
        </form>
    </div>
</div>



                


@endsection

    
@section('additional-scripts')

<script>
    $('#book_type_id').select2({
    });
</script>

@endsection