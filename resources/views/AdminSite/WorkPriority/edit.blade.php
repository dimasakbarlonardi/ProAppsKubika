@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-white">Edit Work Priority</h6>
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
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
