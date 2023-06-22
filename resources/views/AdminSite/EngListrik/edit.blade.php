@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('englistriks.index')}}" class="text-white"> List Engeneering Listrik </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Engeneering Listrik</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('englistriks.update', $englistrik->id_eng_listrik) }}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Nama Engeneering Listrik</label>
                        <input type="text" name="nama_eng_listrik" value="{{ $englistrik->nama_eng_listrik}}" class="form-control" required>
                    </div>
                    <div class=" col-6">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" value="{{ $englistrik->subject}}" class="form-control" required>
                    </div>
                    <div class=" col-6">
                        <label class="form-label">DSG</label>
                        <input type="text" name="dsg" value="{{ $englistrik->dsg}}" class="form-control" required>
                    </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button class="btn btn-danger"><a class="text-white" href="{{ route('englistriks.index')}}">Cancel</a></button>
                </div>
            </form>
        </div>
    </div>
@endsection
