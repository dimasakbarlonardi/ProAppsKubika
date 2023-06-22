@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Edit Monthly Reminder Letter </h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('finmonthlyreminderletters.update', $reminderletter->id_fin_reminder_letter) }}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-3">
                        <label class="form-label"><b>ID Reminder Letter</label>
                        <input type="text" value="{{$reminderletter->id_fin_reminder_letter}}" class="form-control" readonly></b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">No Monthly Invoice</label>
                        <input type="text" name="no_monthly_invoice" value="{{ $reminderletter->no_monthly_invoice}}" class="form-control" required>
                    </div>
                    <div class=" col-6">
                        <label class="form-label">No Reminder Letter</label>
                        <input type="text" name="no_reminder_letter" value="{{ $engdeep->no_reminder_letter}}" class="form-control" required>
                    </div>
                    <div class=" col-6">
                        <label class="form-label">Tanggal Reminder Letter</label>
                        <input type="text" name="tgl_reminder_letter" value="{{ $engdeep->tgl_reminder_letter}}" class="form-control" required>
                    </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
