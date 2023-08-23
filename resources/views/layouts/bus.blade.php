@extends('layouts.base')
@section('title', 'Buses')
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
                                            All Buses


                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div
                                    class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">
                                    <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                        <label class="user_search">
                                            <input type="text" class="form-control" id="searchInput"
                                                placeholder="Search.." value="" aria-controls="DataTables_Table_0">
                                        </label>
                                    </div>
                                    <div class="dt-buttons btn-group flex-wrap">
                                        <button class="btn btn-secondary add-new btn-primary mx-3" tabindex="0"
                                            aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal"
                                            data-bs-target="#addNewBus"><span><i
                                                    class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                    class="d-none d-sm-inline-block">Add New Bus</span></span></button>
                                    </div>
                                </div>
                            </div>

                        </div>



                        <table class="table border-top dataTable">
                            <thead class="table-light">
                                <tr>

                                    <th>Bus Name</th>
                                    <th>Bus Number</th>
                                    <th>Total Seat</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody id="searchResults">
                                @foreach ($buses as $bus)
                                    <tr class="odd">



                                        <td class="">{{ $bus->name }}</td>
                                        <td class="">{{ $bus->bus_number }}</td>
                                        <td class="">{{ $bus->seats }}</td>

                                        <td class="" style="">
                                            <div class="d-flex align-items-center">
                                                <a href="" data-bs-toggle="modal"
                                                    data-bs-target="#editBus{{ $bus->id }}"
                                                    class="text-body delete-record"><i class="ti ti-edit"></i></a>

                                                <a data-bs-toggle="modal" data-bs-target="#deleteModal{{ $bus->id }}"
                                                    class="text-body delete-record">
                                                    <i class="ti ti-trash x`ti-sm mx-2"></i>
                                                </a>


                                            </div>


                                            <div class="modal fade" id="deleteModal{{ $bus->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                                    <div class="modal-content deleteModal verifymodal">
                                                        <div class="modal-header">
                                                            <div class="modal-title" id="modalCenterTitle">Are you sure you
                                                                want to delete
                                                                this bus?
                                                            </div>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="body">After deleting this bus you cannot use
                                                                this bus</div>
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
                                                                        href="{{ route('dashboard-delete-bus', $bus->id) }}">Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="editBus{{ $bus->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalCenterTitle">Edit Bus</h5>

                                                        </div>

                                                        <form action="{{ route('dashboard-edit-bus', $bus->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col mb-3">
                                                                        <label for="" class="form-label">Bus
                                                                            Name</label>
                                                                        <input type="text" id="nameWithTitle"
                                                                            name="name" value="{{ $bus->name }}"
                                                                            class="form-control" placeholder="Add Bus"
                                                                            required />
                                                                        <span class="text-danger mt-1">
                                                                            @error('name')
                                                                                {{ $message }}
                                                                            @enderror
                                                                        </span>
                                                                    </div>

                                                                </div>
                                                                <div class="row g-2">
                                                                    <div class="col mb-0">
                                                                        <label for="" class="form-label">Bus
                                                                            Number</label>
                                                                        <input type="text" id=""
                                                                            class="form-control" placeholder="Add Number"
                                                                            name="bus_number" required
                                                                            value=" {{ $bus->bus_number }}" />
                                                                        <span class="text-danger mt-1">
                                                                            @error('bus_number')
                                                                                {{ $message }}
                                                                            @enderror
                                                                        </span>
                                                                    </div>
                                                                    <div class="col mb-0">
                                                                        <label for="" class="form-label">Total
                                                                            Seats</label>
                                                                        <input type="text" id="dobWithTitle"
                                                                            class="form-control"
                                                                            placeholder="Seats In Number" name="seats"
                                                                            required value="{{ $bus->seats }}" />
                                                                        <span class="text-danger mt-1">
                                                                            @error('seats')
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

                        <div class="modal fade" id="addNewBus" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalCenterTitle">Add New Bus</h5>

                                    </div>


                                    <form id="addBusForm">

                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-mb-12">
                                                    <div class="alert alert-success alert-dismissible" role="alert"
                                                        id="successAlert" style="display: none">
                                                        Bus Added Successfully

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                    <label for="" class="form-label">Bus Name</label>
                                                    <input type="text" id="busName" name="name"
                                                        class="form-control" placeholder="Add Bus" />
                                                    <span class="text-danger mt-1" id="nameError">

                                                    </span>
                                                </div>

                                            </div>
                                            <div class="row g-2">
                                                <div class="col mb-0">
                                                    <label for="" class="form-label">Bus Number</label>
                                                    <input type="text" id="busNumber" class="form-control"
                                                        placeholder="Add Number" name="bus_number" />
                                                    <span class="text-danger mt-1" id="numberError">

                                                    </span>
                                                </div>
                                                <div class="col mb-0">
                                                    <label for="" class="form-label">Total Seats</label>
                                                    <input type="text" id="totalseats" class="form-control"
                                                        placeholder="Seats In Number" name="seats" />
                                                    <span class="text-danger mt-1" id="seatsError">

                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-label-secondary"
                                                data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="" class="btn btn-primary">Add Bus</button>
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
                    // if (searchValue.length) { // Adjust the minimum length as needed
                    $.ajax({
                        url: '{{ route('dashboard-view-bus') }}', // Replace with your controller route
                        method: 'GET',
                        data: {
                            query: searchValue
                        },
                        success: function(data) {
                            console.log(data);
                            $("#searchResults").html(data)

                        }
                    });
                    // }
                });
            });


            $(document).ready(function() {
                $('#addBusForm').on('submit', function(e) {
                    e.preventDefault(); // Prevent the default form submission

                    $.ajax({
                        url: '{{ route('dashboard-add-bus') }}', // Replace with your controller route
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function(data) {
                            console.log(data)
                            if (data.error) {
                                if (data.error.includes('The name field is required.')) {
                                    $('#nameError').text('The name field is required.');
                                } else {
                                    $('#nameError').text('');
                                }

                                if (data.error.includes('The bus number field is required.')) {
                                    $('#numberError').text('The bus number is required.');
                                } else if (data.error.includes(
                                        'The bus number has already been taken.')) {
                                    $('#numberError').text('The bus number is already taken.');
                                } else {
                                    $('#numberError').text('');
                                }

                                if (data.error.includes('The seats field is required.')) {
                                    $('#seatsError').text('The seats field is required.');
                                } else if (data.error.includes('The seats must be an integer.')) {
                                    $('#seatsError').text('The seats must be an integer');
                                } else {
                                    $('#seatsError').text('');
                                }
                            } else {
                                console.log(data)
                                $('#successAlert').show('1000');
                                setTimeout(function() {
                                    $('#successAlert').fadeOut('slow');
                                }, 5000);
                                $("#searchResults").html(data)
                                $("#searchResults").html(data)
                                // $('#success').text(data.success);
                                $('#nameError').text('');
                                $('#numberError').text('');
                                $('#seatsError').text('');
                                $('#addBusForm')[0].reset();

                            }
                        },
                        error: function(error) {

                        }
                    });
                });
            });
        </script>








    @endsection
