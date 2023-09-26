@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        .tscroll {
            overflow-x: scroll;
            margin-bottom: 10px;
            border: solid black 1px;
        }

        .tscroll table td:first-child {
            position: sticky;
            left: 0;
            background-color: #ddd;
        }

        .tscroll td,
        .tscroll th {
            border: solid black 1px;
            border-bottom: dashed #888 1px;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="mb-0 text-white">Work Schedules</h6>
                </div>
                <div class="col-auto d-flex">
                    <a class="btn btn-falcon-default text-600 btn-sm " href="{{ route('shifttype.create') }}">
                        <span class="fas fa-plus fs--2 me-1"></span>Add Work Schedule
                    </a>
                </div>
            </div>
        </div>
        <div class="p-5">
            <div class="table-x-scroll">
                <html>
                <div class="tscroll">
                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                @php
                                    $date = date('F Y'); //Current Month Year
                                    $dates = [];
                                    while (strtotime($date) <= strtotime(date('Y-m') . '-' . date('t', strtotime($date)))) {
                                        $month = date('F', strtotime($date)); //Day number
                                        $day_num = date('j', strtotime($date)); //Day number
                                        $day_name = date('D', strtotime($date)); //th, nd, st and rd
                                        $day = "$month $day_name $day_num";
                                        $dates[] = date('Y', strtotime($date)) . '-' . date('m', strtotime($date)) . '-' . date('d', strtotime($date));
                                        $date = date('Y-m-d', strtotime('+1 day', strtotime($date))); //Adds 1 day onto current date
                                        $weekend = $day_name == 'Sun' || $day_name == 'Sat' ? "style='background: red; color: white;'" : '';
                                        echo '<th ' . $weekend . '>' . $day . '</th>';
                                    }
                                @endphp
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($karyawans as $karyawan)
                                <tr>
                                    <td>{{ $karyawan->nama_karyawan }}</td>
                                    @foreach ($dates as $date)
                                        <td class="text-center" style="width: 100%">
                                            @foreach ($karyawan->WorkSchedule as $schedule)
                                                <span
                                                    style="background-color: {{ $schedule->ShiftType->color }}; color: white; padding: 20px 20px; display:{{ $schedule->date == $date ? 'block' : 'none' }}">
                                                    {{ $schedule->ShiftType->kode_shift }}
                                                </span>
                                            @endforeach
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#datepicker").datepicker({
                showWeek: true,
                firstDay: 1
            });
        });
    </script>
@endsection
