@extends('admin/layouts.app')
@section('content')
    <a href="/admin/forum/post/create/{{$forum_id}}" class="btn btn-primary">Thêm bài đăng</a>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">Topic</th>
            <th >Created by</th>
            <th>Created At</th>
            <th >Last Update</th>
            <th> Actions</th>
          </tr>
        </thead>
        <tbody>
         @foreach ($forum_posts as $forum_post)
          <tr id ="row-{{ $forum_post->id }}">
            <td>{{  $forum_post->topic  }}</td>
            <td>{{  $forum_post->userCreatedID  }}</td>
            <td>{{ $forum_post->created_at }}</td>
            <td>{{ $forum_post->updated_at}}</td>
            <td>
              <a href="/admin/forum/post/{{$forum_post->id}}/edit" class="btn btn-primary">Edit</a>
              <button class="btn btn-primary delete-button" data-id="{{ $forum_post->id }}" data-name="{{ $forum_post->topic }}">Delete</button>
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
    var forum_postID = $(this).data('id');
    var name = $(this).data('name');
    var token = $("meta[name='csrf-token']").attr("content");

    if (confirm("Xóa post "+name) == true) {
        $.ajax({
          type:"DELETE",
          url:'/admin/forum/post/' + forum_postID,
          data : {
            "id": forum_postID,
            "_token": token,
          },
          })
          .done(function() {
          // If successful
            alert("Xóa forum thành công");
            $("#row-" + forum_postID).fadeOut();
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