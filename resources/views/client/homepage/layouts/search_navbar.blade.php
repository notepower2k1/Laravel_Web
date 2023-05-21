<div class="modal fade zoom" tabindex="-1" id="modalSearchHomePage">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Khung tìm kiếm</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="">                 
                <div class="form-control-wrap form-control-lg shadow-sm bg-white rounded">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                            <em class="icon ni ni-search"></em></span>
                        </div>
                        <input type="text" name="query" id="search" class="form-control col-sm-8" placeholder="Nhập tên tài liệu điện tử hoặc tác giả!!" aria-label="Search">                 
                        <div class="input-group-append">
                            <button class="btn btn-outline-success btn-dim dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><span id='option_show'>Sách điện tử</span><em class="icon mx-n1 ni ni-chevron-down"></em></button>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <ul class="link-list-opt no-bdr">
                                    <li class="active"><a class="search-option" data-value=1 >Sách điện tử</a></li>
                                    <li><a class="search-option" data-value=2 >Tài liệu tham khảo</a></li>                                                                 
                                </ul>
                            </div>
                        </div>
                    </div>
                    <ul class="link-list-opt" id="renderArea-ul">
                        
                    </ul>
                    
                </div>               
            </div>
            <div class="modal-footer bg-light">
                <a href="/tim-kiem">Đến trang tìm kiếm</a>
            </div>
        </div>
    </div>
</div>