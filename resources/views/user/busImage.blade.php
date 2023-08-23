@extends('layouts.base')
@section('title', 'Bus Images')
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

                        <div class="row me-2 mt-3">
                            <div class="col-md-2">
                                <div class="me-3">

                                    <div class="dataTables_length" id="DataTables_Table_0_length"><label
                                            style="color: #9E1437; " class="fw-bold">
                                            Bus Images


                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div
                                    class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">

                                    <div class="dt-buttons btn-group flex-wrap mt-2">
                                        <button class="btn btn-secondary add-new btn-primary mx-3" tabindex="0"
                                            aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal"
                                            data-bs-target="#addImage"><span><i
                                                    class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                    class="d-none d-sm-inline-block">Add Bus Image
                                                </span></span></button>
                                    </div>
                                    <form id="uploadForm" action="{{ route('dashboard-add-bus-images') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal fade"  id="addImage" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content addImage">
                                                    <div class="text-right p-3">
                                                        <button href="" id="uploadBtn" type="submit"
                                                            class="btn btn-primary">Upload</button>
                                                    </div>




                                                    <div class="modal-body mb-5">
                                                        <div class="row">
                                                            <div class="col-md-3"></div>
                                                            <div class="col-md-6 text-center" id="uploadContainer">

                                                                <div class="iocn">
                                                                    <i class="ti ti-upload"
                                                                        style="font-size: 70px; font-weight: 200; color: #9E1437"></i>

                                                                </div>
                                                                <div class="text">
                                                                    Your add image here
                                                                </div>

                                                                <div class="mt-4 text-center">
                                                                    <label for="upload"
                                                                        class="btn btn-primary text-center  mb-3"
                                                                        tabindex="0">
                                                                        <span class="d-none d-sm-block">Browse image</span>
                                                                        <i class="ti ti-upload d-block d-sm-none"></i>
                                                                        <input type="file" id="upload"
                                                                            class="account-file-input" name="image" hidden
                                                                            accept="image/png, image/jpeg" />
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6  d-none text-center md-shadow"
                                                                id="imageContainer">
                                                                <div class="image">
                                                                    <img class="rounded " id="previewImage" src="#"
                                                                        alt="" width="100%" height="auto">
                                                                </div>
                                                                <button class="removebtn">Remove File</button>
                                                            </div>
                                                            <div class="col-md-4"></div>
                                                        </div>

                                                    </div>




                                                </div>
                                            </div>
                                        </div>
                                        <form>

                                </div>
                            </div>

                        </div>

                        <hr>

                        <div class="row me-2">

                            <div class="col-md-12">
                                BUS IMAGES
                            </div>
                        </div>

                        <hr class="mb-5">

                        <div class="row imageBus">
                            @foreach ($images as $image)
                                <div class="col-md-3 mb-4">
                                  
                                    <div class="">
                                        <img class="rounded" src="{{ asset('bus/' . $image->image) }}" alt=""
                                            width="100%" height="auto" onclick="openModal('{{ asset('bus/' . $image->image) }}')">
                                    </div>
                                    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-simple modal-upgrade-plan">
                                            <div class="modal-content p-0 bg-transparent">
                                                <div class="modal-body p-0">
                                                    <div class="text-center">
                                                        <img id="modalImage" src="" alt="user image"
                                                            class="img-fluid rounded" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <a data-bs-toggle="modal" data-bs-target="#deleteModal{{ $image->id }}"
                                        class="delete-icon">
                                        <i class="bi bi-trash text-danger"></i>
                                    </a>
                                </div>
                                <div class="modal fade" data-bs-backdrop='static' id="deleteModal{{ $image->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                        <div class="modal-content deleteModal verifymodal">
                                            <div class="modal-header">
                                                <div class="modal-title" id="modalCenterTitle">
                                                    Are you sure you want to delete
                                                    this bus image?
                                                </div>
                                            </div>
                                            <div class="modal-body">
                                                <div class="body">After deleting the bus image you will add
                                                    a new bus image.</div>
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
                                                            href="{{ route('dashboard-delete-bus-image', $image->id) }}">Delete</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>








                    </div>
                </div>
                <!-- Offcanvas to add new user -->








            </div>
        </div>
    @endsection
    @section('script')

        <script>
            $(document).ready(function() {
                // When a file is selected, show the lower col-md-6 with the uploaded image and hide the upper col-md-6
                $("#upload").on("change", function(e) {
                    var file = e.target.files[0];
                    if (file) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $("#previewImage").attr("src", e.target.result);
                            $("#uploadContainer").addClass("d-none");
                            $("#imageContainer").removeClass("d-none");
                        };
                        reader.readAsDataURL(file);
                    }
                });

                // When the "Remove File" button is clicked, show the upper col-md-6 and hide the lower col-md-6
                $(".removebtn").on("click", function() {
                    $("#upload").val(""); // Clear the file input selection
                    $("#uploadContainer").removeClass("d-none");
                    $("#imageContainer").addClass("d-none");
                });
            });


            function openModal(imageSrc) {
                console.log(imageSrc)
                var image = document.getElementById('modalImage');
                image.src = imageSrc;
                $('#imageModal').modal('show');
            }
        </script>
    @endsection
