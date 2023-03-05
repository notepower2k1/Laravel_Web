@extends('client/layouts.app')
@section('pageTitle', 'Chọn tài liệu điện tử muốn thêm')
@section('content')

<div class="wide-lg mx-auto mt-5">
    <div class="nk-block nk-block-lg">
        <div class="card card-bordered">
            <form action="#" id='select-form'>
                <div class="card-inner">
                    <div class="nk-stepper-content">
                            <div>
                                <h5 class="title mb-3">Chọn loại tài liệu bạn muốn đăng:</h5>
                                <ul class="row g-3">
                                    <li class="col-6">
                                        <div class="custom-control custom-control-sm custom-radio pro-control custom-control-full">
                                            <input type="radio" class="custom-control-input" name="type" id="type_0" value=0 required>
                                            <label class="custom-control-label" for="type_0">
                                                <span class="d-flex flex-column text-center">
                                                    <span class="preview-icon-wrap text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 90 90" style="max-width: 50%;">
                                                            <rect x="15" y="5" width="56" height="70" rx="6" ry="6" fill="#e3e7fe" stroke="#6576ff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></rect>
                                                            <path d="M69.88,85H30.12A6.06,6.06,0,0,1,24,79V21a6.06,6.06,0,0,1,6.12-6H59.66L76,30.47V79A6.06,6.06,0,0,1,69.88,85Z" fill="#fff" stroke="#6576ff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                                            <polyline points="60 16 60 31 75 31.07" fill="none" stroke="#6576ff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></polyline>
                                                            <line x1="58" y1="50" x2="32" y2="50" fill="none" stroke="#c4cefe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                                            <line x1="46" y1="38" x2="32" y2="38" fill="none" stroke="#c4cefe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                                            <line x1="68" y1="44" x2="32" y2="44" fill="none" stroke="#c4cefe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                                            <line x1="68" y1="56" x2="32" y2="56" fill="none" stroke="#c4cefe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                                            <line x1="58" y1="62" x2="32" y2="62" fill="none" stroke="#c4cefe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                                            <line x1="68" y1="68" x2="32" y2="68" fill="none" stroke="#c4cefe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                                            <line x1="58" y1="75" x2="32" y2="75" fill="none" stroke="#c4cefe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                                        </svg>
                                                    </span>
                                                    <span class="lead-text mb-1 mt-3">Sách điện tử</span>
                                                    <span class="sub-text">Loại tài liệu điện tử được viết, lưu trữ thông qua các chương</span>
                                                </span>
                                            </label>
                                        </div>
                                    </li>
                                    <li class="col-6">
                                        <div class="custom-control custom-control-sm custom-radio pro-control custom-control-full">
                                            <input type="radio" class="custom-control-input" name="type" id="type_1" value=1 required>
                                            <label class="custom-control-label" for="type_1">
                                                <span class="d-flex flex-column text-center">
                                                    <span class="preview-icon-wrap text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 90 90" style="max-width: 50%;">
                                                            <rect x="15" y="5" width="56" height="70" rx="6" ry="6" fill="#e3e7fe" stroke="#6576ff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></rect>
                                                            <path d="M69.88,85H30.12A6.06,6.06,0,0,1,24,79V21a6.06,6.06,0,0,1,6.12-6H59.66L76,30.47V79A6.06,6.06,0,0,1,69.88,85Z" fill="#fff" stroke="#6576ff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                                            <polyline points="60 16 60 31 75 31.07" fill="none" stroke="#6576ff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></polyline>
                                                            <line x1="69" y1="47" x2="31" y2="47" fill="none" stroke="#c4cefe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                                            <line x1="69" y1="53" x2="31" y2="53" fill="none" stroke="#c4cefe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                                            <line x1="69" y1="59" x2="31" y2="59" fill="none" stroke="#c4cefe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                                            <line x1="69" y1="65" x2="31" y2="65" fill="none" stroke="#c4cefe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                                            <line x1="69" y1="71" x2="31" y2="71" fill="none" stroke="#c4cefe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                                        </svg>
                                                    </span>
                                                    <span class="lead-text mb-1 mt-3">Tài liệu tham khảo trực tuyến</span>
                                                    <span class="sub-text">Loại tài liệu điện tử được viết, lưu trữ thông qua các file pdf, docx</span>
                                                </span>
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>                  
                       
                      
                           <button type="button" class="mt-3 btn btn-primary" id="submit-btn">Tiếp tục</button>
                        
                    </div>
                </div>
            </form>
        </div>
    </div><!-- .nk-block -->
</div><!-- .components-preview -->


@endsection

@section('additional-scripts')

<script>
    $('#submit-btn').click(function (e) { 
        e.preventDefault();
       
       
        var selection = $('#select-form').find("input[name='type']:checked" ).val();

        if(selection == 0){
            window.location.href = "/quan-ly/them-sach";
        }
        else if (selection == 1){
            window.location.href = "/quan-ly/them-tai-lieu";
        }
        else{
            alert("Vui lòng chọn loại tài liệu điện tử");
        }
        
    });
</script>
@endsection