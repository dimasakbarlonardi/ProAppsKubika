@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Edit Jenis Pekerjaan</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('jenispekerjaans.update', $jenispekerjaan->id_jenis_pekerjaan) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">Jenis Pekerjaan</label>
                    <input type="text" name="jenis_pekerjaan" value="{{ $jenispekerjaan->jenis_pekerjaan }}" class="form-control">
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
