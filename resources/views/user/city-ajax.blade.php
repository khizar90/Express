@foreach ($cities as $city)
    <tr class="odd">



        <td class="">{{ $city->name }}</td>

        <td class="" style="">
            <div class="d-flex align-items-center">
                <a href="" data-bs-toggle="modal" data-bs-target="#editBus{{ $city->id }}"
                    class="text-body delete-record"><i class="ti ti-edit"></i></a>

                <a data-bs-toggle="modal" data-bs-target="#deleteModal{{ $city->id }}"
                    class="text-body delete-record">
                    <i class="ti ti-trash x`ti-sm mx-2"></i>
                </a>


            </div>


            <div class="modal fade" id="deleteModal{{ $city->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content deleteModal verifymodal">
                        <div class="modal-header">
                            <div class="modal-title" id="modalCenterTitle">Are you sure you want to delete
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

            <div class="modal fade" id="editBus{{ $city->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Edit City</h5>

                        </div>

                        <form action="{{ route('dashboard-edit-city', $city->id) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="nameWithTitle" class="form-label">City
                                            Name</label>
                                        <input type="text" id="nameWithTitle" name="name"
                                            value="{{ $city->name }}" class="form-control" placeholder="Add Bus"
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
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-primary">Edit City</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </td>

    </tr>
@endforeach
