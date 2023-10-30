@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto d-flex my-2 align-items-center">
                    <a href="{{ route('reminders.index') }}" class="btn btn-falcon-default btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <h6 class="mb-0 ml-3">List Reminder</h6>
                </div>
                <div class="col-auto d-flex">
                    <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('reminders.create') }}">
                        <span class="fas fa-plus fs--2 me-1"></span>Add Reminder</a>
                </div>
            </div>
        </div>
        <div class="p-5">
            <table class="table">
                <thead>
                    <tr>
                        <th class="sort" data-sort="">No</th>
                        <th class="sort" data-sort="reminder_letter">Reminder</th>
                        <th class="sort" data-sort="durasi_reminder_letter">Reminder Date</th>
                        <th class="sort" data-sort="durasi_reminder_letter">Remind On</th>
                        <th class="sort" data-sort="durasi_reminder_letter">Remind To</th>
                        <th class="sort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reminders as $key => $reminder)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $reminder->reminder_name }}</td>
                            <td>{{ HumanDate($reminder->reminder_date) }}</td>
                            <td> <b>{{ $reminder->remind_before }}</b> Days before event</td>
                            <td> {{ $reminder->WorkRelation->work_relation }}</td>
                            <td>
                                <a href="{{ route('reminders.edit', $reminder->id) }}"
                                    class="btn btn-sm btn-warning"><span
                                        class="fas fa-pencil-alt fs--2 me-1   "></span>Edit</a>
                                <form class="d-inline"
                                    action="{{ route('reminders.destroy', $reminder->id) }}" method="post">
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
