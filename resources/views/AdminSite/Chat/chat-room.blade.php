<div class="tab-pane card-chat-pane active" role="tabpanel" aria-labelledby="chat-link-0">
    <div class="chat-content-header">
        <div class="row flex-between-center">
            <div class="col-6 col-sm-8 d-flex align-items-center">
                <a class="pe-3 text-700 d-md-none contacts-list-show" href="#!">
                    <div class="fas fa-chevron-left"></div>
                </a>
                <div class="min-w-0">
                    <h5 class="mb-0 text-truncate fs-0">
                        {{ $room->Sender->nama_user }}
                    </h5>
                    <div class="fs--2 text-400">Active On Chat</div>
                </div>
                <hr>
            </div>
        </div>
    </div>
    <div class="chat-content-body">
        <div class="chat-content-scroll-area scrollbar" id="content-message-master">
            @foreach ($room->Chats as $chat)
                @if (Request::session()->get('user_id') == $chat->sender_id)
                    <div class="d-flex p-3">
                        <div class="flex-1 d-flex justify-content-end">
                            <div class="w-100 w-xxl-75">
                                <div class="hover-actions-trigger d-flex flex-end-center">
                                    <div class="bg-info text-white p-2 rounded-2 chat-message" data-bs-theme="light">
                                        {{ $chat->message }}
                                    </div>
                                </div>
                                <div class="text-400 fs--2 text-end">
                                    {{ HumanDateTime($chat->created_at) }}
                                    @if ($chat->is_read)
                                        <span class="fas fa-check ms-2 text-success"></span>
                                    @else
                                        <span class="fas fa-check text-400" data-fa-transform="shrink-5 down-4">
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="d-flex p-3">
                        <div class="avatar avatar-l me-2">
                            <img class="rounded-circle"
                                src="{{ $chat->Sender->profile_picture ? url($chat->Sender->profile_picture) : url('/storage/img/proapps.png') }}"
                                alt="" />
                        </div>
                        <div class="flex-1">
                            <div class="w-xxl-75">
                                <div class="hover-actions-trigger d-flex align-items-center">
                                    <div class="chat-message bg-200 p-2 rounded-2">
                                        {{ $chat->message }}</div>
                                </div>
                                <div class="text-400 fs--2">
                                    <span>{{ HumanDateTime($chat->created_at) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
<form class="chat-editor-area mt-auto">
    <input class="emojiarea-editor outline-none scrollbar form-control" contenteditable="true" name="value"
        id="message-content" />
    <input type="hidden" id="room_id_value" name="room_id" value="{{ $room->id }}">
    <input type="hidden" id="receiver_id_value" name="receiver_id" value="{{ $room->Sender->id_user }}">
    <button class="btn btn-sm btn-send shadow-none" type="button" id="send_message2">Send</button>
</form>

<script>
   var d = $('#content-message-master');
    d.scrollTop(d.prop("scrollHeight"));

    var input = document.getElementById("message-content");
    // Execute a function when the user presses a key on the keyboard
    input.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("send_message2").click();
        }
    });

    $('#send_message2').on('click', function() {
        value = $('#message-content').val();
        room_id = $('#room_id_value').val();
        receiver_id = $('#receiver_id_value').val();

        $.ajax({
            url: '/admin/chats',
            type: 'POST',
            data: {
                value,
                room_id,
                receiver_id,
            },
            success: function(resp) {
                $('#message-content').val('');
                var d = $('#content-message-master');
                d.scrollTop(d.prop("scrollHeight"));
                getChats(room_id);
            }
        })
    })
</script>
