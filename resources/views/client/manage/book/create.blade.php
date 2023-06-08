@extends('client/manage.layouts.app')
@section('pageTitle', 'Thêm sách sách điện tử')

@section('content')

<div class="nk-fmg-body">
    <div class="nk-fmg-body-head d-none d-lg-flex">
        <div class="nk-fmg-actions">
            <ul class="nk-block-tools g-3">
                <li>
                    <a class="btn btn-light" href="/quan-ly/sach"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a>
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
                                <a href="/quan-ly/sach" class="btn btn-trigger btn-icon"><em class="icon ni ni-arrow-left"></em></a>                            
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
                    <form action="/quan-ly/sach" method="POST" enctype="multipart/form-data" novalidate>

                        @csrf
                        <label class="form-label">Tên sách<sup>*</sup></label>
                        <input type="text" required
                        name="name"
                        class="form-control mb-4 col-6" value="{{ old('name') }}" autofocus>
                  
                        <label class="form-label">Thể loại<sup>*</sup></label>
                        <select required class="form-control mb-4 col-6" name="book_type_id" id="book_type_id">
                            @foreach ($types as $type)
                            <option value="{{ $type->id }}" >{{ $type->name }}</option>
                            @endforeach
                        </select>

                        <label class="mt-4 form-label">Tác giả<sup>*</sup></label>
                        <input type="text" required
                        name="author"
                        class="form-control mb-4 col-6" value="{{ old('author') }}"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Nếu nhiều tác giả, mỗi tác giả cách nhau một dấu phẩy (,)" >	 			 	
                    
                  

                        <div class="col-lg-7">
                            <ul class="custom-control-group">
                                <li>
                                    <div class="custom-control custom-checkbox custom-control-pro no-control">
                                        <input value="0" type="radio" class="custom-control-input" name="btnIconRadio" id="btnIconRadio1" checked>
                                        <label class="custom-control-label text-success" for="btnIconRadio1"><em class="icon ni ni-book"></em><span>Chương</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-checkbox custom-control-pro no-control">
                                        <input value="1" type="radio" class="custom-control-input" name="btnIconRadio" id="btnIconRadio2">
                                        <label class="custom-control-label text-primary" for="btnIconRadio2"><em class="icon ni ni-file-pdf"></em><span>File PDF</span></label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                       
                        <div class="mt-2" id="book-content-type" style="display:none">
                            <label class="form-label">File đính kèm</label>
                            <input type="file"
                            name="file_book" id="file_book"
                            class="form-control col-6 " accept=".pdf">
                        </div>
            
                          <label class="mt-4 form-label">Ảnh bìa<sup>*</sup></label>
                          <div class="d-flex">
                            
                            <div class="me-2">
                              <canvas id="the-canvas" style="border:1px solid black;width:200px;height:300px" ></canvas>
              
                            </div>
              
                            <div class="flex-grow-1 align-self-end">
                              <input type="file"
                              name="image" id="imageFileInput" required
                              class="form-control mb-4 col-6" accept="image/*" data-bs-toggle="tooltip" data-bs-placement="top" title="Nếu bạn để trống hệ thống sẽ sử dụng ảnh mặc định!!!">
                            </div>
                            
                         
                        </div>
                   
            
            
                 
                        <label  class="form-label">Ngôn ngữ<sup>*</sup></label>
                        <select required class="form-control mb-4 col-6" name="language">                           
                            <option value="1" >Tiếng việt</option>
                            <option value="0" >Tiếng anh</option>
                        </select> 

                        <label  class="form-label">Mô tả<sup>*</sup></label>
                      
                        <textarea     
                        name="description"
                        class="form-control mb-4" required
                        ></textarea>

                        <label  class="form-label">Tiến độ<sup>*</sup></label>
                        <select required class="form-control mb-4 col-6" name="isCompleted"> 
                        <option value=0>Chưa hoàn thành</option>
                        <option value=1>Đã hoàn thành</option>
                        </select>
                  
                        
                        <button type="submit" class="btn btn-info">Thêm sách</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>



                


@endsection

    
@section('additional-scripts')
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>

<script>
    var pdfjsLib = window['pdfjs-dist/build/pdf'];
      pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';

    $("button[type=submit]").click(function() {

    $(this).attr("disabled","disabled");

        Swal.fire({
        title: 'Đang thêm dữ liệu!',
        text: 'Vui lòng đợi thêm dữ liệu.',
        imageUrl: 'https://raw.githubusercontent.com/notepower2k1/MyImage/main/gif/codevember-day-6-bookshelf-loader.gif',
        imageWidth: 400,
        imageHeight: 200,
        imageAlt: 'Custom image',
        showConfirmButton: false
    });


    $(this).parent().submit();
    });
    
    $('#book_type_id').select2({
    });

    function bookFileHandler(){
      var pdf = document.getElementById('file_book');
      pdf.onchange = function (ev) {
      if (file = document.getElementById('file_book').files[0]) {
        fileReader = new FileReader();
        fileReader.onload = function (ev) {
          // console.log(ev);

          var loadingTask = pdfjsLib.getDocument(fileReader.result);

          loadingTask.promise
            .then(function (pdf) {
              // console.log('PDF loaded');
              // Fetch the first page
              fetch1Page(pdf);
       
            }, function (error) {
              console.log(error);
            });
        };
        fileReader.readAsArrayBuffer(file);
      }
    }
    }

    function fetch1Page(pdf){
        var pageNumber = 1;
        pdf.getPage(pageNumber).then(function (page) {
          // console.log('Page loaded');

          var scale = 1.5;
          console.log(page);
          var viewport = page.getViewport({ scale: scale });

          var canvas = document.getElementById('the-canvas');
          var context = canvas.getContext('2d');
          canvas.height = viewport.height;
          canvas.width = viewport.width;

          var renderContext = {
            canvasContext: context,
            viewport: viewport
          };

            var renderTask = page.render(renderContext);

            renderTask.promise.then(function () {
              
              const base64Image = canvas.toDataURL('image/jpeg');

              const file = base64ToFile(base64Image);


              const dataTransfer = new DataTransfer();
              dataTransfer.items.add(file);

              const fileInput = document.getElementById('imageFileInput');

              fileInput.files = dataTransfer.files;
            
          });
        });
    }

    base64ToFile = (url) => {
        let arr = url.split(',');
        // console.log(arr)
        let mime = arr[0].match(/:(.*?);/)[1];
        let data = arr[1];

        let dataStr = atob(data);
        let n = dataStr.length;
        let dataArr = new Uint8Array(n);

        while (n--) {
        dataArr[n] = dataStr.charCodeAt(n);
        }

        let file = new File([dataArr], 'image.jpeg', { type: mime });


        return file;

    };

    $("#imageFileInput").change(function() {
        const file = this.files[0]

        if (file) {
            var canvas = document.getElementById('the-canvas');
            var ctx = canvas.getContext('2d');
            var url = URL.createObjectURL(file);
            var img = new Image();

            img.onload = function() {
                var ratio = this.height / this.width;
                canvas.height = canvas.width * ratio;   

                ctx.drawImage(this, 0, 0,canvas.width, canvas.height);    
            }
            img.src = url;
        }
    })
    
    $('input[type="radio"]').on('change', function() {

        const option = $(this).val();

            if(option == 0){
            $('#book-content-type').hide('slow');
            $('input[name="file_book"]').val('');
            }
            else{
            $('#book-content-type').show('slow');

    }
    });

    bookFileHandler();
</script>
@endsection