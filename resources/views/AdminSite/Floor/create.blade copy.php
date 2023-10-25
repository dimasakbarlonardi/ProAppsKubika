@extends('layouts.master')

@section('content')
<div class="card">
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="{{ route('towers.index') }}" class="btn btn-falcon-default btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <div class="ml-3">Create Tower</div>
        </div>
    </div>
</div>
    <div class="p-5">
        <form method="post" action="{{ route('towers.store') }}">
            @csrf
            <div class="mb-3">

                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Nama Site</label>
                        <input type="text" value="Park Royale" class="form-control" readonly>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Nama Tower</label>
                        <input type="text" name="nama_tower" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Jumlah Lantai</label>
                        <input type="text" name="jumlah_lantai" class="form-control" required>
                    </div>

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