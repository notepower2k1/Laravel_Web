@extends('admin/layouts.app')
@section('pageTitle', 'Chi tiết sách điện tử')
@section('content')
<div class="container">
    <div class="nk-block-head-sub"><a class="back-to" href="{{ url()->previous() }}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>

    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="product-gallery" >    
                                    <img src="{{ $book->url }}" class="w-100" alt="">                                     
                               </div>
                            </div><!-- .col -->
                            <div class="col-lg-6 d-flex align-items-end">
                                <div class="product-info mb-5 me-xxl-5">
                                        <h2 class="product-title">{{ $book->name }}
                                         
                                        </h2>                                        
                                    <p class="product-title"><strong>Tác giả: </strong>{{ $book->author }}</p>                 
                                    <div class="product-rating">                                                                      
                                        <p><strong>Đánh giá: </strong>(<span id="score">{{$book->ratingScore}}</span>/5)</p>
                                    </div><!-- .product-rating -->                                   
                                    <div class="product-meta">
                                        <ul class="d-flex g-3 gx-5">
                                            <li>
                                                <div class="fs-14px text-muted">Số chương</div>
                                                <div class="fs-16px fw-bold text-secondary">{{ $book->numberOfChapter }}</div>
                                            </li>
                                            <li>
                                                <div class="fs-14px text-muted">Lượt đọc</div>
                                                <div class="fs-16px fw-bold text-secondary">{{ $book->totalReading }}</div>
                                            </li>
                                            <li>
                                                <div class="fs-14px text-muted">Đánh dấu</div>
                                                <div class="fs-16px fw-bold text-secondary" id="totalBookMarking">{{ $book->totalBookMarking }}</div>
                                            </li>
                                            
                                            @if($book->file)
                                            <li>
                                                <div class="fs-14px text-muted">File</div>
                                                <div class="fs-16px fw-bold text-secondary" id="totalBookMarking"><a href="{{ $book->bookUrl }}">File</a></div>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                    
                                    <div class="product-meta">
                                        <h6 class="title">Ngôn ngữ: 
                                            @if ($book->language === 1)
                                            <span class="text-success fs-14px">Tiếng việt</span>
                                            @else
                                            <span class="text-info fs-14px">Tiếng anh</span>

                                            @endif 
                                        </h6>
                                        
                                    </div><!-- .product-meta -->
                                    <div class="product-meta">
                                        <h6 class="title">Tình trạng: 

                                            @if ($book->isCompleted === 1)
                                            <span class="text-success fs-14px fw-bold">Đã hoàn thành</span>
                                            @else
                                            <span class="text-info fs-14px fw-bold">Chưa hoàn thành</span>

                                            @endif 
                                        </h6>
                                        
                                    </div><!-- .product-meta -->
                                    <div class="product-meta">
                                        <h6 class="title">Thể loại</h6>
                                        <ul class="d-flex flex-wrap ailgn-center g-2 pt-1">                                     
                                            <li class="ms-n1">
                                                <a href="/the-loai/the-loai-sach/{{$book->types->slug}}" class="btn btn-primary">{{ $book->types->name }}</a>
                                            </li>         
                                        </ul>
                                    </div><!-- .product-meta -->
                                    
                                </div><!-- .product-info -->
                               
                              
                            </div><!-- .col -->
                        </div><!-- .row -->
                        <div class="row g-gs flex-lg-row-reverse">                      
                            <div class="col-lg-12">
                                <div class="product-details entry me-xxl-3">
                                    <hr class="hr">
                                    <h3>Giới thiệu</h3>
                                    {!! clean($book->description ) !!}

                                </div>
                            </div><!-- .col -->
                        </div><!-- .row -->  


                     
                    </div>
                </div>


                <div class="">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tabItem1">Số lượt đọc sách</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tabItem2">Thống kê số lược đọc sách</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabItem1">
                            <div class="card card-bordered">
    
                                <div class="card-inner">
            
                                    <table class="datatable-init-export nowrap nk-tb-list nk-tb-ulist mt-2" data-auto-responsive="false" data-export-title="Export">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head">
            
                                                <th class="nk-tb-col"><span class="sub-text">Thời gian</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">Tài khoản</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">Lượt đọc</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($reading_history as $item)
                                            <tr class="nk-tb-item">                
                                                <td class="nk-tb-col">
                                                    <span>{{  $item->created_at }}</span>
                                                </td>
                                                <td class="nk-tb-col">
                                                <span>{{  $item->users->name }}</span>
                                                </td>
                                                <td class="nk-tb-col">
                                                <span>{{ $item->total }}</span>
                                                </td>                  
                                            </tr>
                                        @endforeach
            
                                        </tbody>
                                    </table>     
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabItem2">
                            <div class="card card-bordered">
                                <div class="card-inner">
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
                                                                <a href="#" class="btn btn-primary btn-dim d-none d-sm-inline-flex" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em><span>Chọn năm</span></a>
                                                                <a href="#" class="btn btn-icon btn-primary btn-dim d-sm-none" data-bs-toggle="dropdown"><em class="icon ni ni-calendar"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        @foreach ($allYears as $year)
                                                                            <li><a href="/admin/book/{{ $book->id }}/{{ $year->year }}"><em class="icon ni ni-calendar"></em><span>Năm {{ $year->year }} </span></a></li>
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
              
               
                        
          

                <div class="mt-5 ">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tabItem4">Số lượt đánh giá</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tabItem5">Phân bố điểm</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabItem4">
                            <div class="card card-bordered">

                                <div class="card-inner">
            
                                <table class="datatable-init-export nowrap nk-tb-list nk-tb-ulist mt-2" data-auto-responsive="false" data-export-title="Export">
                                    <thead>
                                        <tr class="nk-tb-item nk-tb-head">
            
                                            <th class="nk-tb-col"><span class="sub-text">Thời gian</span></th>
                                            <th class="nk-tb-col"><span class="sub-text">Tài khoản</span></th>
                                            <th class="nk-tb-col"><span class="sub-text">Số điểm</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($rating_books as $item)
                                        <tr class="nk-tb-item">                
                                            <td class="nk-tb-col">
                                                <span>{{  $item->created_at }}</span>
                                              </td>
                                            <td class="nk-tb-col">
                                              <span>{{  $item->users->name }}</span>
                                            </td>
                                            <td class="nk-tb-col">
                                              <span>{{ $item->score }}</span>
                                            </td>                  
                                        </tr>
                                      @endforeach
            
                                    </tbody>
                                </table>     
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabItem5">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="row g-gs">
                                        <div class="col-12" id="statistics-6">
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner">
                                                    <div class="card-title-group align-start gx-3 mb-3">
                                                        <div class="card-title">
                                                            <h6 class="title">Phân bố điểm đánh giá của sách</h6>
                                                        </div>                                         
                                                    </div>
                                                    <div class="nk-sale-data-group align-center justify-between gy-3 gx-5">                                      
                                                        <div class="nk-sale-data">
                                                            <span class="amount sm">Tổng lượt đánh giá: {{ $rating_books->count() }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="" style="height:300px">
                                                        <canvas id="chart6"></canvas>
                                                    </div>
                                                </div>
                                            </div><!-- .card -->
                                        </div><!-- .col -->                               
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/js/bootstrap5-toggle.jquery.min.js"></script>
<script src="{{ asset('assets/js/example-sweetalert.js?ver=3.1.2') }}" aria-hidden="true"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.4/moment-with-locales.js"></script>
<script>
  //custom datatable

  $(document).ready(function () {
    $('#DataTables_Table_0').DataTable().destroy();
    
    $('#DataTables_Table_0').DataTable( {
      dom: 'Blfrtip',
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Tất cả"] ],
      "language": {
          "lengthMenu": "Hiển thị: _MENU_ đối tượng",
          "search": "Tìm kiếm _INPUT_",
          'info':"",
          "zeroRecords": "Không tìm thấy dữ liệu",
          "infoEmpty": "Không có dữ liệu hợp lệ",
          "infoFiltered": "(Lọc từ _MAX_ dữ liệu)",
          "paginate": {
            "first":      "Đầu tiên",
            "last":       "Cuối cùng",
            "next":       "Tiếp theo",
            "previous":   "Trước đó"
        },
       buttons: {
            colvis: 'Thay đổi số cột'
        }
      },
      buttons: [
            
            {
                extend: 'colvis',
                columns: ':not(.noVis)'
            },
      
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [0,1,2]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0,1,2]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [0,1,2]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [0,1,2]
                }
            },
            
        ],
    
    });

    $('#DataTables_Table_0_wrapper').addClass('d-flex row');
    $('#DataTables_Table_0_length').addClass('mt-2');
    $('#DataTables_Table_0_filter').addClass('mt-2');



    $('#DataTables_Table_1').DataTable().destroy();
    
    $('#DataTables_Table_1').DataTable( {
      dom: 'Blfrtip',
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Tất cả"] ],
      "language": {
          "lengthMenu": "Hiển thị: _MENU_ đối tượng",
          "search": "Tìm kiếm _INPUT_",
          'info':"",
          "zeroRecords": "Không tìm thấy dữ liệu",
          "infoEmpty": "Không có dữ liệu hợp lệ",
          "infoFiltered": "(Lọc từ _MAX_ dữ liệu)",
          "paginate": {
            "first":      "Đầu tiên",
            "last":       "Cuối cùng",
            "next":       "Tiếp theo",
            "previous":   "Trước đó"
        },
       buttons: {
            colvis: 'Thay đổi số cột'
        }
      },
      buttons: [
            
            {
                extend: 'colvis',
                columns: ':not(.noVis)'
            },
      
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [0,1,2]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0,1,2]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [0,1,2]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [0,1,2]
                }
            },
            
        ],
    
    });

    $('#DataTables_Table_1_wrapper').addClass('d-flex row');
    $('#DataTables_Table_1_length').addClass('mt-2');
    $('#DataTables_Table_1_filter').addClass('mt-2');


    var yearSelected = {!! $statisticsYear !!};

    var temp = {!! \Carbon\Carbon::now()->format('YmdH') !!};

    var currentMonth = temp.toString().substring(4,6);

    defaultRenderChart5(currentMonth);

})

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


    function createChart6(){
        const chart6 = document.getElementById('chart6');
        var result =  {!! json_encode($ratingScoreBase) !!}
        

        console.log(result);

        var data = {
            labels: Object.keys(result[0]),
            datasets: [{
                label: 'Tổng số đánh giá',
                data: Object.values(result[0]),         
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: [

                    'rgb(32,201,151)',
                    'rgb(30,224,172)',
                    'rgb(9,194,222)',
                    'rgb(244,189,14)',
                    'rgb(232,83,71)'
                    
                   
                        
                    
                ],
                tension: 0.2,


            }]
        };
        const chart = new Chart(chart6, {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                    
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
                                    // var tooltipItem = tooltipItems[0];
                                    // if (tooltipItem.dataIndex == 23) {

                                    //     const temp = new Date(labelArray[tooltipItem.dataIndex])

                                    //     var hour1 = moment(temp).locale('en').format('LT');

                                    //     return "Sau " + hour1;
                                    // } else {

                                    //     const temp = new Date(labelArray[tooltipItem.dataIndex]);
                                    //     const temp2 = new Date(labelArray[(tooltipItem.dataIndex) + 1]);

                                    //     var hour1 = moment(temp).locale('en').format('LT');
                                    //     var hour2 = moment(temp2).locale('en').format('LT');

                                    //     return hour1 + " - " + hour2;
                                    // }
                                },
                            }
                        },

                    }
                },  
                
        });  
    }

    createChart4();
    createChart5();
    createChart6();
</script>
@endsection