
  <div class="container-fluid">
    
      <div class="nk-header-wrap">
            <div class="nk-header-brand d-none d-xl-block">
                <a href="/" class="logo-link">
                    <img class="logo-light logo-img" src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/logo.png" alt="logo">
                    <img class="logo-dark logo-img" src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/logo.png" alt="logo-dark">
                </a>
            </div><!-- .nk-header-brand -->
           
        
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
                                  <li><a href="/quan-ly"><em class="icon ni ni-setting-alt"></em><span>Trang quản lý</span></a></li>
                                  <li><a href="/them-tai-lieu"><em class="icon ni ni-activity-alt"></em><span>Đăng tài liệu</span></a></li>
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
                            <a href="{{route('login')}}" class="btn btn-primary">Đăng nhập</a>
                        </li>
                    @endif
              </ul><!-- .nk-quick-nav -->
          </div><!-- .nk-header-tools -->
      </div><!-- .nk-header-wrap -->
  </div><!-- .container-fliud -->
