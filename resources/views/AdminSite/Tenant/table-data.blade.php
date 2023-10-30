<table class="table table-striped alternating-rows" id="table-tenant">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th></th>
            <th class="sort" data-sort="equipment">Tenant</th>
            <th class="sort" data-sort="equipment">Unit</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody id="checklist_body">
        @foreach ($tenants as $key => $tenant)
            <tr>
                <th scope="row">{{ $key + '1' }}</th>
                <td>
                    <img src="{{ $tenant->User ? asset($tenant->profile_picture) : asset('/assets/img/team/3-thumb.png') }}"
                        class="rounded-circle" style="max-width: 50px; height: 50px">
                </td>
                <td>
                    {{ $tenant->nama_tenant }}
                </td>
                <td>
                    @if (count($tenant->TenantUnit) > 0)
                        @foreach ($tenant->TenantUnit as $tu)
                            @if ($tu->is_owner)
                                <span class="badge bg-info mb-2">Pemilik</span>
                            @else
                                <span class="badge bg-warning mb-2">Penyewa</span>
                            @endif
                            {{ $tu->Unit->nama_unit }} - {{ $tu->Unit->Tower->nama_tower }} <br>
                        @endforeach
                    @endif
                </td>
                <td class="text-center">
                    <a href="{{ route('tenants.show', $tenant->id_tenant) }}" class="btn btn-outline-info btn-sm mb-2"
                        type="button">
                        Detail
                    </a>
                    <a href="{{ route('getTenantUnit', $tenant->id_tenant) }}"
                        class="btn btn-outline-success btn-sm mb-2" type="button">
                        Tenant Unit
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
