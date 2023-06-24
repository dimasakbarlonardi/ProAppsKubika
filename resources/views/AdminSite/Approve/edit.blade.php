@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Edit Approve</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('updateSystemApprove', $approve->id_approval_subject) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Approve 1</label>
                            <input type="text" name="nama_agama" value="{{ $approve->nama_subject }}" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Approve 2</label>
                            <input type="text" name="nama_agama" value="{{ $approve->nama_subject }}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
