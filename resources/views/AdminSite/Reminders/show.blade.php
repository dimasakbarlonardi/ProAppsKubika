@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-3">
            <div class="d-flex align-items-center">
                <a href="{{ route('reminders.index') }}" class="btn btn-falcon-default btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div class="ml-3">Create Schedule Security</div>
            </div>
        </div>
        <div class="p-5">
            <div class="mb-3">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Reminder</label>
                        <input type="text" name="reminder_name" value="{{ $reminder->reminder_name }}" class="form-control" disabled>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Reminder Date</label>
                        <input class="form-control" type="text" value="{{ HumanDate($reminder->reminder_date) }}" name="reminder_date" aria-describedby="basic-addon2"
                            disabled>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Remind me before</label>
                        <div class="input-group mb-3">
                            <input class="form-control" value="{{ $reminder->remind_before }}" type="text" name="remind_before" aria-describedby="basic-addon2"
                                disabled>
                            <span class="input-group-text text-primary" id="basic-addon2"> Days before event</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Reminder To</label>
                        <input class="form-control" type="text" value="{{ $reminder->WorkRelation->work_relation }}" name="reminder_date" aria-describedby="basic-addon2"
                            disabled>
                    </div>
                </div>
            </div>
            <div class="mt-5 modal-footer">
                <button class="btn btn-danger ml-3">
                    <a class="text-white" href="{{ route('reminders.index') }}">Back</a></button>
            </div>

        </div>
    </div>
@endsection
