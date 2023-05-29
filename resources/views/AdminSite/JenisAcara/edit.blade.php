@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Edit Jenis Acara</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('jenisacaras.update', $jenisacara->id_jenis_acara) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">ID Jenis Acara</label>
                    <input type="text" value="{{$jenisacara->id_jenis_acara}}" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Acara</label>
                    <input type="text" name="jenis_acara" value="{{$jenisacara->jenis_acara}}" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
