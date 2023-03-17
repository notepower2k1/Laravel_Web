@extends('client/manage/layouts.app')
@section('pageTitle', 'Thêm sách sách điện tử')

@section('content')

<div class="nk-fmg-body">
    <div class="nk-fmg-body-content">

        <div class="nk-fmg-quick-list nk-block">
            <div class="nk-block-head-sub"><a class="back-to" href="{{route('sach.index')}}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>

            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <form action="{{ route('sach.store') }}" method="POST" enctype="multipart/form-data" novalidate>

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
                        <select required class="form-control mb-4 col-6" name="book_type_id" id="book_type_id">
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
                        <select required class="form-control mb-4 col-6" name="language">                           
                            <option value="1" >Tiếng việt</option>
                            <option value="0" >Tiếng anh</option>
                        </select> 

                        <label>Mô tả<sup>*</sup></label>
                      
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

        </div>
    </div>
</div>



                


@endsection

    
@section('additional-scripts')
<script>
    $('#book_type_id').select2({
    });
</script>
@endsection