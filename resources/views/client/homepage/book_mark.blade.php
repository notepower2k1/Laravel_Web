@extends('client/homepage.layouts.app')
@section('content')
<div class="nk-block nk-block-lg">
    <div class="nk-block-head">
      
    </div>
    <div class="card card-bordered card-preview" id="mark-book-box">
        <table class="table table-ulogs">
            <thead class="table-light">
                <tr>
                    <th class="nk-tb-col tb-col-mb"><span class="overline-title">Sách</span></th>
                    <th class="nk-tb-col tb-col-lg"><span class="overline-title">Số chương</span></th>
                    <th class="nk-tb-col nk-tb-col-tools text-end"><span class="overline-title">#</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($book_marks as $book_mark)

                <tr id ="row-{{ $book_mark->id }}" class=" {{ $book_mark->status==1?"bg-primary-dim":"" }}">
                    <td class="nk-tb-col tb-col-mb">
                        {{-- <a href="{{$book_mark->books->id}}/{{$book_mark->books->slug}}">
                            {{ $book_mark->books->name }}
                        </a> --}}
                        <div class="user-card">
                            <div class="avatar bg-primary">
                                <a href="/sach/{{$book_mark->books->id}}/{{$book_mark->books->slug}}">
                                    <img class="image-fluid" src={{ $book_mark->books->url }} alt="..." style="width:100px" />
                                </a>
                            </div>
                            <div class="ms-2">
                                <span class="tb-lead text-">{{ $book_mark->books->name }}<span class="dot dot-success d-md-none ms-1"></span></span>
                            </div>
                        </div>
                    </td>
                    <td class="nk-tb-col tb-col-lg"><span class="sub-text">{{ $book_mark->books->numberOfChapter }}</span></td>

                    
                    <td class="nk-tb-col nk-tb-col-tools text-end">
                        <ul class="nk-tb-actions gx-1">                             
                          
                            <li class="me-2">

                                @if($book_mark->status==1)
                                <button class="btn btn-info me-sm-n1 check-book-mark" data-id="{{ $book_mark->id }}" data-name="{{ $book_mark->books->name }}">
                                    <em class="icon ni ni-check-thick"></em></button>
                                @else
                                <button class="btn btn-info me-sm-n1 check-book-mark" disabled>
                                    <em class="icon ni ni-check-thick"></em></button>
                                @endif
                            </li>
                            <li>
                                <button class="btn btn-danger me-sm-n1 remove-book-mark" data-id="{{ $book_mark->id }}" data-name="{{ $book_mark->books->name }}">
                                    <em class="icon ni ni-cross"></em></button>
                            </li>
                                      
                                    
                            
                        </ul>
                        
                    </td>
                </tr>
                @endforeach
                {{ $book_marks->links('vendor.pagination.custom',['elements' => $book_marks]) }}


            </tbody>
        </table>

        
    </div><!-- .card-preview -->
</div>

@endsection
@section('additional-scripts')
<script src="{{ asset('assets/js/example-sweetalert.js?ver=3.1.2') }}" aria-hidden="true"></script>

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.remove-book-mark').click(function(){
    var book_mark_id = $(this).attr("data-id");
    var book_mark_name = $(this).attr("data-name");


    Swal.fire({
        title: "Bạn muốn bỏ theo dõi "+ book_mark_name,
        text: "Bạn sẽ không còn được nhận thông báo khi có chương mới!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Bỏ theo dõi',
        cancelButtonText: 'Không'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type:"DELETE",
                url:'/sach-theo-doi/' + book_mark_id,
                data : {
                    "id": book_mark_id
                },
                })
                .done(function(res) {
                // If successful
                        Swal.fire({
                        icon: 'success',
                        title: `${res.success}`,
                        showConfirmButton: false,
                        timer: 2500
                    });
                    $("#row-" + book_mark_id).fadeOut();
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                })
         
        }
        })
   
})


$(document).on('click','.check-book-mark',function() {
    var book_mark_id = $(this).attr("data-id");
    var book_mark_name = $(this).attr("data-name");


    Swal.fire({
        title: "Bạn muốn đánh dấu đã đọc "+ book_mark_name,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đánh dấu',
        cancelButtonText: 'Không'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type:"GET",
                url:'/bookmark-status-update-no-direct',
                data : {
                    "id": book_mark_id
                    },
                })
                .done(function(res) {
                // If successful
                        Swal.fire({
                        icon: 'success',
                        title: `${res.success}`,
                        showConfirmButton: false,
                        timer: 2500
                    });

                    $("#mark-book-box").load(" #mark-book-box > *");
                    $("#bookMark_notifications_box").load(" #bookMark_notifications_box > *");

                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                })
         
        }
        })
})
</script>
@endsection