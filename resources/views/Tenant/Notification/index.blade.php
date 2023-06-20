@extends('layouts.master')

@section('content')
    <div class="card overflow-hidden mb-3">
        <div class="card-header bg-light">
            <div class="row flex-between-center">
                <div class="col-sm-auto">
                    <h5 class="mb-1 mb-md-0">Your Notifications</h5>
                </div>
                <div class="col-sm-auto fs--1">
                    <a class="font-sans-serif ms-2 ms-sm-3" href="#!">Mark all as read</a>
                </div>
            </div>
        </div>
        <div class="card-body fs--1 p-0">
            @foreach ($notifications as $item)
                <a class="border-bottom-0 notification rounded-0 border-x-0 border-300 d-flex justify-content-between"
                    href="/admin/notification/{{ $item->id }}">
                    <div class="p-2">
                        <div class="row">
                            <div class="col-sm-auto">
                                <div class="notification-avatar">
                                    <div class="avatar avatar-xl me-3">
                                        <img class="rounded-circle" src="{{ $item->Sender->profile_picture }}" alt="" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="notification-body">
                                    <p class="mb-1"><strong>{{ $item->Sender->nama_user }}</strong> Mengirim anda :
                                        {{ $item->notif_message }} - {{ $item->notif_title }}</p>
                                    <span class="notification-time"><span class="me-2" role="img"
                                            aria-label="Emoji">📢</span>{{ TimeAgo($item->created_at) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-2">
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
