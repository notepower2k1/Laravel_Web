<div id="navbar-background" class="d-flex flex-column justify-content-end">
    <div id="navbar-content" class="p-2">
        <div class="container-lg wide-xl">
            <div class="nk-header-wrap">      
                    <div class="nk-menu-trigger me-sm-2 d-lg-none">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-menu"></em></a>
                    </div>
                    <div class="nk-header-brand">
                        <a href="/dien-dan" class="logo-link">
                            <img class="logo-light logo-img" src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/forum_logo_white.png" alt="logo">
                            <img class="logo-dark logo-img" src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/forum_logo_white.png" alt="logo-dark">
                        </a>
                    </div>
                <div class="nk-header-menu ms-auto" data-content="headerNav">    
                    <div class="nk-header-mobile">
                        <div class="nk-header-brand">
                            <a href="/dien-dan" class="logo-link">
                                <img class="logo-light logo-img" src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/forum_logo.png" alt="logo">
                                <img class="logo-dark logo-img" src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/forum_logo.png" alt="logo-dark">
                            </a>
                        </div>
                        <div class="nk-menu-trigger me-n2">
                            <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-arrow-left"></em></a>
                        </div>
                    </div>            
                    <ul class="nk-menu nk-menu-main">             
                         
                        
                        <li>                                                
                            <div class="form-control-wrap" id="search-topic-form">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg" placeholder="Chủ đề bài đăng...." style="background-color:black;color:white">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-dark btn-dim" id="search-topic-btn">
                                            <span class="nk-menu-text">
                                                <em class="icon ni ni-search"></em>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>                          
                        </li>
                    </ul><!-- .nk-menu -->
                </div><!-- .nk-header-menu -->
                <div class="nk-header-tools">
                    <ul class="nk-quick-nav">  
                             
                        @if(Auth::check())
                        <li class="dropdown user-dropdown">
                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                <div class="user-toggle">
                                    <div class="user-avatar sm">
                                        <img src={{ Auth::user()->profile->url }} alt="..."  id="previewImage"/>
                                    </div>
                                    <div class="user-info d-none d-md-block">
                                        <div class="user-status">Thành viên</div>
                                        <div class="user-name dropdown-indicator  text-white">{{Auth::user()->name}}</div>
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
                                        <li>
                                            @if(Auth::user()->role == 1)
                                            <a href="/admin/dashboard"><em class="icon ni ni-activity-alt"></em><span>Trang quản lý</span></a>
                                            @else
                                            <a href="/quan-ly"><em class="icon ni ni-activity-alt"></em><span>Trang quản lý</span></a>
                                            @endif
                                        </li>
                                        <li>
                                            <a href="/"><em class="icon ni ni-book-read"></em>
                                                <span >Đọc sách</span>
                                            </a>                                   
                                        </li>
                                        <li>
                                            <a href="/trang-chatGPT"><em class="icon ni ni-coffee-fill"></em>
                                                <span >Chat GPT (demo)</span>
                                            </a>                                   
                                        </li>
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
                            <li class="dropdown tool-dropdown">
                                <a href="#" class="dropdown-toggle btn btn-outline-light text-white" data-bs-toggle="dropdown">
                                    Chức năng
                                </a>
                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1">                                
                                    <div class="dropdown-inner">
                                        <ul class="link-list">
                                          
                                            <li>
                                                <a href="{{route('login')}}" >
                                                    <em class="icon ni ni-arrow-from-right"></em>
                                                    <span>Đăng nhập</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/"><em class="icon ni ni-book-read"></em>
                                                    <span >Đọc sách</span>
                                                </a>                                         
                                            </li>
                                        </ul>
                                    </div>                           
                                </div>
                            </li><!-- .dropdown -->
                            {{-- <li>
                                <a href="{{route('login')}}" class="btn btn-outline-light text-white">Đăng nhập</a>
                            </li> --}}
                            @endif
                           
                    </ul><!-- .nk-quick-nav -->
                </div><!-- .nk-header-tools -->
              </div><!-- .nk-header-wrap -->
        </div><!-- .container-fliud -->
    </div>
</div>



