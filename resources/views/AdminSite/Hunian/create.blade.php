@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Tambah Lantai</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('hunians.store') }}">
                @csrf
                <div class="mb-3 col-10">
                <div class="row">
                <div class="col-10 ">
                    <label class="form-label">Nama Hunian</label>
                    <input type="text" name="nama_hunian" class="form-control" required>
                </div>
                </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
