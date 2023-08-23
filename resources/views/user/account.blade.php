@extends('layouts.base')
@section('title', 'Account')
@section('main', 'Accounts Management')
@section('content')
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">

            <!-- Users List Table -->
            <div class="card">

                <div class="card-datatable table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                {{ session()->get('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session()->has('edit'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                {{ session()->get('edit') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session()->has('delete'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ session()->get('delete') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="row me-2">
                            <div class="col-md-2">
                                <div class="me-3">

                                    <div class="dataTables_length " id="DataTables_Table_0_length"><label
                                            style="color: #9E1437;" class="fw-bold">
                                            Account Details

                                        </label>
                                    </div>
                                </div>
                            </div>

                            <hr>

                        </div>
                        <div class="row m-3">
                            <ul class="nav nav-pills flex-column flex-md-row mb-4">
                                <li class="nav-item">
                                    <a class="nav-link active" href="javascript:void(0);"><i
                                            class="ti-xs ti ti-users me-1"></i>
                                        Account</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard-account-security') }}"><i
                                            class="ti-xs ti ti-lock me-1"></i> Security</a>
                                </li>

                            </ul>
                        </div>


                        <h5 class="card-header">Account Info</h5>

                        <div class="card-body">
                            <form id="" method="POST" action="{{ route('dashboard-account-update') }}">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6 form-password-toggle">
                                        <label class="form-label" for="">Full Name</label>
                                        <div class="input-group input-group-merge">
                                            <input class="form-control" type="text" name="username"
                                                value="{{ auth()->user()->username}}"/>
                                          
                                        </div>
                                        <span class="text-danger mt-1">
                                            @error('username')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                 
                                    <div class="mb-3 col-md-6 form-password-toggle">
                                        <label class="form-label" for="">Email Address</label>
                                        <div class="input-group input-group-merge">
                                            <input class="form-control" type="text" name="email"
                                                value="{{ auth()->user()->email}}"/>
                                          
                                        </div>
                                        <span class="text-danger mt-1">
                                            @error('email')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                        <button type="reset" class="btn btn-label-secondary">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>



                    </div>
                </div>
                <!-- Offcanvas to add new user -->








            </div>
        </div>
    @endsection
