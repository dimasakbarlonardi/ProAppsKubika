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
                    <select class="form-control" name="select_month" id="select_month">
                        <option value="{{ date('Y') . '-01-01' }}">January</option>
                        <option value="{{ date('Y') . '-02-01' }}">February</option>
                        <option value="{{ date('Y') . '-03-01' }}">March</option>
                        <option value="{{ date('Y') . '-04-01' }}">April</option>
                        <option value="{{ date('Y') . '-05-01' }}">May</option>
                        <option value="{{ date('Y') . '-06-01' }}">June</option>
                        <option value="{{ date('Y') . '-07-01' }}">July</option>
                        <option value="{{ date('Y') . '-08-01' }}">August</option>
                        <option value="{{ date('Y') . '-09-01' }}">September</option>
                        <option value="{{ date('Y') . '-10-01' }}">October</option>
                        <option value="{{ date('Y') . '-11-01' }}">November</option>
                        <option value="{{ date('Y') . '-12-01' }}">December</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="p-5">
            <div class="table-x-scroll">
                <html>
                <div class="tscroll" id="presence_table">
                    {{-- @include('AdminSite.Attendance.attendance_table') --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $('#select_month').on('change', function() {
            var month = $(this).val();
            $.ajax({
                url: '/admin/presences-by-month',
                type: 'GET',
                data: {
                    month
                },
                success: function(resp) {
                    $('#presence_table').html(resp.html);
                }
            })
        })
    </script>
@endsection
