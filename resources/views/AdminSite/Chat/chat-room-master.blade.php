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
