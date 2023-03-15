@extends('admin/layouts.app')
@section('pageTitle', 'Báo cáo xử lý')
@section('content')

      <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                    <a href="/admin/report" class="btn btn-primary">Quay lại</a>    
                            </div>
                        </div>
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false" data-export-title="Export">
                                    <thead>
                                        <tr class="nk-tb-item nk-tb-head">
                                            <th class="nk-tb-col"><span class="sub-text">Ngày báo cáo</span></th>
                                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Loại báo cáo</span></th>
                                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Người báo cáo</span></th>
                                            <th class="nk-tb-col tb-col-md"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($reports as $report)

                                        <tr class="nk-tb-item" id ="row-{{ $report->id }}">

                                            <td class="nk-tb-col">
                                                <div class="user-card">                                           
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ $report->created_at}}</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="nk-tb-col tb-col-md">
                                              <span>{{  $report->types->name }}</span>
                                            </td>
                                            <td class="nk-tb-col tb-col-md">
                                              <span>{{ $report->users->email  }}</span>
                                            </td>                                                                                                                                                                                                                        
                                            <td class="nk-tb-col tb-col-md">
                                                <button class="btn btn-icon ni ni-eye"></button>
                                            </td>
                                        </tr><!-- .nk-tb-item  -->
                                      @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card-preview -->
                    </div> <!-- nk-block -->
@endsection
@section('additional-scripts')
<script src="{{ asset('assets/js/libs/datatable-btns.js?ver=3.1.2') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/js/bootstrap5-toggle.jquery.min.js"></script>
<script src="{{ asset('assets/js/example-sweetalert.js?ver=3.1.2') }}" aria-hidden="true"></script>

@endsection