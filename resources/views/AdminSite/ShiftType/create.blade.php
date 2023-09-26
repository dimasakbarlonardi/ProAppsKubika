@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="my-3 breadcrumb">
                            <li class="breadcrumb-item text-white"> <a href="{{ route('shifttype.index') }}"
                                    class="text-white"> List Shift Type </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Shift Type</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('shifttype.store') }}" id="form-shift-type">
                @csrf
                <div class="row">
                    <div class="col-7 mb-3">
                        <label class="form-label">Shift Name</label>
                        <input type="text" name="shift" class="form-control" required>
                    </div>
                    <div class="col-3 mb-3">
                        <label class="form-label">Shift Code</label>
                        <input type="text" name="kode_shift" class="form-control" required>
                    </div>
                    <div class="col-2 mb-3">
                        <label class="form-label">Pick Color</label>
                        <input type="color" name="color" class="form-control" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">Checkin</label>
                        <input type="time" onchange="modalTotalHour()" name="checkin" class="form-control" id="checkin"
                            required>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Checkout</label>
                        <input type="time" onchange="modalTotalHour()" name="checkout" class="form-control"
                            id="checkout" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">Type</label>
                        <select name="work_hour" id="work-hour" onchange="modalTotalHour()" class="form-control">
                            <option value="8">6 HK + 1 OFF</option>
                            <option value="12">4 HK + 2 OFF</option>
                            <option value="9">5 HK + 2 OFF</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" id="input-work-hour" name="work_hour">
                <div class="mt-5">
                    <a class="text-white btn btn-danger ml-5" href="{{ route('shifttype.index') }}"
                        style="float: right; margin-left: 10px;">Cancel</a>
                    <button type="button" onclick="onSubmit()" class="btn btn-primary"
                        style="float: right;">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" crossorigin="anonymous"></script>
    <script>
        function modalTotalHour() {
            var valuestart = $("#checkin").val();
            var workHour = $("#work-hour").val();

            var startDateTime = `2023-09-26 ${valuestart}`;
            var endDateTime = moment(startDateTime, "YYYY-MM-DD hh:mm:ss")
                .add(workHour, 'hours')
                .format('YYYY-MM-DD HH:mm:ss');

            d = endDateTime.split(' ')[1];
            var splitValueStop = d.split(":");

            var endHour = splitValueStop[0];
            var endMinute = splitValueStop[1];

            $("#checkout").val(`${endHour}:${endMinute}`)
        }

        function onSubmit() {
            var workHour = $("#work-hour").val();

            var result = confirm(`Apakah anda yakin jumlah jam kerja ${workHour} jam dan 1 jam istirahat?`);
            $('#input-work-hour').val(workHour - 1);

            if (result == true) {
                $( "#form-shift-type" ).trigger( "submit" );
            }
        }
    </script>
@endsection
