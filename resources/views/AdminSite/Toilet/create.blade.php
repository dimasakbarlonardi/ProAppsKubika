@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('housekeeping.index')}}" class="text-white"> List Inspection House Keeping </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Inspection House Keeping</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('housekeeping.store') }}">
                @csrf
              <div class="row">
                <div class="col-6 mb-3 ">
                    <label class="form-label">Inspection House Keeping Parameter</label>
                    <input type="text" name="nama_hk_toilet" class="form-control" required>
                </div>
              </div>
            <div class="mt-5">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('housekeeping.index')}}">Cancel</a></button>
            </div>
            </form>
        </div>
    </div>
@endsection
