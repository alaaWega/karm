@extends('admin_layouts.inc')

@section('title','Admin Dashboard')
@section('header','Admin Dashboard')
@section('head_description','statistics, charts, recent events and reports')
@section('breadcrumb','Dashboard')
@section('content')
                    <!-- BEGIN PAGE BASE CONTENT -->
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                              <a href="javascript:;">
                            <div class="dashboard-stat2 bordered">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-green-sharp">
                                        <span data-counter="counterup" data-value="50"></span>
                                        </h3>
                                        <small>ONLINE VEHICLES</small>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-truck"></i>
                                    </div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span style="width: 50%;" class="progress-bar progress-bar-success green-sharp">
                                            <span class="sr-only">50%</span>
                                        </span>
                                    </div>
                                    <div class="status">
                                        <div class="status-number"> 50% </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                             <a href="javascript:;">
                            <div class="dashboard-stat2 bordered">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-red-haze">
                                        <span data-counter="counterup" data-value="50"></span>
                                        </h3>
                                        <small>OFFLINE VEHICLES</small>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-truck"></i>
                                    </div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span style="width: 50%;" class="progress-bar progress-bar-success green-sharp">
                                            <span class="sr-only">50%</span>
                                        </span>
                                    </div>
                                    <div class="status">
                                        <div class="status-number"> 50% </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                             <a href="javascript:;">
                            <div class="dashboard-stat2 bordered">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-blue-sharp">
                                          <span data-counter="counterup" data-value="50"></span>
                                        </h3>
                                        <small>OUT OF NETWORK VEHICLES</small>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-truck"></i>
                                    </div>
                                </div>
                                 <div class="progress-info">
                                    <div class="progress">
                                        <span style="width: 50%;" class="progress-bar progress-bar-success green-sharp">
                                            <span class="sr-only">50%</span>
                                        </span>
                                    </div>
                                    <div class="status">
                                        <div class="status-number"> 50% </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                             <a href="javascript:;">
                            <div class="dashboard-stat2 bordered">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-purple-soft">
                                            <span data-counter="counterup" data-value="50"></span>
                                        </h3>
                                        <small>DRIVERS</small>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-male"></i>
                                    </div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span style="width: 50%;" class="progress-bar progress-bar-success green-sharp">
                                            <span class="sr-only">50%</span>
                                        </span>
                                    </div>
                                    <div class="status">
                                        <div class="status-number"> 50% </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        </div>

                    <!-- END PAGE BASE CONTENT -->
@endsection