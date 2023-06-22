@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('statuskaryawans.index')}}" class="text-white"> List Status Karyawan </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Status Karyawan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('statuskaryawans.store') }}">
                @csrf
                <div class="mb-3 col-10">
                <div class="row">
                <div class="col-10 ">
                    <label class="form-label">Status Karyawan</label>
                    <input type="text" name="status_karyawan" class="form-control" required>
                </div>
                </div>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('statuskaryawans.index')}}">Cancel</a></button>
                </div>
            </form>
        </div>
    </div>
@endsection
