@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('statusaktifkaryawans.index')}}" class="text-white"> List Status Aktif Karyawan </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Status Aktif Karyawan</li>
                        </ol>
                    </nav>
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
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('statusaktifkaryawans.index')}}">Cancel</a></button>
                </div>
            </form>
        </div>
    </div>
@endsection
