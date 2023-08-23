@extends('layouts.base')
@section('title', 'Users')
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

                        <div class="row me-2 mt-3">
                            <div class="col-md-2">
                                <div class="me-3">

                                    <div class="dataTables_length" id="DataTables_Table_0_length"><label
                                            style="color: #9E1437; " class="fw-bold">
                                            All Users


                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div
                                    class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">
                                    <div id="DataTables_Table_0_filter" class="dataTables_filter searchinput">
                                        <label class="user_search input-group input-group-merge">
                                                

                                            <input type="text" class="form-control"
                                                placeholder="Search.." value="" id="searchInput" aria-controls="DataTables_Table_0">
                                                <span class="input-group-text" style="display: none" id="loader"><i
                                                    class="ti ti-rotate-clockwise-2"></i></span>
                                        </label>

                                    </div>
                                    <div class="dt-buttons btn-group flex-wrap">
                                        <div class="btn-group">
                                            <button class="btn btn-secondary buttons-collection btn-label-secondary mx-3"
                                                data-bs-toggle="modal" data-bs-target="#modalContainer" type="button">
                                                <span><i class="ti ti-screen-share me-1 ti-xs"></i>Export</span>
                                                <span class="dt-down-arrow"></span>
                                            </button>
                                        </div>
                                        <button class="btn btn-secondary add-new btn-primary" tabindex="0"
                                            aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal"
                                            data-bs-target="#addNewBus"><span><i
                                                    class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                    class="d-none d-sm-inline-block">Add New User</span></span></button>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <table class="table border-top dataTable" id="usersTable">
                            <thead class="table-light">
                                <tr>

                                    <th>Users</th>
                                    <th>Phones</th>

                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody id="searchResults">
                                @foreach ($users as $user)
                                    <tr class="odd">



                                        <td class="">
                                            <div class="d-flex justify-content-start align-items-center user-name">
                                                @if ($user->image)
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar avatar-sm me-3"><img
                                                                src="{{ asset($user->image != '' ? 'profile/' . $user->image : 'user.png') }}"
                                                                alt="Avatar" class="rounded-circle">
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar avatar-sm me-3"><span
                                                                class="avatar-initial rounded-circle bg-label-danger">
                                                                {{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                                        </div>
                                                    </div>
                                                @endif



                                                <div class="d-flex flex-column"><a href=""
                                                        class="text-body text-truncate"><span
                                                            class="fw-semibold user-name-text">{{ $user->name }}</span></a>
                                                            
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $user->phone }}</td>


                                        <td class="" style="">
                                            <div class="d-flex align-items-center">


                                                <a data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}"
                                                    class="text-body delete-record">
                                                    <i class="ti ti-trash x`ti-sm mx-2"></i>
                                                </a>


                                            </div>
                                            <div class="modal fade" data-bs-backdrop='static' id="deleteModal{{ $user->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                                    <div class="modal-content deleteModal verifymodal">
                                                        <div class="modal-header">
                                                            <div class="modal-title" id="modalCenterTitle">Are you
                                                                sure you want to delete
                                                                this account?
                                                            </div>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="body">After delete this account user cannot
                                                                access anything in application</div>
                                                        </div>
                                                        <hr class="hr">

                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="first">
                                                                    <a href="" class="btn"
                                                                        data-bs-dismiss="modal"
                                                                        style="color: #a8aaae ">Cancel</a>
                                                                </div>
                                                                <div class="second">
                                                                    <a class="btn text-center"
                                                                        href="{{ route('dashboard-delete-user', $user->id) }}">Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>



                                        </td>

                                    </tr>
                                @endforeach



                            </tbody>
                        </table>



                    </div>
                </div>
                <!-- Offcanvas to add new user -->
                <div class="modal fade" data-bs-backdrop='static' id="modalContainer" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                        <div class="modal-content verifymodal">
                            <div class="modal-header">
                                <div class="modal-title" id="modalCenterTitle">Are you sure you want to export all users
                                    in CSV formart?</div>

                            </div>
                            <div class="modal-body">
                                <div class="body">All User export when you click on export button
                                </div>
                            </div>

                            <hr class="hr">

                            <div class="container">
                                <div class="row">
                                    <div class="first">
                                        <a href="" class="btn" data-bs-dismiss="modal"
                                            style="color: #a8aaae ">Cancel</a>
                                    </div>
                                    <div class="second">
                                        <a class="btn text-center"
                                            href="{{ route('dashboard-users-export-csv') }}">Export</a>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>

                <div class="modal fade" data-bs-backdrop='static' id="addNewBus" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCenterTitle">Add New User</h5>

                            </div>

                            <form id="addBusForm" action="{{ route('dashboard-add-user') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="nameWithTitle" class="form-label">Name</label>
                                            <input type="text" id="nameWithTitle" name="name" class="form-control"
                                                placeholder="Johan Doe" required />

                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="nameWithTitle" class="form-label">Phone</label>
                                            <input type="text" id="nameWithTitle" name="phone" class="form-control"
                                                placeholder="+92526789337" required />

                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="nameWithTitle" class="form-label">Password</label>
                                            <input type="password" id="nameWithTitle" name="passsword"
                                                class="form-control" placeholder="*********" required />

                                        </div>

                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal" id="closeButton">
                                        Close
                                    </button>
                                    <button type="submit" class="btn btn-primary">Add User</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>







            </div>
        </div>
    @endsection
    @section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#searchInput').keyup(function() {
                var searchValue = $(this).val();
                var loader = $('#loader');
                loader.show();

                // if (searchValue.length) { // Adjust the minimum length as needed
                    $.ajax({
                        url: '{{ route('dashboard-users') }}', // Replace with your controller route
                        method: 'GET',
                        data: {
                            query: searchValue
                        },
                        success: function(data) {
                            console.log(data);
                            $("#searchResults").html(data)
                            
                        },
                        complete: function() {
                            loader.hide(); // Hide the loader after request is complete
                        }
                    });
                // }
            });
        });
        $(document).ready(function() {
                $('#closeButton').on('click', function(e) {
                    $('#addBusForm')[0].reset();

                });

            });
    </script>
  
    @endsection
