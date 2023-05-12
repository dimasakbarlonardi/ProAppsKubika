<div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
    <h4 class="mb-1" id="modalExampleDemoLabel">Edit Kendaraan</h4>
</div>
<div class="p-4 pb-0">
    <form method="post" action="{{ route('updateTenantKendaraan', $tenantkendaraan->id_tenant_vehicle) }}">
        @csrf
        <div class="mb-3 col-10">
            <div class="row">
                <div class="col-6">
                    <label class="form-label">Unit</label>
                    <select class="form-control" name="id_unit" required>
                        <option selected disabled>-- Pilih Unit --</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id_unit }}"
                                {{ $tenantkendaraan->id_unit == $unit->id_unit ? 'selected' : '' }}>
                                {{ $unit->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label">Jenis Kendaraan</label>
                    <select class="form-control" name="id_jenis_kendaraan" required>
                        <option selected disabled>-- Pilih Jenis Kendaraan --</option>
                        @foreach ($jenis_kendaraan as $jeniskendaraan)
                            <option value="{{ $jeniskendaraan->id_jenis_kendaraan }}"
                                {{ $tenantkendaraan->id_jenis_kendaraan == $jeniskendaraan->id_jenis_kendaraan ? 'selected' : '' }}>
                                {{ $jeniskendaraan->jenis_kendaraan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label class="form-label">No Polisi </label>
                    <input type="text" name="no_polisi" value="{{ $tenantkendaraan->no_polisi }}" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit">Update</button>
        </div>
    </form>
</div>
