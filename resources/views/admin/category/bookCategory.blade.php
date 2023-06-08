@extends('admin/layouts.app')
@section('pageTitle', 'Danh sách thể loại')
@section('additional-style')

@endsection
@section('content')
    <div class="nk-block nk-block-lg">
        <div class="container">
            <div class="nk-block-head row">
                <div class="form-group col-6">
                    <label class="form-label" for="default-01">Thể loại</label>
                    <div class="form-control-wrap">
                        <input type="text" name="type_name" class="form-control" id="default-01" placeholder="Thêm thể loại">
                    </div>
                </div>
                <div class="form-group col-6">
                    <label class="form-label" for="default-02">Slug</label>
                    <div class="form-control-wrap">
                        <input type="text" name="type_slug" class="form-control" id="default-02" placeholder="slug" disabled>
                    </div>
                    <span class="text-danger ff-italic" style="display:none">Slug đã tồn tại</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary float-end" id="addTypebtn">Thêm</button>
                </div>
            </div>
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false" data-export-title="Export">
                        <thead>
                            <tr class="nk-tb-item nk-tb-head">
                                <th class="nk-tb-col"><span class="sub-text">Số thứ tự</span></th>

                                <th class="nk-tb-col"><span class="sub-text">Tên loại</span></th>
                                <th class="nk-tb-col"><span class="sub-text">slug</span></th>
                             
                            
                                <th class="nk-tb-col nk-tb-col-tools text-end">
                                </th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookTypes as $type)
    
                            <tr class="nk-tb-item" id ="row-{{ $type->id }}">
                                
                                <td class="nk-tb-col">
                                    <span>{{  $type->id }}</span>

                                </td>
                            
                                
                                <td class="nk-tb-col">
                                    <span>{{  $type->name }}</span>
                                </td>
                               
                                <td class="nk-tb-col">
                                    <span>{{ $type->slug }}</span>
                                </td>
                                <td class="nk-tb-col nk-tb-col-tools">
                                    <ul class="nk-tb-actions gx-1">
                                        <li>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        @if($type->total)
                                                            <li>
                                                                <a href="#" class="delete-button-fail" data-name="{{ $type->name }}">
                                                                    <em class="icon ni ni-lock"></em><span>Xóa</span>
                                                                </a>
                                                            </li> 
                                                        @else
                                                            <li>
                                                                <a href="#" class="delete-button" data-id="{{ $type->id }}" data-name="{{ $type->name }}">
                                                                    <em class="icon ni ni-trash"></em><span>Xóa</span>
                                                                </a>
                                                            </li>      
                                                        @endif
                                                        <li><a href="#"><em class="icon ni ni-edit"></em><span>Cập nhật</span></a></li>
                                                       
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </td>
    
                            
                                
    
                               
                            </tr><!-- .nk-tb-item  -->
                            @endforeach
    
                        </tbody>
                    </table>
                </div>
            </div><!-- .card-preview -->
        </div>
      
    </div> <!-- nk-block -->
@endsection
@section('additional-scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function() {
        $('#DataTables_Table_0 tbody').on('click','.delete-button',function(){

        var catergory_id = $(this).data('id');
        var name = $(this).data('name');
        var token = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
            title: "Bạn muốn xóa thể loại "+ name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xóa thể loại',
            cancelButtonText: 'Không'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                type:"DELETE",
                url:'/admin/categoryBook/' + catergory_id,
                data : {
                },
                })
                .done(function() {
                // If successful
                Swal.fire({
                        icon: 'success',
                        title: `Xóa thể loại ${name} thành công`,
                        showConfirmButton: false,
                        timer: 2500
                    });

                    window.location.reload();
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                })
            
            }
        })
        })

        $('#DataTables_Table_0 tbody').on('click','.delete-button-fail',function(){

        var name = $(this).data('name');
        var token = $("meta[name='csrf-token']").attr("content");


        // If successful
        Swal.fire({
                icon: 'info',
                title: `Thể loại ${name} có sách không thể xóa`,
                showConfirmButton: true,
                timer: 2500
            });

            
        })
    })
    var typingTimer;                //timer identifier
    var doneTypingInterval = 300;  //time in ms, 5 seconds for example


    //on keyup, start the countdown
    $(document).on('keyup','input[name="type_name"]', function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    //on keydown, clear the countdown 
    $(document).on('keydown','input[name="type_name"]', function () {
    clearTimeout(typingTimer);
    });


    function toSlug(str) {
	// Chuyển hết sang chữ thường
        str = str.toLowerCase();     
    
        // xóa dấu
        str = str
            .normalize('NFD') // chuyển chuỗi sang unicode tổ hợp
            .replace(/[\u0300-\u036f]/g, ''); // xóa các ký tự dấu sau khi tách tổ hợp
    
        // Thay ký tự đĐ
        str = str.replace(/[đĐ]/g, 'd');
        
        // Xóa ký tự đặc biệt
        str = str.replace(/([^0-9a-z-\s])/g, '');
    
        // Xóa khoảng trắng thay bằng ký tự -
        str = str.replace(/(\s+)/g, '-');
        
        // Xóa ký tự - liên tiếp
        str = str.replace(/-+/g, '-');
    
        // xóa phần dư - ở đầu & cuối
        str = str.replace(/^-+|-+$/g, '');
    
        // return
        return str;
    }

    function doneTyping(){
        const text = $('input[name="type_name"]').val();

        const slug = toSlug(text);
        $('input[name="type_slug"]').val(toSlug(slug));

        $('input[name="type_slug"]').parent().next().hide('slow');
   
        if(slug){
            $('#addTypebtn').prop('disabled', false);

            const types = {!! json_encode($bookTypes) !!};
            const AllSlug = types.map(object => object.slug);

            console.log(slug);

            AllSlug.forEach((item,i)=>{
                const temp = item.toLowerCase().normalize();


                if(temp == slug){
                    console.log(true);
                    $('#addTypebtn').prop('disabled', true);
                    $('input[name="type_slug"]').parent().next().show('slow');

                }
               
            })
        }
    
    }
   

    $(document).on('click','#addTypebtn',function (e) {
        const text = $('input[name="type_name').val();
        const slug = $('input[name="type_slug').val();

        console.log(text,slug);
        if(text){

            $.ajax({
                url:'/admin/categoryBook',
                type:"POST",
                data:{
                    'name': text,
                    'slug':slug,
                }
            })
            .done(function(res) {  
                Swal.fire({
                    icon: 'success',
                    title: `${res.success}`,
                    showConfirmButton: false,
                    timer: 2500
                });


                window.location.reload();


                
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
            })
        
        }
    })
     
  
        
</script>
@endsection