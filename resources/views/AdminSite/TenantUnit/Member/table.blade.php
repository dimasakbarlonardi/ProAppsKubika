<div class="table-responsive scrollbar">
    <table class="table">
        <thead>
            <tr>
                <th scope="col" rowspan="2">ID Unit</th>
                <th scope="col">Nama Member</th>
                <th scope="col">Hubungan Tenant</th>
                <th scope="col">No Telp Member</th>
                <th scope="col">ID Status Tinggal</th>
                <th scope="col">ID Tenant</th>
                <th class="text-end" scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tenant_members as $key => $tm)
                <tr>
                    <td>{{ $tm->unit }}</td>
                    <td>{{ $tm->nama_tenant_member }}</td>
                    <td>{{ $tm->hubungan_tenant }}</td>
                    <td>{{ $tm->no_telp_member }}</td>
                    <td>{{ $tm->id_status_tinggal }}</td>
                    <td>{{ $tm->tenant->nama_tenant }}</td>
                    <td class="text-end">
                        <div>
                            <button class="btn btn-link p-0" type="button" data-bs-toggle="modal"
                                data-bs-target="#edit-member" title="Edit"
                                data-target-id="{{ $tm->id_tenant_member }}"
                                onclick="editMemberModal('{{ $tm->id_tenant_member }}')">
                                <span class="text-500 fas fa-edit"></span>
                            </button>
                            <form action="{{ route('deleteTenantMember', $tm->id_tenant_member) }}" method="post" class="d-inline">
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
