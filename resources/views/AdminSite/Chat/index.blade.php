@extends('layouts.master')

@section('content')
    <div class="card card-chat">
        <div class="card-body d-flex p-0 h-100">
            @if (Request::session()->get('work_relation_id') == 1)
                <div class="chat-sidebar">
                    <div class="contacts-list scrollbar-overlay">
                        <div class="nav nav-tabs border-0 flex-column" role="tablist" aria-orientation="vertical"
                            id="data-rooms">
                        </div>
                    </div>
                    <form class="contacts-search-wrapper">
                        <div class="form-group mb-0 position-relative d-md-none d-lg-block w-100 h-100">
                            <input class="form-control form-control-sm chat-contacts-search border-0 h-100" type="text"
                                placeholder="Search contacts ..." />
                            <span class="fas fa-search contacts-search-icon"></span>
                        </div>
                        <button class="btn btn-sm btn-transparent d-none d-md-inline-block d-lg-none">
                            <span class="fas fa-search fs--1"></span>
                        </button>
                    </form>
                </div>
            @else
                <div class="tab-content card-chat-content">
                    <div class="tab-pane card-chat-pane active" id="chat-" role="tabpanel"
                        aria-labelledby="chat-link-0">
                        <div class="chat-content-header">
                            <div class="row flex-between-center">
                                <div class="col-6 col-sm-8 d-flex align-items-center"><a
                                        class="pe-3 text-700 d-md-none contacts-list-show" href="#!">
                                        <div class="fas fa-chevron-left"></div>
                                    </a>
                                    <div class="min-w-0">
                                        <h5 class="mb-0 text-truncate fs-0">
                                            Tenant Relation
                                        </h5>
                                        <div class="fs--2 text-400">Active On Chat</div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <div class="chat-content-body" id="chat-room-slave">
                        </div>
                    </div>
                    <form class="chat-editor-area mt-auto">
                        <input class="emojiarea-editor outline-none scrollbar form-control" contenteditable="true"
                            id="message-content" />
                        <button class="btn btn-sm btn-send shadow-none" type="button" id="send_message">Send</button>
                    </form>
                </div>
            @endif

            {{-- Content message --}}
            @if (Request::session()->get('work_relation_id') == 1)
                <div id="content-message" class="tab-content card-chat-content">

                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            var d = $('#content-message-master');
            d.scrollTop(d.prop("scrollHeight"));

            getRooms();

            Echo.channel("chat-channel")
                .listen('ChatEvent', (e) => {
                    getRooms();
                    getChatMaster(e.room);
                })
        });

        function getRooms() {
            $.ajax({
                url: '/admin/chats/rooms',
                type: 'get',
                success: function(resp) {
                    $('#data-rooms').html(resp.html)
                }
            })
        }
    </script>

    <script>
        $('.footer').css("display", "none");
        $('#body').css("overflow", "hidden");

        $('#content-message').html('')

        function getChatMaster(room_id) {
            $.ajax({
                url: '/admin/chats/rooms-master',
                type: 'get',
                data: {
                    room_id
                },
                success: function(resp) {
                    currRoomID = parseInt($('#room_id_value').val());

                    if (parseInt(room_id) === currRoomID) {
                        console.log('move')
                        $('#content-message-master').html(resp.html)
                        var d = $('#content-message-master');
                        d.scrollTop(d.prop("scrollHeight"));
                        value = $('#message-content').val('');
                    }
                }
            })
        }
    </script>
@endsection
