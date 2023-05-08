@extends('admin/layouts.app')
@section('pageTitle', 'Danh sách người dùng')

@section('content')
<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between g-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Người dùng / <strong class="text-primary small">{{ $user->username != $user->profile->displayName ? $user->profile->displayName :  $user->username}}</strong></h3>
                        <div class="nk-block-des text-soft">
                            <ul class="list-inline">
                                <li>Người dùng ID: <span class="text-base">{{ $user->id }}</span></li>
                                <li>Lần đăng nhập cuối: <span class="text-base">{{ $user->lastLogin }}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <a  href="{{ url()->previous() }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a>
                        <a  href="{{ url()->previous() }}" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em class="icon ni ni-arrow-left"></em></a>
                    </div>
                </div>
            </div><!-- .nk-block-head -->
            <div class="nk-block">
                <div class="card card-bordered">
                    <div class="card-aside-wrap">
                        <div class="card-content">
                            <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#tabItem1"><em class="icon ni ni-user-circle"></em><span>Cá nhân</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tabItem2" ><em class="icon ni ni-book"></em><span>Sách</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tabItem3" ><em class="icon ni ni-file-text"></em><span>Tài liệu</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tabItem4" ><em class="icon ni ni-bell"></em><span>Bài viết</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tabItem5" ><em class="icon ni ni-activity"></em><span>Hoạt động</span></a>
                                </li>
                                <li class="nav-item nav-item-trigger d-xxl-none">
                                    <a href="#" class="toggle btn btn-icon btn-trigger" data-target="userAside"><em class="icon ni ni-user-list-fill"></em></a>
                                </li>
                            </ul><!-- .nav-tabs -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabItem1">
                                    <div class="card-inner">
                                        <div class="nk-block">
                                            <div class="nk-block-head">
                                                <h5 class="title">Thông tin cá nhân</h5>
                                            </div><!-- .nk-block-head -->
                                            <div class="profile-ud-list">
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Giới tính</span>
                                                        <span class="profile-ud-value">
                                                           
                                                                @switch($user->profile->gender)
                                                                @case(0)
                                                                    Nam
                                                                    @break
                                
                                                                @case(1)
                                                                    Nữ
                                                                    @break
                                
                                                                @default
                                                                    Không công khai
                                                                @endswitch
                                                           
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Tên hiển thị</span>
                                                        <span class="profile-ud-value">{{ $user->profile->displayName }}</span>
                                                    </div>
                                                </div>                                                                            
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Email</span>
                                                        <span class="profile-ud-value">{{ $user->email }}</span>
                                                    </div>
                                                   
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Ngày xác thực</span>
                                                        <span class="profile-ud-value">{{ $user->email_verified_at }}</span>
                                                    </div>
                                                </div>
                                            </div><!-- .profile-ud-list -->
                                        </div><!-- .nk-block -->
                                        <div class="nk-block">
                                            <div class="nk-block-head nk-block-head-line">
                                                <h6 class="title overline-title text-base">Các thông tin khác</h6>
                                            </div><!-- .nk-block-head -->
                                            <div class="profile-ud-list">
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Ngày đăng ký</span>
                                                        <span class="profile-ud-value">{{ $user->created_at }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Đổi mật khẩu</span>
                                                        <span class="profile-ud-value">{{ $user->updated_at }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Cập nhật thông tin</span>
                                                        <span class="profile-ud-value">{{ $user->profile->updated_at }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Tình trạng</span>
                                                        <span class="profile-ud-value">
                                                            @if($user->status == 1)
                                                            <span class="tb-status text-success">Hoạt động</span>      
                                                            @else
                                                            <span class="tb-status text-danger">Đình chỉ</span>      
                                                            @endif    
                                                        </span>
                                                    </div>
                                                </div>
                                               
                                            </div><!-- .profile-ud-list -->
                                        </div><!-- .nk-block -->
                                        <div class="nk-divider divider md"></div>
                                        <div class="nk-block">
                                            <div class="nk-block-head nk-block-head-sm nk-block-between">
                                                <h5 class="title">Admin Note</h5>
                                                <a href="#" class="link link-sm">+ Add Note</a>
                                            </div><!-- .nk-block-head -->
                                            <div class="bq-note">
                                                <div class="bq-note-item">
                                                    <div class="bq-note-text">
                                                        <p>Aproin at metus et dolor tincidunt feugiat eu id quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean sollicitudin non nunc vel pharetra. </p>
                                                    </div>
                                                    <div class="bq-note-meta">
                                                        <span class="bq-note-added">Added on <span class="date">November 18, 2019</span> at <span class="time">5:34 PM</span></span>
                                                        <span class="bq-note-sep sep">|</span>
                                                        <span class="bq-note-by">By <span>Softnio</span></span>
                                                        <a href="#" class="link link-sm link-danger">Delete Note</a>
                                                    </div>
                                                </div><!-- .bq-note-item -->
                                                <div class="bq-note-item">
                                                    <div class="bq-note-text">
                                                        <p>Aproin at metus et dolor tincidunt feugiat eu id quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean sollicitudin non nunc vel pharetra. </p>
                                                    </div>
                                                    <div class="bq-note-meta">
                                                        <span class="bq-note-added">Added on <span class="date">November 18, 2019</span> at <span class="time">5:34 PM</span></span>
                                                        <span class="bq-note-sep sep">|</span>
                                                        <span class="bq-note-by">By <span>Softnio</span></span>
                                                        <a href="#" class="link link-sm link-danger">Delete Note</a>
                                                    </div>
                                                </div><!-- .bq-note-item -->
                                            </div><!-- .bq-note -->
                                        </div><!-- .nk-block -->
                                    </div><!-- .card-inner -->
                                </div>
                                <div class="tab-pane" id="tabItem2">
                                    <div class="card-inner">
                                        <table class="datatable-init nowrap nk-tb-list nk-tb-ulist">
                                            <thead>
                                                <tr class="nk-tb-item nk-tb-head">
                                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ảnh đại diện</span></th>
        
                                                    <th class="nk-tb-col"><span class="sub-text">Tiêu đề</span></th>
                                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Tình trạng</span></th>
                                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Trạng thái</span></th>
                                                    <th class="nk-tb-col tb-col-mb"><span class="sub-text">Tiến độ</span></th>
                                                    <th class="nk-tb-col text-end">
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              @foreach ($books as $book)
        
                                                <tr class="nk-tb-item">
        
                                                    <td class="nk-tb-col tb-col-lg">
                                                      <img class="image-fluid" src={{$book->url}} alt="..." style="width:100px" />
                                                    </td>
                                                    <td class="nk-tb-col">
                                                       
                                                        <a class="text-dark fw-bold" href="/admin/book/detail/{{$book->id}}/{{ \Carbon\Carbon::now()->year }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $book->name }}">{{ Str::limit($book->name,30) }}</a>                                                   
                                                      
                                                    </td>
                                                    <td class="nk-tb-col tb-col-lg">
                                                        @if ($book->status == 1)
                                                        <span class="tb-status text-success">Đã duyệt</span>
                                                        @endif 
                                                        @if ($book->status == 0)
                                                        <span class="tb-status text-primary">Đang duyệt</span>
                                                        @endif 
                                                        @if ($book->status == -1)
                                                        <span class="tb-status text-danger">Từ chối</span>
                                                        @endif 
                                                    </td>   
                                                    <td class="nk-tb-col tb-col-lg">
                                                        @if ($book->isPublic === 1)
                                                            <span class="tb-status text-success">Hiển thị</span>
                                                        @else
                                                            <span class="tb-status text-info">Đang ẩn</span>
            
                                                        @endif 
                                                    </td>                                            
                                                    <td class="nk-tb-col tb-col-mb">
                                                    @if ($book->isCompleted === 1)
                                                      <span class="tb-status text-success">Đã hoàn thành</span>
                                                      @else
                                                      <span class="tb-status text-info">Chưa hoàn thành</span>
        
                                                      @endif 
                                                    </td>
                       
                                                    <td class="nk-tb-col">
                                                        @if($book->deleted_at == null)
                                                            <span class="tb-status text-success">Đang lưu</span>
                                                        @else
                                                            <span class="tb-status text-danger">Đã xóa</span>
                                                        @endif
                                                  </td>
                                                </tr><!-- .nk-tb-item  -->
                                              @endforeach
        
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabItem3">
                                    <div class="card-inner">
                                        <table class="datatable-init nowrap nk-tb-list nk-tb-ulist">
                                            <thead>
                                                <tr class="nk-tb-item nk-tb-head">
                                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Ảnh đại diện</span></th>
        
                                                    <th class="nk-tb-col"><span class="sub-text">Tiêu đề</span></th>
                                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Tình trạng</span></th>
                                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Trạng thái</span></th>
                                                    <th class="nk-tb-col tb-col-mb"><span class="sub-text">Tiến độ</span></th>
                                                    <th class="nk-tb-col text-end">
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              @foreach ($documents as $document)
        
                                                <tr class="nk-tb-item">
        
                                                    <td class="nk-tb-col tb-col-lg">
                                                      <img class="image-fluid" src={{$document->url}} alt="..." style="width:100px" />
                                                    </td>
                                                    <td class="nk-tb-col">
                                                       
                                                        <a class="text-dark fw-bold" href="/admin/document/detail/{{$document->id}}/{{ \Carbon\Carbon::now()->year }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $document->name }}">{{ Str::limit($document->name,30) }}</a>                                                   
                                                         
                                                    </td>
                                                    <td class="nk-tb-col tb-col-lg">
                                                        @if ($document->status == 1)
                                                        <span class="tb-status text-success">Đã duyệt</span>
                                                        @endif 
                                                        @if ($document->status == 0)
                                                        <span class="tb-status text-primary">Đang duyệt</span>
                                                        @endif 
                                                        @if ($document->status == -1)
                                                        <span class="tb-status text-danger">Từ chối</span>
                                                        @endif 
                                                    </td>   
                                                    <td class="nk-tb-col tb-col-lg">
                                                        @if ($document->isPublic === 1)
                                                            <span class="tb-status text-success">Hiển thị</span>
                                                        @else
                                                            <span class="tb-status text-info">Đang ẩn</span>
            
                                                        @endif 
                                                    </td>                                            
                                                    <td class="nk-tb-col tb-col-mb">
                                                    @if ($document->isCompleted === 1)
                                                      <span class="tb-status text-success">Đã hoàn thành</span>
                                                      @else
                                                      <span class="tb-status text-info">Chưa hoàn thành</span>
        
                                                      @endif 
                                                    </td>
                       
                                                    <td class="nk-tb-col">
                                                        @if($document->deleted_at == null)
                                                            <span class="tb-status text-success">Đang lưu</span>
                                                        @else
                                                            <span class="tb-status text-danger">Đã xóa</span>
                                                        @endif
                                                  </td>
                                                </tr><!-- .nk-tb-item  -->
                                              @endforeach
        
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabItem4">
                                    <div class="card-inner">
                                        <table class="datatable-init nowrap nk-tb-list nk-tb-ulist">
                                            <thead>
                                                <tr class="nk-tb-item nk-tb-head">    
                                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Diễn đàn</span></th>    
                                                    <th class="nk-tb-col"><span class="sub-text">Tiêu đề</span></th>                     
                                                    <th class="nk-tb-col nk-tb-col-tools text-end">
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              @foreach ($posts as $post)
        
                                                <tr class="nk-tb-item">
        
                                                    <td class="nk-tb-col tb-col-lg">
                                                        <span>
                                                            {{ $post->forums->name }}
                                                        </span>
                                                    </td>
                                                    <td class="nk-tb-col">           
                                                        <a class="text-dark fw-bold" href="/admin/forum/post/{{$post->id}}/detail" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $post->topic }}">{{ Str::limit($post->topic,30) }}</a>                                                   
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        @if($post->deleted_at == null)
                                                            <span class="tb-status text-success">Đang lưu</span>
                                                        @else
                                                            <span class="tb-status text-danger">Đã xóa</span>
                                                        @endif
                                                  </td>
                                                </tr><!-- .nk-tb-item  -->
                                              @endforeach
        
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tabItem5">
                                    <div class="card-inner">
                                        <table class="datatable-init nowrap nk-tb-list nk-tb-ulist">
                                            <thead>
                                                <tr class="nk-tb-item nk-tb-head">
                                                    <th class="nk-tb-col"><span class="sub-text">Ngày bình luận</span></th>                                    
                                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Bình luận về</span></th>
                                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Số lượt phản hồi</span></th>
                                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Trạng thái</span></th>
                                                    <th class="nk-tb-col text-end">
                                                  </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              @foreach ($comments as $comment)
                                    
                                                <tr class="nk-tb-item" id="row-{{ $comment->id }}">
                                    
                                                    <td class="nk-tb-col">
                                                      <span>{{  $comment->created_at  }}</span>
                                                    </td>                                              
                                                    <td class="nk-tb-col tb-col-lg">
                                                      @switch($comment->type_id)
                                                        @case(1)
                                    
                                                            <a href="/admin/book/detail/{{$comment->identifier_id}}/{{ \Carbon\Carbon::now()->year }}">
                                                                <span class="badge rounded-pill bg-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $comment->identifier->name }}">
                                                                {{ $comment->types->name }}
                                                                </span>
                                                            </a>
                                                         
                                                          @break
                                    
                                                        @case(2)
                                                            <a href="/admin/document/detail/{{$comment->identifier_id}}/{{ \Carbon\Carbon::now()->year }}">
                                                                <span class="badge rounded-pill bg-outline-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $comment->identifier->name }}">{{ $comment->types->name }}</span>
                                                            </a>
                                                          @break
                                    
                                                        @case(3)
                                                            <a href="/admin/forum/post/{{$comment->id}}/detail">
                                                                <span class="badge rounded-pill bg-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $comment->identifier->topic }}">{{  $comment->types->name }}</span>
                                                                @break
                                                            </a>
                                                        @default
                                                          <span class="badge rounded-pill bg-outline-success"></span>
                                                      @endswitch
                                    
                                                    </td>
                                                    <td class="nk-tb-col tb-col-lg">
                                                      <span>{{  $comment->totalReplies  }}</span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-lg">
                                                        @if($comment->deleted_at == null)
                                                            <span class="tb-status text-success">Đang lưu</span>
                                                        @else
                                                            <span class="tb-status text-danger">Đã xóa</span>
                                                        @endif
                                                    </td>
                                                    <td class="nk-tb-col nk-tb-col-tools">
                                                        <ul class="nk-tb-actions gx-1">                       
                                                            <li>
                                                                <div class="drodown">
                                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <ul class="link-list-opt no-bdr">
                                                                           
                                                                            <li>
                                                                              <a href="#" class="content-btn" data-id={{ $comment->id }}>
                                                                                <em class="icon ni ni-notice"></em><span>Nội dung</span>
                                                                              </a>                            
                                                                              <button class="d-none" data-bs-toggle="modal" data-bs-target="#modalContent"></button>
                                                                            </li>

                                                                            <li><a href="/admin/comment/replies/{{ $comment->id }}"><em class="icon ni ni-reply-all"></em><span>Xem phản hồi</span></a></li>
                                                                        
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                      </td>
                                                </tr><!-- .nk-tb-item  -->
                                              @endforeach
                                    
                                            </tbody>
                                          </table>      
                                    </div>
                                </div>
                            </div>
                        </div><!-- .card-content -->
                        <div class="card-aside card-aside-right user-aside toggle-slide toggle-slide-right toggle-break-xxl toggle-screen-xxl" data-content="userAside" data-toggle-screen="xxl" data-toggle-overlay="true" data-toggle-body="true">
                            <div class="card-inner-group" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">
                                <div class="card-inner">
                                    <div class="user-card user-card-s2">
                                        <div class="user-avatar lg bg-primary">
                                            <img src="{{ $user->profile->url }}" alt="">
                                        </div>
                                        <div class="user-info">
                                            <h5>{{ $user->profile->displayName }}</h5>
                                            <span class="sub-text">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </div><!-- .card-inner -->                          
                                <div class="card-inner">
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <div class="profile-stats">
                                                <span class="amount">{{ $books->count() }}</span>
                                                <span class="sub-text">Sách</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="profile-stats">
                                                <span class="amount">{{ $documents->count() }}</span>
                                                <span class="sub-text">Tài liệu</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="profile-stats">
                                                <span class="amount">{{ $posts->count() }}</span>
                                                <span class="sub-text">Bài viết</span>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .card-inner -->
                                <div class="card-inner card-inner-sm">
                                    <ul class="btn-toolbar justify-center gx-1">
                                        <li><a href="#" class="btn btn-trigger btn-icon btn-email" data-bs-toggle="tooltip" data-bs-placement="top" title="Gửi email"><em class="icon ni ni-mail-fill"></em></a></li>
                                        <li><a href="#" class="btn btn-trigger btn-icon btn-suspend" data-value={{ $user->status }} data-bs-toggle="tooltip" data-bs-placement="top" title="Đình chỉ"> <em class="icon ni ni-user-cross-fill"></em></a></li>
                                        <li>
                                            <a href="#" class="btn btn-trigger btn-icon recovery-password-a-tag" data-bs-toggle="tooltip" data-bs-placement="top" title="Đổi mật khẩu"><em class="icon ni ni-edit"></em></a>
                                            <button class="d-none" id="open-modal-btn" data-bs-toggle='modal' data-bs-target='#passwordModalForm'></button></li>

                                        </li>
                                        <li><a href="#" class="btn btn-trigger btn-icon delete-button" data-bs-toggle="tooltip" data-bs-placement="top" title="Xóa người dùng"> <em class="icon ni ni-trash"></em></a></li>

                                    </ul>
                                </div>
                                <div class="card-inner">
                                    <h6 class="overline-title-alt mb-2">Khác</h6>
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <span class="sub-text">Người dùng ID:</span>
                                            <span>{{ $user->id }}</span>
                                        </div>
                                        <div class="col-6">
                                            <span class="sub-text">Đăng nhập:</span>
                                            <span>{{ $user->lastLogin }}</span>
                                        </div>
                                        <div class="col-6">
                                            <span class="sub-text">Tình trạng:</span>
                                            <span class="lead-text">
                                                @if($user->status == 1)
                                                <span class="tb-status text-success">Hoạt động</span>      
                                                @else
                                                <span class="tb-status text-danger">Đình chỉ</span>      
                                                @endif    
                                            </span>
                                        </div>
                                        <div class="col-6">
                                            <span class="sub-text">Đăng ký:</span>
                                            <span>{{ $user->created_at }}</span>
                                        </div>
                                    </div>
                                </div><!-- .card-inner -->
                                
                            </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 866px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 512px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div><!-- .card-inner -->
                        </div><!-- .card-aside -->
                    </div><!-- .card-aside-wrap -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>
@endsection
@section('modal')
<div class="modal fade" id="passwordModalForm" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Khôi phục mật khẩu: </h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form method="POST" class="form-validate is-alter" novalidate="novalidate" id="passwordForm">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="form-label" for="password">Mật khẩu mới</label>
                        <div class="form-control-wrap">
                            <input id="password" type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                    </div>
                </form>
            </div>
          
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="modalContent">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Nội dung</h5>
              <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <em class="icon ni ni-cross"></em>
              </a>
          </div>
          <div class="modal-body">
              
          </div>
      </div>
  </div>
</div>
@endsection
@section('additional-scripts')
<script>
     $('.content-btn').on('click',function(e){
        e.preventDefault();
        var comment_id = $(this).data('id');
        $('#modalContent').find('.modal-body').empty();


        $.ajax({
        type:"GET",
        url:'/admin/comment/getContent/' + comment_id,     
        })
        .done(function(res) {
        // If successful
          const content = res.content;

          $('#modalContent').find('.modal-body').append(content);

          setTimeout(function(){ 
            $(`#row-${comment_id}`).find('.content-btn').next().click();
          },500);

        
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
        // If fail
        console.log(textStatus + ': ' + errorThrown);
        });
    
  });
  $('.btn-suspend').on('click',function(e){
        e.preventDefault();

        var user_id = {!! $user->id !!};
        var status = $(this).data('value');

        var message = (status == 0) ? 'Bạn có chắc muốn mở khóa tài khoản của người dùng này?' : 'Bạn có chắc muốn khóa tài khoản của người dùng này?'
        
        Swal.fire({
        title: `${message}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Muốn',
        cancelButtonText: 'Không'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
            type:"GET",
            url:'/admin/user/update/changeStatus',
            data : {
              "id": user_id,
              "status": status,
            },
            })
            .done(function(res) {
            // If successful
              Swal.fire({
                    icon: 'success',
                    title: `${res.message}`,
                    showConfirmButton: false,
                    timer: 2500
                });

                var contentHTML = '';

                
                if(res.status == 1){
                    contentHTML = '<span class="tb-status text-success">Hoạt động</span>' 
                }
                else if (res.status == 0){
                    contentHTML = '<span class="tb-status text-danger">Đình chỉ</span>' 
                }

                setTimeout(function(){
                    location.reload();
                },2600);

            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
            })
         
        }
      })
   
    });

    $('.recovery-password-a-tag').on('click',function(e){
        e.preventDefault();

        var user_id = {!! $user->id !!};
        
        $('#passwordForm').attr('action', `/admin/user/${user_id}`);



        $('#open-modal-btn').click();

        $('#passwordForm').submit(function() {
            Swal.fire({
                    icon: 'success',
                    title: `Đổi mật khẩu thành công!!!`,
                    showConfirmButton: false,
                    timer: 2000
            });
        });
    })

  

    $('.btn-email').on('click',function(e){
        e.preventDefault();

        var email = @json($user->email);
        var subject = 'Đây là email gửi từ quản trị viên!!!';
        var emailBody = 'Xin chào ' + $(this).data('name');
        window.location = "mailto:"+email+"?subject="+subject+"&body="+emailBody;
        // window.location =  `https://mail.google.com/mail/?view=cm&fs=1&to=${email}&su=${subject}&body=${emailBody}`;
    });
</script>
@endsection
