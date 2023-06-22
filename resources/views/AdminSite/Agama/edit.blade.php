@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('agamas.index')}}" class="text-white"> List Agama </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Agama</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('agamas.update', $agama->id_agama) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">Agama</label>
                    <input type="text" name="nama_agama" value="{{ $agama->nama_agama }}" class="form-control">
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('agamas.index')}}">Cancel</a></button>
                </div>
            </form>
        </div>
    </div>
@endsection
