@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('engahus.index')}}" class="text-white"> List Engeneering AHU </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Engeneering AHU</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('engahus.update', $engahu->id_eng_ahu) }}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-6 mt-3">
                        <label class="form-label">No Engeneering AHU</label>
                        <input type="text" name="nama_eng_ahu" value="{{ $engahu->nama_eng_ahu}}" class="form-control" required>
                    </div>
                    <div class="col-6 mt-3">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" value="{{ $engahu->subject}}" class="form-control" required>
                    </div>
                    <div class="col-6 mt-3">
                        <label class="form-label">DSG</label>
                        <input type="text" name="dsg" value="{{ $engahu->dsg}}" class="form-control" required>
                    </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button class="btn btn-danger"><a class="text-white" href="{{ route('engahus.index')}}">Cancel</a></button>
                </div>
            </form>
        </div>
    </div>
@endsection
