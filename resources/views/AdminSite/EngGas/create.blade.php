@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('enggases.index')}}" class="text-white"> List Engeneering Gas </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Engeneering Gas</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('enggases.store') }}">
                @csrf
                <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Nama Engeneering Gas</label>
                    <input type="text" name="nama_eng_gas" class="form-control" required>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control" required>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">DSG</label>
                    <input type="text" name="dsg" class="form-control" >
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button class="btn btn-danger"><a class="text-white" href="{{ route('enggases.index')}}">Cancel</a></button>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
