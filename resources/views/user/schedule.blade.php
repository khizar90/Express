@extends('layouts.base')
@section('title', 'Schedules')
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
                                            All Schedules
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
                                    <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                        <label class="user_search">
                                            {{-- <input type="text" class="form-control" id="searchInput"
                                                placeholder="Search.." value="" aria-controls="DataTables_Table_0"> --}}
                                        </label>
                                    </div>
                                    <div class="dt-buttons btn-group flex-wrap">
                                        <button class="btn btn-secondary add-new btn-primary mx-3" tabindex="0"
                                            aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal"
                                            data-bs-target="#addNewBus"><span><i
                                                    class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                    class="d-none d-sm-inline-block">Add New Bus Time
                                                    Schedules</span></span></button>
                                    </div>
                                </div>
                            </div>

                        </div>



                        <table class="table border-top dataTable" id="usersTable">
                            <thead class="table-light">
                                <tr>

                                    <th>BUS</th>
                                    <th>ROUTES</th>
                                    <th>CHARGES</th>

                                    <th>STATUS</th>
                                    <th>ACTION</th>

                                </tr>
                            </thead>
                            <tbody id="searchResults">
                                @foreach ($schedules as $schedule)
                                    <tr class="odd">



                                        <td class="">{{ $schedule->bus->name }}</td>
                                        <td class="">{{ $schedule->route->departure }} to
                                            {{ $schedule->route->arival }}</td>
                                        <td class="">{{ $schedule->charge }}</td>
                                        <td>
                                            @if ($schedule->status == 1)
                                                <button class="badge bg-label-success btn" data-bs-toggle="modal"
                                                    data-bs-target="#verifyModal{{ $schedule->id }}">Active</button>
                                            @else
                                                <button class="badge bg-label-secondary btn" data-bs-toggle="modal"
                                                    data-bs-target="#verifyModal{{ $schedule->id }}">Inactive</button>
                                            @endif
                                        </td>
                                        <td class="detailbtn"><a
                                                href="{{ route('dashboard-schedule-detail', $schedule->id) }}"
                                                class="badge btn">Details</a></td>




                                        <div class="modal fade" data-bs-backdrop='static' id="verifyModal{{ $schedule->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                                <div class="modal-content verifymodal deleteModal">
                                                    <div class="modal-header">
                                                        <div class="modal-title" id="modalCenterTitle">Are you sure you want
                                                            to inactive
                                                            schedule?
                                                        </div>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="body">After the Inactive schedule, you can be active
                                                            the next time</div>
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
                                                                    href="{{ route('dashboard-schedule-status', $schedule->id) }}">YES</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </tr>
                                @endforeach



                            </tbody>
                        </table>

                        <div class="modal fade" data-bs-backdrop='static' data-bs-backdrop='static' id="addNewBus" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalCenterTitle">Add New Schedule</h5>

                                    </div>

                                    <form action="{{ route('dashboard-add-schedule') }}" id="addBusForm" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col g-2">
                                                    <label for="nameWithTitle" class="form-label">Select Bus</label>
                                                    <select name="bus_id" aria-controls="" class="form-select">
                                                        <option value="" disabled selected>
                                                            Select Bus</option>
                                                        @foreach ($buses as $bus)
                                                            <option value="{{ $bus->id }}">
                                                                {{ $bus->name }} &nbsp;&nbsp; - &nbsp;&nbsp;
                                                                {{ $bus->bus_number }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="row g-2">
                                                    <div class="col mb-0">
                                                        <label for="" class="form-label">Charge ($)</label>
                                                        <input type="text" id="" class="form-control"
                                                            placeholder="Add Charge" name="charges" required
                                                            value="" />

                                                    </div>
                                                    <div class="col mb-0">
                                                        <label for="" class="form-label">Routes</label>
                                                        <select name="route_id" aria-controls="" class="form-select">
                                                            <option value="" disabled selected>
                                                                Select Routes</option>
                                                            @foreach ($routes as $route)
                                                                <option value="{{ $route->id }}">
                                                                    {{ $route->departure }} to {{ $route->arival }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="row g-2">
                                                    <div class="col mb-0">
                                                        <label for="" class="form-label">Departure Time</label>
                                                        {{-- <input type="time" id="" class="form-control"
                                                            placeholder="--:-- ---" name="departure_time" required
                                                            value="" /> --}}
                                                        <input type="text" class="form-control" placeholder="HH:MM"
                                                            id="departure-time" name="departure_time" required />


                                                    </div>
                                                    <div class="col mb-0">
                                                        <label for="" class="form-label">Arrival Time</label>
                                                        {{-- <input type="time" id="" class="form-control"
                                                            placeholder="--:-- ---" name="arrival_time" required
                                                            value="" /> --}}
                                                        <input type="text" class="form-control" placeholder="HH:MM"
                                                            id="arrival-time" name="arrival_time" required />

                                                    </div>
                                                </div>

                                                <div class="row g-2 days">
                                                    <div class="col">
                                                        <input type="checkbox" class="btn-check" id="btn-check-monday"
                                                            name="day[]" autocomplete="off" value="monday">
                                                        <label class="btn " for="btn-check-monday">Monday</label>

                                                    </div>
                                                    <div class="col">
                                                        <input type="checkbox" class="btn-check" id="btn-check-tuesday"
                                                            name="day[]" autocomplete="off" value="tuesday">
                                                        <label class="btn " for="btn-check-tuesday">Tuesday</label>
                                                    </div>
                                                    <div class="col">
                                                        <input type="checkbox" class="btn-check" id="btn-check-wednesday"
                                                            name="day[]" autocomplete="off" value="wednesday">
                                                        <label class="btn " for="btn-check-wednesday">wednesday</label>
                                                    </div>
                                                    <div class="col">
                                                        <input type="checkbox" class="btn-check" id="btn-check-thursday"
                                                            name="day[]" autocomplete="off" value="thursday">
                                                        <label class="btn " for="btn-check-thursday">Thursday</label>
                                                    </div>
                                                    <div class="col">
                                                        <input type="checkbox" class="btn-check" id="btn-check-friday"
                                                            name="day[]" autocomplete="off" value="friday">
                                                        <label class="btn " for="btn-check-friday">Firday</label>
                                                    </div>
                                                    <div class="col">
                                                        <input type="checkbox" class="btn-check" id="btn-check-saturday"
                                                            name="day[]" autocomplete="off" value="saturday">
                                                        <label class="btn " for="btn-check-saturday">Saturday</label>
                                                    </div>
                                                    <div class="col">
                                                        <input type="checkbox" class="btn-check" id="btn-check-sunday"
                                                            name="day[]" autocomplete="off" value="sunday">
                                                        <label class="btn " for="btn-check-sunday">Sunday</label>
                                                    </div>

                                                </div>


                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-label-secondary"
                                                data-bs-dismiss="modal" id="closeButton">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-primary">Add Schedule</button>
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
        <script>
            $(document).ready(function() {
                $('#closeButton').on('click', function(e) {
                    $('#addBusForm')[0].reset();

                });

            });
        </script>
        <script>
            flatpickr("#departure-time", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true
                // Other configuration options can be added here
            });

            flatpickr("#arrival-time", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true
                // Other configuration options can be added here
            });
        </script>
        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#searchInput').keyup(function() {
                    var searchValue = $(this).val();
                    // if (searchValue.length) { // Adjust the minimum length as needed
                    $.ajax({
                        url: '{{ route('dashboard-schedules') }}', // Replace with your controller route
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
        </script> --}}
    @endsection
