@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h6 class="mb-0">List Fin Monthly Reminder Letter</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('finmonthllyreminderletters.create') }}">Tambah Fin Monthly Reminder Letter</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="no_monthly_invoice">No Monthly Invoice</th>
                    <th class="sort" data-sort="no_reminder_letter">No Reminder Letter</th>
                    <th class="sort" data-sort="tgl_reminder_letter">Tanggal Reminder Letter</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($finmonthlyreminderletters as $key => $reminderletter)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $reminderletter->no_monthly_invoice }}</td>
                        <td>{{ $reminderletter->no_reminder_letter }}</td>
                        <td>{{ $reminderletter->tgl_reminder_letter }}</td>
                        <td>
                            <a href="{{ route('finmonthllyreminderletters.edit', $reminderletter->id_fin_reminder_letter) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('finmonthllyreminderletters.destroy', $reminderletter->id_fin_reminder_letter) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('are you sure?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

