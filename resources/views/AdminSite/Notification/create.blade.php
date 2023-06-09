@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Tambah Notification</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('notifications.store') }}">
                @csrf
                <div class="row">
                <div class="col-6 mt-3">
                    <label class="form-label">Tanggal Notif</label>
                    <input type="date" name="tgl_notif" class="form-control" required>
                </div>
                <div class="col-6 mt-3">
                    <label class="form-label">ID User</label>
                    <select class="form-control" name="id_user" required>
                        <option selected disabled>-- Pilih ID User --</option>
                        @foreach ($idusers as $iduser)
                        <option value="{{ $iduser->id }}">{{ $iduser->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class=" col-6 mt-3">
                    <label class="form-label">Notification Title</label>
                    <textarea type="text" name="notification_1" class="form-control" required></textarea>
                </div>
                <div class=" col-6 mt-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea type="text" name="notification_2" class="form-control" required></textarea>
                </div>
                <div class=" col-6 mt-3">
                    <label class="form-label">Notif Image</label>
                    <input type="text" name="notif_image" class="form-control" required>
                </div>
                <div class=" col-6 mt-3">
                    <label class="form-label">Durasi Notif</label>
                    <input type="date" name="durasi_notif" class="form-control" required>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
