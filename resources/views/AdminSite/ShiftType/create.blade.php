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
            <form method="post" action="{{ route('shifttype.store') }}">
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
                        <input type="time" name="checkin" class="form-control" id="checkin" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Checkout</label>
                        <input type="time" name="checkout" class="form-control" id="checkout" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">Type</label>
                        <select name="" id="" class="form-control">
                            <option value="">6 HK + 1 OFF</option>
                            <option value="">4 HK + 2 OFF</option>
                            <option value="">5 HK + 2 OFF</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" id="work-hour" name="work_hour">
                <div class="mt-5">
                    <a class="text-white btn btn-danger ml-5" href="{{ route('shifttype.index') }}"
                        style="float: right; margin-left: 10px;">Cancel</a>
                    <button type="button" onclick="modalTotalHour()" class="btn btn-primary"
                        style="float: right;">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>

        function modalTotalHour() {
            var valuestart = $("#checkin").val();
            var valuestop = $("#checkout").val();

            var nowDate = new Date();
            var newDateObj = new Date(nowDate.getTime() + valuestart*60000);

            alert(newDateObj);

            // const d = new Date();
            // d.setHours(d.getHours() + 12);

            // alert(d)

            // if (valuestart > valuestop) {
            //     dt1 = new Date(`October 13, 2014 ${valuestart}`);
            //     dt2 = new Date(`October 14, 2014 ${valuestart}`);
            //     console.log(diff_hours(dt1, dt2));
            // } else {
            //     dt1 = new Date("October 13, 2014 21:00:00");
            //     dt2 = new Date("October 14, 2014 06:13:00");
            //     console.log(diff_hours(dt1, dt2));
            // }
            // if (hourDiff < 0) {
            //     hourDiff = 24 + hourDiff;
            // }


            // var totalHour = valuestart + valuestop;

            // console.log(totalHour);




            // if (timeEnd > timeStart) {


            // } else {
            //     var hourDiff = timeStart - timeEnd;
            // }

            // var workHour = hourDiff - 1;

            // var result = confirm(`Apakah anda yakin jumlah jam kerja ${workHour} jam dan 1 jam istirahat?`);

            // if (result == true) {
            //     var test = `Apakah anda yakin jumlah kerja ${workHour} jam?`;
            // } else {
            //     var test = `Apakah anda yakin jumlah kerja ${workHour} jam?`;
            // }
            // $('#work-hour').val(workHour);
        }
    </script>
@endsection
