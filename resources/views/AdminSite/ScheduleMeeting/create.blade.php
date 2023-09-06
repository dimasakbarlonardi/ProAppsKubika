@extends('layouts.master')

@section('css')
    <link href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Create Schedule Meeting</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('schedulemeeting.store') }}">
                @csrf
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">Meeting</label>
                        <input type="text" name="meeting" class="form-control" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>
                    <div class=col-6 mb-3>
                        <label class="form-label" for="timepicker1">Start Time</label>
                        <input class="form-control datetimepicker" name="time_in" id="timepicker1" type="text" placeholder="H:i" 
                            data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' />
                    </div>
                    <div class=col-6 mb-3>
                        <label class="form-label" for="timepicker1">End Time</label>
                        <input class="form-control datetimepicker" name="time_out" id="timepicker1" type="text" placeholder="H:i" 
                            data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' />
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Location</label>
                        <select class="form-control" name="id_room" required>
                            <option selected disabled>-- Select Location --</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id_room }}">{{ $room->nama_room }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
@endsection