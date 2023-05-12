@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Edit Role</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('roles.update', $role->id) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Role</label>
                    <input type="text" name="nama_role" value="{{ $role->nama_role }}" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
