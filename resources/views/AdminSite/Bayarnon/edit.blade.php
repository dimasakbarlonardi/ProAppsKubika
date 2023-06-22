@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Edit Pembayaran</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('bayarnons.update', $bayarnon->id_bayarnon) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label">Pembayaran</label>
                    <input type="text" name="bayarnon" value="{{ $bayarnon->bayarnon }}" class="form-control">
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('bayarnons.index')}}">Cancel</a></button>
                </div>
            </form>
        </div>
    </div>
@endsection