@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row flex-between-center">
            <div class="my-3 col-auto">
                <h6 class="mb-0">List Room</h6>
            </div>
            <div class="col-auto d-flex">
                <a class="btn btn-falcon-default btn-sm text-600" href="{{ route('rooms.create') }}"><span class="fas fa-plus fs--2 me-1"></span>Create Room</a>
            </div>
        </div>
    </div>
    <div class="p-5">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="sort" data-sort="">No</th>
                    <th class="sort" data-sort="id_tower">Tower</th>
                    <th class="sort" data-sort="id_lantai">Floor</th>
                    <th class="sort" data-sort="barcode_room">Barcode Room</th>
                    <th class="sort" data-sort="nama_room">Room Name</th>
                    <th class="sort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rooms as $key => $room)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $room->tower->nama_tower }}</td>
                        <td>{{ $room->floor->nama_lantai }}</td>
                        <td>
                            <img src=" {{ url($room->barcode_room) }}" width="80">
                        </td>
                        <td>{{ $room->nama_room }}</td>
                        <td>
                            <a href="{{ route('rooms.edit', $room->id_room) }}" class="btn btn-sm btn-warning"><span class="fas fa-pencil-alt fs--2 me-1"></span>Edit</a>
                            <form class="d-inline" action="{{ route('rooms.destroy', $room->id_room) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('are you sure?')"><span class="fas fa-trash-alt fs--2 me-1"></span>Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
