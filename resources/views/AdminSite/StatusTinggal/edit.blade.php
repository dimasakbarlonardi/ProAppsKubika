@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Edit Status Tinggal</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('statustinggals.update', $statustinggal->id_status_tinggal) }}">
                @method('PUT')
                @csrf   
                <div class="mb-3">
                    <label class="form-label">Status Tinggal</label>
                    <input type="text" name="status_tinggal" value="{{ $statustinggal->status_tinggal}}" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
