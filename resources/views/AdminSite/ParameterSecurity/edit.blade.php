@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('Parameter-Security.index')}}" class="text-white"> List Security Inspection Parameter </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Security Inspection Parameter</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('Parameter-Security.update', $ParameterSecurity->id) }}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-6 mt-3">
                        <label class="form-label">Engineering Inspection Parameter</label>
                        <input type="text" name="name_parameter_security" value="{{ $ParameterSecurity->name_parameter_security}}" class="form-control" required>
                    </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button class="btn btn-danger"><a class="text-white" href="{{ route('Parameter-Security.index')}}">Cancel</a></button>
                </div>
            </form>
        </div>
    </div>
@endsection
