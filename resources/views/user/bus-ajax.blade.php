@foreach ($buses as $bus)
    <tr class="odd">



        <td class="">{{ $bus->name }}</td>
        <td class="">{{ $bus->bus_number }}</td>
        <td class="">{{ $bus->seats }}</td>

        <td class="" style="">
            <div class="d-flex align-items-center">
                <a href="" data-bs-toggle="modal" data-bs-target="#editBus{{ $bus->id }}"
                    class="text-body delete-record"><i class="ti ti-edit"></i></a>

                <a data-bs-toggle="modal" data-bs-target="#deleteModal{{ $bus->id }}"
                    class="text-body delete-record">
                    <i class="ti ti-trash x`ti-sm mx-2"></i>
                </a>


            </div>


            <div class="modal fade" id="deleteModal{{ $bus->id }}" tabindex="-1" aria-hidden="true">
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

            <div class="modal fade" id="editBus{{ $bus->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Edit Bus</h5>

                        </div>

                        <form action="{{ route('dashboard-edit-bus', $bus->id) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="nameWithTitle" class="form-label">Bus
                                            Name</label>
                                        <input type="text" id="nameWithTitle" name="name"
                                            value="{{ $bus->name }}" class="form-control" placeholder="Add Bus"
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
                                        <input type="text" id="" class="form-control"
                                            placeholder="Add Number" name="bus_number" required
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
                                        <input type="text" id="dobWithTitle" class="form-control"
                                            placeholder="Seats In Number" name="seats" required
                                            value="{{ $bus->seats }}" />
                                        <span class="text-danger mt-1">
                                            @error('seats')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
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
