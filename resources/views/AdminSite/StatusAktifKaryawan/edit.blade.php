@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Edit Status Aktif Karyawan</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('statusaktifkaryawans.update', $statusaktifkaryawan->id_status_aktif_karyawan) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">Status Aktif Karyawan</label>
                    <input type="text" name="status_aktif_karyawan" value="{{$statusaktifkaryawan->status_aktif_karyawan}}" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
