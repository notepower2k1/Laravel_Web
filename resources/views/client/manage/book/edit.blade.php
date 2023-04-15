@extends('client/manage.layouts.app')
@section('pageTitle', 'Cập nhật sách điện tử')
@section('content')
<div class="nk-fmg-body">
    <div class="nk-fmg-body-head d-none d-lg-flex">
        <div class="nk-fmg-actions">
            <ul class="nk-block-tools g-3">
                <li>
                    <a class="btn btn-light" href="{{route('sach.index')}}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a>
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
                                <a href="{{route('sach.index')}}" class="btn btn-trigger btn-icon"><em class="icon ni ni-arrow-left"></em></a>                            
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
                    <form action="/quan-ly/sach/{{ $book->id }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        @method('PUT')
                        <label>Tên truyện<sup>*</sup></label>
                        <input type="text" required
                        name="name"
                        value="{{ $book->name }}"
                        class="form-control mb-4 col-6"
                        >
                        
             
                        
                        <label>Thể loại<sup>*</sup></label>
                        <select required class="form-control mb-4 col-6"  name="book_type_id" id="book_type_id">
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}" {{ $book->type_id == $type->id ? 'selected' : '' }} >{{ $type->name }}</option>
                            @endforeach
                        </select>

                        <label>Tác giả<sup>*</sup></label>
                        <input type="text" required
                        name="author"
                        value="{{ $book -> author }}"
                        class="form-control mb-4 col-6 ">	 			 	
                    
                   

                        <label>Ảnh đại diện<sup>*</sup></label>
                        <input type="file"
                        name="image"
                        value="{{ $book -> image }}"
                        class="form-control mb-4 col-6">             
                        
                  
                        <input name="oldImage" type="hidden" value="{{ $book -> image }}">

                        <label>Mô tả</label>
                  
                        <textarea 
                        name="description"
                        class="form-control mb-4"
                        >{{ $book -> description }}</textarea>


                        <label>Tiến độ<sup>*</sup></label>
                        <select required class="form-control mb-4 col-6"  name="isCompleted"> 
                        <option value=0 {{ $book->isCompleted == 0 ? 'selected' : '' }} >Chưa hoàn thành</option>
                        <option value=1 {{ $book->isCompleted == 1 ? 'selected' : '' }} >Đã hoàn thành</option>
                        </select>

                        <button type="submit" class="btn btn-info">Cập nhật truyện</button>
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