@extends('admin/layouts.app')
@section('content')
    <a href="{{ route('book.create') }}" class="btn btn-primary">Thêm truyện</a>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th >Author</th>
            <th >Type</th>
            <th >Last update</th>
            <th >Actions</th>
            <th >Status</th>
            <th> Chapters </th>
          </tr>
        </thead>
        <tbody>
         @foreach ($books as $book)
          <tr id ="row-{{ $book->id }}">
            <td><a href="/admin/book/{{ $book->id }}">{{ $book->name }}</a></td>
            <td>{{ $book->author }}</td>
            <td>{{ $book->types->name }}</td>
            <td>{{ $book->updated_at }}</td>
            <td>
              <a href="/admin/book/{{$book->id}}/edit" class="btn btn-primary">Edit</a>
              <button href="" class="btn btn-primary delete-button" data-id="{{ $book->id }}" data-name="{{ $book->name }}">Delete</button>
            </td>
            <td>
              <div class="form-check form-switch">
                <input class="form-check-input" 
                type="checkbox" role="switch" 
                id="flexSwitchCheckChecked" 
                data-id="{{ $book->id }}"
                {{ $book->status? 'checked':'' }}/>
              </div>
            </td>
            <td> <a href="/admin/book/chapter/{{ $book->id }}" class="btn btn-primary">Chapter</a></td>

          </tr>
          @endforeach

        </tbody>
      </table>

@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

  $(function(){
    $('.form-check-input').change(function() {
      var status = $(this).prop('checked') == true ? 1 :0;
      var book_id = $(this).data('id');

      $.ajax({
        type:"GET",
        url:'/admin/book/update/changeStatus',
        data: {'status':status,'id':book_id}   
        })
        .done(function() {
        // If successful
          console.log("Success");

        })
        .fail(function(jqXHR, textStatus, errorThrown) {
        // If fail
        console.log(textStatus + ': ' + errorThrown);
        })
  })

  $('.delete-button').click(function(){
    var book_id = $(this).data('id');
    var name = $(this).data('name');
    var token = $("meta[name='csrf-token']").attr("content");

    if (confirm("Xóa sách "+name) == true) {
        $.ajax({
          type:"DELETE",
          url:'/admin/book/' + book_id,
          data : {
            "id": book_id,
            "_token": token,
          },
          })
          .done(function() {
          // If successful
            alert("Xóa sách thành công");
            $("#row-" + book_id).fadeOut();
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