@extends('admin/layouts.app')
@section('pageTitle', 'Thống kê sách')
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
                <div class="row g-gs">
                    <div class="col-8" id="statistics-1">
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
                    </div>
    
                    <div class="col-4">
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title card-title-sm">
                                    <h6 class="title">Tổng số sách:</h6>
                                    </div>
                                </div>
                                <div class="nk-knob text-center">
                                    <input type="text" class="knob" value="{{ $totalBooks }}" data-fgColor="#816bff" data-bgColor="#d9e5f7" data-thickness=".07" data-width="240" data-height="240" data-max="100">
                                </div>
                                <div class="card-title-group d-flex justify-content-center mt-3">
                                    <h4 class="title">{{ $totalBooks }}/100</h4>
                                </div>
                            </div>
                        </div><!-- .card-preview -->
                    </div>
                </div>
              
            </div>
        </div>
        <ul class="nav nav-tabs nav-tabs-s2">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#tabItem1">Thống kê số lượt đăng sách</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tabItem2">Thống kê số lượt đọc sách</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tabItem1">
                <div class="row g-gs">      
                    <div class="col-12" id="statistics-2">
                        <div class="card card-bordered h-100">
                            <div class="card-inner">
                                <div class="card-title-group align-start gx-3 mb-3">
                                    <div class="card-title">
                                        <h6 class="title">Thống kê sách</h6>
                                        <p>Thống kê tổng số sách đã được đăng trong vòng 12 tháng </p>
                                    </div>
                                    <div class="card-tools">
                                        <div class="dropdown">
                                            <div class="me-2"  data-bs-toggle="dropdown">
                                                <a href="#" class="btn btn-primary btn-dim d-none d-sm-inline-flex"><em class="icon ni ni-calendar"></em><span>Chọn năm</span></a>
                                                <a href="#" class="btn btn-icon btn-primary btn-dim d-sm-none"><em class="icon ni ni-calendar"></em></a>
                                            </div>
                                       
                                            <div id="report-total-book-btn">
                                                <a href="#" class="btn btn-danger btn-dim d-none d-sm-inline-flex"><em class="icon ni ni-reports"></em><span>Xuất báo cáo</span></a>
                                                <a href="#" class="btn btn-icon btn-danger btn-dim d-sm-none"><em class="icon ni ni-reports"></em></a>
                                            </div>
                                         

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    @foreach ($allYears as $year)
                                                        <li><a href="/admin/statistics/book/{{ $year->year }}"><em class="icon ni ni-calendar"></em><span>Năm {{ $year->year }} </span></a></li>
                                                    @endforeach
                                                        
                                                </ul>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                                <div class="nk-sale-data-group align-center justify-between gy-3 gx-5">
                                    <div class="nk-sale-data">
                                        <span class="amount">Tổng sách: {{ $totalBooksInYear }}</span>
                                    </div>
                                    <div class="nk-sale-data">
                                        <span class="amount sm">Năm: {{ $statisticsYear }}</span>
                                    </div>
                                </div>
                                <div class="" style="height:400px" >
                                    <canvas id="chart2" ></canvas>
                                </div>
                            </div>
                        </div><!-- .card -->
                    </div><!-- .col -->
            
                    <div class="col-12" id="statistics-3">
                        <div class="card card-bordered h-100">
                            <div class="card-inner">
                                <div class="card-title-group align-start gx-3 mb-3">
                                    <div class="card-title">
                                        <h6 class="title">Thống kê sách</h6>
                                        <p>Thống kê tổng số sách đã được đăng theo ngày trong tháng</p>
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
            </div>
            <div class="tab-pane" id="tabItem2">
                <div class="row g-gs">
                    <div class="col-12" id="statistics-4">
                        <div class="card card-bordered h-100">
                            <div class="card-inner">
                                <div class="card-title-group align-start gx-3 mb-3">
                                    <div class="card-title">
                                        <h6 class="title">Thống kê số lượt đọc sách</h6>
                                        <p>Thống kê tổng số lượt đọc sách trong vòng 12 tháng</p>
                                    </div>
                                    <div class="card-tools">
                                        <div class="dropdown">
 
                                            <div class="me-2" data-bs-toggle="dropdown">
                                                <a href="#" class="btn btn-primary btn-dim d-none d-sm-inline-flex"><em class="icon ni ni-calendar"></em><span>Chọn năm</span></a>
                                                <a href="#" class="btn btn-icon btn-primary btn-dim d-sm-none"><em class="icon ni ni-calendar"></em></a>
                                            </div>
                                       
                                            <div id="report-total-reading-btn">
                                                <a href="#" class="btn btn-danger btn-dim d-none d-sm-inline-flex"><em class="icon ni ni-reports"></em><span>Xuất báo cáo</span></a>
                                                <a href="#" class="btn btn-icon btn-danger btn-dim d-sm-none"><em class="icon ni ni-reports"></em></a>
                                            </div>
                                            
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    @foreach ($allYears as $year)
                                                        <li><a href="/admin/statistics/book/{{ $year->year }}"><em class="icon ni ni-calendar"></em><span>Năm {{ $year->year }} </span></a></li>
                                                    @endforeach
                                                  
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="nk-sale-data-group align-center justify-between gy-3 gx-5">
                                    <div class="nk-sale-data">
                                        <span class="amount">Tổng lượt đọc: {{ $totalReadingInYear }}</span>
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
                                        <h6 class="title">Thống kê số lượt đọc sách</h6>
                                        <p>Thống kê tổng số lượt đọc sách theo ngày trong tháng</p>
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
    
</div>



@endsection

    
@section('additional-scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

<script>
    $(document).ready(function () {

        var yearSelected = {!! $statisticsYear !!};

        var temp = {!! \Carbon\Carbon::now()->format('YmdH') !!};

        var currentMonth = temp.toString().substring(4,6);

        defaultRenderChart3(currentMonth);
        defaultRenderChart5(currentMonth);
    });

    function defaultRenderChart3(currentMonth){
        $('#statistics-3').find('#month-selection-span').text(currentMonth);

        const totalBooksPerDate = {!! json_encode($totalBooksPerDate) !!};


        const filterByMonth = totalBooksPerDate.map((obj)=>{
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

            const result = {!! json_encode($totalReadingPerDate) !!};

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

        var result = {!! json_encode($totalBooksPerMonth) !!};

        const data = {
        labels: Object.keys(result[0]),
        datasets: [{
            label: 'Số lượng sách',
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

        var result = {!! json_encode($totalBooksPerDate) !!};


        const data = {
            labels: result.map(object => object.date),
            datasets: [{
                label: 'Số lượng sách',
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

        var result = {!! json_encode($totalReadingPerMonth) !!};

        const data = {
        labels: Object.keys(result[0]),
        datasets: [{
            label: 'Số lượt đọc',
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

        var result = {!! json_encode($totalReadingPerDate) !!};


        const data = {
            labels: result.map(object => object.date),
            datasets: [{
                label: 'Số lượt đọc sách',
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

   

    $('#report-total-book-btn').on('click', function (e) {
        e.preventDefault();
        var yearSelected = {!! $statisticsYear !!};

        var result = {!! json_encode($totalBooksPerMonth) !!};
        let title = [`Tổng số sách từng tháng trong năm ${yearSelected}`];

        let header = ['Tháng','Số lượng']    

        let entries = Object.entries(result[0]);


        let temp = [];
        temp.push(title)
        temp.push(header);
 
        entries.forEach(i => temp.push(i));

        let csv = arrayToCsv(temp);

        downloadBlob(csv, `tong-so-sach-theo-thang-nam-${yearSelected}.csv`);

        var result2 = {!! json_encode($totalBooksPerDate) !!};
        let title2 = [`Tổng số sách theo ngày trong năm ${yearSelected}`];

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

        downloadBlob(csv2, `tong-so-sach-theo-ngay-nam-${yearSelected}.csv`);


    })

    $('#report-total-reading-btn').on('click', function (e) {
        e.preventDefault();
        var yearSelected = {!! $statisticsYear !!};

        var result = {!! json_encode($totalReadingPerMonth) !!};
        let title = [`Tổng lượt đọc từng tháng trong năm ${yearSelected}`];

        let header = ['Tháng','Số lượng']    

        let entries = Object.entries(result[0]);


        let temp = [];
        temp.push(title)
        temp.push(header);
 
        entries.forEach(i => temp.push(i));

        let csv = arrayToCsv(temp);

        downloadBlob(csv, `tong-so-luot-doc-theo-thang-nam-${yearSelected}.csv`);

        var result2 = {!! json_encode($totalReadingPerDate) !!};
        let title2 = [`Tổng lượt đọc theo ngày trong năm ${yearSelected}`];

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

        downloadBlob(csv2, `tong-so-luot-doc-theo-ngay-nam-${yearSelected}.csv`);


    })
</script>
@endsection