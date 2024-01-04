<table class="table mb-0" id="tableData">
    <thead class="text-black bg-200">
        <tr>
            <th class="align-middle">Unit</th>
            <th class="align-middle">Trasaction Type</th>
            <th class="align-middle">Status</th>
            <th class="align-middle text-center">Action</th>
        </tr>
    </thead>
    <tbody id="bulk-select-body">
        @foreach ($transactions as $key => $item)
            <tr>
                <td class="align-middle">
                    {{ $item->Unit->nama_unit }}
                </td>
                <td class="align-middle">
                    Monthly Billing
                </td>
                <td class="align-middle">
                    @if ($item->status_payment)
                        <span class="badge bg-success">Paid</span>
                    @else
                        <span class="badge bg-warning">Pending</span>
                    @endif
                </td>
                <td class="text-center">
                    <a href="{{ route('showInvoices', $item->UtilityCashReceipt->id) }}"
                        class="btn btn-outline-info btn-sm">View</a>
                    {{-- <a href="{{ route('installment', $item->id) }}" class="btn btn-outline-success btn-sm">Installment
                    </a> --}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
