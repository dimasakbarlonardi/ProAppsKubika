@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-aut6">
                     
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('ppns.update', $ppn->id_ppn) }}">
                @method('PUT')
                @csrf
                <div class="row mt-3">
                <div class="col-6">
                    <label class="form-label">Nama PPN</label>
                    <input type="text" name="nama_ppn" value="{{$ppn->nama_ppn}}" class="form-control">
                </div>
                <div class="mt-5" id="biaya">
                    <h6>ISI BIAYA</h6>
                    <hr>
                <div class="col-6" id="biaya_procentage">
                    <label class="form-label">Biaya Procentage</label>
                    <div class="input-group mb-3"><input class="form-control" nama="biaya_procentage" type="text" value="{{$ppn->biaya_procentage}}" name="biaya_procentage" aria-describedby="basic-addon2" /><span class="input-group-text text-primary" id="basic-addon2">%</span></div>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button class="btn btn-danger"><a class="text-white" href="{{route('ipltypes.index')}}">Cancel</a></button>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
