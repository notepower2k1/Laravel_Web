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
            <div class="card card-bordered card-preview">
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
               
                   

                        <label>Tác giả<sup>*</sup></label>
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
                    
                    
        
                        <label>Ảnh đại diện<sup>*</sup></label>
                        <input type="file"
                        name="image"
                        value="{{ $document -> image }}"
                        class="form-control mb-4 col-6">
        
                        <input name="oldImage" type="hidden" value="{{ $document -> image }}">
        
                   
        
                        <label>Mô tả</label>
                        <textarea     
                        name="description"
                        class="form-control mb-4"
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
                        class="form-control mb-4 col-6">
        
                        <input name="oldFile" type="hidden" value="{{ $document -> file }}">
        
                        <input name="oldNumberOfPages" type="hidden" value="{{ $document -> numberOfPages }}">

            
        
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
   

    $('#document_type_id').select2({
    });
</script>
@endsection