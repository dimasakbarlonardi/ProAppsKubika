@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"  aria-current="page">Alasan Tidak Perpanjang
                                Unit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form action="{{ route('offtenantunits.store') }}" method="post">
                @method('POST')
                @csrf
                <div class="row">
                    {{-- <div class="col-6">
                        <label class="col-form-label">Tanggal
                            masuk:</label>
                        <input class="form-control" type="date" name="tgl_masuk" value="{{ $tenantunit->tgl_masuk }}"
                            id="tgl_masuk_edit">
                    </div> --}}
                    <div class="col-6">
                        <label class="col-form-label">Tanggal
                            keluar:</label>
                        <input class="form-control" type="date" name="tgl_keluar" 
                            required>
                    </div>
                    <div class="col-6">
                        <label class="col-form-label">Keterangan:</label>
                        <input class="form-control" type="text" name="keterangan" 
                            required>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        {{-- <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('statustinggals.index')}}">Cancel</a></button> --}}
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

