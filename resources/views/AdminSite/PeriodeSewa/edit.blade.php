@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('sewas.index')}}" class="text-white"> List Periode Sewa </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Periode Sewa</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('sewas.update', $sewa->id_periode_sewa) }}">
                @method('PUT')
                @csrf
                <div class="mb-3 col-3">
                    <label class="form-label">Nama Periode Sewa</label>
                    <input type="text" name="periode_sewa" value="{{ $sewa->periode_sewa}}" class="form-control">
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('sewas.index')}}">Cancel</a></button>
                </div>
            </form>
        </div>
    </div>
@endsection
