@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Tambah Room</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('rooms.store') }}">
                @csrf
                <div class="row">
                <div class="col-6">
                    <label class="form-label">ID Site</label>
                    <input type="text" value="park royale" class="form-control" required>
                </div>

                <div class="col-6 mb-3">
                    <label class="form-label">ID Tower</label>
                    <select class="form-control" name="id_tower" required>
                        <option selected disabled>-- Pilih Tower --</option>
                        @foreach ($towers as $tower)
                        <option value="{{ $tower->id_tower }}">{{ $tower->nama_tower }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 mb-3">
                    <label class="form-label">ID Lantai</label>
                    <select class="form-control" name="id_lantai" required>
                        <option selected disabled>-- Pilih Lantai --</option>
                        @foreach ($floors as $floor)
                        <option value="{{ $floor->id_lantai }}">{{ $floor->nama_lantai }}</option>
                        @endforeach
                    </select>
                </div>
                </div>
                <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Barcode Room</label>
                    <input type="text" name="barcode_room" class="form-control" required>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Nama Room</label>
                    <input type="text" name="nama_room" class="form-control" required>
                </div>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
