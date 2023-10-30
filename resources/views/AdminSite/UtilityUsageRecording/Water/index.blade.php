@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-header py-2">
                    <div class="row flex-between-center">
                        <div class="my-3 col-auto">
                            <h6 class="mb-0 text-white">List Utility Usage Recording Water</h6>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="card shadow-none">
                        <div class="card-body p-0 pb-3">
                            <div class="d-flex row mb-4">
                                <div class="col">
                                    <div class="justify-content-start my-3">
                                        <h5>Total selected : <span id="totalSelected">0</span></h5>
                                    </div>
                                </div>
                                <div class="col-4" id="bulk-action-menu">
                                    <div class="justify-content-end my-3">
                                        <div class="d-none ms-3" id="bulk-select-actions">
                                            <div class="d-flex">
                                                <select class="form-select form-select-sm" aria-label="Bulk actions"
                                                    id="valueAction">
                                                    @if (Request::session()->get('work_relation_id') == $approve->approval_1 && $user->Karyawan->is_can_approve != null)
                                                        <option class="can-select" value="approve" selected="selected">
                                                            Approve</option>
                                                    @elseif (Request::session()->get('work_relation_id') == $approve->approval_2)
                                                        <option class="can-select" value="calculate">Calculate Invoice
                                                        </option>
                                                        <option class="can-select" value="send">Send Invoice</option>
                                                    @else
                                                        <option disabled selected>No Action</option>
                                                    @endif
                                                </select>
                                                <button class="btn btn-falcon-success btn-sm ms-2" type="button"
                                                    id="applyBulk">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="uur-data">

                            </div>
                        </div>
                    </div>
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
                            <label class="mb-1">Tower</label>
                            <select name="id_tower" class="form-control" id="id_tower">
                                @foreach ($towers as $tower)
                                    <option {{ request()->get('id_tower') == $tower->id_tower ? 'selected' : '' }}
                                        value="{{ $tower->id_tower }}">{{ $tower->nama_tower }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1">Status</label>
                            <select name="unit_id" class="form-control" id="select_status">
                                <option value="all">All</option>
                                <option value="0">Pending</option>
                                <option value="APPROVED">Approved</option>
                            </select>
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
            var optionMenu = $('option').hasClass('can-select');
            if (optionMenu == false) {
                $('#bulk-action-menu').css('display', 'none');
            }

            var status = $('#select_status').val();
            var id_tower = $('#id_tower').val();

            // window.location.replace(`/admin/uus-water?status=${status}&id_tower=${id_tower}`)
        })
        $('#applyBulk').on('click', function() {
            if (confirm('Are you sure?')) {
                var url = '';

                $IDs = $("#tableData input:checkbox:checked").map(function() {
                    return $(this).attr("id");
                }).get();

                var value = $('#valueAction').val();

                if (value === 'approve') {
                    url = '/admin/approve/usr-water';
                } else if (value === 'calculate') {
                    url = '/admin/generate-invoice';
                } else if (value === 'send') {
                    url = '/admin/blast-invoice';
                }

                actionPost(url);
            }
        })

        function actionPost(url) {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    'IDs': $IDs,
                    'type': 'water'
                },
                success: function(resp) {
                    if (resp.status === 'ok') {
                        Swal.fire(
                            'Success!',
                            '',
                            'success'
                        ).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Failed!',
                            '',
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
            var value = $(this).val();
            var id_tower = $('#id_tower').val();

            // window.location.replace(`/admin/uus-water?status=${value}&id_tower=${id_tower}`)
        })

        $('#id_tower').on('change', function() {
            var value = $(this).val();
            var status = $('#select_status').val();

            // window.location.replace(`/admin/uus-water?status=${status}&id_tower=${value}`)
        })
    </script>
@endsection
