@extends('admin/layouts.app')
@section('pageTitle', 'Chi tiết sách điện tử')
@section('content')
<div class="nk-block-head-sub"><a class="back-to" href="{{ url()->previous() }}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>
    <div class="row d-flex justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="row">         
                    <div class="col-md-6">
                        <div class="images">
                            <div class="text-center p-4"> <img class="img-fluid" id="main-image" src={{ asset ('storage/'.$book->image) }} alt="..." style="width:800px;height:600px;" /> </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                              
                            <div class="d-flex justify-content-between">
                            <h3 class="text-uppercase ">{{$book->name}}</h3>      
                            </div>
                            <div>
                            <span class="text-muted brand">Thể loại: {{ $book->types->name }}</span>
                            </div> 
                            <div>
                            <span class="text-muted brand">Tác giả: {{$book->author}}</span>
                            </div>
                            <span class="text-decoration-underline" >Nội dung:</span>
                               
                            <div id="divhtmlContent">{{$book->description}}</div>

                            
                            
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('additional-scripts')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<script>

    var value = document.getElementById('divhtmlContent').textContent;
    document.getElementById('divhtmlContent').innerHTML =
          marked.parse(value);
 </script>
@endsection