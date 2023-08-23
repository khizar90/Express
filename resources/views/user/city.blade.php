@extends('layouts.base')
@section('title', 'Cities')
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
                                            All Cities
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
                                            <input type="text" class="form-control" placeholder="Search.." value=""
                                                id="searchInput" aria-controls="DataTables_Table_0">
                                            <span class="input-group-text" style="display: none" id="loader"><i
                                                    class="ti ti-rotate-clockwise-2"></i></span>
                                        </label>
                                    </div>
                                    <div class="dt-buttons btn-group flex-wrap">
                                        <button class="btn btn-secondary add-new btn-primary mx-3" tabindex="0"
                                            aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal"
                                            data-bs-target="#addNewBus"><span><i
                                                    class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                    class="d-none d-sm-inline-block">Add Bus City</span></span></button>
                                    </div>
                                </div>
                            </div>

                        </div>



                        <table class="table border-top dataTable" id="usersTable">
                            <thead class="table-light">
                                <tr>

                                    <th>City Name</th>

                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody id="searchResults">
                                @foreach ($cities as $city)
                                    <tr class="odd">



                                        <td class="">{{ $city->name }}</td>

                                        <td class="" style="">
                                            <div class="d-flex align-items-center">
                                                <a href="" data-bs-toggle="modal"
                                                    data-bs-target="#editBus{{ $city->id }}"
                                                    class="text-body delete-record"><i class="ti ti-edit"></i></a>

                                                <a data-bs-toggle="modal" data-bs-target="#deleteModal{{ $city->id }}"
                                                    class="text-body delete-record">
                                                    <i class="ti ti-trash x`ti-sm mx-2"></i>
                                                </a>


                                            </div>


                                            <div class="modal fade" data-bs-backdrop='static' id="deleteModal{{ $city->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                                    <div class="modal-content deleteModal verifymodal">
                                                        <div class="modal-header">
                                                            <div class="modal-title" id="modalCenterTitle">Are you sure you
                                                                want to delete
                                                                bus city?
                                                            </div>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="body">After deleting this bus city you cannot use
                                                                this bus city</div>
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
                                                                        href="{{ route('dashboard-delete-city', $city->id) }}">Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" data-bs-backdrop='static' id="editBus{{ $city->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalCenterTitle">Edit City</h5>

                                                        </div>

                                                        <form action="{{ route('dashboard-edit-city', $city->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col mb-3">
                                                                        <label for="nameWithTitle" class="form-label">City
                                                                            Name</label>
                                                                        <input type="text" id="nameWithTitle"
                                                                            name="name" value="{{ $city->name }}"
                                                                            class="form-control" placeholder="Add Bus"
                                                                            required />
                                                                        <span class="text-danger mt-1">
                                                                            @error('name')
                                                                                {{ $message }}
                                                                            @enderror
                                                                        </span>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-label-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    Close
                                                                </button>
                                                                <button type="submit" class="btn btn-primary">Edit
                                                                    City</button>
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

                                    <form action="{{ route('dashboard-add-city') }}" id="addBusForm" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col">
                                                    <label for="nameWithTitle" class="form-label">City Name</label>
                                                    <input type="text" id="nameWithTitle" name="name"
                                                        class="form-control" placeholder="City Name" required />
                                                    <span class="text-danger mt-1">
                                                        @error('name')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-label-secondary"
                                                data-bs-dismiss="modal" id="closeButton">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-primary">Add Bus City</button>
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

                    $.ajax({
                        url: '{{ route('dashboard-cities') }}', // Replace with your controller route
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

                });
            });
            $(document).ready(function() {
                $('#closeButton').on('click', function(e) {
                    $('#addBusForm')[0].reset();

                });

            });
        </script>
    @endsection
