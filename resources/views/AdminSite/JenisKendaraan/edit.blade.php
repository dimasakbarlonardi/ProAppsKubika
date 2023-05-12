@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Edit Jenis Kendaraan</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('jeniskendaraans.update', $jeniskendaraan->id_jenis_kendaraan) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">ID Jenis Kendaraan</label>
                    <input type="text" name="" value="{{$jeniskendaraan->id_jenis_kendaraan}}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Kendaraan</label>
                    <input type="text" name="jenis_kendaraan" value="" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
