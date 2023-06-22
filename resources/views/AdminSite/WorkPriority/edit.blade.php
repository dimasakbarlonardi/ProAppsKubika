@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('workprioritys.index')}}" class="text-white"> List Work Priority </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Work Priority</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('workprioritys.update', $workpriority->id_work_priority) }}">
                @method('PUT')
                @csrf
                <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Work Priority</label>
                    <input type="text" name="work_priority" value="{{$workpriority->work_priority}}" class="form-control">
                </div>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger"><a class="text-white" href="{{ route('workprioritys.index')}}">Cancel</a></button>
                </div>
            </form>
        </div>
    </div>
@endsection
