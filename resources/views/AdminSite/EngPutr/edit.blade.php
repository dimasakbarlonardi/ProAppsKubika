@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('engputrs.index')}}" class="text-white"> List Engeneering Putr </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Engeneering Putr</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('engputrs.update', $engputr->id_eng_putr) }}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">Nama Engeneering Putr</label>
                        <input type="text" name="nama_eng_putr" value="{{ $engputr->nama_eng_putr}}" class="form-control" required>
                    </div>
                    <div class=" col-6 mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" value="{{ $engputr->subject}}" class="form-control" required>
                    </div>
                    <div class=" col-6 mb-3">
                        <label class="form-label">DSG</label>
                        <input type="text" name="dsg" value="{{ $engputr->dsg}}" class="form-control" required>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button class="btn btn-danger"><a class="text-white" href="{{ route('engputrs.index')}}">Cancel</a></button>
                    </div>
            </form>
        </div>
    </div>
@endsection
