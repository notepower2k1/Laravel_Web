@extends('admin/layouts.app')
@section('pageTitle', 'Thống kê người dùng')
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
    <div class="row g-gs">
        <div class="col-12">
            <div class="card card-bordered h-100">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title card-title-sm">
                        <h6 class="title">Thống kê số lượng theo tình trạng</h6>
                        </div>
                    </div>
                    <div class="mt-5 d-flex">
                        <canvas id="doughnutChart"></canvas>    
                    </div>
                </div>
            </div>
        </div>
        
        <ul class="nav nav-tabs nav-tabs-s2">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#tabItem9">Thống kê khung giờ đăng nhập
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tabItem10">Thống kê người dùng
                </a>
            </li>
          
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tabItem9">
                <div class="col-12">
                    <div class="col-12">
                        <div class="card card-bordered h-100">
                            <div class="card-inner">
                                <div class="card-title-group align-start gx-3 mb-3">
                                    <div class="card-title">
                                        <h6 class="title">Thống kê khung giờ đăng nhập</h6>
                                        <p>Thống kê khung giờ đăng nhập của người trong vòng 12 tháng </p>
                                    </div>
                                    <div class="card-tools">
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-primary btn-dim d-none d-sm-inline-flex" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em><span>Chọn năm</span></a>
                                            <a href="#" class="btn btn-icon btn-primary btn-dim d-sm-none" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    @foreach ($allYears as $year)
                                                        <li><a href="/admin/statistics/user/{{ $year->year }}"><em class="icon ni ni-calendar"></em><span>Năm {{ $year->year }} </span></a></li>
                                                    @endforeach
                                                  
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="nk-sale-data-group align-center justify-between gy-3 gx-5">
                                    <div class="nk-sale-data">
                                        <span class="amount">Tổng người dùng: {{ $totalUsersInYear }}</span>
                                    </div>
                                    <div class="nk-sale-data">
                                        <span class="amount sm">Năm: {{ $statisticsYear }}</span>
                                    </div>
                                </div>
                                {{-- <div class="analytic-ov"> --}}
                                   
                                    <div class="analytic-ov-ck">
                                        <canvas id="LoginLineChartYear"></canvas>
                                    </div>
                                {{-- </div> --}}
                          
                            </div>
                        </div><!-- .card -->
                    </div><!-- .col -->
            
                    <div class="col-12">
                        <div class="card card-bordered h-100">
                            <div class="card-inner">
                                <div class="card-title-group align-start gx-3 mb-3">
                                    <div class="card-title">
                                        <h6 class="title">Thống kê khung giờ đăng nhập</h6>
                                        <p>Thống kê khung giờ đăng nhập của người trong vòng 1 tháng </p>
                                    </div>
                                    <div class="card-tools">
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-primary btn-dim d-none d-sm-inline-flex" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em><span>Chọn tháng</span></a>
                                            <a href="#" class="btn btn-icon btn-primary btn-dim d-sm-none" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    @for ($i = 1 ; $i < 13 ; $i++)
                                                        <li class="month-selection-login-li" data-value="{{ $i }}"><a style="cursor: pointer;"><span>Tháng {{ $i }}</span></a></li>
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
                                                <span id="total-logins-span"></span>
                                            </div>
                                            {{-- <div class="change up"><em class="icon ni ni-arrow-long-up"></em>12.37%</div> --}}
                                        </div>
                                        <div class="analytic-data analytic-ov-data d-flex flex-column align-items-center">
                                            <div class="title">Min</div>
                                            <div class="amount">                               
                                                <span id="min-logins-span"></span>
            
                                            </div>
                                            {{-- <div class="change up"><em class="icon ni ni-arrow-long-up"></em>47.74%</div> --}}
                                        </div>
                                        <div class="analytic-data analytic-ov-data d-flex flex-column align-items-center">
                                            <div class="title">Max</div>
                                            <div class="amount">
                                                <span id="max-logins-span"></span>
            
                                            </div>
                                            {{-- <div class="change down"><em class="icon ni ni-arrow-long-down"></em>12.37%</div> --}}
                                        </div>
                                        <div class="analytic-data analytic-ov-data d-flex flex-column align-items-center">
                                            <div class="title">Tháng</div>
                                            <div class="amount">
                                                <span id="month-selection-login-span"></span>
                                            </div>
                                            {{-- <div class="change down"><em class="icon ni ni-arrow-long-down"></em>0.35%</div> --}}
                                        </div>
                                    </div>
                                    <div class="analytic-ov-ck" style=" height: 300px;">
                                        <canvas id="LoginLineChartMonth"></canvas>
                                        {{-- <input type="month" onchange="filterChart(this)"/> --}}                    
                                    </div>
                                </div>
            
                               
                            </div>
                        </div><!-- .card -->
                    </div><!-- .col -->
                </div>
            </div>
            <div class="tab-pane" id="tabItem10">
                <div class="col-12">
                    <div class="col-12">
                        <div class="card card-bordered h-100">
                            <div class="card-inner">
                                <div class="card-title-group align-start gx-3 mb-3">
                                    <div class="card-title">
                                        <h6 class="title">Thống kê người dùng</h6>
                                        <p>Thống kê tổng số người dùng đã tham gia trong vòng 12 tháng </p>
                                    </div>
                                    <div class="card-tools">
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-primary btn-dim d-none d-sm-inline-flex" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em><span>Chọn năm</span></a>
                                            <a href="#" class="btn btn-icon btn-primary btn-dim d-sm-none" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    @foreach ($allYears as $year)
                                                        <li><a href="/admin/statistics/user/{{ $year->year }}"><em class="icon ni ni-calendar"></em><span>Năm {{ $year->year }} </span></a></li>
                                                    @endforeach
                                                  
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="nk-sale-data-group align-center justify-between gy-3 gx-5">
                                    <div class="nk-sale-data">
                                        <span class="amount">Tổng người dùng: {{ $totalUsersInYear }}</span>
                                    </div>
                                    <div class="nk-sale-data">
                                        <span class="amount sm">Năm: {{ $statisticsYear }}</span>
                                    </div>
                                </div>
                                {{-- <div class="analytic-ov"> --}}
                                   
                                    <div class="analytic-ov-ck">
                                        <canvas id="userLineChartYear"></canvas>
                                    </div>
                                {{-- </div> --}}
                          
                            </div>
                        </div><!-- .card -->
                    </div><!-- .col -->
            
                    <div class="col-12">
                        <div class="card card-bordered h-100">
                            <div class="card-inner">
                                <div class="card-title-group align-start gx-3 mb-3">
                                    <div class="card-title">
                                        <h6 class="title">Thống kê người dùng</h6>
                                        <p>Thống kê tổng số người dùng đã tham gia theo ngày trong tháng</p>
                                    </div>
                                    <div class="card-tools">
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-primary btn-dim d-none d-sm-inline-flex" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em><span>Chọn tháng</span></a>
                                            <a href="#" class="btn btn-icon btn-primary btn-dim d-sm-none" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    @for ($i = 1 ; $i < 13 ; $i++)
                                                        <li class="month-selection-user-li" data-value="{{ $i }}"><a style="cursor: pointer;"><span>Tháng {{ $i }}</span></a></li>
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
                                                <span id="month-selection-user-span"></span>
                                            </div>
                                            {{-- <div class="change down"><em class="icon ni ni-arrow-long-down"></em>0.35%</div> --}}
                                        </div>
                                    </div>
                                    <div class="analytic-ov-ck" style=" height: 300px;">
                                        <canvas id="userLineChartMonth"></canvas>
                                        {{-- <input type="month" onchange="filterChart(this)"/> --}}                    
                                    </div>
                                </div>
            
                               
                            </div>
                        </div><!-- .card -->
                    </div><!-- .col -->
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

        renderUserLineChartMonth();
        renderLoginChartMonth();

    });

    function renderUserLineChartMonth(){
        var yearSelected = {!! $statisticsYear !!};

        var temp = {!! \Carbon\Carbon::now()->format('YmdH') !!};

        var currentMonth = temp.toString().substring(4,6);

        $('#month-selection-user-span').text(currentMonth);
        const totalUsersPerDate = {!! json_encode($totalUsersPerDate) !!};
        const filterByMonth = totalUsersPerDate.map((obj)=>{
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

    }

    function renderLoginChartMonth(){
        var temp = {!! \Carbon\Carbon::now()->format('YmdH') !!};

        var currentMonth = temp.toString().substring(4,6);

        $('#month-selection-login-span').text(currentMonth);
        const totalLoginsPerMonth = {!! json_encode($totalLoginsPerMonth) !!};

        var min = 0;
        var max = 0;
        var sum = 0;

        if(totalLoginsPerMonth.length){
            min = Math.min(...totalLoginsPerMonth.map(object => object.total));
                
            max = Math.max(...totalLoginsPerMonth.map(object => object.total));

            sum = totalLoginsPerMonth.reduce((accumulator, object) => {
                return accumulator + object.total;
            }, 0);
        }

        $('#total-logins-span').text(sum);
        $('#min-logins-span').text(min);
        $('#max-logins-span').text(max);
    }
    function createDonutChart() {

        const ctx = document.getElementById('doughnutChart');
     

        var result = {!! json_encode($totalByTypes) !!};

        const data = {
            labels: result.map(object=>{
                if(object.status == 1){
                    return 'Hoạt động';
                }
                else{
                    return 'Đình chỉ';
                }
            }),
            datasets: [{
                label: 'Số lượng',
                data: result.map(object=>object.total),
                hoverOffset: 4,
                backgroundColor:[              
                    'rgba(255,46,85,0.3)',
                    'rgba(52,199,89,0.3)',


                ]

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
    
    function createUserLineChartYear(){
        const ctx = document.getElementById('userLineChartYear');

        var result = {!! json_encode($totalUsersPerMonth) !!};

        const data = {
        labels: Object.keys(result[0]),
        datasets: [{
            label: 'Số lượng người dùng',
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
    createUserLineChartYear()

    
    
    function createUserLineChartMonth(){
        const ctx = document.getElementById('userLineChartMonth');

    

        var yearSelected = {!! $statisticsYear !!};

        var temp = {!! \Carbon\Carbon::now()->format('YmdH') !!};

        var currentMonth = temp.toString().substring(4,6);

        const lastDate  = new Date(yearSelected,currentMonth,0).getDate();

        var result = {!! json_encode($totalUsersPerDate) !!};


        const data = {
            labels: result.map(object => object.date),
            datasets: [{
                label: 'Số lượng người dùng',
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



            $('.month-selection-user-li').click(function () {

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

                $('#month-selection-user-span').text(month);

                const result = {!! json_encode($totalUsersPerDate) !!};

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
    }  
    createUserLineChartMonth();


    function createLoginChartYear(){

        var yearSelected = {!! $statisticsYear !!};
        const ctx = document.getElementById('LoginLineChartYear');
        var result = {!! json_encode($totalLoginsPerYear) !!};

        
        var all_hour = [];
        for (var i = 0; i < 24 ; i++){
            
            all_hour.push({
                'hour':i,
                'total':0
            })
        }
        all_hour.forEach(item1 => {
            
            result.forEach(item2=>{
                if(item1.hour === item2.hour){
                    item1.hour = item2.hour;
                    item1.total = item2.total
                }
            })
        });
        
        var newArray = all_hour.map(object=>{

            
            var hour = object.hour;

            if(hour < 10){

                object.hour = `${yearSelected}-01-01` + 'T0'+ object.hour + ':00:00'
            }else{
                object.hour = `${yearSelected}-01-01` + 'T'+ object.hour + ':00:00'

            }

            return object
            });
        var labelArray = newArray.map(object =>object.hour);

        var data = {
            labels: labelArray,
            datasets: [{
                label: 'Lượt đăng nhập',
                data:  all_hour.map(object =>object.total),
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(235,238,255,0.6)',
                tension: 0.2,


            }]
        };
        const loginBar = new Chart(ctx, {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x:{  
                            min:`${yearSelected}-01-01T00:00:00`,
                            max:`${yearSelected}-01-01T23:59:00`,

                            type: 'time',
                            time: {
                                    unit:'hour'  
                                },

                        },
                        y: {
                            ticks: {
                                precision: 0,
                                beginAtZero: true,         
                                },
                            display: false,
                        } 
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            displayColors:false,
                            callbacks:{
                                title: function(tooltipItems, data) {
                                    var tooltipItem = tooltipItems[0];
                                    if (tooltipItem.dataIndex == 23) {

                                        const temp = new Date(labelArray[tooltipItem.dataIndex])

                                        var hour1 = moment(temp).locale('en').format('LT');

                                        return "Sau " + hour1;
                                    } else {

                                        const temp = new Date(labelArray[tooltipItem.dataIndex]);
                                        const temp2 = new Date(labelArray[(tooltipItem.dataIndex) + 1]);

                                        var hour1 = moment(temp).locale('en').format('LT');
                                        var hour2 = moment(temp2).locale('en').format('LT');

                                        return hour1 + " - " + hour2;
                                    }
                                },
                            }
                        },

                    }
                },  
                
        });
    }

    createLoginChartYear();



    function createLoginChartMonth(){

        var yearSelected = {!! $statisticsYear !!};
        const ctx = document.getElementById('LoginLineChartMonth');
        var result = {!! json_encode($totalLoginsPerMonth) !!};

        var month = {!! \Carbon\Carbon::now()->month !!};

        if(month < 10){
            month = '0' + month;
        }
        var all_hour = [];
        for (var i = 0; i < 24 ; i++){
            
            all_hour.push({
                'hour':i,
                'total':0
            })
        }
        all_hour.forEach(item1 => {
            
            result.forEach(item2=>{
                if(item1.hour === item2.hour){
                    item1.hour = item2.hour;
                    item1.total = item2.total
                }
            })
        });
    
    var newArray = all_hour.map(object=>{

        
        var hour = object.hour;

        if(hour < 10){

            object.hour = `${yearSelected}-${month}-01` + 'T0'+ object.hour + ':00:00'
        }else{
            object.hour = `${yearSelected}-${month}-01` + 'T'+ object.hour + ':00:00'

        }

        return object
        });
    var labelArray = newArray.map(object =>object.hour);

    var data = {
            labels: labelArray,
            datasets: [{
                label: 'Lượt đăng nhập',
                data:  newArray.map(object =>object.total),
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(235,238,255,0.6)',
                tension: 0.2,


            }]
        };
    const loginBar = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x:{  
                      
                        type: 'time',
                        time: {
                                unit:'hour'  
                            },

                    },
                    y: {
                        ticks: {
                            precision: 0,
                            beginAtZero: true,         
                            },
                        display: false,
                    } 
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        displayColors:false,
                        callbacks:{
                            title: function(tooltipItems, data) {
                                var tooltipItem = tooltipItems[0];
                                if (tooltipItem.dataIndex == 23) {

                                    const temp = new Date(labelArray[tooltipItem.dataIndex])

                                    var hour1 = moment(temp).locale('en').format('LT');

                                    return "Sau " + hour1;
                                } else {

                                    const temp = new Date(labelArray[tooltipItem.dataIndex]);
                                    const temp2 = new Date(labelArray[(tooltipItem.dataIndex) + 1]);

                                    var hour1 = moment(temp).locale('en').format('LT');
                                    var hour2 = moment(temp2).locale('en').format('LT');

                                    return hour1 + " - " + hour2;
                                }
                            },
                        }
                    },

                }
            },  
            
    });
    console.log(loginBar.data.datasets[0]);

    $('.month-selection-login-li').click(function () {

        const year = {!! $statisticsYear !!};

        var month = $(this).data('value');

        if(month < 10){
            month = '0' + month;
        }
        
      

        $('#month-selection-login-span').text(month);

        $.ajax({
            type:"GET",
            url:'/admin/statistics/user/get/LoginHistoryPerMonth',
            data : {
                "year": year,
                "month":month,
            },
            })
            .done(function(res) {
            // If successful           
                
             var result = res.res;

             var all_hour = [];
                for (var i = 0; i < 24 ; i++){
                    
                    all_hour.push({
                        'hour':i,
                        'total':0
                    })
                }
                all_hour.forEach(item1 => {
                    
                    result.forEach(item2=>{
                        if(item1.hour === item2.hour){
                            item1.hour = item2.hour;
                            item1.total = item2.total
                        }
                    })
                });
            
                var newArray = all_hour.map(object=>{

                    
                    var hour = object.hour;

                    if(hour < 10){

                        object.hour = `${yearSelected}-${month}-01` + 'T0'+ object.hour + ':00:00'
                    }else{
                        object.hour = `${yearSelected}-${month}-01` + 'T'+ object.hour + ':00:00'

                    }

                    return object
                });


                    loginBar.data.datasets[0].data = newArray.map(object =>object.total);

                

                    loginBar.update();




                    var min = 0;
                    var max = 0;
                    var sum = 0;

                    if(result.length){
                        min = Math.min(...result.map(object => object.total));
                            
                        max = Math.max(...result.map(object => object.total));

                        sum = result.reduce((accumulator, object) => {
                            return accumulator + object.total;
                        }, 0);
                    }

                    $('#total-logins-span').text(sum);
                    $('#min-logins-span').text(min);
                    $('#max-logins-span').text(max);

                   

            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
            })
       
        // const result = {!! json_encode($totalUsersPerDate) !!};

     
        })
    }

    createLoginChartMonth();
</script>
@endsection