<div class="table-responsive scrollbar">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nama Unit</th>
                <th scope="col">ID Jenis Kendaraan</th>
                <th scope="col">No Polisi</th>
                <th scope="col">Keterangan</th>
                <th class="text-end" scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <div id="kendaraan_tenant">
                @foreach ($kendaraan_tenants as $key => $kendaraan)
                    <tr>
                        <td>{{ $kendaraan->unit->nama_unit }}</td>
                        <td>{{ $kendaraan->jeniskendaraan->jenis_kendaraan }}</td>
                        <td>{{ $kendaraan->no_polisi }}</td>
                        <td>{{ $kendaraan->keterangan }}</td>
                        <td class="text-end">
                            <div>
                                <button class="btn btn-link p-0" type="button" data-bs-toggle="modal"
                                    data-bs-target="#edit-kendaraan" title="Edit"
                                    data-target-id="{{ $kendaraan->id_tenant_vehicle }}"
                                    onclick="editKendaraanModal('{{ $kendaraan->id_tenant_vehicle }}')"><span
                                        class="text-500 fas fa-edit"></span>
                                </button>
                                <form action="{{ route('deleteTenantKendaraan', $kendaraan->id_tenant_vehicle) }}"
                                    method="post" class="d-inline">
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
            </div>
        </tbody>
    </table>
</div>
