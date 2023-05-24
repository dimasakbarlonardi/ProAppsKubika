@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Tambah Jabatan</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('jabatans.store') }}">
                @csrf
                <div class="mb-3 col-10">
                    <label class="form-label">ID Jabatan</label>
                    <input type="text" maxlength="3" name="id_jabatan" class="form-control" required>
                </div>
                <div class="mb-3 col-10">
                    <label class="form-label">Nama Jabatan</label>
                    <input type="text" name="nama_jabatan" class="form-control" required>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
