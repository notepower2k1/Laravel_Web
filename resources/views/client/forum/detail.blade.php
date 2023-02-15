@extends('client/layouts.app')
@section('content')
<div class="row my-3">

    <a class="btn btn-primary" href="./{{ $forum_slug }}/dang-bai-viet">Đăng bài</a>
    @foreach ($forumPosts as $forumPost)

    
    <a href="./{{ $forum_slug }}/{{ $forumPost->slug }}">{{ $forumPost->topic }}</a>

    @endforeach
    </div>
@endsection 