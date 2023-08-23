@extends('layouts.base')
@section('title', 'Active')
@section('main', 'Active Repots Tickets')
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
                                            @if ($status == 'active')
                                                Active Reports Tickets
                                            @else
                                                Close Reports Tickets
                                            @endif

                                        </label>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <table class="table border-top dataTable" id="usersTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Phone Number</th>
                                    <th>Time</th>
                                    <th>Date</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $report)
                                    <tr class="odd">
                                        <td>{{ $report->category->name }}</td>

                                        <td>{{ $report->user->name }}</td>
                                        <td>{{ $report->user->phone }}</td>

                                        <td>{{ $report->created_at->setTimezone('Asia/Karachi')->format('g:i A') }}</td>
                                        <td>{{ $report->created_at->setTimezone('Asia/Karachi')->format('d-m-Y') }}</td>



                                        <td class="detailbtn"><a
                                                href="{{ route('dashboard-messages', ['channel' => $report->user_id . '-' . $report->id]) }}"
                                                class="badge btn">Details</a></td>

                                    </tr>
                                @endforeach



                            </tbody>
                        </table>



                    </div>
                </div>
                <!-- Offcanvas to add new user -->








            </div>
        </div>
    @endsection
