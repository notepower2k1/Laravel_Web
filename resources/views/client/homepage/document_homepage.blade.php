@extends('client/layouts.app')
@section('content')
<div class="row my-3">

  <div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <h3 class="nk-block-title page-title">Tài liệu</h3>
        </div><!-- .nk-block-head-content -->
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">
                        <li class="nk-block-tools-opt">
                            <a href="#" class="btn btn-icon btn-primary d-md-none"><em class="icon ni ni-eye"></em></a>
                            <a href="#" class="btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-eye"></em><span>Xem thêm</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div><!-- .nk-block-head-content -->
    </div><!-- .nk-block-between -->
</div><!-- .nk-block-head -->
<div class="nk-block">
    <div class="row g-gs">
      @foreach ($documents as $document)

        <div class="col-xxl-2 col-lg-2 col-sm-6">
            <div class="card card-bordered product-card">
                <div class="product-thumb">
                    <a href="/tai-lieu/{{$document->id}}/{{$document->slug}}">
                        <img class="card-img-top" src="{{ $document->url }}" alt="" width="400px" height="300px">
                    </a>
                    @if(\Carbon\Carbon::parse($document->created_at)->isToday())
                    <ul class="product-badges">
                        <li><span class="badge bg-success">Mới</span></li>
                    </ul>    
                    @endif              
                </div>
                <div class="card-inner text-center">             
                    <h5 class="product-title"><a href="/tai-lieu/{{$document->id}}/{{$document->slug}}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $document->name }}">{{ Str::limit($document->name,30)}}</a></h5>

                    <small class="text-muted fs-13px"><em class="icon ni ni-file"></em> {{ $document->numberOfPages }}</small>
                    <small class="text-muted fs-13px ms-3"><em class="icon ni ni-download"></em> {{ $document->totalDownloading }}</small>

                </div>
            </div>
        </div><!-- .col -->
      @endforeach
    </div>
    <div class="col-md-12">                          

        {{ $documents->links('vendor.pagination.custom',['elements' => $documents]) }}
    </div>
</div><!-- .nk-block -->
@endsection