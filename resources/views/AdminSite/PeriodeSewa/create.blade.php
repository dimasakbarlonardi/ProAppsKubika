@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Tambah Periode Sewa</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('sewas.store') }}">
                @csrf
                <div class="mb-3 col-10">
                <div class="row">
                    <div class="col-2 ">
                        <label class="form-label">ID Periode Sewa</label>
                        <input type="text" value="{{$current_id}}" class="form-control" required>
                    </div>
                </div>
                <div class="col-6 ">
                    <label class="form-label">Periode Sewa</label>
                    <input type="text" name="periode_sewa" class="form-control" required>
                </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
