@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Tambah Role</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('eng-bapp.store') }}">
                @csrf
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Nama Engineering BAPP</label>
                            <input type="text" name="nama_eng_bapp" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">DSG</label>
                            <input type="text" name="dsg" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
