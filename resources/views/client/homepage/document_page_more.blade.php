@extends('client/homepage.layouts.app')
@section('additional-style')
<style>
    .high_downloading_documents:hover{
        background-color:rgba(34,197,94,0.9);
    }
</style>
@endsection
@section('content')

      
    <div class="container">
        <div class="nk-block">
            <div class="row">
                @foreach ($documents as $document)
                <div class="col-lg-3 col-md-6 mt-3">
                    <div class="card card-bordered product-card shadow">
                        <div class="product-thumb">                             
                                <img class="card-img-top" src="{{ $document->url }}" alt="" width="300px" height="400px">    
                                                         
                                <div class="product-actions high_downloading_documents w-100 h-100">
                                    <div class="pricing-body w-100 h-100  d-flex text-center align-items-center">      
                                        <div class="row">
                                            <div class="pricing-amount">
                                                <h6 class="bill text-white">{{ $document->name }}</h6>
                                                <p class="text-white">Số trang: {{ $document->numberOfPages }}</p>
                                                <p class="text-white">Lượt tải: {{ $document->totalDownloading }}</p>
                                            </div>
                                            <div class="pricing-action">
                                                <a href="/tai-lieu/{{$document->id}}/{{$document->slug}}" class="btn btn-outline-light">Chi tiết</a>
                                            </div>
                                        </div>                                      
                                        
                                    </div>
                                </div>
                        </div>
                     
                    </div>
                </div>
            @endforeach   
            </div>      
        </div>

    <div class="col-md-12 d-flex justify-content-end">                          

        {{ $documents->links('vendor.pagination.custom',['elements' => $documents]) }}
    </div>
    </div>
      

@endsection