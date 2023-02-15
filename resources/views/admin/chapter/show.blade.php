@extends('admin/layouts.app')
@section('content')
    <a href="/admin/book/chapter/create/{{$book_id}}" class="btn btn-primary">Thêm chương</a>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">Chương số</th>
            <th >Tên</th>
            <th >Lasted Update</th>
            <th >Actions</th>
          </tr>
        </thead>
        <tbody>
         @foreach ($chapters as $chapter)
          <tr id ="row-{{ $chapter->id }}">
            <td>{{ $chapter->code }}</td>
            <td>{{ $chapter->name }}</td>
            <td>{{ $chapter->updated_at }}</td>
            <td>
              <a href="/admin/book/chapter/{{$chapter->id}}/edit" class="btn btn-primary">Edit</a>
              <button href="" class="btn btn-primary delete-button" data-id="{{ $chapter->id }}" data-name="{{ $chapter->code }}">Delete</button>
            </td>
          
          

          </tr>
          @endforeach

        </tbody>
      </table>

@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

  $(function(){
  $('.delete-button').click(function(){
    var chapter_id = $(this).data('id');
    var name = $(this).data('name');
    var token = $("meta[name='csrf-token']").attr("content");

    if (confirm("Xóa "+name) == true) {
        $.ajax({
          type:"DELETE",
          url:'/admin/book/chapter/' + chapter_id,
          data : {
            "id": chapter_id,
            "_token": token,
          },
          })
          .done(function() {
          // If successful
            alert("Xóa chương thành công");
            $("#row-" + chapter_id).fadeOut();
          })
          .fail(function(jqXHR, textStatus, errorThrown) {
          // If fail
          console.log(textStatus + ': ' + errorThrown);
          })
    } else {

    }
  })
});



</script>

@section('additional-scripts')
@endsection