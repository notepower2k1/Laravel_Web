@extends('client/layouts.app')
@section('content')
{{-- <div class="row my-3">

    @foreach ($books as $book)

    <div class="col-sm-4">
    
    <div class="card mb-3">
    <img src="{{ $book->url }}"  class="card-img-top img-fluid" alt="..." style="width:600px;height:400px;">
      <div class="card-body">
        <h5 class="card-title">{{$book->name}}</h5>
        <p class="card-text ">Tác giả: {{$book->author}}</p>
         
        <a href="{{$book->id}}/{{$book->slug}}" class="btn btn-primary">Đọc sách</a>
      </div>
    </div>
            </div>
    
    @endforeach
    </div> --}}

     
      @endsection