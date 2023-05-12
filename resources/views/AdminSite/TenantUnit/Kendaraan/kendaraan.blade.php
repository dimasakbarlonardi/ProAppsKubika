<div class="mb-3">
    <div class="text-end my-3">
        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambah-kendaraan">Tambah
            Kendaraan</button>
    </div>
</div>
<div class="table-responsive scrollbar">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID Tenant</th>
                <th scope="col">ID Unit</th>
                <th scope="col">ID Jenis Kendaraan</th>
                <th scope="col">No Polisi</th>
                <th class="text-end" scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kendaraan_tenants as $key => $kendaraan)
                <tr>
                    <td>{{ $kendaraan->id_tenant }}</td>
                    <td>{{ $kendaraan->id_unit }}</td>
                    <td>{{ $kendaraan->id_jenis_kendaraan }}</td>
                    <td>{{ $kendaraan->no_polisi }}</td>
                    <td class="text-end">
                        <div>
                            <button class="btn btn-link p-0" type="button" data-bs-toggle="modal"
                                data-bs-target="#edit-kendaraan" title="Edit"
                                data-target-id="{{ $kendaraan->id_tenant_vehicle }}"
                                onclick="editKendaraanModal('{{ $kendaraan->id_tenant_vehicle }}')"><span
                                    class="text-500 fas fa-edit"></span>
                            </button>
                            <form action="{{ route('deleteTenantKendaraan', $kendaraan->id_tenant_vehicle) }}" method="post" class="d-inline">
                                @csrf
                                <button class="btn btn-link p-0 ms-2" type="submit" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete"
                                    onClick="return confirm('Are you absolutely sure you want to delete?')"><span
                                        class="text-500 fas fa-trash-alt"></span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="tambah-kendaraan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px">
        <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                    <h4 class="mb-1" id="modalExampleDemoLabel">Tambah Kendaraan</h4>
                </div>
                <div class="p-4 pb-0">
                    <form method="post" action="{{ route('storeTenantVehicle') }}">
                        @csrf
                        <div class="mb-3 col-10">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label">Unit</label>
                                    <select class="form-control" name="id_unit" required>
                                        <option selected disabled>-- Pilih Unit --</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id_unit }}">{{ $unit->nama_unit }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Jenis Kendaraan</label>
                                    <select class="form-control" name="id_jenis_kendaraan" required>
                                        <option selected disabled>-- Pilih Jenis Kendaraan --</option>
                                        @foreach ($jenis_kendaraan as $jeniskendaraan)
                                            <option value="{{ $jeniskendaraan->id_jenis_kendaraan }}">
                                                {{ $jeniskendaraan->jenis_kendaraan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label">No Polisi </label>
                                    <input type="text" name="no_polisi" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit">Tambah</button>
                        </div>
                        <input type="hidden" name="id_tenant" value="{{ $tenant->id_tenant }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-kendaraan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px">
        <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>

            <div class="modal-body-kendaraan-edit p-0">

            </div>
        </div>
    </div>
</div>
