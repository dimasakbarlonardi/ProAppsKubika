@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('lifts.index')}}" class="text-white"> List Lift </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Lift</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('lifts.update', $lift->id_hk_lift) }}">
                @method('PUT')
                @csrf
                <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Nama Lift</label>
                    <input type="text" name="nama_hk_lift" value="{{$lift->nama_hk_lift}}" class="form-control">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" value="{{$lift->subject}}" class="form-control">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Periode</label>
                    <input type="text" name="periode" value="{{$lift->periode}}" class="form-control">
                </div>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('lifts.index')}}">Cancel</a></button>
                </div>
            </form>
        </div>
    </div>
@endsection
