
    <div class="nk-fmg-aside" data-content="files-aside" data-toggle-overlay="true" data-toggle-body="true" data-toggle-screen="lg" data-simplebar>
        <div class="nk-fmg-aside-wrap">
            <div class="nk-fmg-aside-top" data-simplebar>
                <ul class="nk-fmg-menu">
                    <li class="{{ request()->is('quan-ly') ? 'active': '' }}">
                        <a class="nk-fmg-menu-item" href="/quan-ly">
                            <em class="icon ni ni-home-alt"></em>
                            <span class="nk-fmg-menu-text">Trang chủ</span>
                        </a>
                    </li>
                    <li class="{{ (request()->is('quan-ly/tai-lieu') || request()->is('quan-ly/them-tai-lieu') || request()->is('quan-ly/cap-nhat-tai-lieu/*') || request()->is('quan-ly/chi-tiet-tai-lieu/*')) ? 'active': '' }}">
                        <a class="nk-fmg-menu-item" href="/quan-ly/tai-lieu">
                            <em class="icon ni ni-file-docs"></em>
                            <span class="nk-fmg-menu-text">Tài liệu đã đăng</span>
                        </a>
                    </li>
                    <li class="{{ (request()->is('quan-ly/sach') || request()->is('quan-ly/them-sach') || request()->is('quan-ly/cap-nhat-sach/*') || request()->is('quan-ly/chi-tiet-sach/*')) ? 'active': '' }}">
                        <a class="nk-fmg-menu-item" href="/quan-ly/sach">
                            <em class="icon ni ni-book"></em>
                            <span class="nk-fmg-menu-text">Sách đã đăng</span>
                        </a>
                    </li>
                    <li class="{{ (request()->is('quan-ly/bai-viet')) ? 'active': '' }}">
                        <a class="nk-fmg-menu-item" href="/quan-ly/bai-viet">
                            <em class="icon ni ni-list-fill"></em>
                            <span class="nk-fmg-menu-text">Lịch sử đăng bài</span>
                        </a>
                    </li>
                    <li class="{{ (request()->is('quan-ly/binh-luan')) ? 'active': '' }}">
                        <a class="nk-fmg-menu-item" href="/quan-ly/binh-luan">
                            <em class="icon ni ni-comments"></em>
                            <span class="nk-fmg-menu-text">Lịch sử bình luận</span>
                        </a>
                    </li>                  
                </ul>
            </div>
            <div class="nk-fmg-aside-bottom">
                <div class="nk-fmg-status">
                    <h6 class="nk-fmg-status-title"><em class="icon ni ni-hard-drive"></em><span>Storage</span></h6>
                    <div class="progress progress-md bg-light">
                        <div class="progress-bar" data-progress="5" style="width: 5%;"></div>
                    </div>
                    <div class="nk-fmg-status-info">12.47 GB of 50 GB used</div>
                    <div class="nk-fmg-status-action">
                        <a href="#" class="link link-primary link-sm">Upgrade Storage</a>
                    </div>
                </div>
                <div class="nk-fmg-switch">
                    {{-- <div class="dropup">
                        <a href="#" data-bs-toggle="dropdown" data-offset="-10, 12" class="dropdown-toggle dropdown-indicator-unfold">
                            <div class="lead-text">Personal</div>
                            <div class="sub-text">Only you</div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <ul class="link-list-opt no-bdr">
                                <li><a href="#"><span>Team Plan</span></a></li>
                                <li><a class="active" href="#"><span>Personal</span></a></li>
                                <li class="divider"></li>
                                <li><a class="link" href="#"><span>Upgrade Plan</span></a></li>
                            </ul>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div><!-- .nk-fmg-aside -->