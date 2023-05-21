@extends('client/manage.layouts.app')
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

            <div class="card shadow mb-4">
                <div class="card-body ">
                        @if($errors->any())
                        <div class="alert alert-warning">
                            @foreach ($errors->all() as $error)
                                <div class="">{{ $error }}</div>
                            @endforeach
            
                        </div>
                        @endif
                        <form action="{{ route('tai-lieu.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label>Tiêu đề<sup>*</sup></label>
                        <input type="text" required
                        name="name"
                        class="form-control mb-4 col-6" value="{{ old('name') }}" >
                       
            
                        <label>Tác giả<sup>*</sup></label>
                        <input type="text" required
                        name="author"
                        class="form-control mb-4 col-6" value="{{ old('author') }}"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Nếu nhiều tác giả, mỗi tác giả cách nhau một dấu phẩy (,)">
            
                     
            
            
                        <label>Thể loại<sup>*</sup></label>
                        <select required class="form-control mb-4 col-6" name="document_type_id" id="document_type_id">
                            @foreach ($types as $type)
                            <option value="{{ $type->id }}" >{{ $type->name }}</option>
                            @endforeach
                        </select>	 	
                    
                      
                        <label class="mt-4">File đính kèm<sup>*</sup></label>
                        <input type="file" required
                        name="file_document" id="pdf"
                        class="form-control col-6" accept=".pdf">
            
                        <label class="mt-4">Ảnh bìa<sup>*</sup></label>
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
            
            
                        <input type="file"  style="display: none" class="form-control" name="previewImages[]" id="previewImageInput" multiple />
            
                        <div id="renderArea" style="display: none">
            
                        </div>
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
            
                    
            {{-- 
                        <label>File đính kèm<sup>*</sup></label>
                        <input type="file" required
                        name="file_document" id="pdf"
                        class="form-control mb-4 col-6" accept=".pdf"> --}}
            
            
                        <label>Tiến độ<sup>*</sup></label>
                        <select required class="form-control mb-4 col-6" name="isCompleted"> 
                        <option value=0>Chưa hoàn thành</option>
                        <option value=1>Đã hoàn thành</option>
                        </select>
                      
                      <button type="submit" class="btn btn-info">Thêm tài liệu</button>
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
   
    $('#document_type_id').select2({
    });

    
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
    var pdfjsLib = window['pdfjs-dist/build/pdf'];
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';

    //
    // Asynchronous download PDF as an ArrayBuffer
    //
    var pdf = document.getElementById('pdf');

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

    function fetch5Pages(pdf){

      $('#renderArea').empty();
      let numPages = pdf.numPages;

      if (numPages > 6) {
        numPages = 6;
      }      
      for (let i = 2; i <= numPages; i++) {

          pdf.getPage(i).then(function (page) {
            let scale = 1.5;
            let viewport = page.getViewport({ scale });
            let outputScale = window.devicePixelRatio || 1;

            let canvas = document.createElement('canvas');
            let context = canvas.getContext("2d");

            canvas.width = Math.floor(viewport.width * outputScale);
            canvas.height = Math.floor(viewport.height * outputScale);
            canvas.style.width = Math.floor(viewport.width) + "px";
            canvas.style.height = Math.floor(viewport.height) + "px";

            document.getElementById('renderArea').appendChild(canvas);

            let transform = outputScale !== 1 
                ? [outputScale, 0, 0, outputScale, 0, 0] 
                : null;

            let renderContext = {
                canvasContext: context,
                transform,
                viewport
            };

            var renderTask = page.render(renderContext);

            
            renderTask.promise.then(function () {
              
              uploadPreviewImage();

            
            });

          })
        
      }
    }
    pdf.onchange = function (ev) {
      if (file = document.getElementById('pdf').files[0]) {
        fileReader = new FileReader();
        fileReader.onload = function (ev) {
          // console.log(ev);

          var loadingTask = pdfjsLib.getDocument(fileReader.result);

          loadingTask.promise
            .then(function (pdf) {
              // console.log('PDF loaded');
              // Fetch the first page
              fetch1Page(pdf);
              fetch5Pages(pdf);
       
            }, function (error) {
              console.log(error);
            });
        };
        fileReader.readAsArrayBuffer(file);
      }
    }
    


    function uploadPreviewImage() {

      var renderArea = document.getElementById('renderArea');

      var renderCanvas = renderArea.querySelectorAll('canvas')

      const dataTransfer = new DataTransfer();
      renderCanvas.forEach(element => {
          const base64Image = element.toDataURL('image/jpeg');
        

          const file = base64ToFile(base64Image);
          dataTransfer.items.add(file);

      });
      

    

      const fileInput = document.getElementById('previewImageInput');

      fileInput.files = dataTransfer.files;

      
    };
  
</script>

@endsection