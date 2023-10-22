@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="mb-0 text-white">List Request Permit</h6>
                </div>
            </div>
        </div>
        <div class="p-5 justify-content-center">
            <table class="table table-striped" id="table-requestattendance">
                <thead>
                    <tr>
                        <th class="sort" data-sort="">No</th>
                        <th class="sort" data-sort="">Name</th>
                        <th class="sort" data-sort="date">Date</th>
                        <th class="sort" data-sort="id_request_type">Request Type</th>
                        <th class="sort" data-sort="status">Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="checklist_body">
                    @foreach ($permit_attendances as $key => $permit)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $permit->Karyawan->nama_karyawan }}</td>
                            <td>
                                @if (!isset($permit->replacement_id))
                                    <b>{{ $permit->WorkTimeline($permit->work_date)->ShiftType->shift }}</b><br>
                                @elseif (isset($permit->previous_shift_id))
                                    <b>{{ $permit->CurrentShift->shift }}</b><br>
                                @endif
                                {{ HumanDate($permit->work_date) }}
                            </td>
                            <td>
                                <b>{{ $permit->permit_type }}</b> <br>
                                @if (isset($permit->previous_shift_id))
                                    <span>Current shift : {{ $permit->CurrentShift->shift }}</span> <br>
                                @endif
                                @if (isset($permit->replace_shift_id))
                                    <span>Request change to : {{ $permit->RequestShift->shift }}</span> <br>
                                @endif
                                @if (isset($permit->replacement_id))
                                    <span>Replacement Employee : {{ $permit->Replacement->nama_karyawan }}</span>
                                @endif
                                @if ($permit->request_time)
                                    <span>{{ HumanTime($permit->request_time) }}</span>
                                @endif
                                @if ($permit->permit_photo)
                                    <a href="{{ url($permit->permit_photo) }}" target="_blank">Image</a> <br>
                                @endif
                                @if ($permit->permit_file)
                                    <a href="{{ url($permit->permit_file) }}" target="_blank">File</a>
                                @endif
                            </td>

                            <td>
                                {{ $permit->status_permit }}
                            </td>
                            <td>
                                @if ($permit->status_permit == 'PENDING')
                                    <button class="btn btn-success btn-sm" onclick="onApprove({{ $permit->id }})"
                                        id="approveButton">Approve</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
        new DataTable('#table-requestattendance');

        function onApprove(id) {
            Swal.fire({
                title: 'Are you sure?',
                icon: 'info',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result['isConfirmed']) {
                    $.ajax({
                        url: `/admin/permit-attendance/approve/${id}`,
                        type: 'POST',
                        success: function(data) {
                            if (data.status === 'ok') {
                                Swal.fire(
                                    'Success!',
                                    'Success approve permit!',
                                    'success'
                                ).then(() => window.location.reload())
                            }
                        }
                    })
                }
            })
        }
    </script>
@endsection
