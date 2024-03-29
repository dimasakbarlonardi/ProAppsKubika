@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Tambah Checklist AHU</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('inspectionStore') }}">
                @csrf
                <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Inspection Engineering</label>
                    <input type="text" name="inspection_engineering" class="form-control" required>
                </div>  
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
