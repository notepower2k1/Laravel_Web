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
                <li class="nk-menu-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <a href="/admin/dashboard" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                        <span class="nk-menu-text">Dashboard</span>
                    </a>
                </li><!-- .nk-menu-item -->
                
                <li class="nk-menu-item {{ Request::is('admin/calendar') ? 'active' : '' }}">
                    <a href="/admin/calendar" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-calendar-booking"></em></span>                    
                        <span class="nk-menu-text">Lịch sự kiện</span>
                    </a>
                </li><!-- .nk-menu-item -->

                <li class="nk-menu-heading">
                    <h6 class="overline-title text-primary-alt">Tài nguyên</h6>
                </li><!-- .nk-menu-heading -->

                <li class="nk-menu-item {{ Request::is('admin/wait-verification') ? 'active' : '' }}">
                    <a href="/admin/wait-verification" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-clipboad-check"></em></span>
                        <span class="nk-menu-text">Danh sách phê duyệt</span>
                        {{-- <span class="badge rounded-pill bg-outline-primary">{{ $wait_verified_totals }}</span> --}}
                        <span class="nk-menu-badge">{{ $wait_verified_totals }}</span>
                    </a>
                </li><!-- .nk-menu-item -->
                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-book-fill"></em></span>
                        <span class="nk-menu-text">Sách</span>
                    </a>
                    <ul class="nk-menu-sub">               
                        <li class="nk-menu-item {{ Request::is('admin/book/*') ? 'active' : '' }}">
                            <a href="/admin/book" class="nk-menu-link"><span class="nk-menu-text">Dữ liệu</span></a>
                        </li>
                        <li class="nk-menu-item {{ Request::is('admin/statistics/book/*') ? 'active' : '' }}">
                            <a href="/admin/statistics/book/{{ \Carbon\Carbon::now()->year }}" class="nk-menu-link"><span class="nk-menu-text">Thống kê</span></a>
                        </li>
                        <li class="nk-menu-item {{ Request::is('admin/deleted/book') ? 'active' : '' }}">
                            <a href="/admin/deleted/book" class="nk-menu-link"><span class="nk-menu-text">Dữ liệu đã xóa</span></a>
                        </li>
                    </ul><!-- .nk-menu-sub -->
                </li><!-- .nk-menu-item -->

                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-book-read"></em></span>
                        <span class="nk-menu-text">Chương</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item {{ Request::is('admin/chapter/*') ? 'active' : '' }}">
                            <a href="/admin/chapter" class="nk-menu-link"><span class="nk-menu-text">Dữ liệu</span></a>
                        </li>
                        <li class="nk-menu-item {{ Request::is('admin/statistics/chapter/*') }}">
                            <a href="/admin/statistics/chapter/{{ \Carbon\Carbon::now()->year }}" class="nk-menu-link"><span class="nk-menu-text">Thống kê</span></a>
                        </li>
                        <li class="nk-menu-item {{ Request::is('admin/deleted/chapter') ? 'active' : '' }}">
                            <a href="/admin/deleted/chapter" class="nk-menu-link"><span class="nk-menu-text">Dữ liệu đã xóa</span></a>
                        </li>
                    </ul><!-- .nk-menu-sub -->
                </li><!-- .nk-menu-item -->

                <li class="nk-menu-item has-sub">
                  <a href="#" class="nk-menu-link nk-menu-toggle">
                      <span class="nk-menu-icon"><em class="icon ni ni-file-text"></em></span>
                      <span class="nk-menu-text">Tài liệu</span>
                  </a>
                  <ul class="nk-menu-sub">
                      <li class="nk-menu-item {{ Request::is('admin/document/*') ? 'active' : '' }}">
                          <a href="/admin/document" class="nk-menu-link"><span class="nk-menu-text">Dữ liệu</span></a>
                      </li>
                      <li class="nk-menu-item {{ Request::is('admin/statistics/document/*') ? 'active' : '' }}">
                        <a href="/admin/statistics/document/{{ \Carbon\Carbon::now()->year }}" class="nk-menu-link"><span class="nk-menu-text">Thống kê</span></a>
                      </li>
                      <li class="nk-menu-item {{ Request::is('admin/deleted/document') ? 'active' : '' }}">
                        <a href="/admin/deleted/document" class="nk-menu-link"><span class="nk-menu-text">Dữ liệu đã xóa</span></a>
                    </li>
                  </ul><!-- .nk-menu-sub -->
              </li><!-- .nk-menu-item -->
              <li class="nk-menu-item has-sub">
                <a href="#" class="nk-menu-link nk-menu-toggle">
                    <span class="nk-menu-icon"><em class="icon ni ni-msg-fill"></em></span>
                    <span class="nk-menu-text">Diễn đàn</span>
                </a>
                <ul class="nk-menu-sub">
                    <li class="nk-menu-item {{ Request::is('admin/forum/*') ? 'active' : '' }}">
                        <a href="/admin/forum" class="nk-menu-link"><span class="nk-menu-text">Dữ liệu</span></a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="/admin/statistics/forum/1/{{ \Carbon\Carbon::now()->year }}" class="nk-menu-link"><span class="nk-menu-text">Thống kê</span></a>
                    </li>
                </ul><!-- .nk-menu-sub -->
            </li><!-- .nk-menu-item -->
            <li class="nk-menu-item has-sub">
              <a href="#" class="nk-menu-link nk-menu-toggle">
                  <span class="nk-menu-icon"><em class="icon ni ni-list-fill"></em></span>
                  <span class="nk-menu-text">Bài đăng</span>
              </a>
              <ul class="nk-menu-sub">
                  <li class="nk-menu-item  {{ Request::is('admin/post/*') ? 'active' : '' }}">
                      <a href="/admin/post" class="nk-menu-link"><span class="nk-menu-text">Dữ liệu</span></a>
                  </li>
                  <li class="nk-menu-item {{ Request::is('admin/statistics/post/*') ? 'active' : '' }}">
                      <a href="/admin/statistics/post/1/{{ \Carbon\Carbon::now()->month }}/{{ \Carbon\Carbon::now()->year }}" class="nk-menu-link"><span class="nk-menu-text">Thống kê</span></a>
                  </li>
                  <li class="nk-menu-item {{ Request::is('admin/deleted/post') ? 'active' : '' }}">
                    <a href="/admin/deleted/post" class="nk-menu-link"><span class="nk-menu-text">Dữ liệu đã xóa</span></a>
                </li>
              </ul><!-- .nk-menu-sub -->
          </li><!-- .nk-menu-item -->

            <li class="nk-menu-item has-sub">
                <a href="#" class="nk-menu-link nk-menu-toggle">
                    <span class="nk-menu-icon"><em class="icon ni ni-comments"></em></span>
                    <span class="nk-menu-text">Bình luận</span>
                </a>
                <ul class="nk-menu-sub">
                    <li class="nk-menu-item  {{ Request::is('admin/comment/*') ? 'active' : '' }}">
                        <a href="/admin/comment" class="nk-menu-link"><span class="nk-menu-text">Dữ liệu</span></a>
                    </li>
                    {{-- <li class="nk-menu-item {{ Request::is('admin/statistics/post/*') ? 'active' : '' }}">
                        <a href="/admin/statistics/post/{{ \Carbon\Carbon::now()->year }}" class="nk-menu-link"><span class="nk-menu-text">Thống kê</span></a>
                    </li> --}}
                    <li class="nk-menu-item {{ Request::is('admin/deleted/comment') ? 'active' : '' }}">
                    <a href="/admin/deleted/comment" class="nk-menu-link"><span class="nk-menu-text">Dữ liệu đã xóa</span></a>
                    </li>
                </ul><!-- .nk-menu-sub -->
            </li><!-- .nk-menu-item -->
            <li class="nk-menu-item has-sub">
                <a href="#" class="nk-menu-link nk-menu-toggle">
                    <span class="nk-menu-icon"><em class="icon ni ni-list-fill"></em></span>
                    <span class="nk-menu-text">Thể loại</span>
                </a>
                <ul class="nk-menu-sub">               
                    <li class="nk-menu-item {{ Request::is('admin/categoryDocument') ? 'active' : '' }}">
                        <a href="/admin/categoryDocument" class="nk-menu-link"><span class="nk-menu-text">Thể loại tài liệu</span></a>
                    </li>
                    <li class="nk-menu-item {{ Request::is('admin/categoryBook') ? 'active' : '' }}">
                        <a href="/admin/categoryBook" class="nk-menu-link"><span class="nk-menu-text">Thể loại sách</span></a>
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
                        <li class="nk-menu-item {{ Request::is('admin/user/*') ? 'active' : '' }}">
                            <a href="/admin/user" class="nk-menu-link"><span class="nk-menu-text">Dữ liệu</span></a>
                        </li>
                        <li class="nk-menu-item {{ Request::is('admin/statistics/user/*') }}">
                            <a href="/admin/statistics/user/{{ \Carbon\Carbon::now()->year }}" class="nk-menu-link"><span class="nk-menu-text">Thống kê</span></a>
                        </li>
                    </ul><!-- .nk-menu-sub -->
                </li><!-- .nk-menu-item -->
                <li class="nk-menu-item  has-sub">
                    <a href="/admin/report" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-alert"></em></span>
                        <span class="nk-menu-text">Báo cáo</span>
                        {{-- <span class="badge rounded-pill bg-outline-primary">{{ $report_not_done_totals }}</span> --}}
                        <span class="nk-menu-badge">{{ $report_not_done_totals }}</span>

                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item {{ Request::is('admin/report/*') ? 'active' : '' }}">
                            <a href="/admin/report" class="nk-menu-link"><span class="nk-menu-text">Dữ liệu</span></a>
                        </li>
                        <li class="nk-menu-item {{ Request::is('admin/statistics/report/*') }}">
                            <a href="/admin/statistics/report/{{ \Carbon\Carbon::now()->year }}" class="nk-menu-link"><span class="nk-menu-text">Thống kê</span></a>
                        </li>
                    </ul><!-- .nk-menu-sub -->
                </li><!-- .nk-menu-item -->
                
            </ul><!-- .nk-menu -->
        </div><!-- .nk-sidebar-menu -->
    </div><!-- .nk-sidebar-content -->
  </div><!-- .nk-sidebar-element -->