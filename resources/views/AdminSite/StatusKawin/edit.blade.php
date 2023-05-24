@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Edit Status Kawin</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('statuskawins.update', $statuskawin->id_status_kawin) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">Status Kawin</label>
                    <input type="text" name="status_kawin" value="{{$statuskawin->status_kawin}}" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
