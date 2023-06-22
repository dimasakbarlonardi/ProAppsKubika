@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('jeniskendaraans.index')}}" class="text-white"> List Jenis Kendaraan </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Jenis Kendaraan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('jeniskendaraans.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Jenis Kendaraan</label>
                    <input type="text" name="jenis_kendaraan" class="form-control" required>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('jeniskendaraans.index')}}">Cancel</a></button>
                </div>
            </form>
        </div>
    </div>
@endsection
