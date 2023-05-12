@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header bg-light py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3">Edit Tower</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('towers.update', $tower->id_tower) }}">
                @method('PUT')
                @csrf
                <div class="mb-3 col-12">
              <div class="row">
                <div class="col-4">
                    <label class="form-label">ID Tower</label>
                    <input type="text" value="{{ $tower->id_tower}}" class="form-control" readonly>
                </div>
                <div class="col-4">
                    <label class="form-label">ID Site</label>
                    <input type="text" value="{{ $tower->id_site}}" class="form-control" readonly>
                </div>
              </div>
                <div class="col-4">
                    <label class="form-label">Nama Tower</label>
                    <input type="text" name="nama_tower" value="{{ $tower->nama_tower}}" value="" class="form-control">
                </div>
                <div class="row">
                <div class="col-4">
                    <label class="form-label">Jumlah Lantai</label>
                    <input type="text" name="jumlah_lantai" value="{{ $tower->jumlah_lantai}}" class="form-control">
                </div>
                <div class="col-4">
                    <label class="form-label">Jumlah Unit</label>
                    <input type="text" name="jumlah_unit" value="{{ $tower->jumlah_unit}}" class="form-control" required>
                </div>
                <div class="col-4">
                    <label class="form-label">keterangan </label>
                    <input type="text" name="keterangan" value="{{ $tower->keterangan}}" class="form-control" >
                </div>
             </div>
          </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
