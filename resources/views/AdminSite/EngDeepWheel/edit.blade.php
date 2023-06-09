@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Edit Engeneering Chiller</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('engdeeps.update', $engdeep->id_eng_deep) }}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-3">
                        <label class="form-label"><b>ID Engeneering DeepWheel</label>
                        <input type="text" value="{{$engdeep->id_eng_deep}}" class="form-control" readonly></b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Nama Engeneering DeepWheel</label>
                        <input type="text" name="nama_eng_ahu" value="{{ $engdeep->nama_eng_ahu}}" class="form-control" required>
                    </div>
                    <div class=" col-6">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" value="{{ $engdeep->subject}}" class="form-control" required>
                    </div>
                    <div class=" col-6">
                        <label class="form-label">DSG</label>
                        <input type="text" name="dsg" value="{{ $engdeep->dsg}}" class="form-control" required>
                    </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
