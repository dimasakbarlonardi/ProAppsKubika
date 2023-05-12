@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Edit Jenis Kelamin</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('genders.update', $gender->id_jenis_kelamin) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">ID Jenis Kelamin</label>
                    <input type="text" name="" value="{{$gender->id_jenis_kelamin}}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <input type="text" name="jenis_kelamin" value="" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
