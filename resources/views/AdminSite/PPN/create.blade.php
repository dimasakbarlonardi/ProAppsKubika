@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('ppns.index') }}" class="text-white">
                                    List PPN</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create PPN</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('ppns.store') }}">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Nama PPN</label>
                        <input type="text" name="nama_ppn" class="form-control" required>
                    </div>
                    <div class="mt-5" id="biaya">
                        <h6>ISI BIAYA</h6>
                        <hr>
                        <div class="mb-3">
                            <div class="col-6" id="biaya_procentage">
                                <label class="form-label">Biaya Procentage</label>
                                <div class="input-group mb-3"><input class="form-control" type="text"
                                        name="biaya_procentage"><span
                                        class="input-group-text text-primary" id="basic-addon2">%</span></div>
                            </div>
                            <div class="mt-5">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button class="btn btn-danger"><a class="text-white"
                                        href="{{ route('ppns.index') }}">Cancel</a></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
