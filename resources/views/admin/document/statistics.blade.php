@extends('admin/layouts.app')
@section('pageTitle', 'Thống kê tài liệu')
@section('additional-style')

<style>
    #doughnutChart{
        width:500px;
        height: 500px;
    }
</style>

@endsection
@section('content')

<div class="nk-block">
    <div class="container">
        <div class="card card-bordered h-100">
            <div class="card-inner">
                <div class="card-title-group">
                    <div class="card-title card-title-sm">
                    <h6 class="title">Thống kê số lượng theo thể loại</h6>
                    </div>
                </div>
                <div class="mt-5 d-flex">
                    <canvas id="doughnutChart"></canvas>    
                </div>
            </div>
        </div>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#tabItem1">Thống kê số lượt đăng tài liệu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tabItem2">Thống kê số lượt tải tài liệu</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tabItem1">
              
                
                <div class="col-12" id="statistics-2">
                    <div class="card card-bordered h-100">
                        <div class="card-inner">
                            <div class="card-title-group align-start gx-3 mb-3">
                                <div class="card-title">
                                    <h6 class="title">Thống kê tài liệu</h6>
                                    <p>Thống kê tổng số tài liệu đã được đăng trong vòng 12 tháng </p>
                                </div>
                                <div class="card-tools">
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-primary btn-dim d-none d-sm-inline-flex" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em><span>Chọn năm</span></a>
                                        <a href="#" class="btn btn-icon btn-primary btn-dim d-sm-none" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                @foreach ($allYears as $year)
                                                    <li><a href="/admin/statistics/document/{{ $year->year }}"><em class="icon ni ni-calendar"></em><span>Năm {{ $year->year }} </span></a></li>
                                                @endforeach
                                              
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-sale-data-group align-center justify-between gy-3 gx-5">
                                <div class="nk-sale-data">
                                    <span class="amount">Tổng tài liệu: {{ $totalDocumentsInYear }}</span>
                                </div>
                                <div class="nk-sale-data">
                                    <span class="amount sm">Năm: {{ $statisticsYear }}</span>
                                </div>
                            </div>
                            <div class="" style="height:400px">
                                <canvas id="chart2"></canvas>
                            </div>
                        </div>
                    </div><!-- .card -->
                </div><!-- .col -->

                <div class="col-12"  id="statistics-3">
                    <div class="card card-bordered h-100">
                        <div class="card-inner">
                            <div class="card-title-group align-start gx-3 mb-3">
                                <div class="card-title">
                                    <h6 class="title">Thống kê tài liệu</h6>
                                    <p>Thống kê tổng số tài liệu đã được đăng theo ngày trong tháng</p>
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
                                            <span id="total"></span>
                                        </div>
                                        {{-- <div class="change up"><em class="icon ni ni-arrow-long-up"></em>12.37%</div> --}}
                                    </div>
                                    <div class="analytic-data analytic-ov-data d-flex flex-column align-items-center">
                                        <div class="title">Min</div>
                                        <div class="amount">                               
                                            <span id="min"></span>
        
                                        </div>
                                        {{-- <div class="change up"><em class="icon ni ni-arrow-long-up"></em>47.74%</div> --}}
                                    </div>
                                    <div class="analytic-data analytic-ov-data d-flex flex-column align-items-center">
                                        <div class="title">Max</div>
                                        <div class="amount">
                                            <span id="max"></span>
        
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
                                    <canvas id="chart3"></canvas>
                                    {{-- <input type="month" onchange="filterChart(this)"/> --}}                    
                                </div>
                            </div>
                        </div>
                    </div><!-- .card -->
                </div><!-- .col -->
            </div>
            <div class="tab-pane" id="tabItem2">
                <div class="col-12" id="statistics-4">
                    <div class="card card-bordered h-100">
                        <div class="card-inner">
                            <div class="card-title-group align-start gx-3 mb-3">
                                <div class="card-title">
                                    <h6 class="title">Thống kê số lượt tải xuống</h6>
                                    <p>Thống kê tổng số lượt tải xuống trong vòng 12 tháng</p>
                                </div>
                                <div class="card-tools">
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-primary btn-dim d-none d-sm-inline-flex" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em><span>Chọn năm</span></a>
                                        <a href="#" class="btn btn-icon btn-primary btn-dim d-sm-none" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                @foreach ($allYears as $year)
                                                    <li><a href="/admin/statistics/document/{{ $year->year }}"><em class="icon ni ni-calendar"></em><span>Năm {{ $year->year }} </span></a></li>
                                                @endforeach
                                              
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-sale-data-group align-center justify-between gy-3 gx-5">
                                <div class="nk-sale-data">
                                    <span class="amount">Tổng lượt tải: {{ $totalDownloadingInYear }}</span>
                                </div>
                                <div class="nk-sale-data">
                                    <span class="amount sm">Năm: {{ $statisticsYear }}</span>
                                </div>
                            </div>
                            <div class="" style="height:400px">
                                <canvas id="chart4"></canvas>
                            </div>
                        </div>
                    </div><!-- .card -->
                </div><!-- .col -->
    
                <div class="col-12" id="statistics-5">
                    <div class="card card-bordered h-100">
                        <div class="card-inner">
                            <div class="card-title-group align-start gx-3 mb-3">
                                <div class="card-title">
                                    <h6 class="title">Thống kê số lượt tải xuống</h6>
                                    <p>Thống kê tổng số tải xuống theo ngày trong tháng</p>
                                </div>
                                <div class="card-tools">
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-primary btn-dim d-none d-sm-inline-flex" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em><span>Chọn tháng</span></a>
                                        <a href="#" class="btn btn-icon btn-primary btn-dim d-sm-none" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                @for ($i = 1 ; $i < 13 ; $i++)
                                                    <li class="month-selection-li-5" data-value="{{ $i }}"><a style="cursor: pointer;"><span>Tháng {{ $i }}</span></a></li>
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
                                            <span id="total-5"></span>
                                        </div>
                                    </div>
                                    <div class="analytic-data analytic-ov-data d-flex flex-column align-items-center">
                                        <div class="title">Min</div>
                                        <div class="amount">                               
                                            <span id="min-5"></span>
        
                                        </div>
                                    </div>
                                    <div class="analytic-data analytic-ov-data d-flex flex-column align-items-center">
                                        <div class="title">Max</div>
                                        <div class="amount">
                                            <span id="max-5"></span>
        
                                        </div>
                                    </div>
                                    <div class="analytic-data analytic-ov-data d-flex flex-column align-items-center">
                                        <div class="title">Tháng</div>
                                        <div class="amount">
                                            <span id="month-selection-span-5"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="analytic-ov-ck" style=" height: 300px;">
                                    <canvas id="chart5"></canvas>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.4/moment-with-locales.js"></script>
<script>
    $(document).ready(function () {

        var yearSelected = {!! $statisticsYear !!};

        var temp = {!! \Carbon\Carbon::now()->format('YmdH') !!};

        var currentMonth = temp.toString().substring(4,6);

        defaultRenderChart3(currentMonth);
        defaultRenderChart5(currentMonth);

    })

    function defaultRenderChart3(currentMonth){
        $('#statistics-3').find('#month-selection-span').text(currentMonth);

        const totalDocumentsPerDate = {!! json_encode($totalDocumentsPerDate) !!};


        const filterByMonth = totalDocumentsPerDate.map((obj)=>{
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


        $('#statistics-3').find('#total').text(sum);
        $('#statistics-3').find('#min').text(min);
        $('#statistics-3').find('#max').text(max);

       
    }

    function defaultRenderChart5(currentMonth){
        $('#statistics-5').find('#month-selection-span-5').text(currentMonth);


        const result = {!! json_encode($totalDownloadingPerDate) !!};


        const filterByMonth = result.map((obj)=>{
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
                return accumulator + parseInt(object.total);
            }, 0);
        }



        $('#statistics-5').find('#total-5').text(sum);
        $('#statistics-5').find('#min-5').text(min);
        $('#statistics-5').find('#max-5').text(max);

    }

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
    
    function createChart2(){
        const ctx = document.getElementById('chart2');

        var result = {!! json_encode($totalDocumentsPerMonth) !!};

        const data = {
        labels: Object.keys(result[0]),
        datasets: [{
            label: 'Số lượng tài liệu',
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

  

    
    function createChart3(){
        const ctx = document.getElementById('chart3');

      

        var yearSelected = {!! $statisticsYear !!};

        var temp = {!! \Carbon\Carbon::now()->format('YmdH') !!};

        var currentMonth = temp.toString().substring(4,6);

        const lastDate  = new Date(yearSelected,currentMonth,0).getDate();

        var result = {!! json_encode($totalDocumentsPerDate) !!};


        const data = {
            labels: result.map(object => object.date),
            datasets: [{
                label: 'Số lượng tài liệu',
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



            $('#statistics-3').find('.month-selection-li').click(function () {

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

            $('#statistics-3').find('#month-selection-span').text(month);

            const result = {!! json_encode($totalDocumentsPerDate) !!};

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


            $('#statistics-3').find('#total').text(sum);
            $('#statistics-3').find('#min').text(min);
            $('#statistics-3').find('#max').text(max);

            })
    }
     
    function createChart4(){
        const ctx = document.getElementById('chart4');

        var result = {!! json_encode($totalDownloadingPerMonth) !!};

        const data = {
        labels: Object.keys(result[0]),
        datasets: [{
            label: 'Số lượt tải',
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

    function createChart5(){
        const ctx = document.getElementById('chart5');

      

        var yearSelected = {!! $statisticsYear !!};

        var temp = {!! \Carbon\Carbon::now()->format('YmdH') !!};

        var currentMonth = temp.toString().substring(4,6);

        const lastDate  = new Date(yearSelected,currentMonth,0).getDate();

        var result = {!! json_encode($totalDownloadingPerDate) !!};


        const data = {
            labels: result.map(object => object.date),
            datasets: [{
                label: 'Số lượng lượt đọc sách',
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

            $('#statistics-5').find('.month-selection-li-5').click(function () {

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

            $('#statistics-5').find('#month-selection-span-5').text(month);


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
                    return accumulator + parseInt(object.total);
                }, 0);
            }



            $('#statistics-5').find('#total-5').text(sum);
            $('#statistics-5').find('#min-5').text(min);
            $('#statistics-5').find('#max-5').text(max);

            })

    }

    createDonutChart();
    createChart2();
    createChart3();
    createChart4();
    createChart5();
</script>
@endsection