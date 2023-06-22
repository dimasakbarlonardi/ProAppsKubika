@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('penempatans.index')}}" class="text-white"> List Penempatan </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Penempatan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('penempatans.store') }}">
                @csrf
             <div class="mb-3 col-10">
              <div class="row">
                <div class="col-10 ">
                    <label class="form-label">ID Penempatan</label>
                    <input type="text" maxlength="3" name="id_penempatan" class="form-control" required>
                </div>
                <div class="col-10 ">
                    <label class="form-label">Lokasi Penempatan</label>
                    <input type="text" name="lokasi_penempatan" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="mt-5">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('penempatans.index')}}">Cancel</a></button>
            </div>
            </form>
        </div>
    </div>
@endsection
