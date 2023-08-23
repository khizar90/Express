@extends('layouts.base')
@section('title', 'Logout')
@section('main', 'Accounts Management')
@section('style')
    <style>
        .card1 {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .inner-card {
            width: 200px;
            min-height: auto !important;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">

            <!-- Users List Table -->
            <div class="card card1">
                <div class="card inner-card">
                    <div class="card-body">
                        <div class="logout text-center">
                            <div class="dt-buttons btn-group flex-wrap mb-3">
                                <button class="btn btn-secondary add-new btn-primary mx-3" tabindex="0"
                                    aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal"><span><i
                                            class="ti ti-power me-0 me-sm-1 ti-xs"></i></span></button>
                            </div>
                            <div class="dataTables_length" id="DataTables_Table_0_length"><label style="color: #9E1437; "
                                    class="fw-bold">
                                    Logout


                                </label>
                            </div>
                        </div>

                        <div class="modal fade" data-bs-backdrop='static' id="deleteModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                <div class="modal-content deleteModal verifymodal">
                                    <div class="modal-header">
                                        <div class="modal-title" id="modalCenterTitle">Are You Sure You Want To Logout
                                            This Account?
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="body">After logout this account you cannot open
                                            panel without login details.</div>
                                    </div>
                                    <hr class="hr">

                                    <div class="container">
                                        <div class="row">
                                            <div class="first">
                                                <a href="" class="btn" data-bs-dismiss="modal"
                                                    style="color: #a8aaae ">Cancel</a>
                                            </div>
                                            <div class="second">
                                                <a class="btn text-center" href="{{ route('dashboard-logout') }}">Logout</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Your card content goes here -->
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script')

    @endsection
