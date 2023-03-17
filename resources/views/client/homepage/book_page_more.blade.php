@extends('client/layouts.app')
@section('pageTitle', `${{$title}}`)

@section('content')

    <div class="nk-block-head nk-block-head-sm">
      <div class="nk-block-between">
          <div class="nk-block-head-content">
              <h3 class="nk-block-title page-title">{{ $title }}</h3>
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
        @foreach ($books as $book)

          <div class="col-xxl-2 col-lg-2 col-sm-6">
              <div class="card card-bordered product-card">
                  <div class="product-thumb">
                      <a href="/sach/{{$book->id}}/{{$book->slug}}">
                          <img class="card-img-top" src="{{ $book->url }}" alt="" width="400px" height="300px">
                      </a>
                      <ul class="product-badges">
                          <li><span class="badge bg-success">Mới</span></li>
                      </ul>             
                  </div>
                  <div class="card-inner text-center">
                      <ul class="product-tags">
                          <li>
                            <div class="rateYo" data-rateyo-read-only="true" data-rateyo-rating='{{ $book->ratingScore }}'></div>
                          </li>
                      </ul>
                      <h5 class="product-title" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $book->name }}" ><a href="/sach/{{$book->id}}/{{$book->slug}}"> {{ Str::limit($book->name,40)}}</a></h5>
                      <small class="text-muted fs-13px"><em class="icon ni ni-book-read"></em> {{ $book->numberOfChapter }} Chương</small>
                  </div>
              </div>
          </div><!-- .col -->
        @endforeach



      </div>
  </div><!-- .nk-block -->
    <div class="col-md-12">                          

        {{ $books->links('vendor.pagination.custom',['elements' => $books]) }}
    </div>
@endsection
@section('additional-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

<script>
    $(function () {
        $(".rateYo").rateYo({
            starWidth: "20px"
        });
    });
</script>
@endsection
