@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Edit Checklist Listrik Detail</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('listrikdetails.update', $listrikdetail->id_eng_listrik) }}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Nomer Checklist Listrik</label>
                        <input type="text" name="no_checklist_listrik" value="{{ $listrikdetail->no_checklist_listrik }}" class="form-control" required>
                    </div>
                    <div class=" col-6">
                        <label class="form-label">Nilai</label>
                        <input type="text" name="nilai" value="{{ $listrikdetail->nilai}}" class="form-control" required>
                    </div>
                    <div class=" col-6">
                        <label class="form-label">Hasil</label>
                        <input type="date" name="hasil" value="{{ $listrikdetail->hasil }}" class="form-control" required>
                    </div>
                    <div class=" col-6">
                        <label class="form-label">Keterangan</label>
                        <input type="time" name="keterangan" value="{{ $listrikdetail->keterangan }}" class="form-control" required>
                    </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
