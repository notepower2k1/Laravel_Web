@extends('client/homepage.layouts.app')

@section('content')

<div class="container">
    <h3 class="text-center">Liên hệ</h3>

    
    <div class="w-50 m-auto">
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="#"  class="form-validate" id="send-contact-form">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="full-name">Họ và tên</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control" id="full-name" name="full-name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="subject">Chủ đề</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="subject" name="subject" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="topics">Lý do</label>
                                <div class="form-control-wrap ">
                                    <select class="form-select" id="topics" name="topics" required>
                                        <option value="Hỏi đáp">Hỏi đáp</option>
                                        <option value="Góp ý">Góp ý</option>
                                        <option value="">Khác</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="message">Nội dung</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control form-control-sm" id="message" name="message" placeholder="Viết nội dung tin nhắn" required></textarea>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-md-12">
                            <div class="form-group float-end">
                                <button id="send-contact-btn" class="btn btn-lg btn-danger"><em class="icon ni ni-send"></em><span>Chuyển tiếp</span></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
  
</div>
       
    
  

@endsection

@section('additional-scripts')

<script>
    $('#send-contact-btn').click(function(e) {
        e.preventDefault();
        var email = 'nguyenthach617@gmail.com';


        // form.submit();

        if($("#send-contact-form").valid()) {
            const form = $('#send-contact-form');

            var fullName = form.find('input[name="full-name"]').val();

            var subject = form.find('input[name="subject"]').val();
            var topics = form.find('select[name="topics"]').val();
            var message = form.find('textarea[name="message"]').val();
            var emailBody = `Xin chào quản trị viên %0DTôi là ${fullName} viết mail này vì lý do: ${topics} %0DNội dung: ${message}`;

            window.location = "mailto:"+email+"?subject="+subject+"&body="+emailBody;
            // window.location =  `https://mail.google.com/mail/?view=cm&fs=1&to=${email}&su=${subject}&body=${emailBody}`;

            // console.log(fullName);
        }


       
    })
</script>
@endsection
