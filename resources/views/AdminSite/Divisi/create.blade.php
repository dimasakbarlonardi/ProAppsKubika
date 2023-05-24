@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Tambah Divisi</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('divisis.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">ID Divisi</label>
                    <input type="text" maxlength="3" name="id_divisi" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Divisi</label>
                    <input type="text" name="nama_divisi" class="form-control" required>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
