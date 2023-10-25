@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('sewas.index') }}" class="btn btn-falcon-default btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div class="ml-3">Edit Periode Sewa</div>
            </div>
        </div>
    </div>
        <div class="p-5">
            <form method="post" action="{{ route('sewas.update', $sewa->id_periode_sewa) }}">
                @method('PUT')
                @csrf
                <div class="mb-3 col-3">
                    <label class="form-label">Nama Periode Sewa</label>
                    <input type="text" name="periode_sewa" value="{{ $sewa->periode_sewa}}" class="form-control">
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('sewas.index')}}">Cancel</a></button>
                </div>
            </form>
        </div>
    </div>
@endsection
