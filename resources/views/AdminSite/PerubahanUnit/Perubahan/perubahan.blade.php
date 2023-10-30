<div class="table-responsive scrollbar">
    <table class="table table-striped" id="table-perubahan">
        <thead>
            <tr>
                <th scope="col">Tenant</th>
                <th scope="col">Unit</th>
                <th scope="col">Pemilik</th>
                <th scope="col">Periode Sewa</th>
                <th scope="col">Sewa Ke</th>
                <th scope="col">Jatuh Tempo IPL</th>
                <th scope="col">Jatuh Tempo UTIL</th>
                <th class="text-end" scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tenant_units as $key => $tu)
                <tr>
                    <td>{{ $tu->tenant->nama_tenant }}</td>
                    <td>{{ $tu->unit->nama_unit }}</td>
                    <td>{{ $tu->Owner($tu->unit->id_unit)->nama_tenant }}</td>
                    <td class="text-center">
                        {{ !$tu->is_owner ? HumanDate($tu->tgl_masuk) : '-' }} <br>
                        {{ !$tu->is_owner ? HumanDate($tu->tgl_keluar) : '' }}
                    </td>
                    <td>{{ $tu->sewa_ke }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($tu->tgl_jatuh_tempo_ipl)->format(' d-M-Y') }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($tu->tgl_jatuh_tempo_util)->format(' d-M-Y') }}
                    </td>
                    <td class="text-center">
                        <div>
                            <a class="btn btn-sm btn-warning"
                                href="{{ route('perubahanunit', $tu->id_tenant_unit) }}">Detail</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="edit-unit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px">
        <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>

            <div class="modal-body-unit-edit p-0">

            </div>
        </div>
    </div>
</div>
