@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('statustinggals.index')}}" class="text-white"> List Status Tinggal </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Status Tinggal</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('statustinggals.update', $statustinggal->id_status_tinggal) }}">
                @method('PUT')
                @csrf   
                <div class="col-6">
                    <label class="form-label">Status Tinggal</label>
                    <input type="text" name="status_tinggal" value="{{ $statustinggal->status_tinggal}}" class="form-control">
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('statustinggals.index')}}">Cancel</a></button>
                </div>
            </form>
        </div>
    </div>
@endsection
