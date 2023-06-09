@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Tambah Engeneering Listrik</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('englistriks.store') }}">
                @csrf
                <div class="row">
                <div class="col-6">
                    <label class="form-label">Nama Engeneering Listrik</label>
                    <input type="text" name="nama_eng_listrik" class="form-control" required>
                </div>
                <div class=" col-6">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control" required>
                </div>
                <div class=" col-6">
                    <label class="form-label">DSG</label>
                    <input type="text" name="dsg" class="form-control" required>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
