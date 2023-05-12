@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Buat Menu</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('menus.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Menu</label>
                    <input type="text" name="caption" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Route Name</label>
                    <input type="text" name="route_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Icon</label>
                    <input type="text" name="icon" class="form-control" required>
                </div>
                <input type="hidden" name="heading_id" value="{{ $id }}">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
