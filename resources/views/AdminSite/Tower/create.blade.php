@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Tambah Tower</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('towers.store') }}">
                @csrf
                <div class="mb-3">
                   
                    <div class="col-6">
                        <label class="form-label">Nama Site</label>
                        <input type="text" value="Park Royale" class="form-control" readonly>
                    </div>
                   
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Nama Tower</label>
                            <input type="text" name="nama_tower" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Jumlah Lantai</label>
                            <input type="text" name="jumlah_lantai" class="form-control" required>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Jumlah Unit</label>
                            <input type="text" name="jumlah_unit" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
