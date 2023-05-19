@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Tambah Agama</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('agamas.store') }}">
                @csrf
                <div class="mb-3 col-10">
                <div class="row">
                <div class="col-10 ">
                    <label class="form-label">Agama</label>
                    <input type="text" name="nama_agama" class="form-control" required>
                </div>
                </div>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
