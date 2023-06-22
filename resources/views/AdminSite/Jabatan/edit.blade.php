@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('jabatans.index')}}" class="text-white"> List Jabatan </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Jabatan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('jabatans.update', $jabatan->id) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">ID Jabatan</label>
                    <input type="text" maxlength="3" name="id_jabatan" value="{{$jabatan->id_jabatan}}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Jabatan</label>
                    <input type="text" name="nama_jabatan" value="{{$jabatan->nama_jabatan}}" class="form-control">
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button class="btn btn-danger"><a class="text-white" href="{{ route('jabatans.index')}}">Cancel</a></button>
                </div>
            </form>
        </div>
    </div>
@endsection
