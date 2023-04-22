@extends('admin/layouts.app')
@section('pageTitle', 'Thêm tài liệu')

@section('content')
<div class="nk-block-head-sub"><a class="back-to" href="{{ url()->previous() }}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>

<div class="card shadow mb-4">
    <div class="card-body ">
            @if($errors->any())
            <div class="alert alert-warning">
                @foreach ($errors->all() as $error)
                    <div class="">{{ $error }}</div>
                @endforeach

            </div>
            @endif
            <form action="{{ route('document.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label>Tiêu đề<sup>*</sup></label>
            <input type="text" required
            name="name"
            class="form-control mb-4 col-6" value="{{ old('name') }}" >
           

            <label>Tác giả<sup>*</sup></label>
            <input type="text" required
            name="author"
            class="form-control mb-4 col-6" value="{{ old('author') }}">

         


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
            <div>
                <canvas id="the-canvas" style="border:1px solid black;width:200px;height:300px" ></canvas>

            </div>


            <input type="file"
            name="image" id="imageFileInput" required
            class="form-control mb-4 col-6" accept="image/*" data-bs-toggle="tooltip" data-bs-placement="top" title="Nếu bạn để trống hệ thống sẽ sử dụng ảnh mặc định!!!">


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


          
          <button type="submit" class="btn btn-info">Thêm tài liệu</button>
        </form>
    </div>
</div>



                


@endsection

    
@section('additional-scripts')
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>

<script>

  
    
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