@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Edit Status Karyawan</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('statuskaryawans.update', $statuskaryawan->id_status_karyawan) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">Status Karyawan</label>
                    <input type="text" name="status_karyawan" value="{{$statuskaryawan->status_karyawan}}" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
