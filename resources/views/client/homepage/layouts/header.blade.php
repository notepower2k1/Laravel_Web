<div class="container-lg wide-xl">
    <div class="nk-header-wrap">      
            <div class="nk-menu-trigger me-sm-2 d-lg-none">
                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-menu"></em></a>
            </div>
            <div class="nk-header-brand">
                <a href="/" class="logo-link">
                    <img class="logo-light logo-img" src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/logo.png" alt="logo">
                    <img class="logo-dark logo-img" src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/logo.png" alt="logo-dark">
                </a>
            </div>
        <div class="nk-header-menu ms-auto" data-content="headerNav">    
            <div class="nk-header-mobile">
                <div class="nk-header-brand">
                    <a href="/" class="logo-link">
                        <img class="logo-light logo-img" src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/logo.png" alt="logo">
                        <img class="logo-dark logo-img" src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/logo.png" alt="logo-dark">
                    </a>
                </div>
                <div class="nk-menu-trigger me-n2">
                    <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>            
            <ul class="nk-menu nk-menu-main">             
             

                @if(!Request::is('tim-kiem'))
                    <li class="nk-menu-item">
                        {{-- <a href="/tim-kiem" class="nk-menu-link">
                            <span class="nk-menu-text">
                                <em class="icon ni ni-search"></em>
                                Tìm kiếm               
                            </span>
                        
                        </a> --}}
                        <a href="#" class="nk-menu-link" data-bs-toggle="modal" data-bs-target="#modalSearchHomePage">
                            <em class="icon ni ni-search"></em>
                            <span class="nk-menu-text">
                                Tìm kiếm               
                            </span>
                        </a>

                    </li><!-- .nk-menu-item -->
                @endif
                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <em class="icon ni ni-menu-circled"></em>
                        <span class="nk-menu-text">Danh sách</span>
                    </a>
                    <ul class="nk-menu-sub">                     
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-text">Sách điện tử</span>
                            </a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item">
                                    <a href="/sach/all/moi-dang" class="nk-menu-link"><span class="nk-menu-text">Mới cập nhật</span></a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="/sach/all/doc-nhieu" class="nk-menu-link"><span class="nk-menu-text">Đọc nhiều</span></a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="/sach/all/danh-gia-cao" class="nk-menu-link"><span class="nk-menu-text">Đánh giá cao</span></a>
                                </li>
                            </ul><!-- .nk-menu-sub -->
                        </li><!-- .nk-menu-item -->
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-text">Tài liệu tham khảo</span>
                            </a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item">
                                    <a href="/tai-lieu/all/moi-dang" class="nk-menu-link"><span class="nk-menu-text">Mới cập nhật</span></a>
                                </li>                  
                                <li class="nk-menu-item">
                                    <a href="/tai-lieu/all/luot-tai-cao" class="nk-menu-link"><span class="nk-menu-text">Lượt tải cao</span></a>
                                </li>
                            </ul><!-- .nk-menu-sub -->
                        </li><!-- .nk-menu-item -->
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-text">Tình trạng</span>
                            </a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-text">Sách điện tử</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="/tinh-trang/tinh-trang-sach/da-hoan-thanh" class="nk-menu-link"><span class="nk-menu-text">Đã hoàn thành</span></a>
                                        </li>                  
                                        <li class="nk-menu-item">
                                            <a href="/tinh-trang/tinh-trang-sach/chua-hoan-thanh" class="nk-menu-link"><span class="nk-menu-text">Chưa hoàn thành</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-text">Tài liệu tham khảo</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="/tinh-trang/tinh-trang-tai-lieu/da-hoan-thanh" class="nk-menu-link"><span class="nk-menu-text">Đã hoàn thành</span></a>
                                        </li>                  
                                        <li class="nk-menu-item">
                                            <a href="/tinh-trang/tinh-trang-tai-lieu/chua-hoan-thanh" class="nk-menu-link"><span class="nk-menu-text">Chưa hoàn thành</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->
                            </ul><!-- .nk-menu-sub -->
                        </li><!-- .nk-menu-item -->
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-text">Ngôn ngữ</span>
                            </a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-text">Sách điện tử</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="/ngon-ngu/ngon-ngu-sach/tieng-viet" class="nk-menu-link"><span class="nk-menu-text">Tiếng Việt</span></a>
                                        </li>                  
                                        <li class="nk-menu-item">
                                            <a href="/ngon-ngu/ngon-ngu-sach/tieng-anh" class="nk-menu-link"><span class="nk-menu-text">Tiếng Anh</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-text">Tài liệu tham khảo</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="/ngon-ngu/ngon-ngu-tai-lieu/tieng-viet" class="nk-menu-link"><span class="nk-menu-text">Tiếng Việt</span></a>
                                        </li>                  
                                        <li class="nk-menu-item">
                                            <a href="/ngon-ngu/ngon-ngu-tai-lieu/tieng-anh" class="nk-menu-link"><span class="nk-menu-text">Tiếng Anh</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->
                            </ul><!-- .nk-menu-sub -->
                        </li><!-- .nk-menu-item -->
                      
                    </ul><!-- .nk-menu-sub -->
                </li>
                <li class="nk-menu-item {{ Request::is('the-loai') ? 'active' : '' }}">
                    <a href="/the-loai/sort_by=created_at" class="nk-menu-link">
                        <em class="icon ni ni-menu-circled"></em>

                        <span class="nk-menu-text">
                            Thể loại
                        </span>
                    </a>
                </li><!-- .nk-menu-item -->           
              <!-- .nk-menu-item -->             
                {{-- <li class="nk-menu-item {{ Request::is('/tom-tat-tai-lieu/*') ? 'active' : '' }}">
                    <a href="/tom-tat-tai-lieu" class="nk-menu-link">
                        
                        <span class="nk-menu-text">
                            <em class="icon ni ni-package-fill"></em>
                            Tóm tắt</span>
                    </a>
                </li>--}}
                <li class="nk-menu-item {{ Request::is('/dien-dan') ? 'active' : '' }}">
                    <a href="/dien-dan" class="nk-menu-link">
                        <em class="icon ni ni-question"></em>

                        <span class="nk-menu-text">
                            Diễn đàn</span>
                    </a>
                </li><!-- .nk-menu-item -->
            </ul><!-- .nk-menu -->
        </div><!-- .nk-header-menu -->
        <div class="nk-header-tools">
            <ul class="nk-quick-nav">              
                @if(Auth::check())
                    
                <li class="dropdown notification-dropdown {{ Request::is('trang-theo-doi') ? 'd-none':'' }}" id="bookMark_notifications_box">
                    <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                        @if($follow_notifications->isEmpty())
                        <em class="icon ni ni-bookmark"></em>
                        @else
                        <div class="icon-status icon-status-info"><em class="icon ni ni-bookmark"></em></div>
                        @endif  
                    </a>
                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end dropdown-menu-s1">
                        <div class="dropdown-head">
                            <span class="sub-title nk-dropdown-title">Theo dõi</span>
                            <button class="btn btn-info" id="mark_all_bookMark_notifications">Đánh dấu đã đọc hết</button>
                        </div>
                        <div class="dropdown-body">
                            <div class="nk-notification">
                                @foreach ($follow_notifications as  $follow_notification)
                                    <div class="nk-notification-item bookMark-notifications dropdown-inner" data-id="{{ $follow_notification->id }}" style="cursor: pointer;">
                                        <div class="nk-notification-icon">
                                            <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                        </div>
                                        <div class="nk-notification-content">

                                            @if($follow_notification->type_id == 2)
                                            <div class="nk-notification-text">Sách <a href="/sach/{{$follow_notification->identifier->id}}/{{$follow_notification->identifier->slug}}" >{{$follow_notification->identifier->name }}</a> 
                                                có chương mới                                            
                                                @foreach ($follow_notification->identifier->chapters as $chapter)
                                                    @if($loop->last)
                                                        <strong>{{ $chapter->code }}</strong>
                                                    @endif
                                                @endforeach
                                            </div>  
                                            @endif
                                            @if($follow_notification->type_id == 1)
                                            <div class="nk-notification-text">Tài liệu <a href="/tai-lieu/{{$follow_notification->identifier->id}}/{{$follow_notification->identifier->slug}}" >{{$follow_notification->identifier->name }}</a> 
                                                có cập nhật mới                                                        
                                            </div>  
                                            @endif
                                            <div class="nk-notification-time">
                                                {{ $follow_notification->time }}
                                            </div>  
                                        </div>
                                    </div>
                                @endforeach
                            
                               
                            </div><!-- .nk-notification -->
                        </div><!-- .nk-dropdown-body -->
                        <div class="dropdown-foot center">
                            <a href="/trang-theo-doi">Xem tất cả</a>
                        </div>
                    </div>
                </li><!-- .dropdown -->
                
                <li class="dropdown notification-2-dropdown" id="comment_notifications_box">
                    <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                        @if($comment_notifications_show->isEmpty())
                        <em class="icon ni ni-bell"></em>

                        @else
                        <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em></div>

                        @endif  
                    </a>
                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end dropdown-menu-s1">
                        <div class="dropdown-head">
                            <span class="sub-title nk-dropdown-title">Thông báo</span>
                            <button class="btn btn-info" id="mark_all_comment_notifications">Đánh dấu đã đọc hết</button>
                        </div>
                        <div class="dropdown-body">
                            
                            <div class="nk-notification">
                                @foreach ($comment_notifications as  $comment_notification)
                                    @if($comment_notification->status == 1)
                                    <div class="nk-notification-item comment-notifications dropdown-inner" data-id="{{ $comment_notification->id }}" style="cursor: pointer;">
                                        <div class="nk-notification-icon">      
                                            @if($comment_notification->type_id == 1)
                                                <em class="icon icon-circle bg-success-dim ni ni-comments"></em>        
                                            @endif                   
                                            @if($comment_notification->type_id == 2)
                                                <em class="icon icon-circle bg-primary-dim ni ni-reply-all"></em>                           
                                            @endif
                                            @if($comment_notification->type_id == 3)
                                                <em class="icon icon-circle bg-warning-dim ni ni-policy-fill"></em>                           
                                            @endif
                                            @if($comment_notification->type_id == 4 || $comment_notification->type_id == 5)
                                            <em class="icon icon-circle bg-danger-dim ni ni-na"></em>                           
                                            @endif
                                            @if($comment_notification->type_id == 6 || $comment_notification->type_id == 7)
                                            <em class="icon icon-circle bg-success-dim ni ni-check"></em>                           
                                            @endif
                                            @if($comment_notification->type_id == 8 || $comment_notification->type_id == 9)
                                            <em class="icon icon-circle bg-danger-dim ni ni-lock"></em>                           
                                            @endif
                                            @if($comment_notification->type_id == 10 || $comment_notification->type_id == 11)
                                            <em class="icon icon-circle bg-success-dim ni ni-unlock"></em>                           
                                            @endif
                                        </div>
                                        <div class="nk-notification-content">
                                            <div class="nk-notification-text">
                                                @if($comment_notification->type_id == 1)
                                                    <strong>{{ $comment_notification->senders->profile->displayName }}</strong>

                                                    vừa bình luận về
                                                    @switch($comment_notification->identifier->type_id)
                                                        @case(1)
                                                            tài liệu
                                                            <strong>
                                                                {{ $comment_notification->identifier->identifier->name }}
                                                            </strong>
                                                            @break
                                                        @case(2)                                                   
                                                            sách
                                                            <strong>
                                                                {{ $comment_notification->identifier->identifier->name }}
                                                            </strong>
                                                            @break

                                                        @case(3)
                                                            bài viết
                                                            <strong>
                                                                {{ $comment_notification->identifier->identifier->topic }}
                                                            </strong>
                                                            @break
                                                        @default 
                                                            Lỗi thông báo
                                                    @endswitch
                                                    của bạn
                                                @endif
                                                @if($comment_notification->type_id == 2)
                                                    <strong>{{ $comment_notification->senders->profile->displayName }}</strong>

                                                    vừa phản hồi bình luận của bạn về
                                                    @switch($comment_notification->identifier->comments->type_id)
                                                        @case(1)
                                                            tài liệu
                                                            <strong>
                                                                {{ $comment_notification->identifier->comments->identifier->name }}
                                                            </strong>
                                                            @break
                                                        @case(2)                                                   
                                                            sách
                                                            <strong>
                                                                {{ $comment_notification->identifier->comments->identifier->name }}
                                                            </strong>
                                                            @break

                                                        @case(3)
                                                            bài viết
                                                            <strong>
                                                                {{ $comment_notification->identifier->comments->identifier->topic }}
                                                            </strong>
                                                            @break
                                                        @default   
                                                            Lỗi thông báo
                                                    @endswitch                                      
                                                @endif
                                                @if($comment_notification->type_id == 3)
                                                    Quản trị viên vừa đăng thông báo mới 
                                                    <strong>
                                                        {{ $comment_notification->identifier->topic}}
                                                    </strong>
                                                @endif
                                                @if($comment_notification->type_id == 4)
                                                    Quản trị viên vừa từ chối sách duyệt sách
                                                    <strong>
                                                        {{ $comment_notification->identifier->name}}
                                                    </strong>
                                                    của bạn
                                                @endif
                                                @if($comment_notification->type_id == 5)
                                                    Quản trị viên vừa từ chối duyệt tài liệu
                                                    <strong>
                                                        {{ $comment_notification->identifier->name}}
                                                    </strong>
                                                @endif
                                                @if($comment_notification->type_id == 6)
                                                    Quản trị viên vừa duyệt sách
                                                    <strong>
                                                        {{ $comment_notification->identifier->name}}
                                                    </strong>
                                                @endif
                                                @if($comment_notification->type_id == 7)
                                                    Quản trị viên vừa duyệt tài liệu
                                                    <strong>
                                                        {{ $comment_notification->identifier->name}}
                                                    </strong>
                                                    của bạn

                                                @endif
                                                @if($comment_notification->type_id == 8)
                                                    Quản trị viên vừa khóa sách
                                                    <strong>
                                                        {{ $comment_notification->identifier->name}}
                                                    </strong>
                                                    của bạn
                                                @endif
                                                @if($comment_notification->type_id == 9)
                                                    Quản trị viên vừa khóa tài liệu
                                                    <strong>
                                                        {{ $comment_notification->identifier->name}}
                                                    </strong>
                                                    của bạn
                                                @endif
                                                @if($comment_notification->type_id == 10)
                                                    Quản trị viên vừa mở khóa sách
                                                    <strong>
                                                        {{ $comment_notification->identifier->name}}
                                                    </strong>
                                                    của bạn
                                                @endif
                                                @if($comment_notification->type_id == 11)
                                                    Quản trị viên vừa mở khóa tài liệu
                                                    <strong>
                                                        {{ $comment_notification->identifier->name}}
                                                    </strong>
                                                    của bạn
                                                @endif
                                            </div>  
                                            <div class="nk-notification-time">
                                                <span class="text-primary">{{ $comment_notification->time }}
                                                </span>
                                            </div>  
                                        </div>
                                    </div>
                                    @else
                                    <div class="nk-notification-item comment-notifications dropdown-inner" data-id="{{ $comment_notification->id }}" style="cursor: pointer;color:brown">
                                        <div class="nk-notification-icon">      
                                            @if($comment_notification->type_id == 1)
                                                <em class="icon icon-circle bg-success-dim ni ni-comments"></em>        
                                            @endif                   
                                            @if($comment_notification->type_id == 2)
                                                <em class="icon icon-circle bg-primary-dim ni ni-reply-all"></em>                           
                                            @endif
                                            @if($comment_notification->type_id == 3)
                                                <em class="icon icon-circle bg-warning-dim ni ni-policy-fill"></em>                           
                                            @endif
                                            @if($comment_notification->type_id == 4 || $comment_notification->type_id == 5)
                                            <em class="icon icon-circle bg-danger-dim ni ni-na"></em>                           
                                            @endif
                                            @if($comment_notification->type_id == 6 || $comment_notification->type_id == 7)
                                            <em class="icon icon-circle bg-success-dim ni ni-check"></em>                           
                                            @endif
                                            @if($comment_notification->type_id == 8 || $comment_notification->type_id == 9)
                                            <em class="icon icon-circle bg-danger-dim ni ni-lock"></em>                           
                                            @endif
                                            @if($comment_notification->type_id == 10 || $comment_notification->type_id == 11)
                                            <em class="icon icon-circle bg-success-dim ni ni-unlock"></em>                           
                                            @endif
                                        </div>
                                        <div class="nk-notification-content">
                                            <div class="nk-notification-text">
                                                <span class="text-muted">
                                                    @if($comment_notification->type_id == 1)
                                                        <strong>{{ $comment_notification->senders->profile->displayName }}</strong>

                                                        vừa bình luận về
                                                        @switch($comment_notification->identifier->type_id)
                                                            @case(1)
                                                                tài liệu
                                                                <strong>
                                                                    {{ $comment_notification->identifier->identifier->name }}
                                                                </strong>
                                                                @break
                                                            @case(2)                                                   
                                                                sách
                                                                <strong>
                                                                    {{ $comment_notification->identifier->identifier->name }}
                                                                </strong>
                                                                @break

                                                            @case(3)
                                                                bài viết
                                                                <strong>
                                                                    {{ $comment_notification->identifier->identifier->topic }}
                                                                </strong>
                                                                @break
                                                            @default 
                                                                Lỗi thông báo
                                                        @endswitch
                                                        của bạn
                                                    @endif
                                                    @if($comment_notification->type_id == 2)
                                                        <strong>{{ $comment_notification->senders->profile->displayName }}</strong>

                                                        vừa phản hồi bình luận của bạn về
                                                        @switch($comment_notification->identifier->comments->type_id)
                                                            @case(1)
                                                                tài liệu
                                                                <strong>
                                                                    {{ $comment_notification->identifier->comments->identifier->name }}
                                                                </strong>
                                                                @break
                                                            @case(2)                                                   
                                                                sách
                                                                <strong>
                                                                    {{ $comment_notification->identifier->comments->identifier->name }}
                                                                </strong>
                                                                @break

                                                            @case(3)
                                                                bài viết
                                                                <strong>
                                                                    {{ $comment_notification->identifier->comments->identifier->topic }}
                                                                </strong>
                                                                @break
                                                            @default   
                                                                Lỗi thông báo
                                                        @endswitch                                      
                                                    @endif
                                                    @if($comment_notification->type_id == 3)
                                                        Quản trị viên vừa đăng thông báo mới 
                                                        <strong>
                                                            {{ $comment_notification->identifier->topic}}
                                                        </strong>
                                                    @endif
                                                    @if($comment_notification->type_id == 4)
                                                        Quản trị viên vừa từ chối sách duyệt sách
                                                        <strong>
                                                            {{ $comment_notification->identifier->name}}
                                                        </strong>
                                                        của bạn
                                                    @endif
                                                    @if($comment_notification->type_id == 5)
                                                        Quản trị viên vừa từ chối duyệt tài liệu
                                                        <strong>
                                                            {{ $comment_notification->identifier->name}}
                                                        </strong>
                                                    @endif
                                                    @if($comment_notification->type_id == 6)
                                                        Quản trị viên vừa duyệt sách
                                                        <strong>
                                                            {{ $comment_notification->identifier->name}}
                                                        </strong>
                                                    @endif
                                                    @if($comment_notification->type_id == 7)
                                                        Quản trị viên vừa duyệt tài liệu
                                                        <strong>
                                                            {{ $comment_notification->identifier->name}}
                                                        </strong>
                                                        của bạn

                                                    @endif
                                                    @if($comment_notification->type_id == 8)
                                                        Quản trị viên vừa khóa sách
                                                        <strong>
                                                            {{ $comment_notification->identifier->name}}
                                                        </strong>
                                                        của bạn
                                                    @endif
                                                    @if($comment_notification->type_id == 9)
                                                        Quản trị viên vừa khóa tài liệu
                                                        <strong>
                                                            {{ $comment_notification->identifier->name}}
                                                        </strong>
                                                        của bạn
                                                    @endif
                                                    @if($comment_notification->type_id == 10)
                                                        Quản trị viên vừa mở khóa sách
                                                        <strong>
                                                            {{ $comment_notification->identifier->name}}
                                                        </strong>
                                                        của bạn
                                                    @endif
                                                    @if($comment_notification->type_id == 11)
                                                        Quản trị viên vừa mở khóa tài liệu
                                                        <strong>
                                                            {{ $comment_notification->identifier->name}}
                                                        </strong>
                                                        của bạn
                                                    @endif
                                                </span>
                                            </div>  
                                            <div class="nk-notification-time">
                                                {{ $comment_notification->time }}
                                            </div>  
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            
                              
                            </div><!-- .nk-notification -->
                        </div><!-- .nk-dropdown-body -->
                       
                    </div>
                </li><!-- .dropdown -->

                <li class="dropdown user-dropdown">
                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                        <div class="user-toggle">
                            <div class="user-avatar sm">
                                <img src={{ Auth::user()->profile->url }} alt="..."  id="previewImage"/>
                            </div>
                            <div class="user-info d-none d-md-block">
                                <div class="user-status">Thành viên</div>
                                <div class="user-name dropdown-indicator">{{Auth::user()->name}}</div>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1">
                        <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                            <div class="user-card">
                                <div class="user-avatar">
                                    <img src={{ Auth::user()->profile->url }} alt="..."  id="previewImage"/>
                                </div>
                                <div class="user-info">
                                    <span class="lead-text">{{Auth::user()->name}}</span>
                                    <span class="sub-text">{{Auth::user()->email}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-inner">
                            <ul class="link-list">
                                <li><a href="/trang-ca-nhan"><em class="icon ni ni-user-alt"></em><span>Trang cá nhân</span></a></li>
                                <li>
                                    @if(Auth::user()->role == 1)
                                    <a href="/admin/dashboard"><em class="icon ni ni-activity-alt"></em><span>Trang quản lý</span></a>
                                    @else
                                    <a href="/quan-ly"><em class="icon ni ni-activity-alt"></em><span>Trang quản lý</span></a>
                                    @endif
                                </li>
                                <li><a href="/them-tai-lieu"><em class="icon ni ni-plus"></em><span>Đăng tài liệu</span></a></li>
                                <li><a href="/trang-theo-doi"><em class="icon ni ni-bookmark"></em><span>Sách theo dõi</span></a></li>
                                {{-- <li><a class="dark-switch" href="#"><em class="icon ni ni-moon"></em><span>Chế độ ban đêm</span></a></li> --}}
                            </ul>
                        </div>
                        <div class="dropdown-inner">
                            <ul class="link-list">
                                <li>
                                <a href="/logout"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    <em class="icon ni ni-signout"></em><span>Đăng xuất</span>
                                </a>

                                <form id="logout-form" action="/logout" method="POST" class="d-none">
                                    @csrf
                                </form>
                                
                                </li>
                            </ul>
                        </div>
                    </div>
                </li><!-- .dropdown -->
                @else
                    <li>
                        <a href="{{route('login')}}" class="btn btn-outline-primary">Đăng nhập</a>
                    </li>
                @endif

            </ul><!-- .nk-quick-nav -->
        </div><!-- .nk-header-tools -->
      </div><!-- .nk-header-wrap -->
  </div><!-- .container-fliud -->

