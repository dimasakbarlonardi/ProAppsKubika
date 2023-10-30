@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-header py-2">
                    <div class="row flex-between-center">
                        <div class="my-3 col-auto">
                            <h6 class="mb-0 text-white">List Utility Usage Recording Electric</h6>
                        </div>
                    </div>
                </div>
                <div id="uur-data">

                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <form action="" method="post">
                    <div class="card-header">
                        <h6 class="mb-0">Properties</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="mb-1">Towers</label>
                            <select class="form-control" id="id_tower">
                                <option value="all">All</option>
                                @foreach ($towers as $tower)
                                    <option value="{{ $tower->id_tower }}">{{ $tower->nama_tower }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1">Status</label>
                            <select class="form-control" id="select_status">
                                <option value="all">All</option>
                                <option value="0">Pending</option>
                                <option value="1">Approved</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1">Periode</label>
                            <div class="row">
                                <div class="col-6">
                                    <select class="form-control" id="select_period">
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <select class="form-control" id="select_year">
                                        <option value="2023">2023</option>
                                        <option value="2022">2022</option>
                                        <option value="2021">2021</option>
                                        <option value="2020">2020</option>
                                        <option value="2019">2019</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>
        $('document').ready(function() {
            var tower = $('#id_tower').val();
            var status = $('#select_status').val();

            getData(tower, status);
        })
        $('#applyBulk').on('click', function() {
            var url = '';

            $IDs = $("#tableData input:checkbox:checked").map(function() {
                return $(this).attr("id");
            }).get();

            var value = $('#valueAction').val();

            if (value === 'approve') {
                url = '/admin/approve/usr-electric';
            } else if (value === 'calculate') {
                url = '/admin/generate-invoice';
            } else if (value === 'send') {
                url = '/admin/blast-invoice';
            }

            actionPost(url);
        })

        function actionPost(url) {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    'IDs': $IDs,
                    'type': 'electric'
                },
                success: function(resp) {
                    if (resp.status === 'ok') {
                        Swal.fire(
                            'Good job!',
                            'You clicked the button!',
                            'success'
                        ).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Failed!',
                            'You clicked the button!',
                            'error'
                        ).then(() => {
                            window.location.reload();
                        });
                    }
                }
            })
        }

        $('.form-check-input').on('change', function() {
            $IDs = $("#tableData input:checkbox:checked").map(function() {
                return $(this).attr("id");
            }).get();
            $('#totalSelected').html($IDs.length)
        })

        $('#select_status').on('change', function() {
            var status = $(this).val();
            var tower = $('#id_tower').val();
            var period = $('#select_period').val();
            var year = $('#select_year').val();

            getData(tower, status, period, year);
        })

        $('#id_tower').on('change', function() {
            var tower = $(this).val();
            var status = $('#select_status').val();
            var period = $('#select_period').val();
            var year = $('#select_year').val();

            getData(tower, status, period, year);
        })

        $('#select_period').on('change', function() {
            var tower = $('#id_tower').val();
            var period = $(this).val();
            var status = $('#select_status').val();
            var year = $('#select_year').val();

            getData(tower, status, period, year);
        })

        $('#select_year').on('change', function() {
            var tower = $('#id_tower').val();
            var period = $('#select_period').val();
            var status = $('#select_status').val();
            var year = $(this).val();

            getData(tower, status, period, year);
        })

        function getData(tower, status, period, year) {
            $.ajax({
                url: '/admin/uus-electric-filtered',
                type: 'GET',
                data: {
                    tower,
                    status,
                    period,
                    year
                },
                success: function(resp) {
                    $('#uur-data').html(resp.html);
                }
            })
        }
    </script>
@endsection
