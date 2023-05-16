@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Edit Departemen</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('departemens.update', $departemen->id_departemen) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">ID Departemen</label>
                    <input type="text" name="" value="{{$departemen->id_departemen}}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Departemen</label>
                    <input type="text" name="nama_departemen" value="" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
