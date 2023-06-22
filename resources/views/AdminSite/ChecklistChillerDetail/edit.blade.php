@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Edit Checklist Chiller Detail</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('chillerdetails.update', $chillerdetail->id_eng_chiller) }}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Nomer Checklist Chiller</label>
                        <input type="text" name="no_checklist_chiller" value="{{ $chillerdetail->no_checklist_chiller }}" class="form-control" required>
                    </div>
                    <div class=" col-6">
                        <label class="form-label">IN / OUT</label>
                        <input type="text" name="in_out" value="{{ $chillerdetail->in_out}}" class="form-control" required>
                    </div>
                    <div class=" col-6">
                        <label class="form-label">Check Point</label>
                        <input type="date" name="check_point" value="{{ $chillerdetail->check_point }}" class="form-control" required>
                    </div>
                    <div class=" col-6">
                        <label class="form-label">Keterangan</label>
                        <input type="time" name="keterangan" value="{{ $chillerdetail->keterangan }}" class="form-control" required>
                    </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
