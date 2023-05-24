@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Edit ID Card</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('idcards.update', $idcard->id_card_type) }}">
                @method('PUT')
                @csrf
                {{-- <div class="mb-3">
                    <label class="form-label">ID Lantai</label>
                    <input type="text" name="id_card_type" value="" class="form-control">
                </div> --}}
                <div class="mb-3">
                    <label class="form-label">ID Card Name</label>
                    <input type="text" name="card_id_name" value="{{ $idcard->card_id_name }}" class="form-control">
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
