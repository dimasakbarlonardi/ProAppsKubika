@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="my-3 col-auto">
                <h6 class="mb-0">List Notification</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('notifications.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Tambah Notification</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table text-center">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="tgl_notif">Tanggal Notif</th>
                    <th class="sort" data-sort="notification_1">Notification Title</th>
                    <th class="sort" data-sort="notification_2">Deskripsi</th>
                    <th class="sort" data-sort="notif_image">Notif Image</th>
                    <th class="sort" data-sort="durasi_notif">Durasi Notif</th>
                    {{-- <th class="sort" data-sort="id_user">User</th> --}}
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notifications as $key => $notification)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $notification->tgl_notif }}</td>
                        <td>{{ $notification->notification_1 }}</td>
                        <td>{{ $notification->notification_2 }}</td>
                        <td>{{ $notification->notif_image }}</td>
                        <td>{{ $notification->durasi_notif }}</td>
                        {{-- <td>{{ $notification->user }}</td> --}}
                        <td>
                            <a href="{{ route('notifications.edit', $notification->id) }}" class="btn btn-sm btn-warning"><span class="fas fa-pencil-alt fs--2 me-1"></span> Edit</a>
                            <form class="d-inline" action="{{ route('notifications.destroy', $notification->id) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('are you sure?')"><span class="fas fa-trash-alt fs--2 me-1"></span> Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

