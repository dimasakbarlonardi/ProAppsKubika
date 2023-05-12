@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Edit ID Card</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('idcards.update', $idcard->card_id_name) }}">
                @method('PUT')
                @csrf
                {{-- <div class="mb-3">
                    <label class="form-label">ID Lantai</label>
                    <input type="text" name="id_card_type" value="" class="form-control">
                </div> --}}
                <div class="mb-3">
                    <label class="form-label">Card ID NamE</label>
                    <input type="text" name="card_id_name" value="" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
