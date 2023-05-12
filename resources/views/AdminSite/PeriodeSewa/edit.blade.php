@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Edit Periode Sewa</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('sewas.update', $sewa->id_periode_sewa) }}">
                @method('PUT')
                @csrf
                <div class="mb-3 col-3">
                    <label class="form-label">Nama Periode Sewa</label>
                    <input type="text" name="periode_sewa" value="" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
