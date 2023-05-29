@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Edit Work Relation</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('workrelations.update', $workrelation->id_work_relation) }}">
                @method('PUT')
                @csrf
                <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Work Relation</label>
                    <input type="text" name="work_relation" value="{{$workrelation->work_relation}}" class="form-control">
                </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
