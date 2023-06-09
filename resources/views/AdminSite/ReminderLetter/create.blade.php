@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Tambah Reminder Letter</h6>
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
                    <input type="text" name="durasi_reminder_letter" class="form-control" required>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
