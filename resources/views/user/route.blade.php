@extends('layouts.base')
@section('title', 'Routes')
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

                                    <div class="dataTables_length" id="DataTables_Table_0_length"><label
                                            style="color: #9E1437; " class="fw-bold">
                                            All Routes
                                            {{-- <select name="entries" id="entries" aria-controls="" class="form-select">
                                                <option value="20" {{ $perPage == 20 ? ' selected' : '' }}>20
                                                </option>
                                                <option value="50" {{ $perPage == 50 ? ' selected' : '' }}>50
                                                </option>
                                                <option value="100" {{ $perPage == 100 ? ' selected' : '' }}>
                                                    100</option>
                                                <option value="500" {{ $perPage == 500 ? ' selected' : '' }}>
                                                    500</option>
                                                <option value="1000" {{ $perPage == 1000 ? ' selected' : '' }}>
                                                    1000</option>
                                                <option value="3000" {{ $perPage == 3000 ? ' selected' : '' }}>
                                                    All</option>
                                            </select> --}}

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
                                        <button class="btn btn-secondary add-new btn-primary mx-3" tabindex="0"
                                            aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal"
                                            data-bs-target="#addNewBus"><span><i
                                                    class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                    class="d-none d-sm-inline-block">Add New Routes</span></span></button>
                                    </div>
                                </div>
                            </div>

                        </div>



                        <table class="table border-top dataTable" id="usersTable">
                            <thead class="table-light">
                                <tr>

                                    <th>Departures</th>

                                    <th>Arrivals</th>
                                    <th>Action</th>


                                </tr>
                            </thead>
                            <tbody id="searchResults">
                                @foreach ($routes as $route)
                                    <tr class="odd">



                                        <td class="">{{ $route->departure }}</td>
                                        <td class="">{{ $route->arival }}</td>

                                        <td class="" style="">
                                            <div class="d-flex align-items-center">
                                                <a href="" data-bs-toggle="modal"
                                                    data-bs-target="#editBus{{ $route->id }}"
                                                    class="text-body delete-record"><i class="ti ti-edit"></i></a>

                                                <a data-bs-toggle="modal" data-bs-target="#deleteModal{{ $route->id }}"
                                                    class="text-body delete-record">
                                                    <i class="ti ti-trash x`ti-sm mx-2"></i>
                                                </a>


                                            </div>


                                            <div class="modal fade" data-bs-backdrop='static' id="deleteModal{{ $route->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                                    <div class="modal-content deleteModal verifymodal">
                                                        <div class="modal-header">
                                                            <div class="modal-title" id="modalCenterTitle">Are you sure you
                                                                want to delete
                                                                this route?
                                                            </div>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="body">After deleting this route you cannot use
                                                                this route</div>
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
                                                                        href="{{ route('dashboard-delete-route', $route->id) }}">Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" data-bs-backdrop='static' id="editBus{{ $route->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalCenterTitle">Edit Route</h5>

                                                        </div>

                                                        <form action="{{ route('dashboard-edit-route', $route->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-12 mb-3">
                                                                        <label for="nameWithTitle"
                                                                            class="form-label">Departure</label>
                                                                        <select name="departure" id="entries"
                                                                            aria-controls="" class="form-select">
                                                                            <option value="" disabled selected>
                                                                                Departure City</option>
                                                                            @foreach ($cities as $city)
                                                                                <option value="{{ $city->name }}"
                                                                                    {{ $route->departure === $city->name ? 'selected' : '' }}>
                                                                                    {{ $city->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="nameWithTitle"
                                                                            class="form-label">Arrival</label>
                                                                        <select name="arrival" id="entries"
                                                                            aria-controls="" class="form-select">
                                                                            <option value="" disabled selected>
                                                                                Arrival City</option>

                                                                            @foreach ($cities as $city)
                                                                                <option value="{{ $city->name }}"
                                                                                    {{ $route->arival === $city->name ? 'selected' : '' }}>
                                                                                    {{ $city->name }}
                                                                                </option>
                                                                            @endforeach

                                                                        </select>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-label-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    Close
                                                                </button>
                                                                <button type="submit" class="btn btn-primary">Add
                                                                    Bus</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach



                            </tbody>
                        </table>

                        <div class="modal fade" data-bs-backdrop='static' id="addNewBus" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalCenterTitle">Add New Bus</h5>

                                    </div>

                                    <form action="{{ route('dashboard-add-route') }}" id="addBusForm" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label for="nameWithTitle" class="form-label">Departure</label>
                                                    <select name="departure" id="entries" aria-controls=""
                                                        class="form-select">
                                                        <option value="" disabled selected>Departure City</option>
                                                        @foreach ($cities as $city)
                                                            <option value="{{ $city->name }}">{{ $city->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="col-12">
                                                    <label for="nameWithTitle" class="form-label">Arrival</label>
                                                    <select name="arrival" id="entries" aria-controls=""
                                                        class="form-select">
                                                        <option value="" disabled selected>Arrival City</option>

                                                        @foreach ($cities as $city)
                                                            <option value="{{ $city->name }}">{{ $city->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>

                                                </div>

                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-label-secondary"
                                                data-bs-dismiss="modal" id="closeButton">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-primary">Add Route</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        {{-- 
                        <div id="paginationContainer">
                            <div class="row mx-2">
                                <div class="col-sm-12 col-md-6">
                                    <div class="dataTables_info" id="DataTables_Table_0_info" role="status"
                                        aria-live="polite">Showing to
                                        of
                                        entries</div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="dataTables_paginate paging_simple_numbers" id="paginationLinks">
                                        @if ($buses->hasPages())

                                            {{ $buses->links() }}
                                        @endif


                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <!-- Offcanvas to add new user -->








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
                        url: '{{ route('dashboard-routes') }}', // Replace with your controller route
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
