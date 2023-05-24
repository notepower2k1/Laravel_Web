@extends('admin/layouts.app')
@section('pageTitle', 'Thống kê bài viết')
@section('additional-style')
<link href="{{ asset('js/pagination/pagination.css') }}" rel="stylesheet" type="text/css">

@endsection
@section('content')
<div class="container">
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <h3>
                    Diễn đàn: {{ $forum_name }} ( {{ $statisticsMonth }}/{{ $statisticsYear }} )
                </h3>
              
                <div class="row g-gs">
                    <div class="col-6">
                        <div class="forum-change-div">
                            <select id="forum-select">
                                <option></option>
        
                                @foreach ($all_forum as $forum)
                                    <option value="{{ $forum->id }}">{{ $forum->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="year-change-div">
                            <select id="year-select">
                                <option></option>
        
                                @foreach ($allYears as $year)
                                    <option value="{{ $year->year }}">Năm {{ $year->year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="month-change-div">
                            <select id="month-select">
                                <option></option>
                                @for ($i = 1 ; $i < 13 ; $i++)
                                    <option value="{{ $i }}">Tháng {{$i}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-sm-4">
                        <div class="card">
                            <div class="nk-ecwg nk-ecwg6">
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">Số lượt bình luận</h6>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="data-group d-flex justify-content-between align-items-center">
                                            <div class="amount">
                                                <em class="icon icon-circle bg-primary-dim ni ni-comments"></em>                                            
                                                {{ $totalComments }}
                                            </div>

                                            @if($percentGrowthComment == 0)

                                            @else
                                                @if ($percentGrowthComment > 0)
                                                <div class="info"><span class="change down text-success"><em class="icon ni ni-arrow-long-up"></em>{{ $percentGrowthComment }}</span><span> so với tháng {{ $previousMonth }}</span></div>
                                                @else
                                                <div class="info"><span class="change down text-danger"><em class="icon ni ni-arrow-long-down"></em>{{ $percentGrowthComment }}</span><span>  so với tháng {{ $previousMonth }}</span></div>
                                                @endif
                                            @endif
                                         
                                        </div>
                                    </div>
                                </div><!-- .card-inner -->
                            </div><!-- .nk-ecwg -->
                        </div><!-- .card -->
                    </div><!-- .col -->
                    <div class="col-xxl-4 col-sm-4">
                        <div class="card">
                            <div class="nk-ecwg nk-ecwg6">
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">Số lượt xem</h6>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="data-group d-flex justify-content-between align-items-center">
                                            <div class="amount">
                                                <em class="icon icon-circle bg-secondary-dim ni ni-eye"></em>            
                                                {{ $totalViews }}
                                            </div>
                                            @if($percentGrowthView == 0)

                                            @else
                                                @if ($percentGrowthView > 0)
                                                <div class="info"><span class="change down text-success"><em class="icon ni ni-arrow-long-up"></em>{{ $percentGrowthView }}</span><span> so với tháng {{ $previousMonth }}</span></div>
                                                @else
                                                <div class="info"><span class="change down text-danger"><em class="icon ni ni-arrow-long-down"></em>{{ $percentGrowthView }}</span><span>  so với tháng {{ $previousMonth }}</span></div>
                                                @endif
                                            @endif                                
                                        </div>
                                    </div>
                                </div><!-- .card-inner -->
                            </div><!-- .nk-ecwg -->
                        </div><!-- .card -->
                    </div><!-- .col -->
                    <div class="col-xxl-4 col-sm-4">
                        <div class="card">
                            <div class="nk-ecwg nk-ecwg6">
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">Số bài viết</h6>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="data-group  d-flex justify-content-between align-items-center">
                                            <div class="amount">
                                                <em class="icon icon-circle bg-info-dim ni ni-list-fill"></em>            
                                                {{ $all_posts->count() }}
                                            </div>
                                            @if($percentGrowthPost == 0)

                                            @else
                                                @if ($percentGrowthPost > 0)
                                                <div class="info"><span class="change down text-success"><em class="icon ni ni-arrow-long-up"></em>{{ $percentGrowthPost }}</span><span> so với tháng {{ $previousMonth }}</span></div>
                                                @else
                                                <div class="info"><span class="change down text-danger"><em class="icon ni ni-arrow-long-down"></em>{{ $percentGrowthPost }}</span><span>  so với tháng {{ $previousMonth }}</span></div>
                                                @endif
                                            @endif                                
                                        </div>
                                    </div>
                                </div><!-- .card-inner -->
                            </div><!-- .nk-ecwg -->
                        </div><!-- .card -->
                    </div><!-- .col -->
                </div>
                </div>
               
               
        
           
            <div class="row g-gs" id ="post-render-div">
             
             
                @foreach ($all_posts as $post)
                    <div class="col-sm-6 col-lg-6 col-xxl-6">
                        <div class="gallery card card-bordered">
                            @if($post->firstImage)
                            <a href="/admin/forum/post/{{ $post->id }}/detail">
                                <img class="w-100 rounded-top" src="{{ $post->firstImage }}" style="height:270px" alt="">
                            </a>

                            @else
                            <a  href="/admin/forum/post/{{ $post->id }}/detail">
                                <img class="w-100 rounded-top" src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/banner/post_no_Image.png" style="height:270px" alt="">
                            </a>

                            @endif
                            <h5 class="text-center mt-2">
                                {{ Str::limit($post->topic,40) }}
                            </h5>
                            <div class="gallery-body card-inner align-center justify-between flex-wrap g-2">
                             
                                <div class="user-card">
                                 
                                    <div class="user-avatar">
                                        <img src="{{ $post->users->profile->url }}" alt="">
                                    </div>
                                    <div class="user-info">
                                        <span class="lead-text">{{ $post->users->profile->displayName }}</span>
                                        <span class="sub-text">{{ $post->users->email }}</span>
                                    </div>
                                </div>
                                <div class="">
                                    
                                    <span class="me-2">
                                        <em class="icon ni ni-comments"></em><span>{{ $post->totalComments }}</span>

                                    </span>

                                    <span class="me-2">
                                        <em class="icon ni ni-eye"></em><span>{{ $post->totalViews }}</span>
                                    </span>

                                



                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($all_posts->count() > 0)
                <div class="data-container"></div>
                <div class="col-md-12 d-flex justify-content-end mt-4">                          
                    <div id="pagination"></div>
                </div>
            @endif

         
        </div>
    </div>
</div>


@endsection

    
@section('additional-scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<script src="{{ asset('js/pagination/pagination.min.js') }}" ></script>

<script>
    $(function(){
        $('#forum-select').select2({
            placeholder:"Đổi diễn đàn",

        });

        $('#year-select').select2({
            placeholder:"Đổi năm",
        });

        $('#month-select').select2({
            placeholder:"Đổi tháng",
        });

        postRender();
    })

    function postRender(){
        const container = $('#pagination');

  

        if (!container.length) return;
            var sources = function () {
            var result = [];

            $('#post-render-div').children().each(function(item){

                result.push($(this).get(0).outerHTML);

            })
        return result;
        }();

        var options = {
            dataSource: sources,
            pageSize:4,
            callback: function (response, pagination) {
                var dataHtml = '<div class="row g-gs">';

                $.each(response, function (index, item) {
                    dataHtml += item;
                });

                dataHtml += '</div>';

                container.parent().prev().html(dataHtml);
                $('#post-render-div').remove();
            }
        };


  
        container.pagination(options);
    }
    $("#forum-select").change(function(){
        var yearSelected = {!! $statisticsYear !!};
        var monthSelected = {!! $statisticsMonth !!};

        var forum_id = $(this).find('option:selected').val();
        window.location.href = `/admin/statistics/post/${forum_id}/${monthSelected}/${yearSelected}`;

    });

    $("#year-select").change(function(){

        var yearSelected = $(this).find('option:selected').val();
        var monthSelected = {!! $statisticsMonth !!};
        var forum_id = {!! $forum_id !!};
        window.location.href = `/admin/statistics/post/${forum_id}/${monthSelected}/${yearSelected}`;


    });

    $("#month-select").change(function(){

        var yearSelected = {!! $statisticsYear !!};        
        var forum_id = {!! $forum_id !!};
        var monthSelected = $(this).find('option:selected').val();

        window.location.href = `/admin/statistics/post/${forum_id}/${monthSelected}/${yearSelected}`;
    });

    
</script>
@endsection