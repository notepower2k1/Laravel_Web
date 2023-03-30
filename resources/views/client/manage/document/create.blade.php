@extends('client/manage/layouts.app')
@section('pageTitle', 'Thêm tài liệu')

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
                    <form action="/quan-ly/tai-lieu" method="POST" enctype="multipart/form-data">

                        @csrf
                        <label>Tiêu đề<sup>*</sup></label>
                        <input type="text" required
                        name="name"
                        class="form-control mb-4 col-6">
       

                        <label>Tác giả<sup>*</sup></label>
                        <input type="text" required
                        name="author"
                        class="form-control mb-4 col-6">


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
                        class="form-control mb-4 col-6">        

                        <button type="submit" class="btn btn-info">Thêm tài liệu</button>
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