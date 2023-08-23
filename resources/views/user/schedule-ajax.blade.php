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
            <td class="detailbtn"><a href="{{ route('dashboard-schedule-detail', $schedule->id) }}"
                    class="badge btn">Details</a></td>




            <div class="modal fade" id="verifyModal{{ $schedule->id }}" tabindex="-1" aria-hidden="true">
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
