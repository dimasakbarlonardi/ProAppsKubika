@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('reminders.index')}}" class="text-white"> List Reminder Letter</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Reminder Letter</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('reminders.store') }}">
                @csrf
                <div class="row">
                <div class="col-6">
                    <label class="form-label">Reminder Letter</label>
                    <input type="text" name="reminder_letter" class="form-control" required>
                </div>
                <div class=" col-6">
                    <label class="form-label">Durasi Reminder Letter</label>
                    <div class="input-group mb-3"><input class="form-control" type="text" name="reminder_letter" aria-describedby="basic-addon2" required><span class="input-group-text text-primary" id="basic-addon2">/Hari</span></div>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button class="btn btn-danger"><a class="text-white" href="{{ route('reminders.index')}}">Cancel</a></button>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
