@foreach ($rooms as $room)
    <div class="hover-actions-trigger chat-contact nav-item
        @if ($room->LatestChat($room->id))
            @if (
                $room->LatestChat($room->id)->is_read == 0 &&
                    $room->LatestChat($room->id)->sender_id != Request::session()->get('user_id')) unread-message
            @endif
        @endif
        "
        role="tab" room-id="{{ $room->id }}" data-bs-toggle="tab" data-bs-target="#chat-0" aria-controls="chat-0"
        aria-selected="false">
        <div class="d-md-none d-lg-block">
            <div class="dropdown dropdown-active-trigger dropdown-chat">
                <button
                    class="hover-actions btn btn-link btn-sm text-400 dropdown-caret-none dropdown-toggle end-0 fs-0 mt-4 me-1 z-1 pb-2 mb-n2"
                    type="button" data-boundary="viewport" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <span class="fas fa-cog" data-fa-transform="shrink-3 down-4"></span>
                </button>
                <div class="dropdown-menu dropdown-menu-end border py-2 rounded-2">
                    <a class="dropdown-item text-danger" href="#!">Delete</a>
                </div>
            </div>
        </div>
        <div class="d-flex p-3">
            <div class="avatar avatar-xl">
                <img class="rounded-circle"
                    src="{{ $room->Sender->profile_picture ? url($room->Sender->profile_picture) : url('/storage/img/proapps.png') }}"
                    alt="" />
            </div>
            <div class="flex-1 chat-contact-body ms-2 d-md-none d-lg-block">
                <div class="d-flex justify-content-between">
                    <h6 class="mb-0 chat-contact-title">
                        {{ $room->Sender->nama_user }} <br>
                        <small>{{ $room->Ticket->no_tiket }}</small>
                    </h6>
                    <span class="message-time fs--2">Wed</span>
                </div>
                <div class="min-w-0">
                    <div class="chat-contact-content pe-3">
                        @if ($room->LatestChat($room->id))
                            {{ $room->LatestChat($room->id)->sender_id == Request::session()->get('user_id') ? 'You' : $room->Sender->nama_user }}
                            : {{ $room->LatestChat($room->id)->message }}
                        @else
                            Say Hello to {{ $room->Sender->nama_user }}!
                        @endif
                    </div>
                    <div class="position-absolute bottom-0 end-0 hover-hide">
                        <span class="fas fa-check text-400" data-fa-transform="shrink-5 down-4">
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    $('.chat-contact').on('click', function() {
        room_id = $(this).attr("room-id");

        getChats(room_id);
    })

    function getChats(room_id)
    {
        $.ajax({
            url: '/admin/get-chats',
            type: 'get',
            data: {
                room_id
            },
            success: function(resp) {
                $('#content-message').html(resp.html)
            }
        })

        $.ajax({
            url: '/admin/read-chats',
            type: 'POST',
            data: {
                room_id
            }
        })
    }
</script>
