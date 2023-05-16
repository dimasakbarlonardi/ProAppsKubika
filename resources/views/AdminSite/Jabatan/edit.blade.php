@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Edit Jabatan</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('jabatans.update', $jabatan->id_jabatan) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">ID Jabatan</label>
                    <input type="text" name="" value="{{$jabatan->id_jabatan}}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Jabatan</label>
                    <input type="text" name="nama_jabatan" value="" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
