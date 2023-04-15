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
                {{-- <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-text">Apps</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item">
                            <a href="html/apps-messages.html" class="nk-menu-link"><span class="nk-menu-text">Messages</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="html/apps-inbox.html" class="nk-menu-link"><span class="nk-menu-text">Inbox / Mail</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="html/apps-file-manager.html" class="nk-menu-link"><span class="nk-menu-text">File Manager</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="html/apps-chats.html" class="nk-menu-link"><span class="nk-menu-text">Chats / Messenger</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="html/apps-calendar.html" class="nk-menu-link"><span class="nk-menu-text">Calendar</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="html/apps-kanban.html" class="nk-menu-link"><span class="nk-menu-text">Kanban Board</span></a>
                        </li>
                    </ul><!-- .nk-menu-sub -->
                </li> --}}             
                <li class="nk-menu-item {{ Request::is('/tim-kiem') ? 'active' : '' }}">
                    <a href="/tim-kiem" class="nk-menu-link">
                        <span class="nk-menu-text">
                            <em class="icon ni ni-search"></em>
                            Tìm kiếm               
                        </span>
                       
                    </a>
                </li><!-- .nk-menu-item -->
                <li class="nk-menu-item {{ Request::is('/the-loai') ? 'active' : '' }}">
                    <a href="/the-loai" class="nk-menu-link">
                        
                        <span class="nk-menu-text">
                            <em class="icon ni ni-menu-circled"></em>
                            Thể loại
                        </span>
                    </a>
                </li><!-- .nk-menu-item -->           
                <li class="nk-menu-item {{ Request::is('/the-loai') ? 'active' : '' }}">
                    <a href="/sach/all/sach-hay-nen-doc" class="nk-menu-link">
                        
                        <span class="nk-menu-text">
                            <em class="icon ni ni-star-fill"></em>
                            Khuyên đọc</span>
                    </a>
                </li><!-- .nk-menu-item -->             
                <li class="nk-menu-item {{ Request::is('/tai-lieu/*') ? 'active' : '' }}">
                    <a href="/tai-lieu/all/tai-lieu-hay-nhat" class="nk-menu-link">
                        
                        <span class="nk-menu-text">
                            <em class="icon ni ni-download"></em>
                            Nên tải</span>
                    </a>
                </li><!-- .nk-menu-item -->               
                <li class="nk-menu-item {{ Request::is('/dien-dan') ? 'active' : '' }}">
                    <a href="/dien-dan" class="nk-menu-link">
                        <span class="nk-menu-text">
                            <em class="icon ni ni-question"></em>
                            Diễn đàn</span>
                    </a>
                </li><!-- .nk-menu-item -->
            </ul><!-- .nk-menu -->
        </div><!-- .nk-header-menu -->
        <div class="nk-header-tools">
            <ul class="nk-quick-nav">              
                @if(Auth::check())
                    
                <li class="dropdown notification-dropdown {{ Request::is('sach-theo-doi') ? 'd-none':'' }}" id="bookMark_notifications_box">
                    <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                        @if($bookMark_notifications->isEmpty())
                        <em class="icon ni ni-bookmark"></em>
                        @else
                        <div class="icon-status icon-status-info"><em class="icon ni ni-bookmark"></em></div>
                        @endif  
                    </a>
                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end dropdown-menu-s1">
                        <div class="dropdown-head">
                            <span class="sub-title nk-dropdown-title">Sách theo dõi</span>
                            <button class="btn btn-info" id="mark_all_bookMark_notifications">Đánh dấu đã đọc hết</button>
                        </div>
                        <div class="dropdown-body">
                            <div class="nk-notification">
                                @foreach ($bookMark_notifications as  $bookMark_notification)
                                    <div class="nk-notification-item bookMark-notifications dropdown-inner" data-id="{{ $bookMark_notification->id }}" style="cursor: pointer;">
                                        <div class="nk-notification-icon">
                                            <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                        </div>
                                        <div class="nk-notification-content">
                                            <div class="nk-notification-text">Sách <a href="/sach/{{$bookMark_notification->books->id}}/{{$bookMark_notification->books->slug}}" >{{$bookMark_notification->books->name }}</a> 
                                                có chương mới  
                                                
                                                @foreach ($bookMark_notification->books->chapters as $chapter)
                                                    @if($loop->last)
                                                        <strong>{{ $chapter->code }}</strong>
                                                    @endif
                                                @endforeach

                                                
                                            </div>  
                                        </div>
                                    </div>
                                @endforeach
                            
                               
                            </div><!-- .nk-notification -->
                        </div><!-- .nk-dropdown-body -->
                        <div class="dropdown-foot center">
                            <a href="/sach-theo-doi">Xem tất cả</a>
                        </div>
                    </div>
                </li><!-- .dropdown -->
                
                <li class="dropdown notification-2-dropdown" id="comment_notifications_box">
                    <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                        @if($comment_notifications->isEmpty())
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
                                    <div class="nk-notification-item comment-notifications dropdown-inner" data-id="{{ $comment_notification->id }}" style="cursor: pointer;">
                                        <div class="nk-notification-icon">
                                            @switch($comment_notification->type_id)
                                            @case(1)
                                            <em class="icon icon-circle bg-success-dim ni ni-book"></em>
                                            @break
        
                                            @case(2)
                                            <em class="icon icon-circle bg-secondary-dim ni ni-file-docs"></em>
                                            @break

                                            @case(3)
                                            <em class="icon icon-circle bg-info-dim ni ni-list-fill"></em>
                                            @break

                                            @case(4)
                                            <em class="icon icon-circle bg-success-dim ni ni-reply"></em>
                                            @break

                                            @case(5)
                                            <em class="icon icon-circle bg-secondary-dim ni ni-reply"></em>
                                            @break

                                            @case(5)
                                            <em class="icon icon-circle bg-info-dim ni ni-reply"></em>
                                            @break
                                        @default
                                            Lỗi thông báo
                                        @endswitch
                                        </div>
                                        <div class="nk-notification-content">
                                            <div class="nk-notification-text">
                                                <strong>{{ $comment_notification->senders->profile->displayName }}</strong>
                                                @switch($comment_notification->type_id)
                                                    @case(1)
                                                    vừa bình luận về sách
                                                    <strong>
                                                        {{ $comment_notification->identifier }}
                                                    </strong>
                                                    của bạn
                                                    @break
                
                                                    @case(2)
                                                    vừa bình luận về tài liệu
                                                    <strong>
                                                        {{ $comment_notification->identifier }}
                                                    </strong>
                                                    của bạn

                                                    @break

                                                    @case(3)
                                                    vừa bình luận về bài viết
                                                    <strong>
                                                    {{ $comment_notification->identifier }}
                                                    </strong>
                                                    của bạn
                                                    @break

                                                    @case(4)
                                                    vừa trả lời bình luận của bạn trong sách
                                                    <strong>
                                                    {{ $comment_notification->identifier}}
                                                    </strong>
                                                    @break

                                                    @case(5)
                                                    vừa trả lời bình luận của bạn tài liệu
                                                    <strong>
                                                    {{ $comment_notification->identifier }}
                                                    </strong>
                                                    @break

                                                    @case(5)
                                                    vừa trả lời bình luận của bạn trong bài viết
                                                    <strong>
                                                    {{ $comment_notification->identifier }}
                                                    </strong>
                                                    @break
                                                @default
                                                    Lỗi thông báo
                                                @endswitch
                                            </div>  
                                            <div class="nk-notification-time">
                                                {{ $comment_notification->time }}
                                            </div>  
                                        </div>
                                    </div>
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
                                <li><a href="/sach-theo-doi"><em class="icon ni ni-bookmark"></em><span>Sách theo dõi</span></a></li>
                                {{-- <li><a class="dark-switch" href="#"><em class="icon ni ni-moon"></em><span>Chế độ ban đêm</span></a></li> --}}
                            </ul>
                        </div>
                        <div class="dropdown-inner">
                            <ul class="link-list">
                                <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    <em class="icon ni ni-signout"></em><span>Đăng xuất</span>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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

