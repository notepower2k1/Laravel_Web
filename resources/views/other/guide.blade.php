@extends('client/homepage.layouts.app')
@section('content')
<div class="container">
    <div class="nk-block-head nk-block-head-lg wide-sm mx-auto">
        <div class="nk-block-head-content text-center">
            <h2 class="nk-block-title fw-normal">Câu hỏi thường gặp</h2>
            
        </div>
    </div>
    <div class="nk-block">
        <div id="accordion" class="accordion">
            <div class="accordion-item">
                <a href="#" class="accordion-head" data-bs-toggle="collapse" data-bs-target="#accordion-item-1">
                    <h6 class="title">Làm thề nào để đăng tài liệu?</h6>
                    <span class="accordion-icon"></span>
                </a>
                <div class="accordion-body collapse show" id="accordion-item-1" data-bs-parent="#accordion">
                    <div class="accordion-inner">
                        <p>- Tạo tài khoản, xác thực email của bạn.</p>
                        <p>- Sử dụng nút đăng tài liệu trong icon người dùng</p>                        
                        <p>- Nhập đủ thông tin tài liệu và đợi quản trị viên xét duyệt tài liệu của bạn</p>
                        <p>* Tài liệu của bạn phải phù hợp với <a href="/thong-tin/quy-dinh">các quy định </a> của website</p>

                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <a href="#" class="accordion-head collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-item-2">
                    <h6 class="title">Số liệu "Đã đọc (<em class="icon ni ni-eye"></em>)" trong đánh giá, bình luận là gì?</h6>
                    <span class="accordion-icon"></span>
                </a>
                <div class="accordion-body collapse" id="accordion-item-2" data-bs-parent="#accordion" >
                    <div class="accordion-inner">
                        <p>- Để đánh giá, bình luận tài liệu tất nhiên bạn phải đọc tài liệu đó rồi mới có thể đánh giá, bình luận được.                        </p>
                        <p>- Số liệu "Đã đọc" thể hiện người đánh giá đã đọc bao nhiêu lần trong tài liệu đó rồi, số "Đã đọc" càng lớn thì đánh giá càng có tính chính xác cao hơn. Nếu chỉ mới đọc vài lần đã đánh giá thì tất nhiên đánh giá đó không đáng tin cho lắm rồi.</p>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <a href="#" class="accordion-head collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-item-3">
                    <h6 class="title">Số liệu "Đã đọc (<em class="icon ni ni-eye"></em>)" trong đánh giá, bình luận của tôi không chính xác?</h6>
                    <span class="accordion-icon"></span>
                </a>
                <div class="accordion-body collapse" id="accordion-item-3" data-bs-parent="#accordion" >
                    <div class="accordion-inner">
                        <p>Cái này có thể do nhiều nguyên nhân:</p>
                        <p>- Bạn đọc mà quên không đăng nhập tài khoản</p>
                        <p>- Lag, lỗi ,...</p>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <a href="#" class="accordion-head collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-item-4">
                    <h6 class="title">Vì sao tôi bị khóa nick?</h6>
                    <span class="accordion-icon"></span>
                </a>
                <div class="accordion-body collapse" id="accordion-item-4" data-bs-parent="#accordion" >
                    <div class="accordion-inner">
                        <p>Bạn có thể xem lý do bằng cách liên hệ quản trị viên qua gmail</p>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <a href="#" class="accordion-head collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-item-5">
                    <h6 class="title">Tôi còn thắm mắc khác?</h6>
                    <span class="accordion-icon"></span>
                </a>
                <div class="accordion-body collapse" id="accordion-item-5" data-bs-parent="#accordion" >
                    <div class="accordion-inner">
                        <p>Bạn có thể vào Liên hệ quản trị viên qua gmail để đặt câu hỏi</p>
                    </div>
                </div>
            </div>
          </div> 
    </div>
   
</div>

@endsection