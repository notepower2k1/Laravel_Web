@extends('client/layouts.app')
@section('content')
<div class="row my-3">

    @foreach ($forums as $forum)

    <a href="forum/{{ $forum->slug }}">{{ $forum->name }}</a>
    
    @endforeach
    </div>
@endsection