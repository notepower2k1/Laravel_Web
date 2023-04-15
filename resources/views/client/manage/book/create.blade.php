@extends('client/manage.layouts.app')
@section('pageTitle', 'Thêm sách sách điện tử')

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
                    <form action="{{ route('sach.store') }}" method="POST" enctype="multipart/form-data" novalidate>

                        @csrf
                        <label>Tên sách<sup>*</sup></label>
                        <input type="text" required
                        name="name"
                        class="form-control mb-4 col-6" value="{{ old('name') }}" autofocus>
                  
                        <label>Thể loại<sup>*</sup></label>
                        <select required class="form-control mb-4 col-6" name="book_type_id" id="book_type_id">
                            @foreach ($types as $type)
                            <option value="{{ $type->id }}" >{{ $type->name }}</option>
                            @endforeach
                        </select>

                        <label class="mt-4">Tác giả<sup>*</sup></label>
                        <input type="text" required
                        name="author"
                        class="form-control mb-4 col-6" value="{{ old('author') }}" >	 			 	
                    
                  

                        <label>Ảnh bìa<sup>*</sup></label>
                        <input type="file" required accept="image/*"
                        name="image"
                        class="form-control mb-4 col-6">

                        <label>Ngôn ngữ<sup>*</sup></label>
                        <select required class="form-control mb-4 col-6" name="language">                           
                            <option value="1" >Tiếng việt</option>
                            <option value="0" >Tiếng anh</option>
                        </select> 

                        <label>Mô tả<sup>*</sup></label>
                      
                        <textarea     
                        name="description"
                        class="form-control mb-4" required
                        ></textarea>

                 
                    
                        
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