@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Tambah Penempatan</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('penempatans.store') }}">
                @csrf
             <div class="mb-3 col-10">
              <div class="row">
                <div class="col-10 ">
                    <label class="form-label">ID Penempatan</label>
                    <input type="text" maxlength="3" name="id_penempatan" class="form-control" required>
                </div>
                <div class="col-10 ">
                    <label class="form-label">Lokasi Penempatan</label>
                    <input type="text" name="lokasi_penempatan" class="form-control" required>
                </div>
              </div>
            </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
