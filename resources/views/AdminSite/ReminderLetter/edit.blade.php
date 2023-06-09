@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Edit Reminder Letter</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('reminders.update', $reminder->id_reminder_letter) }}">
                @method('PUT')
                @csrf
                <div class="row">
                <div class="col-6">
                    <label class="form-label"><b>ID Reminder Letter</label>
                    <input type="text" value="{{$reminder->id_reminder_letter}}" class="form-control" readonly></b>
                </div>
                </div>
                <div class="row">
                <div class="col-6">
                    <label class="form-label">Reminder Letter</label>
                    <input type="text" name="reminder_letter" value="{{$reminder->reminder_letter}}" class="form-control">
                </div>
                <div class="col-6">
                    <label class="form-label">Durasi Reminder Letter</label>
                    <input type="text" name="durasi_reminder_letter" value="{{$reminder->durasi_reminder_letter}}" class="form-control">
                </div>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
