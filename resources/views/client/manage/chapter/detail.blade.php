@extends('client/manage.layouts.app')
@section('pageTitle', 'Chi tiết chương')
@section('additional-style')
<style>
    .mce-tinymce, .mce-edit-area.mce-container, .mce-container-body.mce-stack-layout
    {
        height: 100% !important;
    }
    
    .mce-edit-area.mce-container {
        height: calc(100% - 88px) !important;
        overflow-y: scroll;
    }
</style>
@endsection
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
                                <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li>
                                            <a href="{{ url()->previous() }}" class="btn btn-light"><em class="icon ni ni-arrow-left"></em> <span>Quay lại</span></a>                    
                                          </li>                                      
                                    </ul>
                                </div>
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
                    <div class="title mb-2">
                        @if($chapter->name)
                        <h4 class="text-left">       
                        {{$chapter->code}}: {{ $chapter->name }}
                        </h4>
                        @else
                        <h4 class="text-left">       
                            {{$chapter->code}}
                        </h4>
                        @endif 
                    </div>
                    <div>
                        {!! clean($chapter->content) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('additional-scripts')
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

    $(() => {
       

        tinymce.init({
        entity_encoding : "raw",
        selector: '#mytextarea',
        setup: function (editor) {
            editor.on('init', function (e) {
                var theEditor = tinymce.activeEditor;
                var wordCount = theEditor.plugins.wordcount.getCount();
                $('#wordCount').val(wordCount);
            });
        },
        branding: false,
        statusbar: false,
        height: 1000,
        resize: false,
         menubar: false,
        plugins: [
            "advlist", "anchor", "autolink", "charmap", "code", "fullscreen", 
            "help", "image", "insertdatetime", "link", "lists", "media", 
            "preview", "searchreplace", "table", "visualblocks", " wordcount",
        ],
        toolbar: "undo redo |  bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | wordcount",
      
        init_instance_callback: function (editor) {
            editor.on('Change', function (e) {
                
                var theEditor = tinymce.activeEditor;

                var wordCount = theEditor.plugins.wordcount.getCount();

                $('#wordCount').val(wordCount);

            });
        }
        });
    })
   

</script>
@endsection