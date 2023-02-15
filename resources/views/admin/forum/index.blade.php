@extends('admin/layouts.app')
@section('content')
    <a href="{{ route('forum.create') }}" class="btn btn-primary">Thêm diễn đàn</a>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th >Create At</th>
            <th >Last update</th>
            <th>Actions</th>
            <th >Status</th>
            <th> Post in Forums </th>
          </tr>
        </thead>
        <tbody>
         @foreach ($forums as $forum)
          <tr id ="row-{{ $forum->id }}">
            <td>{{  $forum->name  }}</td>
            <td>{{ $forum->created_at }}</td>
            <td>{{ $forum->updated_at}}</td>
            <td>
              <a href="/admin/forum/{{$forum->id}}/edit" class="btn btn-primary">Edit</a>
              <button href="" class="btn btn-primary delete-button" data-id="{{ $forum->id }}" data-name="{{ $forum->name }}">Delete</button>
            </td>
            <td>
              <div class="form-check form-switch">
                <input class="form-check-input" 
                type="checkbox" role="switch" 
                id="flexSwitchCheckChecked" 
                data-id="{{ $forum->id }}"
                {{ $forum->status? 'checked':'' }}/>
              </div>
            </td>
            <td> <a href="/admin/forum/post/{{ $forum->id }}" class="btn btn-primary">Posts</a></td>

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
      var forum_id = $(this).data('id');

      $.ajax({
        type:"GET",
        url:'/admin/forum/update/changeStatus',
        data: {'status':status,'id':forum_id}   
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
    var forum_id = $(this).data('id');
    var name = $(this).data('name');
    var token = $("meta[name='csrf-token']").attr("content");

    if (confirm("Xóa forum "+name) == true) {
        $.ajax({
          type:"DELETE",
          url:'/admin/forum/' + forum_id,
          data : {
            "id": forum_id,
            "_token": token,
          },
          })
          .done(function() {
          // If successful
            alert("Xóa forum thành công");
            $("#row-" + forum_id).fadeOut();
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