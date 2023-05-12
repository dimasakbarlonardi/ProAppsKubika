@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Tambah Akun</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('users.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">ID user</label>
                    <input type="text" name="id_user" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama_user" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" name="login_user" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password_user" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">ID Status User</label>
                    <input type="text" name="id_status_user" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">ID Role HDR</label>
                    <input type="text" name="id_role_hdr" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
