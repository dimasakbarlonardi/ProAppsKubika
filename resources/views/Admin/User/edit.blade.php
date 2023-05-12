@extends('layouts.master')

@section('header')
    Create User
@endsection

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
            <form method="post" action="{{ route('logins.update', $login->id) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" value="{{ $login->name }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" name="email" value="{{ $login->email }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">No HP</label>
                    <input type="text" name="no_hp" value="{{ $login->no_hp }}" class="form-control" required>
                </div>
                <div class="mb-5">
                    <label class="form-label">ID Site</label>
                    <select class="form-control" name="id_site" required>
                        <option selected disabled>-- Pilih Site --</option>
                        @foreach ($sites as $site)
                            <option value="{{ $site->id_site }}" {{ $site->id_site == $login->id_site ? 'selected' : '' }}>{{ $site->nama_site }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
