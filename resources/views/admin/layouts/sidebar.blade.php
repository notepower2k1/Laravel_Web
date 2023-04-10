{{-- <header>


  <nav class="navbar navbar-light bg-light">
       

    <div class="container-fluid">
        <a href="/"> <img src="{{ asset('storage/logo.png') }}" alt="Groover Brand Logo" class="app-brand-logo"></a>
      <div class="d-flex">

        
        @if(request()->is('/'))
         <a href="./book/create" class="btn btn-danger fas fa-upload"> Đăng sách </a>       
         @else
        <div></div>
        @endif
    
      </div>
    </div>
  </nav>
    
       
         
      
   

   
</header>    --}}
<div class="nk-sidebar-element nk-sidebar-head">
    <div class="nk-menu-trigger">
        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
        <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
    </div>
  
  </div><!-- .nk-sidebar-element -->
  <div class="nk-sidebar-element nk-sidebar-body">
    <div class="nk-sidebar-content">
        <div class="nk-sidebar-menu" data-simplebar>
            <ul class="nk-menu">
                <li class="nk-menu-item {{ Request::is('/admin/dashboard') ? 'active' : '' }}">
                    <a href="/admin/dashboard" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                        <span class="nk-menu-text">Dashboard</span>
                    </a>
                </li><!-- .nk-menu-item -->
                
                <li class="nk-menu-heading">
                    <h6 class="overline-title text-primary-alt">Tài nguyên</h6>
                </li><!-- .nk-menu-heading -->

                <li class="nk-menu-item {{ Request::is('/admin/wait-verification') ? 'active' : '' }}">
                    <a href="/admin/wait-verification" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-clipboad-check"></em></span>
                        <span class="nk-menu-text">Danh sách phê duyệt</span>
                    </a>
                </li><!-- .nk-menu-item -->
                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-book-fill"></em></span>
                        <span class="nk-menu-text">Sách</span>
                    </a>
                    <ul class="nk-menu-sub">               
                        <li class="nk-menu-item {{ Request::is('/admin/book') ? 'active' : '' }}">
                            <a href="{{route('book.index')}}" class="nk-menu-link"><span class="nk-menu-text">Dữ liệu</span></a>
                        </li>
                        <li class="nk-menu-item {{ Request::is('/admin/statistics/book/*') ? 'active' : '' }}">
                            <a href="/admin/statistics/book/{{ \Carbon\Carbon::now()->year }}" class="nk-menu-link"><span class="nk-menu-text">Thống kê</span></a>
                        </li>
                    </ul><!-- .nk-menu-sub -->
                </li><!-- .nk-menu-item -->

                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-book-read"></em></span>
                        <span class="nk-menu-text">Chương</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item {{ Request::is('/admin/chapter/*') ? 'active' : '' }}">
                            <a href="/admin/chapter" class="nk-menu-link"><span class="nk-menu-text">Dữ liệu</span></a>
                        </li>
                        <li class="nk-menu-item {{ Request::is('/admin/statistics/chapter/*') }}">
                            <a href="/admin/statistics/chapter/{{ \Carbon\Carbon::now()->year }}" class="nk-menu-link"><span class="nk-menu-text">Thống kê</span></a>
                        </li>
                    </ul><!-- .nk-menu-sub -->
                </li><!-- .nk-menu-item -->

                <li class="nk-menu-item has-sub">
                  <a href="#" class="nk-menu-link nk-menu-toggle">
                      <span class="nk-menu-icon"><em class="icon ni ni-file-text"></em></span>
                      <span class="nk-menu-text">Tài liệu</span>
                  </a>
                  <ul class="nk-menu-sub">
                      <li class="nk-menu-item {{ Request::is('/admin/document/*') ? 'active' : '' }}">
                          <a href="{{route('document.index')}}" class="nk-menu-link"><span class="nk-menu-text">Dữ liệu</span></a>
                      </li>
                      <li class="nk-menu-item {{ Request::is('/admin/statistics/document/*') ? 'active' : '' }}">
                        <a href="/admin/statistics/document/{{ \Carbon\Carbon::now()->year }}" class="nk-menu-link"><span class="nk-menu-text">Thống kê</span></a>
                      </li>
                  </ul><!-- .nk-menu-sub -->
              </li><!-- .nk-menu-item -->
              <li class="nk-menu-item has-sub">
                <a href="#" class="nk-menu-link nk-menu-toggle">
                    <span class="nk-menu-icon"><em class="icon ni ni-msg-fill"></em></span>
                    <span class="nk-menu-text">Diễn đàn</span>
                </a>
                <ul class="nk-menu-sub">
                    <li class="nk-menu-item {{ Request::is('/admin/forum/*') ? 'active' : '' }}">
                        <a href="{{route('forum.index')}}" class="nk-menu-link"><span class="nk-menu-text">Dữ liệu</span></a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="#" class="nk-menu-link"><span class="nk-menu-text">Thống kê</span></a>
                    </li>
                </ul><!-- .nk-menu-sub -->
            </li><!-- .nk-menu-item -->
            <li class="nk-menu-item has-sub">
              <a href="#" class="nk-menu-link nk-menu-toggle">
                  <span class="nk-menu-icon"><em class="icon ni ni-list-fill"></em></span>
                  <span class="nk-menu-text">Bài đăng</span>
              </a>
              <ul class="nk-menu-sub">
                  <li class="nk-menu-item  {{ Request::is('/admin/post/*') ? 'active' : '' }}">
                      <a href="/admin/post" class="nk-menu-link"><span class="nk-menu-text">Dữ liệu</span></a>
                  </li>
                  <li class="nk-menu-item {{ Request::is('/admin/statistics/post/*') ? 'active' : '' }}">
                      <a href="/admin/statistics/post/{{ \Carbon\Carbon::now()->year }}" class="nk-menu-link"><span class="nk-menu-text">Thống kê</span></a>
                  </li>
              </ul><!-- .nk-menu-sub -->
          </li><!-- .nk-menu-item -->

            <li class="nk-menu-heading">
            <h6 class="overline-title text-primary-alt">Người dùng</h6>
            </li><!-- .nk-menu-heading -->
                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                        <span class="nk-menu-text">Người dùng</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item {{ Request::is('/admin/user/*') ? 'active' : '' }}">
                            <a href="/admin/user" class="nk-menu-link"><span class="nk-menu-text">Dữ liệu</span></a>
                        </li>
                        <li class="nk-menu-item {{ Request::is('/admin/statistics/user/*') }}">
                            <a href="/admin/statistics/user/{{ \Carbon\Carbon::now()->year }}" class="nk-menu-link"><span class="nk-menu-text">Thống kê</span></a>
                        </li>
                    </ul><!-- .nk-menu-sub -->
                </li><!-- .nk-menu-item -->
                <li class="nk-menu-item  has-sub">
                    <a href="/admin/report" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-alert"></em></span>
                        <span class="nk-menu-text">Báo cáo</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item {{ Request::is('/admin/report/*') ? 'active' : '' }}">
                            <a href="/admin/report" class="nk-menu-link"><span class="nk-menu-text">Dữ liệu</span></a>
                        </li>
                        <li class="nk-menu-item {{ Request::is('/admin/statistics/report/*') }}">
                            <a href="/admin/statistics/report/{{ \Carbon\Carbon::now()->year }}" class="nk-menu-link"><span class="nk-menu-text">Thống kê</span></a>
                        </li>
                    </ul><!-- .nk-menu-sub -->
                </li><!-- .nk-menu-item -->
                
            </ul><!-- .nk-menu -->
        </div><!-- .nk-sidebar-menu -->
    </div><!-- .nk-sidebar-content -->
  </div><!-- .nk-sidebar-element -->