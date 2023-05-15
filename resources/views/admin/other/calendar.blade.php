@extends('admin/layouts.app')
@section('pageTitle', 'Ghi chú')
@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Lịch sự kiện</h3>
                            <p id="moment-today-span"></p>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="dropdown">
                                <a class="btn btn-outline-primary dropdown-toggle" href="#" type="button" data-bs-toggle="dropdown"><em class="icon ni ni-menu"></em><span>Tác vụ</span></a>
                                <div class="dropdown-menu">
                                  <ul class="link-list-opt">
                                    <li><a data-bs-toggle="modal" href="#addEventPopup"><em class="icon ni ni-plus"></em><span>Thêm sự kiện</span></a>                                    </li>
                                    <li><a href="#" id="exportcsvbtn"><em class="icon ni ni-file-xls"></em><span>Xuất dữ liệu</span></a></li>
                             
                                  </ul>
                                </div>
                              </div>
                            
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div id="calendar" class="nk-calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
<div class="modal fade" id="addEventPopup">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm sự kiện</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" id="addEventForm" class="form-validate is-alter">
                    <div class="row gx-4 gy-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="event-title">Chủ đề sự kiện</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="event-title" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Thời gian bắt đầu</label>
                                <div class="row gx-2">
                                    <div class="w-55">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-calendar"></em>
                                            </div>
                                            <input type="text" id="event-start-date" class="form-control date-picker" data-date-format="yyyy-mm-dd" required>
                                        </div>
                                    </div>
                                    <div class="w-45">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-clock"></em>
                                            </div>
                                            <input type="text" id="event-start-time" data-time-format="HH:mm:ss" class="form-control time-picker">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Thời gian kết thúc</label>
                                <div class="row gx-2">
                                    <div class="w-55">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-calendar"></em>
                                            </div>
                                            <input type="text" id="event-end-date" class="form-control date-picker" data-date-format="yyyy-mm-dd">
                                        </div>
                                    </div>
                                    <div class="w-45">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-clock"></em>
                                            </div>
                                            <input type="text" id="event-end-time" data-time-format="HH:mm:ss" class="form-control time-picker">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="event-description">Mô tả sự kiện</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control" id="event-description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Loại sự kiện</label>
                                <div class="form-control-wrap">
                                    <select id="event-theme" class="select-calendar-theme form-control" data-search="on">
                                        <option value="event-primary">Công ty</option>
                                        <option value="event-success">Hội thảo</option>
                                        <option value="event-info">Hội nghị</option>
                                        <option value="event-warning">Meeting</option>
                                        {{-- <option value="event-danger">Business dinners</option> --}}
                                        <option value="event-pink">Cá nhân</option>
                                        <option value="event-primary-dim">Đấu giá</option>
                                        <option value="event-success-dim">Sự kiện mạng</option>
                                        <option value="event-info-dim">Ra mắt sản phẩm</option>
                                        <option value="event-warning-dim">Gây quỹ</option>
                                        <option value="event-danger-dim">Tài trợ</option>
                                        <option value="event-pink-dim">Sự kiện thể thao</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <ul class="d-flex justify-content-between gx-4 mt-1">
                                <li>
                                    <button id="addEvent" type="submit" class="btn btn-primary">Thêm sự kiện</button>
                                </li>
                                <li>
                                    <button id="resetEvent" data-bs-dismiss="modal" class="btn btn-danger btn-dim">Hủy bỏ</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editEventPopup">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cập nhật sự kiện</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" id="editEventForm" class="form-validate is-alter">
                    <div class="row gx-4 gy-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="edit-event-title">Chủ đề sự kiện</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="edit-event-title" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Thời gian bắt đầu</label>
                                <div class="row gx-2">
                                    <div class="w-55">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-calendar"></em>
                                            </div>
                                            <input type="text" id="edit-event-start-date" class="form-control date-picker" data-date-format="yyyy-mm-dd" required>
                                        </div>
                                    </div>
                                    <div class="w-45">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-clock"></em>
                                            </div>
                                            <input type="text" id="edit-event-start-time" data-time-format="HH:mm:ss" class="form-control time-picker">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Thời gian kết thúc</label>
                                <div class="row gx-2">
                                    <div class="w-55">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-calendar"></em>
                                            </div>
                                            <input type="text" id="edit-event-end-date" class="form-control date-picker" data-date-format="yyyy-mm-dd">
                                        </div>
                                    </div>
                                    <div class="w-45">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-clock"></em>
                                            </div>
                                            <input type="text" id="edit-event-end-time" data-time-format="HH:mm:ss" class="form-control time-picker">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="edit-event-description">Mô tả sự kiện</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control" id="edit-event-description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Loại sự kiện</label>
                                <div class="form-control-wrap">
                                    <select id="edit-event-theme" class="select-calendar-theme form-control" data-search="on">
                                        <option value="event-primary">Công ty</option>
                                        <option value="event-success">Hội thảo</option>
                                        <option value="event-info">Hội nghị</option>
                                        <option value="event-warning">Meeting</option>
                                        {{-- <option value="event-danger">Business dinners</option> --}}
                                        <option value="event-pink">Cá nhân</option>
                                        <option value="event-primary-dim">Đấu giá</option>
                                        <option value="event-success-dim">Sự kiện mạng</option>
                                        <option value="event-info-dim">Ra mắt sản phẩm</option>
                                        <option value="event-warning-dim">Gây quỹ</option>
                                        <option value="event-danger-dim">Tài trợ</option>
                                        <option value="event-pink-dim">Sự kiện thể thao</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <ul class="d-flex justify-content-between gx-4 mt-1">
                                <li>
                                    <button id="updateEvent" type="submit" class="btn btn-primary">Cập nhật sự kiện</button>
                                </li>
                                <li>
                                    <button data-bs-dismiss="modal" data-toggle="modal" data-target="#deleteEventPopup" class="btn btn-danger btn-dim">Xóa sự kiện</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="previewEventPopup">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div id="preview-event-header" class="modal-header">
                <h5 id="preview-event-title" class="modal-title">Placeholder Title</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <div class="row gy-3 py-1">
                    <div class="col-sm-6">
                        <h6 class="overline-title">Thời gian bắt đầu</h6>
                        <p id="preview-event-start"></p>
                    </div>
                    <div class="col-sm-6" id="preview-event-end-check">
                        <h6 class="overline-title">Thời gian kết thúc</h6>
                        <p id="preview-event-end"></p>
                    </div>
                    <div class="col-sm-10" id="preview-event-description-check">
                        <h6 class="overline-title">Mô tả sự kiện</h6>
                        <p id="preview-event-description"></p>
                    </div>
                </div>
                <ul class="d-flex justify-content-between gx-4 mt-3">
                    <li>
                        <button data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#editEventPopup" class="btn btn-primary">Cập nhật sự kiện</button>
                    </li>
                    <li>
                        <button data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#deleteEventPopup" class="btn btn-danger btn-dim">Xóa sự kiện</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteEventPopup">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal py-4">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-cross bg-danger"></em>
                    <h4 class="nk-modal-title">Bạn có chắc muốn xóa sự kiện?</h4>
                    <div class="nk-modal-text mt-n2">
                        <p class="text-soft">Thông tin về sự kiện này sẽ bị xóa <strong>vĩnh viễn</strong>.</p>
                    </div>
                    <ul class="d-flex justify-content-center gx-4 mt-4">
                        <li>
                            <button data-bs-dismiss="modal" id="deleteEvent" class="btn btn-success">Tôi đồng ý</button>
                        </li>
                        <li>
                            <button data-bs-dismiss="modal" data-toggle="modal" data-target="#editEventPopup" class="btn btn-danger btn-dim">Xóa</button>
                        </li>
                    </ul>
                </div>
            </div><!-- .modal-body -->
        </div>
    </div>
</div>
@endsection
@section('additional-scripts')
<script src="{{ asset('assets/js/libs/fullcalendar.js?ver=3.1.2') }}"></script>
<script src="{{ asset('assets/js/apps/calendar.js?ver=3.1.2') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.4/moment-with-locales.js"></script>
<script src="https://cdn.jsdelivr.net/npm/json2csv"></script>

<script>
     $(function() {

        const today = {!! json_encode($today) !!};
        var dateObj = new Date(today);

        var vietnameseDate = moment(dateObj).locale('vi').format('LLLL').toString();
        //clear
        var vietnameseDate = vietnameseDate.substring(0, vietnameseDate.length - 6);

        //upppercase
        var vietnameseDate = vietnameseDate.charAt(0).toUpperCase() + vietnameseDate.slice(1)

        $('#moment-today-span').text(vietnameseDate);
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

    
    $('#exportcsvbtn').click(function(e) {

        let type = {
            "fc-event-primary":"Công ty",
            "fc-event-success":"Hội thảo",
            "fc-event-info":"Hội nghị",
            "fc-event-warning":"Meeting",
            "fc-event-pink":"Cá nhân",
            "fc-event-primary-dim":"Đấu giá",
            "fc-event-success-dim":"Sự kiện mạng",
            "fc-event-info-dim":"Ra mắt sản phẩm",
            "fc-event-warning-dim":"Gây quỹ",
            "fc-event-danger-dim":"Tài trợ",
            "fc-event-pink-dim":"Sự kiện thể thao"
        }

        e.preventDefault();
        var localStorageData = window.localStorage.getItem('calendar');
        if(localStorageData){
            localStorageData = JSON.parse(localStorageData);
        }

        for (const [key, value] of Object.entries(type)) {

            localStorageData.forEach(object => {
                if(object['className'] == key){
                    object['className'] = value;
                }
                delete object['id'];
            });
        }



        let header = Object.keys(localStorageData[0])
        let value = [];
        
        for(const n of localStorageData){

            var item = Object.values(n);
            
            for (const i of item){
                value.push(i);
            }
        }

        const result = [...chunks(value,5)];

        let temp = [];

        temp.push(header);
        result.forEach(i => temp.push(i));

        let csv = arrayToCsv(temp);
        


        downloadBlob(csv, 'calendar.csv');

    })

    function* chunks(array, n){
        for(let i = 0; i < array.length; i += n) yield array.slice(i, i + n);
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
</script>
@endsection