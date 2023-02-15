@extends('client/layouts.app')
@section('content')
<div class="row my-3">

    <form action="/forum/post/{{ $forumPost->id }}" method="post">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger">
          Delete
        </button>
      </form>

    <h1>{{ $forumPost->topic }}</h1>
    <p>{{ $forumPost->content }}</p>
    
    </div>
@endsection