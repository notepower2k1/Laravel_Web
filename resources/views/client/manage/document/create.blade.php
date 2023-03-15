@extends('client/manage/layouts.app')
@section('pageTitle', 'Thêm tài liệu')

@section('content')

<div class="nk-fmg-body">
    <div class="nk-fmg-body-content">
        <div class="nk-fmg-quick-list nk-block">
            <div class="nk-block-head-sub"><a class="back-to" href="{{ url()->previous() }}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>

            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <form action="/quan-ly/tai-lieu" method="POST" enctype="multipart/form-data">

                        @csrf
                        <label>Tiêu đề<sup>*</sup></label>
                        <input type="text" required
                        name="name"
                        class="form-control mb-4 col-6 @error('name') is-invalid @enderror">
                        
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror


                        <label>Tác giả<sup>*</sup></label>
                        <input type="text" required
                        name="author"
                        class="form-control mb-4 col-6 @error('author') is-invalid @enderror">

                        @error('author')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror


                        <label>Thể loại<sup>*</sup></label>
                        <select required class="form-control mb-4 col-6" name="document_type_id">
                            @foreach ($types as $type)
                            <option value="{{ $type->id }}" >{{ $type->name }}</option>
                            @endforeach
                        </select>	 	
                    
                    

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
                        <textarea     
                        name="description"
                        class="form-control mb-4 @error('description') is-invalid @enderror"
                        ></textarea>

                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <label>File đính kèm<sup>*</sup></label>
                        <input type="file" required
                        name="file_document"
                        class="form-control mb-4 col-6 @error('file_document') is-invalid @enderror">

                        @error('file_document')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <button type="submit" class="btn btn-info">Thêm tài liệu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    




                


@endsection

    
@section('additional-scripts')

@endsection