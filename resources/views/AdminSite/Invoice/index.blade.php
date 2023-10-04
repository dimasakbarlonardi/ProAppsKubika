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
                                <div class="col-4" id="bulk-action-menu">
                                    <div class="justify-content-end my-3">
                                        <div class="d-none ms-3" id="bulk-select-actions">
                                            <div class="d-flex">
                                                <select class="form-select form-select-sm" aria-label="Bulk actions"
                                                    id="valueAction">
                                                    {{-- @if ($user->id_role_hdr == $approve->approval_1 && $user->Karyawan->is_can_approve != null)
                                                        <option class="can-select" value="approve" selected="selected">
                                                            Approve</option>
                                                    @elseif ($user->id_role_hdr == $approve->approval_2)
                                                        <option class="can-select" value="calculate">Calculate Invoice
                                                        </option>
                                                        <option class="can-select" value="send">Send Invoice</option>
                                                    @else
                                                        <option disabled selected>No Action</option>
                                                    @endif --}}
                                                </select>
                                                <button class="btn btn-falcon-success btn-sm ms-2" type="button"
                                                    id="applyBulk">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive scrollbar">
                                <table class="table mb-0" id="tableData">
                                    <thead class="text-black bg-200">
                                        <tr>
                                            <th class="align-middle">No Invoice</th>
                                            <th class="align-middle">Trasaction Type</th>
                                            <th class="align-middle">Status</th>
                                            <th class="align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bulk-select-body">
                                        @foreach ($transactions as $key => $item)
                                            <tr>
                                                <th class="align-middle">
                                                    {{ $item->no_reff }}
                                                </th>
                                                <th class="align-middle">
                                                    {{ $item->transaction_type }}
                                                </th>
                                            </tr>

                                            <div class="modal fade" id="edit-modal{{ $item->id }}" tabindex="-1"
                                                role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document"
                                                    style="max-width: 500px">
                                                    <div class="modal-content position-relative">
                                                        <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                                                            <button
                                                                class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-0">
                                                            <div class="rounded-top-3 py-3 ps-4 pe-6 bg-light">
                                                                <h4 class="mb-1" id="modalExampleDemoLabel">Edit Record
                                                                </h4>
                                                            </div>
                                                            <div class="p-4 pb-0">
                                                                <form method="post" action="{{ route('updateWater') }}">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <div class="row">
                                                                            <div class="col-6">
                                                                                <label class="col-form-label"
                                                                                    for="recipient-name">Previous:</label>
                                                                                <input class="form-control"
                                                                                    value="{{ $item->nomor_air_awal }}"
                                                                                    type="integer" />
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <label class="col-form-label"
                                                                                    for="recipient-name">Current:</label>
                                                                                <input class="form-control"
                                                                                    value="{{ $item->nomor_air_akhir }}"
                                                                                    type="integer" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="col-form-label"
                                                                            for="message-text">Notes:</label>
                                                                        <textarea class="form-control" rows="8" id="message-text"></textarea>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button class="btn btn-primary" type="button"
                                                                onclick="return confirm('are you sure?')">Edit
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
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
                            <label class="mb-1">Unit</label>
                            <select name="unit_id" class="form-control" id="id_unit">
                                {{-- @foreach ($units as $unit)
                                    <option {{ request()->get('id_unit') == $unit->id_unit ? 'selected' : '' }}
                                        value="{{ $unit->id_unit }}">{{ $unit->nama_unit }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1">Status</label>
                            <select name="unit_id" class="form-control" id="select_status">
                                <option value="">All</option>
                                <option {{ request()->get('status') == 'PENDING' ? 'selected' : '' }} value="PENDING">
                                    Pending</option>
                                <option {{ request()->get('status') == 'APPROVED' ? 'selected' : '' }} value="APPROVED">
                                    Approved</option>
                                <option {{ request()->get('status') == 'WAITING' ? 'selected' : '' }} value="WAITING">
                                    Waiting
                                    to Send
                                </option>
                                <option {{ request()->get('status') == 'PAYED' ? 'selected' : '' }} value="PAYED">Paid
                                </option>
                                <option {{ request()->get('status') == 'UNPAID' ? 'selected' : '' }} value="UNPAID">
                                    Unpaid</option>
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
            var id_unit = $('#id_unit').val();

            window.location.replace(`/admin/uus-water?status=${value}&id_unit=${id_unit}`)
        })

        $('#id_unit').on('change', function() {
            var value = $(this).val();
            var status = $('#select_status').val();

            window.location.replace(`/admin/uus-water?status=${status}&id_unit=${value}`)
        })
    </script>
@endsection
