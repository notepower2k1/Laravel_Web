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
    <link rel = "icon" href ="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/logo_title.png" type = "image/x-icon">


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

    
    <div class="modal fade" id="alertCalendarModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body modal-body-xl text-center">
                    <div class="nk-modal">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-calendar-booking bg-warning"></em>
                        <h4 class="nk-modal-title">Lịch kế hoạch ngày mai </h4>
                        <div class="nk-modal-text">
                            <div class="row g-gs" id='calendar-render-div'>
                             
                             
                                
                            </div>
                        </div>
                        <div class="nk-modal-action mt-5">
                            <a href="#" class="btn btn-lg btn-mw btn-light" data-bs-dismiss="modal">Tắt thông báo</a>
                        </div>
                    </div>
                </div><!-- .modal-body -->
            </div>
        </div>
    </div>
    <script src=" {{ asset('assets/js/bundle.js?ver=3.1.2') }}"></script>
    <script src="{{ asset('assets/js/scripts.js?ver=3.1.2') }}"></script>
    <script src="{{ asset('assets/js/libs/datatable-btns.js?ver=3.1.2') }}"></script>

    {{-- <script src="{{ asset('assets/js/charts/gd-default.js?ver=3.1.2') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.4/moment-with-locales.js"></script>

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
            // $("#alertCalendarModal").modal('show');
            calendarEventAlert();


            $('#note-type').select2({
                placeholder: "Chọn loại",
                dropdownParent: $('#modalNote')

            });
            $('#note-object').select2({
                placeholder:"Chọn đối tượng",
                dropdownParent: $('#modalNote')

            });
        })
        

        function calendarEventAlert(){
            const today = new Date(); 
            let upComingEvent = [];
            let type = {
                "fc-event-primary":"Bảo trì",
                "fc-event-success":"Unban",
                "fc-event-info":"Thống kê",
                "fc-event-warning":"Meeting",
                "fc-event-pink":"Cá nhân",
            }
            const dataExist = window.localStorage.getItem('calendar');
            if(dataExist){
                var parseJson = JSON.parse(dataExist);

                for (const [key, value] of Object.entries(type)) {

                    parseJson.forEach(object => {
                        if(object['className'] == key){
                            object['className'] = value;
                        }
                    });
                }
                // window.localStorage.setItem('calendar',JSON.stringify(parseJson));
                parseJson.forEach(element => {

                    if(element.status == 1){
                        let temp = new Date(element.end);

                        //remove timezone offset
                        let endDate = new Date(temp.toISOString().slice(0, -1));

                        let temp2 = new Date(element.start);

                         //remove timezone offset
                        let startDate = new Date(temp2.toISOString().slice(0, -1));

                        var difference= Math.abs(startDate-today);

                        var days = difference/(1000 * 3600 * 24);
                    
                        if(days <= 1 && days > 0){

                            console.log(Math.round(days,1));

                            upComingEvent.push(element);
                  

                            const startDateConvert = moment(startDate).format('LLLL').toString();
                            const endDateConvert = moment(endDate).format('LLLL').toString();

                            console.log(startDateConvert);
                            console.log(endDateConvert);
                            const htmlRender = 
                            '<div class="col-6">'+
                                        '<div class="card card-bordered">'+
                                            '<div class="card-inner">'+
                                                '<div class="kanban-item-title">'+
                                                    `<h6 class="title">${element.title}</h6>`+
                                                '</div>'+
                                                '<div class="kanban-item-text text-start">'+
                                                    `<span>${element.description}</span>`+
                                                '</div>'+
                                                '<ul class="kanban-item-tags">'+
                                                    `<li><span class="badge bg-primary">${element.className}</span></li>`+
                                                '</ul>'+
                                                '<div class="kanban-item-meta text-start">'+
                                                ' <ul class="link-list-menu">'+
                                                    `<li><em class="icon ni ni-calendar"></em><span>${startDateConvert}</span></li>`+
                                                    `<li><em class="icon ni ni-calendar-fill"></em><span>${endDateConvert}</span></li>`+
                                                ' </ul>'+
                                                '</div>'+
                                            '</div>'+
                                    ' </div>'+
                            '</div>';

                            $('#calendar-render-div').append(htmlRender);
                        }
                    }
                  


                });

                if(upComingEvent.length > 0){
                    $('#alertCalendarModal').modal('show');
                }
            }
        }

        $('#alertCalendarModal').on('click','a',function(e){
            const today = new Date(); 

            const dataExist = window.localStorage.getItem('calendar');
            if(dataExist){
                var parseJson = JSON.parse(dataExist);
                var newData = parseJson.map(element => {
                    let endDate = new Date(element.end);
                    var difference= Math.abs(startDate-today);

                    var days = difference/(1000 * 3600 * 24);
                    
                    if(days <= 1 && days > 0){
                        element.status = 0
                    }


                    return element;

                });

                window.localStorage.setItem('calendar',[]);
                window.localStorage.setItem('calendar',JSON.stringify(newData));

            }

        });
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