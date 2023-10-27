@extends('layouts.master')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endsection

@section('content')
<div class="card">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('schedulemeeting.index') }}" class="btn btn-falcon-default btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                @if(isset($employee[0]))
                <h6 class="mb-0 text-white ml-3">List Participants {{ $employee[0]->Meeting->meeting }}</h6>
                @else
                <h6 class="mb-0 text-white">List Participants</h6>
                @endif
            </div>
        </div>
    </div>
    <div class="p-5 justify-content-center">
        <table class="table table-striped" id="table-schedulemeeting">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_karyawan">Employee</th>
                    <th class="sort" data-sort="action">Divisi</th>
                </tr>
            </thead>
            <tbody id="checklist_body">
                @foreach ($employee as $key => $meeting)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td> {{ $meeting->Karyawan->nama_karyawan }}</td>
                    <td> {{ $meeting->Karyawan->Divisi->nama_divisi}}</td>
                    <!-- <td>
                            <a href="{{ route('shifttype.edit', $meeting->id) }}" class="btn btn-sm btn-warning"><span
                                    class="fas fa-pencil-alt fs--2 me-1"></span>Edit</a>
                            <form class="d-inline" action="{{ route('shifttype.destroy', $meeting->id) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('are you sure?')"><span
                                        class="fas fa-trash-alt fs--2 me-1"></span>Hapus</button>
                            </form>
                        </td> -->
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
    new DataTable('#table-schedulemeeting');
</script>
@endsection