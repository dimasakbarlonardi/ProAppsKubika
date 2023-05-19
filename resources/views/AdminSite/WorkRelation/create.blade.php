@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Tambah Work Relation</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('workrelations.store') }}">
                @csrf
                <div class="mb-3 col-10">
                <div class="row">
                <div class="col-6 ">
                    <label class="form-label">Work Relation</label>
                    <input type="text" name="work_relation" class="form-control" required>
                </div>
                </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
