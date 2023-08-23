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


        <div class="modal fade" id="deleteModal{{ $route->id }}" tabindex="-1"
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

        <div class="modal fade" id="editBus{{ $route->id }}" tabindex="-1"
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