@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Tambah Equipment Engineering</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklistahus.store') }}">
                @csrf
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">No. Equipment</label>
                        <input type="text" name="no_equiqment" class="form-control" required>
                    </div>
                    <div class=" col-6 mb-3">
                        <label class="form-label">Nama Equipment</label>
                        <input type="text" name="equiqment" class="form-control" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">PIC</label>
                        <select class="form-control" name="id_role" required>
                            <option selected disabled>-- Select PIC --</option>
                            @foreach ($role as $role)
                                <option value="{{ $role->id }}">{{ $role->nama_role }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Location</label>
                        <select class="form-control" name="id_room" required>
                            <option selected disabled>-- Select Location --</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id_room }}">{{ $room->nama_room }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
