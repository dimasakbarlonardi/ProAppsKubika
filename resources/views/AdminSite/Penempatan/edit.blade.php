@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Edit Penempatan</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('penempatans.update', $penempatan->id) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">ID Penempatan</label>
                    <input type="text" name="id_penempatan" maxlength="3" value="{{$penempatan->id_penempatan}}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Lokasi Penempatan</label>
                    <input type="text" name="lokasi_penempatan" value="{{$penempatan->lokasi_penempatan}}" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
