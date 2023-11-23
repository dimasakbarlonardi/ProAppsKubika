@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="my-3 col-auto">
                    <h6 class="mb-0 text-white">List Announcement</h6>
                </div>
                <div class="col-auto d-flex">
                    <a class="btn btn-falcon-default text-600 btn-sm" href="{{ route('announcements.create') }}">
                        <span class="fas fa-plus fs--2 me-1"></span>Create Announcement
                    </a>
                </div>
            </div>
        </div>
        <div class="p-5">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th class="text-center">Banner</th>
                        <th>File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($announcements as $key => $notif)
                        <tr class="align-middle">
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $notif->notif_title }}</td>
                            <td class="text-center">
                                @if ($notif->photo)
                                    <img width="200" src="{{ url($notif->photo) }}" alt="{{ $notif->photo }}">
                                @endif
                            </td>
                            <td>
                                @if ($notif->file)
                                    <a href="{{ url($notif->file) }}" class="btn btn-warning btn-sm"
                                        target="_blank">File</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
