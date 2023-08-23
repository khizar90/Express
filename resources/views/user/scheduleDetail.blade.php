@extends('layouts.base')
@section('title', 'Detail Schedule')
@section('main', 'Accounts Management')
@section('content')
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <!-- Statistics -->
                <div class="col-lg-12 mb-4 col-md-12">
                    <div class="card">
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
                        <div class="card-header d-flex justify-content-between">

                            <div class="dataTables_length" id="DataTables_Table_0_length"><label style="color: #9E1437; " class="fw-bold">
                                    All Schedules


                                </label>
                            </div>





                            <div class="d-flex align-items-center">
                                <a data-bs-toggle="modal" data-bs-target="#editModal{{ $schedule->id }}" class="text-body ">
                                    <i class="ti ti-edit x`ti-sm mx-2"></i>
                                </a>

                                <div class="modal fade" data-bs-backdrop='static' id="editModal{{ $schedule->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalCenterTitle">Edit Schedule</h5>

                                            </div>

                                            <form action="{{ route('dashboard-schedule-edit' , $schedule->id ) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col g-2">
                                                            <label for="nameWithTitle" class="form-label">Select Bus</label>
                                                            <select name="bus_id" aria-controls="" class="form-select">
                                                                <option value="" disabled selected>
                                                                    Select Bus</option>
                                                                @foreach ($buses as $bus)
                                                                    <option value="{{ $bus->id }}"
                                                                        {{ $schedule->bus->name == $bus->name ? 'selected' : '' }}>
                                                                        {{ $bus->name }} &nbsp;&nbsp; - &nbsp;&nbsp;
                                                                        {{ $bus->bus_number }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                        <div class="row g-2">
                                                            <div class="col mb-0">
                                                                <label for="" class="form-label">Charge</label>
                                                                <input type="text" id="" class="form-control"
                                                                    placeholder="Add Charge" name="charges" required
                                                                    value="{{ $schedule->charge }}" />

                                                            </div>
                                                            <div class="col mb-0">
                                                                <label for="" class="form-label">Routes</label>
                                                                <select name="route_id" aria-controls=""
                                                                    class="form-select">
                                                                    <option value="" disabled selected>
                                                                        Select Routes</option>
                                                                    @foreach ($routes as $route)
                                                                        <option value="{{ $route->id }}"
                                                                            {{ $schedule->route->departure == $route->departure && $schedule->route->arival == $route->arival ? 'selected' : '' }}>
                                                                            {{ $route->departure }} to
                                                                            {{ $route->arival }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                        </div>

                                                        <div class="row g-2">
                                                            <div class="col mb-0">
                                                                <label for="" class="form-label">Departure
                                                                    Time</label>
                                                                <input type="time" id="" class="form-control"
                                                                    name="departure_time" required
                                                                    value="{{ date('H:i', strtotime($schedule->departure_time)) }}" />

                                                            </div>
                                                            <div class="col mb-0">
                                                                <label for="" class="form-label">Arrival
                                                                    Time</label>
                                                                <input type="time" id="" class="form-control"
                                                                    name="arrival_time" required
                                                                    value="{{ date('H:i', strtotime($schedule->arrival_time)) }}" />

                                                            </div>
                                                        </div>

                                                        <div class="row g-2 days">
                                                            @php
                                                                $scheduleDays = explode(',', $schedule->days);
                                                            @endphp
                                                            <div class="col">
                                                                <input type="checkbox" class="btn-check"
                                                                    id="btn-check-monday" name="day[]"
                                                                    autocomplete="off" value="monday"
                                                                    {{ in_array('monday', $scheduleDays) ? 'checked' : '' }}>
                                                                <label class="btn "
                                                                    for="btn-check-monday">Monday</label>

                                                            </div>
                                                            <div class="col">
                                                                <input type="checkbox" class="btn-check"
                                                                    id="btn-check-tuesday" name="day[]"
                                                                    autocomplete="off" value="tuesday"
                                                                    {{ in_array('tuesday', $scheduleDays) ? 'checked' : '' }}>
                                                                <label class="btn "
                                                                    for="btn-check-tuesday">Tuesday</label>
                                                            </div>
                                                            <div class="col">
                                                                <input type="checkbox" class="btn-check"
                                                                    id="btn-check-wednesday" name="day[]"
                                                                    autocomplete="off" value="wednesday"
                                                                    {{ in_array('wednesday', $scheduleDays) ? 'checked' : '' }}>
                                                                <label class="btn "
                                                                    for="btn-check-wednesday">wednesday</label>
                                                            </div>
                                                            <div class="col">
                                                                <input type="checkbox" class="btn-check"
                                                                    id="btn-check-thursday" name="day[]"
                                                                    autocomplete="off" value="thursday"
                                                                    {{ in_array('thursday', $scheduleDays) ? 'checked' : '' }}>
                                                                <label class="btn "
                                                                    for="btn-check-thursday">Thursday</label>
                                                            </div>
                                                            <div class="col">
                                                                <input type="checkbox" class="btn-check"
                                                                    id="btn-check-friday" name="day[]"
                                                                    autocomplete="off" value="friday"
                                                                    {{ in_array('friday', $scheduleDays) ? 'checked' : '' }}>
                                                                <label class="btn "
                                                                    for="btn-check-friday">Firday</label>
                                                            </div>
                                                            <div class="col">
                                                                <input type="checkbox" class="btn-check"
                                                                    id="btn-check-saturday" name="day[]"
                                                                    autocomplete="off" value="saturday"
                                                                    {{ in_array('saturday', $scheduleDays) ? 'checked' : '' }}>
                                                                <label class="btn "
                                                                    for="btn-check-saturday">Saturday</label>
                                                            </div>
                                                            <div class="col">
                                                                <input type="checkbox" class="btn-check"
                                                                    id="btn-check-sunday" name="day[]"
                                                                    autocomplete="off" value="sunday"
                                                                    {{ in_array('sunday', $scheduleDays) ? 'checked' : '' }}>
                                                                <label class="btn "
                                                                    for="btn-check-sunday">Sunday</label>
                                                            </div>

                                                        </div>


                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-label-secondary"
                                                        data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">Edit Schedule</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>



                                <a data-bs-toggle="modal" data-bs-target="#deleteModal{{ $schedule->id }}"
                                    class="text-body ">
                                    <i class="ti ti-trash x`ti-sm mx-2"></i>
                                </a>

                                <div class="modal fade" data-bs-backdrop='static' id="deleteModal{{ $schedule->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                        <div class="modal-content deleteModal verifymodal">
                                            <div class="modal-header">
                                                <div class="modal-title" id="modalCenterTitle">Are you sure you want to delete
                                                    this schedule?
                                                </div>
                                            </div>
                                            <div class="modal-body">
                                                <div class="body">After deleting this schedule you cannot 
                                                    use this schedule</div>
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
                                                            href="{{ route('dashboard-schedule-delete', $schedule->id) }}">Delete</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row gy-3 mb-5">
                                <div class="col-md-4 col-6 ">
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <i class="bi bi-dot" style="font-size: 50px; color:  #9E1437"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0">Bus</h5>
                                            <small>{{ $schedule->bus->name }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <i class="bi bi-dot" style="font-size: 50px; color:  #9E1437"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0">Routes</h5>
                                            <small>{{ $schedule->route->departure }} to
                                                {{ $schedule->route->arival }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <i class="bi bi-dot" style="font-size: 50px; color:  #9E1437"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0">Departure</h5>
                                            <small>{{ $schedule->departure_time }}</small>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row gy-3 mb-3">
                                <div class="col-md-4 col-6 ">
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <i class="bi bi-dot" style="font-size: 50px; color:  #9E1437"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0">Day</h5>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <small>{{ $schedule->days }}</small>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <i class="bi bi-dot" style="font-size: 50px; color:  #9E1437"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0">Charges</h5>
                                            <small>{{ $schedule->charge }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <i class="bi bi-dot" style="font-size: 50px; color:  #9E1437"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0">Arrival</h5>
                                            <small>{{ $schedule->arrival_time }}</small>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    @endsection
