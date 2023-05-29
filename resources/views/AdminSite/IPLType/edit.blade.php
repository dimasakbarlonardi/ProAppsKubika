@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Edit Jabatan</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('jabatans.update', $jabatan->id) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">ID Jabatan</label>
                    <input type="text" maxlength="3" name="id_ipl_type" value="{{$jabatan->id_ipl_type}}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Jabatan</label>
                    <input type="text" name="nama_ipl_type" value="{{$jabatan->nama_ipl_type}}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Jabatan</label>
                    <input type="text" name="biaya_permeter" value="{{$jabatan->biaya_permeter}}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Jabatan</label>
                    <input type="text" name="biaya_procentage" value="{{$jabatan->biaya_procentage}}" class="form-control">
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
