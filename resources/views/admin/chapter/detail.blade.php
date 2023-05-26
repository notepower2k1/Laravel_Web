@extends('admin/layouts.app')
@section('pageTitle', 'Chi tiết chương')

@section('content')
<nav>
    <ul class="breadcrumb breadcrumb-arrow">
        <li class="breadcrumb-item"><a href="/admin/book">Sách</a></li>
        <li class="breadcrumb-item"><a href="/admin/book/chapter/{{ $chapter->book_id }}">Chương</a></li>
        <li class="breadcrumb-item active">Chi tiết</li>

    </ul>
</nav>
<div>
    <div class="d-flex justify-content-end mb-2"  id="chapter-render-div">

        @if($chapter->deleted_at == null)
        <a href="#" class="btn btn-outline-danger delete-button" data-id="{{ $chapter->id }}" data-name="{{ $chapter->code }}">
            <em class="icon ni ni-trash"></em><span>Xóa</span>
        </a>
        @else
        <button class="btn btn-outline-primary" id="verification_item_button" data-id="{{ $chapter->id }}" data-name="{{ $chapter->code }}">
            <em class="icon ni ni-file-check-fill"></em>
            <span>Khôi phục dữ liệu</span>
        </button>
        @endif
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
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

@endsection

@section('additional-scripts')
<script>
     $('.delete-button').on('click',function(){
        var chapter_id = $(this).data('id');
        var name = $(this).data('name');
        var token = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
            title: "Bạn muốn xóa chương "+ name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xóa chương',
            cancelButtonText: 'Không'
            }).then((result) => {
            if (result.isConfirmed) {
            
                $.ajax({
                    type:"GET",
                    url:'/admin/book/chapter/customDelete/' + chapter_id,
                    data : {
                    },
                    })
                    .done(function() {
                    // If successful
                        Swal.fire({
                            icon: 'success',
                            title: `Xóa chương ${name} thành công`,
                            showConfirmButton: false,
                            timer: 2500
                        });

                        $('#chapter-render-div').load(' #chapter-render-div > *')

                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                    // If fail
                    console.log(textStatus + ': ' + errorThrown);
                    })
            
            }
        })
  })

  $(document).on('click','#verification_item_button',function(){
        var chapter_id = $(this).data('id');

      var data = [];
  
        data.push(chapter_id);
     

      $.ajax({ 
        type:"GET",
        url:'/admin/deleted/chapter/recovery',
        data: {'data':data}   
        })
        .done(function() {
        // If successful

      
          Swal.fire({
            icon: 'success',
            title: `Khôi phục thành công!!!`,
            showConfirmButton: false,
            timer: 2500
          });

          $('#chapter-render-div').load(' #chapter-render-div > *')


        })
        .fail(function(jqXHR, textStatus, errorThrown) {
        // If fail
          Swal.fire({
                      icon: 'error',
                      title: `Đổi trạng thái không thành công`,
                      showConfirmButton: false,
                      timer: 2500
                  });
        })

    

    })
</script>
@endsection