@extends('layouts.master')

@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endsection

@section('content')
<div class="card">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('karyawans.index') }}" class="btn btn-falcon-default btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div class="ml-3">Create Work Schedule</div>
            </div>
        </div>
    </div>

    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="shift_type">Karyawan</th>
                    <th class="sort" data-sort="shift_type">Shift Type</th>
                    <th class="sort" data-sort="shift_type">Date</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                <form action="{{ route('storeWorkSchedules', $karyawan->id) }}" method="post">
                    @csrf
                    <tr>
                        <td>
                            <input class="form-control" type="text" value="{{ $karyawan->nama_karyawan }}" disabled>
                        </td>
                        <td>
                            <select name="shift_type_id" class="form-control">
                                @foreach ($shift_types as $type)
                                <option value="{{ $type->id }}">{{ $type->shift }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input name="date" class="form-control" type="date">
                        </td>
                        <td>
                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('are you sure?')"><span class="fas fa-plus-circle fs--2 me-1"></span>Add</button>
                        </td>
                    </tr>
                    <input type="hidden" value="{{ $karyawan->id }}" name="karyawan_id">
                </form>
            </tbody>
        </table>
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="shift_type">Karyawan</th>
                    <th class="sort" data-sort="shift_type">Shift Type</th>
                    <th class="sort text-center" data-sort="shift_type">Kode Type</th>
                    <th class="sort text-center" data-sort="shift_type">Date</th>
                    <th class="sort text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($work_timelines as $key => $wt)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $wt->Karyawan->nama_karyawan }}</td>
                    <td>{{ $wt->ShiftType->shift }}</td>
                    <td class="text-center">{{ $wt->ShiftType->kode_shift }}</td>
                    <td class="text-center">{{ $wt->date }}</td>
                    <td class="text-center">
                        <button class="btn btn-info btn-sm" onclick="showModalTool({{ $wt->id }})">Edit</button>
                        <!-- <a href="" class="btn btn-sm btn-warning"><span class="fas fa-pencil-alt fs--2 me-1"></span>Edit</a> -->
                        <form class="d-inline" action="{{ route('destroyWT', $wt->id) }}" method="post">
                            @method('POST')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                <span class="fas fa-trash-alt fs--2 me-1"></span>Hapus
                            </button>
                        </form>

                    </td>
                </tr>

                <div class="modal fade" id="edit-tools{{ $wt->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Work Schedule</h5>
                            </div>
                            <form action="{{ route('updateWT', $wt->id) }}" method="POST">
                                @method('PATCH')
                                @csrf
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-6 mb-3">
                                            <label class="form-label">Karyawan</label>
                                            <input type="text" name="nama_karyawan" value="{{ $karyawan->nama_karyawan }}" class="form-control" disabled>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label class="form-label">Shift Type</label>
                                            <select name="shift_type_id" class="form-control">
                                                @foreach ($shift_types as $type)
                                                <option value="{{ $type->id }}">{{ $type->shift }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label class="form-label">Karyawan</label>
                                            <input type="date" name="date" value="{{ $wt->date }}" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script>
    $(function() {
        $("#datepicker").datepicker({
            showWeek: true,
            firstDay: 1
        });
    });

    function showModalTool(id) {
        console.log(id);
        $(`#edit-tools${id}`).modal('show')
       
    }
</script>
@endsection