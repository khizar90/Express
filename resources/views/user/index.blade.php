@extends('layouts.base')
@section('title', 'Dashborad')
@section('main', 'Accounts Management')
@section('content')
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <!-- Statistics -->
                <div class="col-lg-12 mb-4 col-md-12">
                    <div class="card card1">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="card-title mb-0 fw-bold" style="color: #9E1437">Statistics</h5>
                        </div>
                        <div class="card-body">
                            <div class="row gy-3">
                                <div class="col-md-4 col-6">
                                    <a href="{{ route('dashboard-view-bus') }}">
                                        <div class="d-flex align-items-center">
                                            <div class="badge bg-label-primary me-3 p-2">
                                                <i class="ti ti-bus"></i>
                                            </div>
                                            <div class="card-info">
                                                <h5 class="mb-0">{{ $buses }}</h5>
                                                <small>buses</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4 col-6">
                                    <a href="{{ route('dashboard-schedules') }}">
                                        <div class="d-flex align-items-center">
                                            <div class="badge  bg-label-info me-3 p-2">
                                                <i class="ti ti-calendar"></i>
                                            </div>
                                            <div class="card-info">
                                                <h5 class="mb-0">{{ $schedules }}</h5>
                                                <small>Schedules</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4 col-6">
                                 <a href="{{ route('dashboard-routes') }}">
                                    <div class="d-flex align-items-center">
                                        <div class="badge  bg-label-danger me-3 p-2">
                                            <i class="ti ti-route"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0">{{ $routes }}</h5>
                                            <small>Routes</small>
                                        </div>
                                    </div>
                                 </a>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
@endsection
