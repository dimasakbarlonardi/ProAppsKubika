@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('notifications.index')}}" class="text-white"> List Reminder Letter</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Notification</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('notifications.update', $notification->id) }}">
                @method('PUT')
                @csrf
                <div class="row">
                <div class="col-6">
                    <label class="form-label">Tanggal Notif</label>
                    <input type="date" name="tgl_notif" value="{{$notification->tgl_notif}}" class="form-control">
                </div>
                <div class="col-6">
                    <label class="form-label">ID User</label>
                    <select class="form-control" name="id_user" required>
                        <option selected disabled>-- Pilih ID User --</option>
                        @foreach ($idusers as $iduser)
                        <option value="{{ $iduser->id }}" {{ $iduser->name == $iduser->name ? 'selected' : ''}}>{{ $iduser->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label">Notification Title</label>
                    <textarea type="text" name="notification_1" class="form-control">{{$notification->notification_1}}</textarea>
                </div>
                <div class="col-6">
                    <label class="form-label">Deskripsi</label>
                    <textarea type="text" name="notification_2" class="form-control">{{$notification->notification_2}}</textarea>
                </div>
                <div class="col-6">
                    <label class="form-label">Notif Image</label>
                    <input type="text" name="notif_image" value="{{$notification->notif_image}}" class="form-control">
                </div>
                <div class="col-6">
                    <label class="form-label">Durasi Notif</label>
                    <input type="text" name="durasi_notif" value="{{$notification->durasi_notif}}" class="form-control">
                </div>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button class="btn btn-danger"><a class="text-white" href="{{ route('notifications.index')}}">Cancel</a></button>
                </div>
            </form>
        </div>
    </div>
@endsection
