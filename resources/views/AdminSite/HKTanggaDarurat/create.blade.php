@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('hktanggadarurats.index')}}" class="text-white">List Tanggga Darurat </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Tangga Darurat</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('hktanggadarurats.store') }}">
                @csrf
              <div class="row">
                <div class="col-6 mb-3 ">
                    <label class="form-label">Nama Tanggga Darurat</label>
                    <input type="text" name="nama_hk_tangga_darurat" class="form-control" required>
                </div>
                <div class="col-6 mb-3 ">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control" required>
                </div>
                <div class="col-6 mb-3 ">
                    <label class="form-label">Periode</label>
                    <input type="text" name="periode" class="form-control" required>
                </div>
              </div>
            <div class="mt-5">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('hktanggadarurats.index')}}">Cancel</a></button>
            </div>
            </form>
        </div>
    </div>
@endsection
