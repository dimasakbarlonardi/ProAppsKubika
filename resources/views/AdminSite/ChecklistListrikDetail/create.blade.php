@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Tambah Checklist Listrik Detail</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('listrikdetails.store') }}">
                @csrf
                <div class="row">
                <div class="col-6">
                    <label class="form-label">Nomer Checklist Listrik</label>
                    <input type="text" name="no_checklist_listrik" class="form-control" required>
                </div>
                <div class=" col-6">
                    <label class="form-label">Nilai</label>
                    <input type="text" name="nilai" class="form-control" required>
                </div>
                <div class=" col-6">
                    <label class="form-label">Hasil</label>
                    <input type="date" name="hasil" class="form-control" required>
                </div>
                <div class=" col-6">
                    <label class="form-label">Keterangan</label>
                    <input type="time" name="keterangan" class="form-control" required>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
