@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Edit Divisi</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('divisis.update', $divisi->id_divisi) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">ID Divisi</label>
                    <input type="text" name="" value="{{$divisi->id_jabatan}}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Divisi</label>
                    <input type="text" name="nama_divisi" value="" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
