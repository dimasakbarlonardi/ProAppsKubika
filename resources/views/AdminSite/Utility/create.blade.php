@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Tambah Utility</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('utilitys.store') }}">
                @csrf
                <div class="mb-3">
                <div class="row">
                <div class="col-6 ">
                    <label class="form-label">Nama Utility</label>
                    <input type="text" name="nama_utility" class="form-control" required>
                </div>
                <div class="col-6 ">
                    <label class="form-label">Biaya Admin</label>
                    <input type="text" name="biaya_admin" class="form-control" required>
                </div>
                <div class="col-6 ">
                    <label class="form-label">Biaya Abodemen</label>
                    <input type="text" name="biaya_abodemen" class="form-control" required>
                </div>
                <div class="col-6 ">
                    <label class="form-label">Biaya Tetap</label>
                    <input type="text" name="biaya_tetap" class="form-control" required>
                </div>
                <div class="col-6 ">
                    <label class="form-label">Biaya M3</label>
                    <input type="text" name="biaya_m3" class="form-control" required>
                </div>
                <div class="col-6 ">
                    <label class="form-label">Biaya PJU</label>
                    <input type="text" name="biaya_pju" class="form-control" required>
                </div>
                <div class="col-6 ">
                    <label class="form-label">Biaya PPJ</label>
                    <input type="text" name="biaya_ppj" class="form-control" required>
                </div>
                </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
