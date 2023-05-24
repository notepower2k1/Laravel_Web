@extends('admin/layouts.app')
@section('pageTitle', 'Thống kê bài viết')
@section('additional-style')

<style>
    #doughnutChart{
        width:500px;
        height: 500px;
    }
</style>

@endsection
@section('content')
<div class="container">
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-8">
                <div class="card card-bordered h-100">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title card-title-sm">
                            <h6 class="title">Thống kê số lượng theo diễn đàn</h6>
                            </div>
                        </div>
                        <div class="mt-5 d-flex">
                            <canvas id="doughnutChart"></canvas>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card card-bordered card-preview">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title card-title-sm">
                            <h6 class="title">Tổng số bài viết:</h6>
                            </div>
                        </div>
                        <div class="nk-knob text-center">
                            <input type="text" class="knob" value="{{ $totalPosts }}" data-fgColor="#816bff" data-bgColor="#d9e5f7" data-thickness=".07" data-width="240" data-height="240" data-max="100">
                        </div>
                        <div class="card-title-group d-flex justify-content-center mt-3">
                            <h4 class="title">{{ $totalPosts }}/100</h4>
                        </div>
                    </div>
                </div><!-- .card-preview -->
            </div>

          
            <div class="col-12">
                <h3>
                    Diễn đàn: {{ $forum_name }} (Năm: {{ $statisticsYear }})
                </h3>
              
                <div class="forum-change-div">
                    <select id="forum-select">
                        <option></option>

                        @foreach ($all_forum as $forum)
                            <option value="{{ $forum->id }}">{{ $forum->name }}</option>
                        @endforeach
                    </select>
                </div>
               
            </div>

            <div class="col-12">

                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#tabItem1">Bài viết đã đăng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tabItem2">Lượt bình luận và xem bài viết</a>
                    </li>
                
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tabItem1">
                        <div class="col-12">
                            <div class="card card-bordered h-100">
                                <div class="card-inner">
                                    <div class="card-title-group align-start gx-3 mb-3">
                                        <div class="card-title">
                                            <h6 class="title">Thống kê bài viết</h6>
                                            <p>Thống kê tổng số bài viết đã được đăng trong vòng 12 tháng </p>
                                        </div>
                                        <div class="card-tools">
                                            <div class="dropdown">
                                                <div class="me-2"  data-bs-toggle="dropdown">
                                                    <a href="#" class="btn btn-primary btn-dim d-none d-sm-inline-flex"><em class="icon ni ni-calendar"></em><span>Chọn năm</span></a>
                                                    <a href="#" class="btn btn-icon btn-primary btn-dim d-sm-none"><em class="icon ni ni-calendar"></em></a>
                                                </div>
                                        
                                                <div id="report-total-post-btn">
                                                    <a href="#" class="btn btn-danger btn-dim d-none d-sm-inline-flex"><em class="icon ni ni-reports"></em><span>Xuất báo cáo</span></a>
                                                    <a href="#" class="btn btn-icon btn-danger btn-dim d-sm-none"><em class="icon ni ni-reports"></em></a>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        @foreach ($allYears as $year)
                                                            <li><a href="/admin/statistics/post/{{ $year->year }}"><em class="icon ni ni-calendar"></em><span>Năm {{ $year->year }} </span></a></li>
                                                        @endforeach
                                                    
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-sale-data-group align-center justify-between gy-3 gx-5">
                                        <div class="nk-sale-data">
                                            <span class="amount">Tổng bài viết: {{ $totalPostsInYear }}</span>
                                        </div>
                                        <div class="nk-sale-data">
                                            <span class="amount sm">Năm: {{ $statisticsYear }}</span>
                                        </div>
                                    </div>
                                    <div class="">
                                        <canvas id="salesOverview" style="height:300px" ></canvas>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                
                        <div class="col-12">
                            <div class="card card-bordered h-100">
                                <div class="card-inner">
                                    <div class="card-title-group align-start gx-3 mb-3">
                                        <div class="card-title">
                                            <h6 class="title">Thống kê bài viết</h6>
                                            <p>Thống kê tổng số bài viết đã được đăng theo ngày trong tháng</p>
                                        </div>
                                        <div class="card-tools">
                                            <div class="dropdown">
                                                <a href="#" class="btn btn-primary btn-dim d-none d-sm-inline-flex" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em><span>Chọn tháng</span></a>
                                                <a href="#" class="btn btn-icon btn-primary btn-dim d-sm-none" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        @for ($i = 1 ; $i < 13 ; $i++)
                                                            <li class="month-selection-li" data-value="{{ $i }}"><a style="cursor: pointer;"><span>Tháng {{ $i }}</span></a></li>
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
                                                    <span id="total-users-span"></span>
                                                </div>
                                                {{-- <div class="change up"><em class="icon ni ni-arrow-long-up"></em>12.37%</div> --}}
                                            </div>
                                            <div class="analytic-data analytic-ov-data d-flex flex-column align-items-center">
                                                <div class="title">Min</div>
                                                <div class="amount">                               
                                                    <span id="min-users-span"></span>
                
                                                </div>
                                                {{-- <div class="change up"><em class="icon ni ni-arrow-long-up"></em>47.74%</div> --}}
                                            </div>
                                            <div class="analytic-data analytic-ov-data d-flex flex-column align-items-center">
                                                <div class="title">Max</div>
                                                <div class="amount">
                                                    <span id="max-users-span"></span>
                
                                                </div>
                                                {{-- <div class="change down"><em class="icon ni ni-arrow-long-down"></em>12.37%</div> --}}
                                            </div>
                                            <div class="analytic-data analytic-ov-data d-flex flex-column align-items-center">
                                                <div class="title">Tháng</div>
                                                <div class="amount">
                                                    <span id="month-selection-span"></span>
                                                </div>
                                                {{-- <div class="change down"><em class="icon ni ni-arrow-long-down"></em>0.35%</div> --}}
                                            </div>
                                        </div>
                                        <div class="analytic-ov-ck" style=" height: 300px;">
                                            <canvas id="myBar"></canvas>
                                            {{-- <input type="month" onchange="filterChart(this)"/> --}}                    
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
            
                    </div>
                    <div class="tab-pane" id="tabItem2">
                        <div class="col-12">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="card-title">
                                        <h6 class="title">Thống kê số lượt bình luận và xem bài viết ( Năm: {{ $statisticsYear }} )</h6>
                                        <p>Thống kê tổng số lượt bình luận và xem bài viết</p>
                                    </div>
                                    <div class="analytic-ov-ck" style=" height: 400px;">
                                        <canvas id="lineChart"></canvas>
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

    
@section('additional-scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $('#forum-select').select2({
            placeholder:"Đổi diễn đàn",

        });

        var yearSelected = {!! $statisticsYear !!};

        var temp = {!! \Carbon\Carbon::now()->format('YmdH') !!};

        var currentMonth = temp.toString().substring(4,6);

        $('#month-selection-span').text(currentMonth);

        const totalPostsPerDate = {!! json_encode($totalPostsPerDate) !!};


        const filterByMonth = totalPostsPerDate.map((obj)=>{
            const temp = new Date(obj.date).toISOString().slice(5,7);
            if (temp === currentMonth){
                return obj;
            }
        }).filter(item =>  item !== undefined );


        var min = 0;
        var max = 0;
        var sum = 0;
        if(filterByMonth.length){
            min = Math.min(...filterByMonth.map(object => object.total));
                
            max = Math.max(...filterByMonth.map(object => object.total));

            sum = filterByMonth.reduce((accumulator, object) => {
                return accumulator + object.total;
            }, 0);
        }
     

        $('#total-users-span').text(sum);
        $('#min-users-span').text(min);
        $('#max-users-span').text(max);

    });

    function createDonutChart() {

        const ctx = document.getElementById('doughnutChart');
     

        var result = {!! json_encode($totalByTypes) !!};

        const data = {
            labels: result.map(object=>object.name),
            datasets: [{
                label: 'Số lượng',
                data: result.map(object=>object.total),
            
                hoverOffset: 4
            }]
        };

        new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: {  
                responsive: true,
                maintainAspectRatio: false,
                cutout: 100,

                plugins: {
                 
                    legend: {
                        position: 'bottom',
                        labels: {
                            textAlign: 'left',
                        }
                    }
                },
            },

        });
    
    }
    
    function createLineChart(){
        const ctx = document.getElementById('salesOverview');

        var result = {!! json_encode($totalPostsPerMonth) !!};

        const data = {
        labels: Object.keys(result[0]),
        datasets: [{
            label: 'Số lượng bài viết',
            data: Object.values(result[0]),
            fill: true,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1,
            backgroundColor: 'rgba(235,238,255,0.6)'
        }]
        };

        new Chart(ctx, {
            type: 'line',
            data: data,

            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                    ticks: {
                        precision: 0,
                        beginAtZero: true,

                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },  
                    tooltip: {
                        displayColors:false
                    },

                }
            }
        });
        
    }

    createDonutChart()
    createLineChart()

    
    

        const ctx = document.getElementById('myBar');

      

        var yearSelected = {!! $statisticsYear !!};

        var temp = {!! \Carbon\Carbon::now()->format('YmdH') !!};

        var currentMonth = temp.toString().substring(4,6);

        const lastDate  = new Date(yearSelected,currentMonth,0).getDate();

        var result = {!! json_encode($totalPostsPerDate) !!};


        const data = {
            labels: result.map(object => object.date),
            datasets: [{
                label: 'Số lượng bài viết',
                data: result.map(object => object.total),         
                borderWidth: 1
            }]
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
                        }
                    },
                    y: {
                    ticks: {
                        precision: 0,
                        beginAtZero: true,         
                        }
                    } 
                },
                plugins: {
                    legend: {
                        display: false
                    },
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
    
   

    $('.month-selection-li').click(function () {

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

        $('#month-selection-span').text(month);

        const result = {!! json_encode($totalPostsPerDate) !!};

        const filterByMonth = result.map((obj)=>{
            const temp = new Date(obj.date).toISOString().slice(5,7);
            if (temp === month){
                return obj;
            }
        }).filter(item =>  item !== undefined );



        var min = 0;
        var max = 0;
        var sum = 0;
        if(filterByMonth.length){
            min = Math.min(...filterByMonth.map(object => object.total));
                
            max = Math.max(...filterByMonth.map(object => object.total));

            sum = filterByMonth.reduce((accumulator, object) => {
                return accumulator + object.total;
            }, 0);
        }
     

        $('#total-users-span').text(sum);
        $('#min-users-span').text(min);
        $('#max-users-span').text(max);

    })

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

   

    $('#report-total-post-btn').on('click', function (e) {
        e.preventDefault();
        var yearSelected = {!! $statisticsYear !!};

        var result = {!! json_encode($totalPostsPerMonth) !!};
        let title = [`Tổng số bài viết từng tháng trong năm ${yearSelected}`];

        let header = ['Tháng','Số lượng']    

        let entries = Object.entries(result[0]);


        let temp = [];
        temp.push(title)
        temp.push(header);
 
        entries.forEach(i => temp.push(i));

        let csv = arrayToCsv(temp);

        downloadBlob(csv, `tong-so-bai-viet-theo-thang-nam-${yearSelected}.csv`);

        var result2 = {!! json_encode($totalPostsPerDate) !!};
        let title2 = [`Tổng số bài viết theo ngày trong năm ${yearSelected}`];

        let header2 = ['Ngày','Số lượng']    

        const obj = {};
        result2.forEach(function(item) {
           
            obj[item.date] = item.total;
        })

       
 
        let entries2 = Object.entries(obj);
      
        let temp2 = [];
        temp2.push(title2)
        temp2.push(header2);

        entries2.forEach(i => temp2.push(i));

        let csv2 = arrayToCsv(temp2);

        downloadBlob(csv2, `tong-so-bai-viet-theo-ngay-nam-${yearSelected}.csv`);


    })

    $("#forum-select").change(function(){
        var yearSelected = {!! $statisticsYear !!};
        var forum_id = $(this).find('option:selected').val();
        window.location.href = `/admin/statistics/forum/${forum_id}/${yearSelected}`

    });

    function createLineChart2() {

        const ctx = document.getElementById('lineChart');


        var comments = {!! json_encode($totalCommentsPerMonth) !!};
        var views = {!! json_encode($totalViewsPerMonth) !!};

        const data = {
            labels: Object.keys(comments[0]),
            datasets: [
            {
                label: 'Số lượt bình luận',
                data: Object.values(comments[0]),
                borderColor: 'red',
                tension: 0.1,
                backgroundColor: 'red',
                yAxisID: 'y',
            },
            {
                label: 'Số lượng xem',
                data: Object.values(views[0]),
                borderColor: 'blue',
                tension: 0.1,
                backgroundColor: 'blue',
                yAxisID: 'y1',
            },
        ]  
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

        createLineChart2();
</script>
@endsection