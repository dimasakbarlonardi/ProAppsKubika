@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Pindah Kepemilikan Unit</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('deleteKepemilikanUnit', $kepemilikans->id_pemilik)}}">
            @method('POST')
                @csrf
                <div class="mb-5">
                    <div class="row">
                        <div class="col-6 mb-3 mt-2 ">
                            <label class="form-label">Tanggal Keluar</label>
                            <input type="date" name="tgl_keluar" class="form-control" >
                        </div>
                        <div class="col-6 mb-3 mt-2 ">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" required>
                        </div>
                    </div>
                <div class="mt-5">
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('perubahanunits.index')}}">Back</a></button>
                    <button type="submit" class="btn btn-primary">Pindah</button>
                </div>
            </form>
        </div>
    </div>
@endsection
