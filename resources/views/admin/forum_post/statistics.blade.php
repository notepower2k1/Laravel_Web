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
                    Diễn đàn: {{ $forum_name }} (Năm: {{ $statisticsYear }})
                </h3>
              
                <div class="row g-gs">
                    <div class="col-8">
                        <div class="forum-change-div">
                            <select id="forum-select">
                                <option></option>
        
                                @foreach ($all_forum as $forum)
                                    <option value="{{ $forum->id }}">{{ $forum->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="year-change-div">
                            <select id="year-select">
                                <option></option>
        
                                @foreach ($allYears as $year)
                                    <option value="{{ $year->year }}">Năm {{ $year->year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
               
               
            </div>
            <div class="row g-gs" id ="post-render-div">
                @foreach ($all_posts as $post)
                    <div class="col-sm-6 col-lg-6 col-xxl-6">
                        <div class="gallery card card-bordered">
                            @if($post->firstImage)
                            <a class="gallery-image popup-image" href="{{ $post->firstImage }}">
                                <img class="w-100 rounded-top" src="{{ $post->firstImage }}" style="height:270px" alt="">
                            </a>

                            @else
                            <a class="gallery-image popup-image" href="https://raw.githubusercontent.com/notepower2k1/MyImage/main/banner/post_no_Image.png">
                                <img class="w-100 rounded-top" src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/banner/post_no_Image.png" style="height:270px" alt="">
                            </a>

                            @endif
                        
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

                                    <a href="/admin/forum/post/{{ $post->id }}/detail" class="me-2">
                                        <em class="icon ni ni-info"></em><span>Chi tiết</span>                         
                                    </a>



                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="data-container"></div>
            <div class="col-md-12 d-flex justify-content-end mt-4">                          
                <div id="pagination"></div>
            </div>
          
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
        var forum_id = $(this).find('option:selected').val();
        window.location.href = `/admin/statistics/post/${forum_id}/${yearSelected}`;

    });

    $("#year-select").change(function(){

        var yearSelected = $(this).find('option:selected').val();
        var forum_id = {!! $forum_id !!};
        window.location.href = `/admin/statistics/post/${forum_id}/${yearSelected}`;


    });
</script>
@endsection