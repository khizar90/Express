@extends('layouts.base')
@section('title', 'Active')
@section('main', 'Accounts Management')
@section('content')
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">

            <!-- Users List Table -->
            <div class="app-chat card">




                <div class="row">
                    <div class="col app-chat-history bg-body">
                        <div class="chat-history-wrapper">
                            <div class="chat-history-header border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex overflow-hidden align-items-center">
                                        <i class="ti ti-menu-2 ti-sm cursor-pointer d-lg-none d-block me-2"
                                            data-bs-toggle="sidebar" data-overlay data-target="#app-chat-contacts"></i>
                                        @if ($findUser->image)
                                            <div class="flex-shrink-0 avatar">
                                                <img src="{{ asset('profile/' . $findUser->image) }}" alt="Avatar"
                                                    class="rounded-circle" data-bs-toggle="sidebar" data-overlay
                                                    data-target="#app-chat-sidebar-right" />
                                                <span class="avatar-status-busy"></span>

                                            </div>
                                        @else
                                            <div class="flex-shrink-0 avatar">
                                                <img src="https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg"
                                                    alt="Avatar" class="rounded-circle" data-bs-toggle="sidebar"
                                                    data-overlay data-target="#app-chat-sidebar-right" />
                                                <span class="avatar-status-busy"></span>
                                            </div>
                                        @endif
                                        <div class="chat-contact-info flex-grow-1 ms-2">
                                            <h6 class="m-0">{{ $findUser->name }}</h6>
                                            <small class="user-status text-muted">{{ $cat->name }}</small>
                                        </div>
                                    </div>
                                    @if ($report->status == 1)
                                        <div class="d-flex align-items-center">
                                            <a class="btn btn-danger btn-sm" href="" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal">Close</a>
                                            <div class="modal fade" data-bs-backdrop='static' id="deleteModal" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                                    <div class="modal-content deleteModal verifymodal">
                                                        <div class="modal-header">
                                                            <div class="modal-title" id="modalCenterTitle">
                                                                Are you sure you want to Close
                                                                this Report?
                                                            </div>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="body">After Closing User cannot send message to
                                                                this ticket</div>
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
                                                                        href="{{ route('dashboard-close-report', $to) }}">Close</a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center">

                                            <span class="btn btn-primary btn-sm disabled">Ticket Closed</span>

                                        </div>
                                    @endif

                                </div>
                            </div>
                            <div class="chat-history-body bg-body" id="chat-messages">
                                @foreach ($conversation as $message)
                                    <ul class="list-unstyled chat-history ">

                                        @if ($message->sendBy == 'user')
                                            <li class="chat-message">
                                                <div class="d-flex overflow-hidden">
                                                    @if ($findUser->image)
                                                        <div class="user-avatar flex-shrink-0 me-3">
                                                            <div class="avatar avatar-sm">
                                                                <img src="{{ asset('profile/' . $findUser->image) }}"
                                                                    alt="Avatar" class="rounded-circle" />
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="user-avatar flex-shrink-0 me-3">
                                                            <div class="avatar avatar-sm">
                                                                <img src="https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg"
                                                                    alt="Avatar" class="rounded-circle" />
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="chat-message-wrapper flex-grow-1">

                                                        @if ($message->attachment)
                                                            <div class="chat-message-text  p-0 bg-transparent">

                                                                <img src="{{ asset('messages/' . $message->attachment) }}"
                                                                    alt="" class="rounded"
                                                                    style="width: 200px; height: auto"
                                                                    onclick="openModal('{{ asset('messages/' . $message->attachment) }}')">


                                                                <div class="modal fade" id="imageModal" tabindex="-1"
                                                                    aria-hidden="true">
                                                                    <div
                                                                        class="modal-dialog modal-dialog-centered modal-simple modal-upgrade-plan">
                                                                        <div class="modal-content p-0 bg-transparent">
                                                                            <div class="modal-body p-0">
                                                                                <div class="text-center">
                                                                                    <img id="modalImage" src=""
                                                                                        alt="user image"
                                                                                        class="img-fluid rounded" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($message->message)
                                                            <div class="chat-message-text">
                                                                <p class="mb-0">
                                                                    {{ $message->message }}
                                                                </p>
                                                            </div>
                                                        @endif
                                                        <div class="text-start text-muted mt-1">
                                                            {{-- <i class="ti ti-checks ti-xs me-1 text-success"></i> --}}
                                                            @if ($message->created_at->isToday())
                                                                {{ $message->created_at->setTimezone('Asia/Karachi')->format('g:i A') }}
                                                            @elseif($message->created_at->isYesterday())
                                                                Yesterday
                                                            @else
                                                                {{ $message->created_at->setTimezone('Asia/Karachi')->format('M j, Y') }}
                                                            @endif
                                                        </div>

                                                    </div>




                                                </div>
                                            </li>
                                        @else
                                            <li class="chat-message chat-message-right">
                                                <div class="d-flex overflow-hidden">
                                                    <div class="chat-message-wrapper flex-grow-1">
                                                        @if ($message->attachment)
                                                            <div class="chat-message-text  p-0 ">

                                                                <img src="{{ asset('messages/' . $message->attachment) }}"
                                                                    alt="" class="rounded"
                                                                    style="width: 200px; height: auto"
                                                                    onclick="openModal('{{ asset('messages/' . $message->attachment) }}')">

                                                                <div class="modal fade" id="imageModal" tabindex="-1"
                                                                    aria-hidden="true">
                                                                    <div
                                                                        class="modal-dialog modal-dialog-centered modal-simple modal-upgrade-plan">
                                                                        <div class="modal-content p-0 bg-transparent">
                                                                            <div class="modal-body p-0">
                                                                                <div class="text-center">
                                                                                    <img id="modalImage" src=""
                                                                                        alt="user image"
                                                                                        class="img-fluid rounded" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($message->message)
                                                            <div class="chat-message-text">
                                                                <p class="mb-0">
                                                                    {{ $message->message }}
                                                                </p>
                                                            </div>
                                                        @endif
                                                        <div class="text-end text-muted mt-1">
                                                            {{-- <i class="ti ti-checks ti-xs me-1 text-success"></i> --}}
                                                            @if ($message->created_at->isToday())
                                                                {{ $message->created_at->setTimezone('Asia/Karachi')->format('g:i A') }}
                                                            @elseif($message->created_at->isYesterday())
                                                                Yesterday
                                                            @else
                                                                {{ $message->created_at->setTimezone('Asia/Karachi')->format('M j, Y') }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="user-avatar flex-shrink-0 ms-3">
                                                        <div class="avatar avatar-sm">
                                                            <img src="../../assets/img/avatars/1.png" alt="Avatar"
                                                                class="rounded-circle" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif


                                    </ul>
                                @endforeach
                            </div>
                            <!-- Chat message form -->
                            @if ($report->status == 1)
                                <div class="chat-history-footer shadow-sm">
                                    <form class="form-send-message d-flex justify-content-between align-items-center"
                                        id="messageForm" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $from }}">
                                        <input type="hidden" name="ticket_id" value="{{ $to }}">
                                        <input class="form-control message-input border-0 me-3 shadow-none"
                                            placeholder="Type your message here" name="message" />
                                        <div class="message-actions d-flex align-items-center">
                                            <label for="attach-doc" class="form-label mb-0">
                                                <i class="ti ti-photo ti-sm cursor-pointer mx-3"></i>
                                                <input type="file" id="attach-doc" name="attachment" hidden />
                                            </label>
                                            <button class="btn btn-primary d-flex send-msg-btn" id="sendMessage">
                                                <i class="ti ti-send me-md-1 me-0" id="sendicon"></i>
                                                <span class="align-middle" id="sending">Send</span>

                                                <span class="align-middle" style="display: none" id="loader"><i
                                                        class="ti ti-rotate-clockwise-2"></i></span>
                                            </button>
                                        </div>
                                    </form>

                                    <div class="modal fade" data-bs-backdrop='static' id="imageModal1" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-simple modal-upgrade-plan">
                                            <div class="modal-content p-0 bg-transparent">
                                                <div class="modal-body p-0">
                                                    <div class="text-center">
                                                        <img id="modalImage1" src="" alt="user image"
                                                            class="img-fluid rounded" />
                                                    </div>
                                                    <div class="text-center d-flex mt-2 mb-2 justify-content-between mx-2">
                                                        <button class="btn btn-danger" id="removeImage">Remove Image</button>
                                                        <button class="btn btn-primary me-2" id="changeImage">OK</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- <form class="d-flex justify-content-between align-items-center" id="messageForm"
                                        enctype="multipart/form-data">
                                        @csrf <!-- Add this CSRF token for security -->
                                        <input type="hidden" name="user_id" value="{{ $from }}">
                                        <input type="hidden" name="ticket_id" value="{{ $to }}">
                                        <input class="form-control message-input border-0 me-3 shadow-none"
                                            placeholder="Type your message here" name="message" />
                                        <div class="message-actions d-flex align-items-center">
                                            <label for="attach-doc" class="form-label mb-0">
                                                <i class="ti ti-photo ti-sm cursor-pointer mx-3"></i>
                                                <input type="file" id="attach-doc" name="attachment" hidden />
                                            </label>
                                            <button  class="btn btn-primary d-flex send-msg-btn"
                                                id="sendMessage">
                                                <i class="ti ti-send me-md-1 me-0"></i>
                                                <span class="align-middle d-md-inline-block d-none">Send</span>
                                            </button>
                                        </div>
                                    </form> --}}
                                </div>
                            @endif

                        </div>
                    </div>
                </div>








            </div>
        </div>
    @endsection

    @section('script')
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
        <script>
            const pusher = new Pusher('97a86cd58ea79e2dcf60', {
                cluster: 'us3',
                encrypted: true,
            });

            const channelName = '{{ $channelName }}';
            const channel = pusher.subscribe(channelName);
            channel.bind('new-message', function(data) {
                console.log(data);
                appendMessage(data);
            });

            function appendMessage(data) {
                const messageContainer = document.getElementById('chat-messages');
                const message = data.message;
                const sender = data.sender;
                const user = data.user;
                const profile = data.profile;
                const attachment = data.attachment;

                console.log(message.message)
                console.log(user)
                let profileImage;
                if (profile) {
                    profileImage = profile;
                } else {
                    profileImage =
                        'https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg';
                }

                let newMessage = '';
                if (message && message.message) {
                    newMessage = `<div class="chat-message-text ">
                        <p class="mb-0"> ${message.message }</p>
                    </div>`;
                }

                let attachmentElement = '';
                if (message && message.attachment) {
                    attachmentElement =
                        `<div class="chat-message-text  p-0">
                            <img src="${attachment}"
                                alt="" class="rounded"
                                style="width: 200px; height: auto"  onclick="openModal('${attachment}')">

                                <div class="modal fade" id="imageModal" tabindex="-1"
                                    aria-hidden="true">
                                    <div
                                        class="modal-dialog modal-dialog-centered modal-simple modal-upgrade-plan">
                                        <div class="modal-content p-0 bg-transparent">
                                            <div class="modal-body p-0">
                                                <div class="text-center">
                                                    <img id="modalImage" src=""
                                                        alt="user image"
                                                        class="img-fluid rounded" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                }

                let messageElement;
                if (sender === 'admin') {
                    messageElement = `
                    <ul class="list-unstyled chat-history">
                        <li class="chat-message chat-message-right">
                        <div class="d-flex overflow-hidden">
                            <div class="chat-message-wrapper flex-grow-1">
                                <div class="chat-message-wrapper flex-grow-1">
                                    <div class="chat-message-wrapper flex-grow-1">
                                        ${attachmentElement}
                                        ${newMessage}
                                    </div>
                                </div>  
                                <div class="text-end text-muted mt-1">just now</div>

                            </div> 
                            <div class="user-avatar flex-shrink-0 ms-3">
                                <div class="avatar avatar-sm">
                                    <img src="../../assets/img/avatars/1.png" alt="Avatar"
                                        class="rounded-circle" />
                                </div>
                             </div>
                                                  
                        </div>
                    </li>
                    </ul>


                `;
                } else {
                    messageElement = `
                    <ul class="list-unstyled chat-history">
                        <li class="chat-message">
                            <div class="d-flex overflow-hidden">
                                <div class="user-avatar flex-shrink-0 me-3">
                                    <div class="avatar avatar-sm">
                                        <img src="${profileImage}" alt="Avatar"
                                        class="rounded-circle" />
                                    </div>
                                </div>

                                <div class="chat-message-wrapper flex-grow-1">
                                    <div class="chat-message-wrapper flex-grow-1">
                                        ${attachmentElement}
                                        ${newMessage}
                                    </div>
                                    <div class="text-start text-muted mt-1">just now</div>

                                </div>
                            </div>
                        </li>
                    </ul>
                `;
                }

                messageContainer.innerHTML += messageElement;

                // Scroll to the bottom of the message container
                messageContainer.scrollTop = messageContainer.scrollHeight;
            }
        </script>

        <script>
            $(document).ready(function() {
                // When the "Send" button is clicked
                $("#sendMessage").on("click", function() {
                    var message = $("input[name='message']").val();
                    var attachment = $("#attach-doc").prop("files")[0];

                    if (message.trim() === "" && !attachment) {
                        return;
                    }



                    // Create a FormData object to capture form data, including files
                    var formData = new FormData($("#messageForm")[0]);
                    var loader = $('#loader');
                    var sending = $('#sending');
                    var sendicon = $('#sendicon');

                    loader.show();
                    sending.hide();
                    sendicon.hide();
                    // Send the form data using Ajax
                    $.ajax({
                        type: "POST",
                        url: '{{ route('dashboard-send-message') }}', // Replace with your actual route URL
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            // Handle the response if needed
                            $("input[name='message']").val("");
                            $("#attach-doc").val(null);
                        },
                        complete: function() {
                            loader.hide();
                            sending.show();
                            sendicon.show();

                        },
                        error: function(xhr, status, error) {
                            // Handle errors if needed
                            console.error(error);
                        }
                    });
                });
            });
        </script>
        <script>
            function openModal(imageSrc) {
                var image = document.getElementById('modalImage');
                image.src = imageSrc;
                $('#imageModal').modal('show');
            }


    
            document.addEventListener('DOMContentLoaded', function() {
                // Get references to the necessary elements
                const inputFile = document.getElementById('attach-doc');
                const modalImage = document.getElementById('modalImage1');
                const changeImageButton = document.getElementById('changeImage');
                const removeImageButton = document.getElementById('removeImage');
                const imageModal = new bootstrap.Modal(document.getElementById('imageModal1'));

                // Function to update modal content
                function updateModalContent(imageURL) {
                    modalImage.src = imageURL;
                    imageModal.show();
                }

                // Listen for file input change event
                inputFile.addEventListener('change', function(event) {
                    const selectedImage = event.target.files[0];

                    if (selectedImage) {
                        const imageURL = URL.createObjectURL(selectedImage);
                        updateModalContent(imageURL);
                    }
                });

                // Handle "Change Image" button click
                changeImageButton.addEventListener('click', function() {
                    imageModal.hide(); 
                });

                // Handle "Remove Image" button click
                removeImageButton.addEventListener('click', function() {
                    inputFile.value = null; // Clear the input type file
                    modalImage.src = ''; // Clear the modal image source
                    imageModal.hide(); // Hide the modal
                });
            });
        </script>
   

    @endsection
