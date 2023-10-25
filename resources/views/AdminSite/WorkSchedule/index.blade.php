@extends('layouts.master')

@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endsection

@section('content')
<div class="card">
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="{{ route('work-schedules.index') }}" class="btn btn-falcon-default btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <div class="ml-3">Create Tower</div>
        </div>
    </div>
</div>
    <!-- <div class="card-header py-2">
        <div class="row flex-between-center">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('towers.index') }}" class="btn btn-falcon-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <div class="ml-3">Create Tower</div>
                    </div>
                <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600 " href="{{ route('shifttype.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Add Work Schedule</a>
            </div>
        </div>
    </div> -->
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
                        <a href="" class="btn btn-sm btn-warning"><span class="fas fa-pencil-alt fs--2 me-1"></span>Edit</a>
                        <form class="d-inline" action="" method="post">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('are you sure?')"><span class="fas fa-trash-alt fs--2 me-1"></span>Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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