@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header py-2">
            <div class="row flex-between-center">
                <div class="col-auto">
                    <h6 class="my-3 text-light">Create Checklist Chiller</h6>
                </div>
            </div>
        </div>
        <div class="p-5">
            <form method="post" action="{{ route('checklistchillers.store') }}">
                @csrf
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">No. Equiqment</label>
                        <input type="text" name="no_equiqment" class="form-control" required>
                    </div>  
                    <div class=" col-6 mb-3">
                        <label class="form-label">Nama Equiqment</label>
                        <input type="text" name="equiqment" class="form-control" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">PIC</label>
                        <select class="form-control" name="id_role" required>
                            <option selected disabled>-- Pilih PIC --</option>
                            @foreach ($role as $role)
                            <option value="{{ $role->id }}">{{ $role->nama_role }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Lokasi</label>
                        <select class="form-control" name="id_room" required>
                            <option selected disabled>-- Pilih Lokasi --</option>
                            @foreach ($rooms as $room)
                            <option value="{{ $room->id_room }}">{{ $room->nama_room }} </option>
                            @endforeach
                        </select>
                    </div>
    
                    <div class="row mt-3">
                        <h6> Tanggal<hr></h6>
                        <div class=" col-6 mb-3">
                            <label class="form-label">Januari</label>
                            <input type="date" name="januari" class="form-control">
                        </div>
                        <div class=" col-6 mb-3">
                            <label class="form-label">Febuari</label>
                            <input type="date" name="febuari" class="form-control">
                        </div>
                        <div class=" col-6 mb-3">
                            <label class="form-label">Maret</label>
                            <input type="date" name="maret" class="form-control">
                        </div>
                        <div class=" col-6 mb-3">
                            <label class="form-label">April</label>
                            <input type="date" name="april" class="form-control">
                        </div>
                        <div class=" col-6 mb-3">
                            <label class="form-label">Mei</label>
                            <input type="date" name="mei" class="form-control">
                        </div>
                        <div class=" col-6 mb-3">
                            <label class="form-label">Juni</label>
                            <input type="date" name="juni" class="form-control">
                        </div>
                        <div class=" col-6 mb-3">
                            <label class="form-label">Juli</label>
                            <input type="date" name="juli" class="form-control">
                        </div>
                        <div class=" col-6 mb-3">
                            <label class="form-label">Agustus</label>
                            <input type="date" name="agustus" class="form-control">
                        </div>
                        <div class=" col-6 mb-3">
                            <label class="form-label">September</label>
                            <input type="date" name="september" class="form-control">
                        </div>
                        <div class=" col-6 mb-3">
                            <label class="form-label">Oktober</label>
                            <input type="date" name="oktober" class="form-control">
                        </div>
                        <div class=" col-6 mb-3">
                            <label class="form-label">November</label>
                            <input type="date" name="november" class="form-control">
                        </div>
                        <div class=" col-6 mb-3">
                            <label class="form-label">December</label>
                            <input type="date" name="december" class="form-control">
                        </div>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    </div>
            </form>
        </div>
    </div>
@endsection
