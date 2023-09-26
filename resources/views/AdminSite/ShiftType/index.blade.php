@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="mb-0 text-white">List Shift Type</h6>
                </div>
                <div class="col-auto d-flex">
                    <a class="btn btn-falcon-default text-600 btn-sm " href="{{ route('shifttype.create') }}"><span
                            class="fas fa-plus fs--2 me-1"></span>Create Shift Type</a>
                </div>
            </div>
        </div>
        <div class="p-5">
            <table class="table">
                <thead>
                    <tr>
                        <th class="sort" data-sort="">No</th>
                        <th class="sort" data-sort="shift_type">Shift Type</th>
                        <th class="sort" data-sort="shift_type">Kode Type</th>
                        <th class="sort" data-sort="shift_type">Check In / Check Out</th>
                        <th class="sort text-center" data-sort="shift_type">Work Hour</th>
                        <th class="sort text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shifttype as $key => $shift)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $shift->shift }}</td>
                            <td>{{ $shift->kode_shift }}</td>
                            <td>{{ $shift->checkin }} / {{ $shift->checkout }}</td>
                            <td class="text-center">{{ $shift->work_hour }}</td>
                            <td class="text-center">
                                <a href="{{ route('shifttype.edit', $shift->id) }}" class="btn btn-sm btn-warning"><span
                                        class="fas fa-pencil-alt fs--2 me-1"></span>Edit</a>
                                <form class="d-inline" action="{{ route('shifttype.destroy', $shift->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('are you sure?')"><span
                                            class="fas fa-trash-alt fs--2 me-1"></span>Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
