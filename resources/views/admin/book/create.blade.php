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
            class="form-control mb-4 col-6">
            
            <label>Thể loại<sup>*</sup></label>
            <select required class="form-control mb-4 col-6" name="book_type_id">
                @foreach ($types as $type)
                <option value="{{ $type->id }}" >{{ $type->name }}</option>
                @endforeach
            </select>

            <label>Tác giả<sup>*</sup></label>
            <input type="text" required
            name="author"
            class="form-control mb-4 col-6">	 			 	
        
            <label>Ảnh bìa<sup>*</sup></label>
            <input type="file" required
            name="image"
            class="form-control mb-4 col-6" accept="image/*">

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

            
            <button type="submit" class="btn btn-info">Thêm truyện</button>
        </form>
    </div>
</div>



                


@endsection

    
@section('additional-scripts')
@endsection