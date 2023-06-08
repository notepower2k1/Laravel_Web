@extends('admin/layouts.app')
@section('pageTitle', 'Chi tiết bài đăng')



@section('content')


<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="nk-block">
            <div class="container">
                <ul class="breadcrumb breadcrumb-arrow">
                    <li class="breadcrumb-item"><a href="/admin/forum">Diễn đàn</a></li>
                    <li class="breadcrumb-item"><a href="/admin/forum/post/{{ $post->forumID }}">Bài đăng</a></li>
                    <li class="breadcrumb-item active">Chi tiết</li>
                </ul>	
                <hr>
                
                    <div class="d-flex justify-content-end mb-2" id="post-render-div">
                
                        @if($post->deleted_at == null)
                        <a href="#" class="btn btn-outline-danger delete-button" data-id="{{ $post->id }}" data-name="{{ $post->topic }}">
                            <em class="icon ni ni-trash"></em><span>Xóa</span>
                        </a>
                        @else
                        <button class="btn btn-outline-primary" id="verification_item_button" data-id="{{ $post->id }}" data-name="{{ $post->topic }}">
                            <em class="icon ni ni-file-check-fill"></em>
                            <span>Khôi phục dữ liệu</span>
                        </button>
                        @endif
                    </div>
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="row g-gs flex-lg-row-reverse">
                        
                            <div class="col-lg-12">
                                <div class="entry me-xxl-3">
                                
                                <div class="d-flex align-content-center">
                                    <h3>{{ $post->topic }}   
                                </h3>
                                
                                    
                                </div>
                                    <span class="text-mute ff-italic fw-bold">Đăng bởi: <a href="/thanh-vien/{{ $post->users->id }}" class="text-primary fs-14px">{{ $post->users->profile->displayName }}</a></span>
                                    <br>
                                    <span class="text-mute ff-italic fw-bold">Ngày đăng: {{ $post->created_at->format("H:i Y/m/d") }} </span>
            
                                <div>
                                    {!! clean($post->content) !!}
            
                                </div>
                                </div>
            
                            
                            </div><!-- .col -->
                        </div><!-- .row -->
                        <div class="d-flex align-items-center border bg-gray-200 p-1 mt-3 fs-11px">
                        <em class="icon ni ni-clock"></em>
                        <span> Update vào lúc {{  $post->updated_at->format("H:i Y/m/d") }}</span>  
                        </div>
                    </div>
                  
            
                </div>
                
                <div class="mt-5 d-flex justify-content-center">
                    <div class="dropdown ">
                        <a href="#" class="btn btn-primary btn-lg d-none d-sm-inline-flex" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em><span>Chọn năm</span></a>
                        <a href="#" class="btn btn-icon  btn-lg btn-primary d-sm-none" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <ul class="link-list-opt no-bdr">
                                @foreach ($allYears as $year)
                                    <li><a href="/admin/forum/post/{{ $post->id }}/{{ $year->year }}/detail"><em class="icon ni ni-calendar"></em><span>Năm {{ $year->year }} </span></a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
    
                <div class="">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tabItem7">Số bình luận</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tabItem8">Thống kê số lượt bình luận</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabItem7">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <table class="datatable-init-export nowrap nk-tb-list nk-tb-ulist mt-2" data-auto-responsive="false" data-export-title="Export">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head">
                                                <th class="nk-tb-col"><span class="sub-text">Ngày bình luận</span></th>
                                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">Người bình luận</span></th>
                                
                                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">Số lượt phản hồi</span></th>
                                                <th class="nk-tb-col nk-tb-col-tools text-end">
                                              </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach ($comments as $comment)
                                
                                            <tr class="nk-tb-item" id ="row-{{ $comment->id }}">
                                                <td class="nk-tb-col">
                                                  <span>{{  $comment->created_at  }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                  <span>{{  $comment->users->name  }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                  <span>{{  $comment->totalReplies  }}</span>
                                                </td>
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                  <ul class="nk-tb-actions gx-1">                       
                                                      <li>
                                                          <div class="drodown">
                                                              <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                              <div class="dropdown-menu dropdown-menu-end">
                                                                  <ul class="link-list-opt no-bdr">
                                                                      <li>
                                                                        <a href="#" class="content-btn" data-id={{ $comment->id }}>
                                                                          <em class="icon ni ni-notice"></em><span>Nội dung</span>
                                                                        </a>
                                
                                                                      </li>
                                                                      <li><a href="/admin/comment/replies/{{ $comment->id }}"><em class="icon ni ni-reply-all"></em><span>Xem phản hồi</span></a></li>
                                                                  
                                                                  </ul>
                                                              </div>
                                                          </div>
                                                      </li>
                                                  </ul>
                                                </td>
                                            </tr><!-- .nk-tb-item  -->
                                          @endforeach
                                
                                        </tbody>
                                    </table> 
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabItem8">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="row g-gs">
                                        <div class="col-12" id="statistics-7">
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner">
                                                    <div class="card-title-group align-start gx-3 mb-3">
                                                        <div class="card-title">
                                                            <h6 class="title">Thống kê số bình luận & phản hồi</h6>
                                                            <p>Thống kê tổng số lượt bình luận trong vòng 12 tháng</p>
                                                        </div>
                                                        <div class="card-tools">
                                                            <div class="dropdown">
                                                                <div id="report-total-comment-btn">
                                                                    <a href="#" class="btn btn-danger btn-dim d-none d-sm-inline-flex"><em class="icon ni ni-reports"></em><span>Xuất báo cáo</span></a>
                                                                    <a href="#" class="btn btn-icon btn-danger btn-dim d-sm-none"><em class="icon ni ni-reports"></em></a>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="nk-sale-data-group align-center justify-between gy-3 gx-5">
                                                        <div class="nk-sale-data">
                                                            <span class="amount sm">Tổng lượt bình luận: {{ $totalCommentsInYear }}</span>
                                                            <span class="amount sm">Tổng lượt phản hồi: {{ $totalRepliesInYear->total }}</span>
    
                                                            
                                                        </div>
                                                        <div class="nk-sale-data">
                                                            <span class="amount sm">Năm: {{ $statisticsYear }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="" style="height:400px">
                                                        <canvas id="chart7"></canvas>
                                                    </div>
                                                </div>
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                    
                                        <div class="col-12" id="statistics-8">
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner">
                                                    <div class="card-title-group align-start gx-3 mb-3">
                                                        <div class="card-title">
                                                            <h6 class="title">Thống kê số lượt bình luận & phản hồi</h6>
                                                            <p>Thống kê tổng số lượt bình luận theo ngày trong tháng</p>
                                                        </div>
                                                        <div class="card-tools">
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-primary btn-dim d-none d-sm-inline-flex" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em><span>Chọn tháng</span></a>
                                                                <a href="#" class="btn btn-icon btn-primary btn-dim d-sm-none" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        @for ($i = 1 ; $i < 13 ; $i++)
                                                                            <li class="month-selection-li-8" data-value="{{ $i }}"><a style="cursor: pointer;"><span>Tháng {{ $i }}</span></a></li>
                                                                        @endfor
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="analytic-ov">
                                                        <div class="analytic-data-group analytic-ov-group g-3">
                                                            <div class="analytic-data analytic-ov-data d-flex flex-column  align-items-center">
                                                                <div class="title">Tổng</div>
                                                                <div class="amount">
                                                                    <span id="total-8"></span>
                                                                </div>
                                                            </div>
                                                            <div class="analytic-data analytic-ov-data d-flex flex-column align-items-center">
                                                                <div class="title">Min</div>
                                                                <div class="amount">                               
                                                                    <span id="min-8"></span>
                                
                                                                </div>
                                                            </div>
                                                            <div class="analytic-data analytic-ov-data d-flex flex-column align-items-center">
                                                                <div class="title">Max</div>
                                                                <div class="amount">
                                                                    <span id="max-8"></span>
                                
                                                                </div>
                                                            </div>
                                                            <div class="analytic-data analytic-ov-data d-flex flex-column align-items-center">
                                                                <div class="title">Tháng</div>
                                                                <div class="amount">
                                                                    <span id="month-selection-span-8"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="analytic-ov-ck" style=" height: 300px;">
                                                            <canvas id="chart8"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
 
</div>
@endsection

@section('modal')
<div class="modal fade" tabindex="-1" id="modalContent">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Nội dung</h5>
              <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <em class="icon ni ni-cross"></em>
              </a>
          </div>
          <div class="modal-body">
              
          </div>
      </div>
  </div>
</div>
@endsection

@section('additional-scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.4/moment-with-locales.js"></script>
<script>

    $(function(){

        $('#DataTables_Table_0 tbody').on('click','.content-btn',function(e){
            e.preventDefault();

            
            var comment_id = $(this).data('id');
            $('#modalContent').find('.modal-body').empty();


            $.ajax({
            type:"GET",
            url:'/admin/comment/getContent/' + comment_id,     
            })
            .done(function(res) {
            // If successful
                const content = res.content;

                $('#modalContent').find('.modal-body').append(content);

                setTimeout(function(){ 
                $('#modalContent').modal('show');
                },500);

            
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
            });
        
        });
    

        $(document).on('click','.delete-button',function(){
            var forum_postID = $(this).data('id');
            var name = $(this).data('name');
            var token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: "Bạn muốn xóa bài đăng "+ name,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xóa bài đăng',
                cancelButtonText: 'Không'
                }).then((result) => {
                if (result.isConfirmed) {
                    
                    $.ajax({
                        type:"GET",
                        url:'/admin/forum/post/customDelete/' + forum_postID,
                        data : {
                        },
                        })
                        .done(function() {
                        // If successful
                            Swal.fire({
                                icon: 'success',
                                title: `Xóa bài đăng thành công`,
                                showConfirmButton: false,
                                timer: 2500
                            });
                            $('#post-render-div').load(' #post-render-div > *')

                        })
                        .fail(function(jqXHR, textStatus, errorThrown) {
                        // If fail
                        console.log(textStatus + ': ' + errorThrown);
                        })
                
                }
                })
            })

        $(document).on('click','#verification_item_button',function(){

            const post_id = $(this).data('id');

            var data = [];
            data.push(post_id);

            $.ajax({ 
                type:"GET",
                url:'/admin/deleted/post/recovery',
                data: {'data':data}   
                })
                .done(function() {
                // If successful
            
                Swal.fire({
                    icon: 'success',
                    title: `Khôi phục thành công!!!`,
                    showConfirmButton: false,
                    timer: 2500
                });

                $('#post-render-div').load(' #post-render-div > *')

                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                Swal.fire({
                            icon: 'error',
                            title: `Đổi trạng thái không thành công`,
                            showConfirmButton: false,
                            timer: 2500
                        });
                })



        })


        var yearSelected = {!! $statisticsYear !!};

        var temp = {!! \Carbon\Carbon::now()->format('YmdH') !!};

        var currentMonth = temp.toString().substring(4,6);

        defaultRenderChart8(currentMonth);

    })

    
    function defaultRenderChart8(currentMonth){
        $('#statistics-8').find('#month-selection-span-8').text(currentMonth);

        var comments = {!! json_encode($totalCommentsPerDate) !!};
        var replies = {!! json_encode($totalRepliesPerDate) !!};


        const filterByMonth1 = comments.map((obj)=>{
            const temp = new Date(obj.date).toISOString().slice(5,7);
            if (temp === currentMonth){
                return obj;
            }
        }).filter(item =>  item !== undefined );


        const filterByMonth2 = replies.map((obj)=>{
            const temp = new Date(obj.date).toISOString().slice(5,7);
            if (temp === currentMonth){
                return obj;
            }
        }).filter(item =>  item !== undefined );



        var min1 = 0;
        var max1 = 0;
        var sum1 = 0;
        if(filterByMonth1.length){
            min1 = Math.min(...filterByMonth1.map(object => object.total));
                
            max1 = Math.max(...filterByMonth1.map(object => object.total));

            sum1 = filterByMonth1.reduce((accumulator, object) => {
                return accumulator + parseInt(object.total);
            }, 0);
        }

        var min2 = 0;
        var max2 = 0;
        var sum2 = 0;

        if(filterByMonth2.length){
            min2 = Math.min(...filterByMonth2.map(object => object.total));
                
            max2 = Math.max(...filterByMonth2.map(object => object.total));

            sum2 = filterByMonth2.reduce((accumulator, object) => {
                return accumulator + parseInt(object.total);
            }, 0);
        }



        $('#statistics-8').find('#total-8').text(`${sum1} & ${sum2}`);
        $('#statistics-8').find('#min-8').text(`${min1} & ${min2}`);
        $('#statistics-8').find('#max-8').text(`${max1} & ${max2}`);
                    

    }

    function createChart7(){
        const ctx = document.getElementById('chart7');

        var comments = {!! json_encode($totalCommentsPerMonth) !!};

        var replies  = {!! json_encode($totalRepliesPerMonth) !!};

        const data = {
        labels: Object.keys(comments[0]),
        datasets: [{
            label: 'Số lượt bình luận',
            data: Object.values(comments[0]),
            borderColor: 'rgb(255,139,142)',
            tension: 0.1,
            backgroundColor: 'rgb(255,139,142)',
            yAxisID: 'y',
        },{
            label: 'Số lượt phản hồi',
            data: Object.values(replies[0]),
            borderColor: 'blue',
            tension: 0.1,
            backgroundColor: 'blue',
            yAxisID: 'y1',
        }]
        };

        new Chart(ctx, {
            type: 'line',
            data: data,

            options: {
                responsive: true,
                maintainAspectRatio: false,
                    interaction: {
                    mode: 'index',
                    intersect: false,
                },
                stacked: false,
                scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',

                    // grid line settings
                    grid: {
                    drawOnChartArea: false, // only want the grid lines for one axis to show up
                    },
                },
                }
            }
        });
        
    }

    function createChart8(){
        const ctx = document.getElementById('chart8');

      

        var yearSelected = {!! $statisticsYear !!};

        var temp = {!! \Carbon\Carbon::now()->format('YmdH') !!};

        var currentMonth = temp.toString().substring(4,6);

        const lastDate  = new Date(yearSelected,currentMonth,0).getDate();

        var comments = {!! json_encode($totalCommentsPerDate) !!};
        var replies = {!! json_encode($totalRepliesPerDate) !!};

        
        const data = {
            // labels: comments.map(object => object.date),
            datasets: [
            {
                label: 'Số lượt bình luận',
                data: comments,         
                borderWidth: 1,
                backgroundColor: 'rgb(255,139,142)',
                parsing:{
                    xAxisKey:'date',
                    yAxisKey:'total'
                }

            },
            {
                label: 'Số lượt phản hồi',
                data: replies,         
                borderWidth: 1,
                backgroundColor: 'blue',
                parsing:{
                    xAxisKey:'date',
                    yAxisKey:'total'
                }

            },
        ]
        };

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: data,

            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x:{
                        min:`${yearSelected}-${currentMonth}-01`,
                        max:`${yearSelected}-${currentMonth}-${lastDate}`,
                        type: 'time',
                        time:{
                            displayFormats: {
                                day: 'dd'
                            }
                        },
                        stacked: true,

                    },
                    y: {
                    ticks: {
                        precision: 0,
                        beginAtZero: true,         
                        },
                        stacked: true,

                    } 
                },
                plugins: {
                   
                    tooltip: {
                        displayColors:false,
                        callbacks:{
                            title: function(tooltipItem, data) {

                                var date = tooltipItem[0].label;
                                var dateObj = new Date(date.substring(0, date.length - 15));


                                var vietnameseDate = moment(dateObj).locale('vi').format('LLLL').toString();

                                //clear
                                var vietnameseDate = vietnameseDate.substring(0, vietnameseDate.length - 6);

                                //upppercase
                                var vietnameseDate = vietnameseDate.charAt(0).toUpperCase() + vietnameseDate.slice(1)

                                // return date;
                        

                                return vietnameseDate;
                            },
                        }
                    },

                }
            },
            });

            $('#statistics-8').find('.month-selection-li-8').click(function () {

            const year = {!! $statisticsYear !!};

            var month = $(this).data('value');

            if(month < 10){
                month = '0' + month;
            }
            const lastDay = (y,m)=>{
            return new Date(y,m,0).getDate();
            }


            const startDate = `${year}-${month}-01`;
            const endDate = `${year}-${month}-${lastDay(year,month)}`;

            myChart.config.options.scales.x.min = startDate;
            myChart.config.options.scales.x.max = endDate;

            myChart.update();

            $('#statistics-8').find('#month-selection-span-5').text(month);


            const filterByMonth1 = comments.map((obj)=>{
                const temp = new Date(obj.date).toISOString().slice(5,7);
                if (temp === month){
                    return obj;
                }
            }).filter(item =>  item !== undefined );


            const filterByMonth2 = replies.map((obj)=>{
                const temp = new Date(obj.date).toISOString().slice(5,7);
                if (temp === month){
                    return obj;
                }
            }).filter(item =>  item !== undefined );



            var min1 = 0;
            var max1 = 0;
            var sum1 = 0;
            if(filterByMonth1.length){
                min1 = Math.min(...filterByMonth1.map(object => object.total));
                    
                max1 = Math.max(...filterByMonth1.map(object => object.total));

                sum1 = filterByMonth1.reduce((accumulator, object) => {
                    return accumulator + parseInt(object.total);
                }, 0);
            }

            var min2 = 0;
            var max2 = 0;
            var sum2 = 0;

            if(filterByMonth2.length){
                min2 = Math.min(...filterByMonth2.map(object => object.total));
                    
                max2 = Math.max(...filterByMonth2.map(object => object.total));

                sum2 = filterByMonth2.reduce((accumulator, object) => {
                    return accumulator + parseInt(object.total);
                }, 0);
            }

            

          
            $('#statistics-8').find('#total-8').text(`${sum1} & ${sum2}`);
            $('#statistics-8').find('#min-8').text(`${min1} & ${min2}`);
            $('#statistics-8').find('#max-8').text(`${max1} & ${max2}`);

            })

    }



    createChart7();
    createChart8();

    function arrayToCsv(data){
        return data.map(row =>
            row
            .map(String)  // convert every value to String
            .map(v => v.replaceAll('"', '""'))  // escape double colons
            .map(v => `"${v}"`)  // quote it
            .join(',')  // comma-separated
        ).join('\r\n');  // rows starting on new lines
    }

    function downloadBlob(content, filename, contentType) {
    // Create a blob
        var blob = new Blob(["\ufeff",content], { type: 'text/csv;charset=utf-8;' });
        var url = URL.createObjectURL(blob);

        // Create a link to download it
        var pom = document.createElement('a');
        pom.href = url;
        pom.setAttribute('download', filename);
        pom.click();
    }


    $('#report-total-comment-btn').on('click', function (e) {
        e.preventDefault();
        var yearSelected = {!! $statisticsYear !!};

        var comments = {!! json_encode($totalCommentsPerMonth) !!};
        var replies = {!! json_encode($totalRepliesPerMonth) !!};

        let title = [`Tổng số lượt bình luận và phản hồi từng tháng trong năm ${yearSelected}`];

        let header = ['Tháng','Số lượt bình luận','Số lượt phản hồi']    

        let commentEntries = Object.entries(comments[0]);

        
        var repliesTotal = Object.values(replies[0]);


        for (var i = 0; i < commentEntries.length; i++){
            commentEntries[i].push(repliesTotal[i]);

        }

        

        let temp = [];
        temp.push(title)
        temp.push(header);
 
        commentEntries.forEach(i => temp.push(i));


        
        let csv = arrayToCsv(temp);
        
        downloadBlob(csv, `tong-so-luot-binh-luan-theo-thang-nam-${yearSelected}.csv`);

        var comments2 = {!! json_encode($totalCommentsPerDate) !!};

        let title2 = [`Tổng số bình luận theo ngày trong năm ${yearSelected}`];

        let header2 = ['Ngày','Số lượt bình luận']    

        const obj1 = {};

        comments2.forEach(function(item) {
            obj1[item.date] = item.total;
        })

        let commentEntries2 = Object.entries(obj1);

    
        let temp2 = [];
        temp2.push(title2)
        temp2.push(header2);


        commentEntries2.forEach(i => temp2.push(i));

        let csv2 = arrayToCsv(temp2);

    
        downloadBlob(csv2, `tong-so-luot-binh-luan-theo-ngay-nam-${yearSelected}.csv`);
 

        ////
        var replies2 = {!! json_encode($totalRepliesPerDate) !!};

        const obj2 = {};

        replies2.forEach(function(item) {
            obj2[item.date] = item.total;
        })

        let replyEntries2 = Object.entries(obj2);

        temp2 = [];
        temp2.push(title2)
        temp2.push(header2);

        replyEntries2.forEach(i => temp2.push(i));

        csv2 = arrayToCsv(temp2);

    
        downloadBlob(csv2, `tong-so-luot-phan-hoi-theo-ngay-nam-${yearSelected}.csv`);

    })
</script>



@endsection