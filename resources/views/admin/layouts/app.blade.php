<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('pageTitle')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.tiny.cloud/1/eg8iogzlu3jipzfj7j3tuxbi6raibc22pcwt4y2jcu6d3qcn/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="stylesheet" href="{{ asset('assets/css/dashlite.css?ver=3.1.2') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme.css?ver=3.1.2') }}">
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/css/bootstrap5-toggle.min.css"
    rel="stylesheet" />

    @yield('additional-style')

    <style>
        .mce-tinymce, .mce-edit-area.mce-container, .mce-container-body.mce-stack-layout
        {
            height: 100% !important;
        }
        
        .mce-edit-area.mce-container {
            height: calc(100% - 88px) !important;
            overflow-y: scroll;
        }
       
        .sorting_disabled:after{
            content: none !important;
        }
        .sorting_disabled:before{
            content: none !important;
        }

    </style>
    

</head>
<body class="nk-body bg-lighter npc-general has-sidebar">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
                @include('admin/layouts.sidebar')
            </div>
            <div class="nk-wrap ">
                
                <div class="nk-header nk-header-fixed is-light">
                    @include('admin/layouts.header')
                </div>

                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            {{-- @include('admin/layouts.footer') --}}
        </div>
  

    </div>
  
  

  
    @yield('modal')
    <div class="modal fade" id="modalNote">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ghi chú</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form class="form-validate is-alter" id="note-form">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="type_id">Loại</label>
                            <div class="form-control-wrap">
                                <select class="form-select" name="type_id" id="note-type" required>
                                    <option></option>

                                    @foreach ($note_types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>                  
                            </div>
                        </div>   
                        <div class="form-group">
                            <label class="form-label" for="identifier_id">Đối tượng</label>
                            <div class="form-control-wrap">
                                <select class="form-select" name="identifier_id" id="note-object" required disabled>
                                </select>                  
                            </div>
                        </div>                  
                        <div class="form-group">
                            <label class="form-label" for="content">Nội dung</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control no-resize" name="content" id="note-text" required>Nội dung ghi chú</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <button id="note-submitbtn" class="btn btn-lg btn-primary">Lưu ghi chú</button>
                        </div>
                    </form>
                </div>
             
            </div>
        </div>
    </div>
    <script src=" {{ asset('assets/js/bundle.js?ver=3.1.2') }}"></script>
    <script src="{{ asset('assets/js/scripts.js?ver=3.1.2') }}"></script>
    <script src="{{ asset('assets/js/libs/datatable-btns.js?ver=3.1.2') }}"></script>

    {{-- <script src="{{ asset('assets/js/charts/gd-default.js?ver=3.1.2') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    @yield('additional-scripts')
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script>
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function() {
            $('#note-type').select2({
                placeholder: "Chọn loại",
                dropdownParent: $('#modalNote')

            });
            $('#note-object').select2({
                placeholder:"Chọn đối tượng",
                dropdownParent: $('#modalNote')

            });
        })
        

        $(document).on("change","#note-type",function(e){
            e.preventDefault();
            const option = $(this).val();

            $.ajax({
                type:"GET",
                url:"/admin/getObject",
                data: {"type_id":option}   
                })
                .done(function(res) {
                // If successful
                $("#note-object").removeAttr("disabled");

                $("#note-object").empty();
                var obj = res.res;

                var data = [];
                for(const item of obj){
                    const dataItem = `<option value="${item.id}">${item.name}</option>`
                    data.push(dataItem);
                }


                $("#note-object").append(data);


                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
            })
        })

       
        $(document).on("click","#note-submitbtn",function(e) {
            e.preventDefault();
            const form = $('#note-form');

            const content = form.find("textarea").val();
            const identifier_id = form.find("select[name='identifier_id']").val();
            const type_id = form.find("select[name='type_id']").val();

            console.log(content,identifier_id,type_id);

            if(content === '' || identifier_id == '-1' || type_id == '-1' ){
                Swal.fire({
                        icon: 'error',
                        title: `Vui lòng điền đủ thông tin!!!`,
                        showConfirmButton: false,
                        timer: 1500
                });    
                
            }
            else{
               $.ajax({
                type:"POST",
                url:"/admin/create-note",
                data: {
                    "content":content,
                    'identifier_id':identifier_id,
                    'type_id':type_id
                }   
                })
                .done(function(res) {
                // If successful
                    Swal.fire({
                        icon: 'success',
                        title: `${res.success}`,
                        showConfirmButton: false,
                        timer: 2500
                    });    

                    setTimeout(() => {      
                        $('#modalNote').modal('hide');
                    }, 2500);
              
                })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                    // If fail
                    console.log(textStatus + ': ' + errorThrown);
                })

            }
           
           
        })

    </script>
</body>
</html>