@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('workrelations.index')}}" class="text-white"> List Work Relation </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Work Relation</li>
                        </ol>
                    </nav>
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
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('workrelations.index')}}">Cancel</a></button>
                </div>
            </form>
        </div>
    </div>
@endsection
