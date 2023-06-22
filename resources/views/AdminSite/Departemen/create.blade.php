@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('departemens.index')}}" class="text-white"> List Departemen </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Departemen</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('departemens.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">ID Departemen</label>
                    <input type="text" maxlength="3" name="id_departemen" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Departemen</label>
                    <input type="text" name="nama_departemen" class="form-control" required>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('departemens.index')}}">Cancel</a></button>
                </div>
            </form>
        </div>
    </div>
@endsection
