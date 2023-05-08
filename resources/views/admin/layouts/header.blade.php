
  <div class="container-fluid">
      <div class="nk-header-wrap">
          <div class="nk-menu-trigger d-xl-none ms-n1">
              <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
          </div>
          <div class="nk-header-news d-none d-xl-block">
                <div class="nk-news-list">
                    <a class="nk-news-item" href="#"  data-bs-toggle="modal" data-bs-target="#modalNote">
                        <div class="nk-news-icon">
                            <em class="icon ni ni-note-add"></em>
                        </div>
                        
                    </a>
                              
                </div>
            
            
          </div><!-- .nk-header-news -->
          <div class="nk-header-tools">
              <ul class="nk-quick-nav">             
                  <li class="dropdown user-dropdown">
                      <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                          <div class="user-toggle">
                              <div class="user-avatar sm">
                                <img src={{ Auth::user()->profile->url }} alt="..."  id="previewImage"/>
                            </div>
                              <div class="user-info d-none d-md-block">
                                  <div class="user-status">Quản trị viên</div>
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
                                  <li><a href="/"><em class="icon ni ni-home"></em><span>Trang chủ</span></a></li>
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

                @if(Request::is('admin/report') || Request::is('admin/report/done'))

                @else
                <li class="dropdown notification-dropdown me-n1">
                    <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">

                    @if($report_notifications->count() > 0)
                        <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em></div>
                    @else
                        <div class=""><em class="icon ni ni-bell"></em></div>
                    @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end dropdown-menu-s1">
                        <div class="dropdown-head">
                            <span class="sub-title nk-dropdown-title">Báo cáo mới</span>
                        </div>
                        <div class="dropdown-body">
                            <div class="nk-notification">

                                @foreach ($report_notifications as $report_notification)
                                <div class="nk-notification-item dropdown-inner">
                                    <div class="nk-notification-icon">
                                        <em class="icon icon-circle bg-danger-dim ni ni-alert"></em>
                                    </div>
                                    <div class="nk-notification-content">
                                        <div class="nk-notification-text">Báo cáo mới về <span>{{ $report_notification->identifier  }}</span></div>
                                        <div class="nk-notification-time">{{ $report_notification->time }}</div>
                                    </div>
                                </div>
                                @endforeach
                            
                                
                            </div><!-- .nk-notification -->
                        </div><!-- .nk-dropdown-body -->
                        <div class="dropdown-foot center">
                            <a href="/admin/report">Xem hết</a>
                        </div>
                    </div>
                </li><!-- .dropdown -->
                @endif
              </ul><!-- .nk-quick-nav -->
          </div><!-- .nk-header-tools -->
      </div><!-- .nk-header-wrap -->
  </div><!-- .container-fliud -->
